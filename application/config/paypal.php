<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['paypal'] = array(
    'currencies' => array(// allowed currencies
        'USD', 'GBP', 'EUR'
    ),
    'paypal_live_url' => 'https://www.paypal.com/webscr?cmd=',// do not change if not required from PayPal
    'paypal_sandbox_url' => 'https://www.sandbox.paypal.com/webscr?cmd=',// do not change if not required from PayPal
    'developer_portal' => 'https://developer.paypal.com',// do not change if not required from PayPal
    'connection_params' => array(// used to make requests to PayPal API
        // values: 'sandbox' for testing
        //		   'live' for production
        "mode" => "sandbox",

        // These values are defaulted in SDK. If you want to override default values, uncomment it and add your value.
        // "http.ConnectionTimeOut" => "5000",
        // "http.Retry" => "2",
    ),
);

// below configs are used for Adaptive Payments
$config['paypal']['adaptive_payments'] = array(
    'cancelUrl' => 'http://app.sportzweb.com/payment/canceled',// where user will return if he cancels payment
    'returnUrl' => 'http://app.sportzweb.com/payment/completed',// where user will return if payment successfully
    'ipnNotificationUrl' => 'http://app.sportzweb.com/payment/ipn',// where PayPal IPN will go
    'primary_receiver' => array(
        'email' => 'ptpro-owner@sonuto.com',// PayPal email of website owner
        'payment_share' => '10',//website owner share % from user payment to trainer
    ),
    /*
     *  The payer of PayPal fees. Allowable values are:
        SENDER – Sender pays all fees (for personal, implicit simple/parallel payments; do not use for chained or unilateral payments)
        PRIMARYRECEIVER – Primary receiver pays all fees (chained payments only)
        EACHRECEIVER – Each receiver pays their own fee (default, personal and unilateral payments)
        SECONDARYONLY – Secondary receivers pay all fees (use only for chained payments with one secondary receiver)
     */
    'fees_payer' => 'SECONDARYONLY',
    // below params used to make requests to PayPal API for Adaptive payments
    // NOTE: used with 'connection_params'
    'service_params' => array_merge($config['paypal']['connection_params'], array(
        // Signature Credential
        // IMPORTANT: when go production, these Credential must be changed to real params from PayPal
        "acct1.UserName" => "ptpro-owner_api1.sonuto.com",
        "acct1.Password" => "UNHJUNC6Y94QDQSR",
        "acct1.Signature" => "AFcWxV21C7fd0v3bYYYRCpSSRl31A6sNmJrfXZJeJ3QRYq5Cy6M.bomo",
        "acct1.AppId" => "APP-80W284485P519543T"

        // Sample Certificate Credential
        // "acct1.UserName" => "certuser_biz_api1.paypal.com",
        // "acct1.Password" => "D6JNKKULHN3G5B8A",
        // Certificate path relative to config folder or absolute path in file system
        // "acct1.CertPath" => "cert_key.pem",
        // "acct1.AppId" => "APP-80W284485P519543T"
    )),
);
