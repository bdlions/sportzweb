<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paypal extends CI_Controller {

	/**
	 * Used for displaying payment form and processing payment on form submission
	 */
	public function index()
	{
		$data = array();

		$this->load->helper(array('form', 'url'));

		if ('POST' == $_SERVER['REQUEST_METHOD']) {
			$this->config->load('paypal');
			$this->load->library('paypal_chained_adaptive_payment', $this->config->item('paypal'));

			/** @var Paypal_chained_adaptive_payment $payment */
			$payment = $this->paypal_chained_adaptive_payment;
			$payment->setCurrency('GBP');// currency, must be three letters, and be accepted in configs
			$payment->setAmount(40);// total payment amount
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

		$this->load->view('paypal_form', $data);
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
			if ('COMPLETED' !== $ipn['status']) {
				log_message('error', 'Payment not completed: '.json_encode($ipn));
			}
			elseif ('session_payment' === $ipn['memo']) {
				// change payment status in Session table
				log_message('debug', 'Valid payment: '.json_encode($ipn));
			}
			else {
				log_message('error', 'Unknown payment: '.json_encode($ipn));
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
		$this->load->view('paypal_completed');
	}

	/**
	 * Canceled payments will be redirected here
	 */
	public function canceled()
	{
		$this->load->view('paypal_canceled');
	}
}
