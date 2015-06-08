<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ipn_response extends CI_Controller {
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
                        $this->load->library('org/application/gympro_library');
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
}
