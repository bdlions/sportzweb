<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'Paypal/vendor/autoload.php';
require 'Ipn.php';

use PayPal\Service\AdaptivePaymentsService;
use PayPal\Types\AP\PayRequest;
use PayPal\Types\AP\Receiver;
use PayPal\Types\AP\ReceiverList;
use PayPal\Types\Common\RequestEnvelope;
use PayPal\IPN\PPIPNMessage;

class Paypal_chained_adaptive_payment {

    protected $configs;
    protected $primaryReceiver;
    protected $secondaryReceiver;
    protected $amount;
    protected $currency;
    protected $trackingId;
    protected $productName;
    protected $productId;
    protected $errors;
    protected $paymentExecStatus;
    protected $payKey;
    protected $payPalUrl;

    public function __construct($configs)
    {
        $this->configs = $configs;
    }

    /**
     * @param mixed $primaryReceiver
     * @return Paypal_chained_adaptive_payment
     */
    public function setPrimaryReceiver($primaryReceiver)
    {
        $this->primaryReceiver = $primaryReceiver;
        return $this;
    }

    /**
     * @param mixed $secondaryReceiver
     * @return Paypal_chained_adaptive_payment
     */
    public function setSecondaryReceiver($secondaryReceiver)
    {
        $this->secondaryReceiver = $secondaryReceiver;
        return $this;
    }

    /**
     * @param mixed $amount
     * @return Paypal_chained_adaptive_payment
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param mixed $currency
     * @return Paypal_chained_adaptive_payment
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @param mixed $trackingId
     * @return Paypal_chained_adaptive_payment
     */
    public function setTrackingId($trackingId)
    {
        $this->trackingId = $trackingId;
        return $this;
    }

    /**
     * @param mixed $productName
     * @return Paypal_chained_adaptive_payment
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;
        return $this;
    }

    /**
     * @param mixed $productId
     * @return Paypal_chained_adaptive_payment
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
        return $this;
    }
    
    public function addError($error)
    {
        $this->errors[] = $error;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return mixed
     */
    public function getPayPalUrl()
    {
        return $this->payPalUrl;
    }

    /**
     * @return mixed
     */
    public function getPaymentExecStatus()
    {
        return $this->paymentExecStatus;
    }

    /**
     * @return mixed
     */
    public function getPayKey()
    {
        return $this->payKey;
    }

    public function process()
    {
        $receiverEmail = filter_var($this->secondaryReceiver, FILTER_VALIDATE_EMAIL);
        if ( ! $receiverEmail) {
            $this->addError('Invalid Receiver Email');
            return false;
        }

        $amount = filter_var($this->amount, FILTER_VALIDATE_FLOAT);
        if ( ! $amount) {
            $this->addError('Invalid Receiver Amount');
            return false;
        }

        $currency = $this->currency;
        if ( ! $currency or ! in_array($currency, $this->configs['currencies'])) {
            $this->addError('Invalid Receiver Currency');
            return false;
        }

        // PRIMARY RECEIVER
        $primaryReceiver = new Receiver();
        $primaryReceiver->email = $this->configs['adaptive_payments']['primary_receiver']['email'];
        // Amount to be credited to the receiver's account
        $primaryReceiver->amount = $amount;
        // Set to true to indicate a chained payment; only one receiver can be a primary receiver.
        $primaryReceiver->primary = true;

        // SECONDARY RECEIVER
        $secondaryReceiver = new Receiver();
        $secondaryReceiver->email = $receiverEmail;
        // Amount to be credited to the receiver's account
        $secondaryReceiver->amount = $amount - $amount * $this->configs['adaptive_payments']['primary_receiver']['payment_share'] / 100;

        $receiverList = new ReceiverList(array($primaryReceiver, $secondaryReceiver));

        \PayPal\Core\PPHttpConfig::$DEFAULT_CURL_OPTS[CURLOPT_SSLVERSION] = 4;
        $payRequest = new PayRequest(new RequestEnvelope("en_US"), 'PAY', $this->configs['adaptive_payments']['cancelUrl'], $currency, $receiverList, $this->configs['adaptive_payments']['returnUrl']);

        /*
         *  (Optional) The payer of PayPal fees. Allowable values are:

            SENDER – Sender pays all fees (for personal, implicit simple/parallel payments; do not use for chained or unilateral payments)
            PRIMARYRECEIVER – Primary receiver pays all fees (chained payments only)
            EACHRECEIVER – Each receiver pays their own fee (default, personal and unilateral payments)
            SECONDARYONLY – Secondary receivers pay all fees (use only for chained payments with one secondary receiver)

         */
        $payRequest->feesPayer = $this->configs['adaptive_payments']['fees_payer'];

        // The URL to which you want all IPN messages for this payment to be sent. Maximum length: 1024 characters
        $payRequest->ipnNotificationUrl = $this->configs['adaptive_payments']['ipnNotificationUrl'];
        $payRequest->memo = json_encode(array('product_name' => $this->productName, 'product_id' => $this->productId));
        // A unique ID that you specify to track the payment.
        // Note: You are responsible for ensuring that the ID is unique.
        if ($this->trackingId) {
            $payRequest->trackingId = $this->trackingId;
        }

        // send request
        $service = new AdaptivePaymentsService($this->configs['adaptive_payments']['service_params']);
        try {
        	/* wrap API method calls on the service object with a try catch */
            /** @var \PayPal\Types\AP\PayResponse $response */
        	$response = $service->Pay($payRequest);
        }
        catch (Exception $ex) {
            $this->addError($ex->getMessage());
            if ($ex instanceof \PayPal\Exception\PPConnectionException) {
                $this->addError("Error connecting to " . $ex->getUrl());
           	}
            else if ($ex instanceof \PayPal\Exception\PPConfigurationException) {
                $this->addError("Error at {$ex->getLine()} in {$ex->getFile()}");
           	}
            else if ($ex instanceof \PayPal\Exception\PPInvalidCredentialException or $ex instanceof \PayPal\Exception\PPMissingCredentialException) {
                $this->addError($ex->errorMessage());
           	}

        	return false;
        }

        $ack = strtoupper($response->responseEnvelope->ack);
        if ($ack != "SUCCESS") {
            $this->addError("NOT SUCCESS: {$response->error[0]->message}");
            var_dump($response);
            return false;
        }
        else {
            $payKey = $response->payKey;
            $this->paymentExecStatus = $response->paymentExecStatus;
            $this->payKey = $response->payKey;
            switch ($response->paymentExecStatus) {
                case "COMPLETED" :
                    break;

                case "CREATED" :
                    $this->payPalUrl = ('sandbox' == $this->configs['adaptive_payments']['service_params']['mode'] ? $this->configs['paypal_sandbox_url'] : $this->configs['paypal_live_url']) . '_ap-payment&paykey=' . $payKey;
                    break;

                default :
                    $this->addError( "Invalid payment exec status: {$response->paymentExecStatus}");
                    return false;
            }
        }

        return true;
    }

    /**
     * @return bool|Ipn
     */
    public function validateIpn()
    {
        // first param takes ipn data to be validated. if null, raw POST data is read from input stream
        $ipnMessage = new PPIPNMessage(null, $this->configs['connection_params']);

        #log_message('debug', 'paypal message initialized');

        \PayPal\Core\PPHttpConfig::$DEFAULT_CURL_OPTS[CURLOPT_SSLVERSION] = 4;
        $result = $ipnMessage->validate();

        #log_message('debug', 'paypal message validated');

        if ($result) {
            return new Ipn($ipnMessage->getRawData());
        }
        $this->addError("Error: Got invalid IPN data");
        return false;
    }
}
