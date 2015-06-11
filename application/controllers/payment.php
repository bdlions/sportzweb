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

    function index() {
        
    }

    /*
     * This method will used for displaying payment form and processing payment on form submission
     * @param $session_id, id of a session which will be paid
     */

    public function pay_ptpro($session_id = 0) {
        //session info
        $session_info = array();
        $session_info_array = $this->gympro_library->get_session_info($session_id)->result_array();
        if (!empty($session_info_array)) {
            $session_info = $session_info_array[0];
        }

        $data = array();

        $this->load->helper(array('form', 'url'));

        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $this->config->load('paypal');
            $this->load->library('paypal_chained_adaptive_payment', $this->config->item('paypal'));

            /** @var Paypal_chained_adaptive_payment $payment */
            $payment = $this->paypal_chained_adaptive_payment;
            $payment->setProductName('session'); // product name (if change here - must be changed also in IPN handler)
            $payment->setProductId($session_id); // Session ID, required to update this Session payment status when PayPal sends back an IPN
            $payment->setCurrency($session_info['currency_code']); // currency, must be three letters, and be accepted in configs
            $payment->setAmount($session_info['cost']); // total payment amount
            $payment->setSecondaryReceiver($session_info['account_email']); // paypal email of trainer, for testing use ptpro-secondary@sonuto.com
            // process payment
            if (FALSE === $payment->process()) {// failed
                $data['payment_errors'] = $payment->getErrors(); // process errors
            } else {// success
                // it must return PayPal UWL where user must be redirected
                if ($payPalUrl = $payment->getPayPalUrl()) {
                    header("Location: {$payPalUrl}"); // redirect user to PayPal website to complete a payment
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
     * Completed payments will be redirected here
     */
    public function completed() {
        $this->session->set_flashdata('message', "Payment has been completed. Thank you!");
        redirect('applications/gympro/schedule','refresh');
    }

    /**
     * Canceled payments will be redirected here
     */
    public function canceled() {
        $this->session->set_flashdata('message', "Payment has been cancelled.");
        redirect('applications/gympro/schedule','refresh');
    }

}
