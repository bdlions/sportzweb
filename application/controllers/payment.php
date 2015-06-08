<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment extends Role_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        // Loading gympro library
        $this->load->library('org/application/gympro_library');
    }
    
    function index()
    {
        
    }
    /*
     * This method will used for displaying payment form and processing payment on form submission
     * @param $session_id, id of a session which will be paid
     */
    public function pay_ptpro($session_id = 0)
    {
        //session info
        $session_info = array();
        $session_info_array = $this->gympro_library->get_session_info($session_id)->result_array();
        if(!empty($session_info_array)){
            $session_info = $session_info_array[0];
        }
        
        $data = array();

        $this->load->helper(array('form', 'url'));

        if ('POST' == $_SERVER['REQUEST_METHOD']) {
                $this->config->load('paypal');
                $this->load->library('paypal_chained_adaptive_payment', $this->config->item('paypal'));

                /** @var Paypal_chained_adaptive_payment $payment */
                $payment = $this->paypal_chained_adaptive_payment;
                $payment->setProductName('session');// product name (if change here - must be changed also in IPN handler)
                $payment->setProductId($session_id);// Session ID, required to update this Session payment status when PayPal sends back an IPN
                $payment->setCurrency('GBP');// currency, must be three letters, and be accepted in configs
                $payment->setAmount($session_info['cost']);// total payment amount
                $payment->setSecondaryReceiver('ptpro-secondary@sonuto.com');// paypal email of trainer, for testing use ptpro-secondary@sonuto.com

                // process payment
                if (FALSE === $payment->process()) {// failed
                        $data['payment_errors'] = $payment->getErrors();// process errors
                }
                else {// success
                        // it must return PayPal UWL where user must be redirected
                        if ($payPalUrl = $payment->getPayPalUrl()) {
                                header("Location: {$payPalUrl}");// redirect user to PayPal website to complete a payment
                                exit;
                        }
                        // if there is no PayPal URL, the PayPal payment status could be checked
                        $data['payment_errors'][] = $payment->getPaymentExecStatus();
                }
        }

        $this->data['session_info'] = $session_info;
        $this->template->load(null, 'paypal_form', $this->data);
    }
    /**
    * Required to receive PayPal IPN messages and change payment status in website database
    */
   public function ipn()
   {
        error_reporting(E_ALL);
        $this->config->load('paypal');
        $this->load->library('paypal_chained_adaptive_payment', $this->config->item('paypal'));
        log_message('debug', 'paypal library loaded');
        /** @var Paypal_chained_adaptive_payment $payment */
        $payment = $this->paypal_chained_adaptive_payment;
        log_message('debug', 'paypal payment initialized');

        $ipn = $payment->validateIpn();// validate IPN message
        log_message('debug', 'ipn validated');

        if (false !== $ipn) {// IPN verified by PayPal
                if ('COMPLETED' !== $ipn->getStatus()) {
                        log_message('error', 'Payment not completed: '.json_encode($ipn->getRawData()));
                }
                elseif ('session' === $ipn->getProductName()) {
                        // change payment status in Session table
                        $sessionId = $ipn->getProductId();
                        //updating status of the session
                        $additional_data = array(
                             'status_id' => GYMPRO_SESSION_STATUS_PAY_PT_PRO_ID
                        );
                        $this->gympro_library->update_session($sessionId, $additional_data);
                        log_message('debug', 'Valid payment: '.json_encode($ipn->getRawData()));
                }
                else {
                        log_message('error', 'Unknown payment: '.json_encode($ipn->getRawData()));
                }
        }
        else {
                // log errors
                log_message('error', implode("\n", $payment->getErrors()));
        }
        echo "SUCCESS";
   }
    /**
    * Completed payments will be redirected here
    */
   public function completed()
   {
       $this->data['message'] = '';    
       $this->template->load(null, 'paypal_completed', $this->data); 
   }

   /**
    * Canceled payments will be redirected here
    */
   public function canceled()
   {
       $this->data['message'] = '';
       $this->template->load(null, 'paypal_canceled', $this->data); 
   }

}