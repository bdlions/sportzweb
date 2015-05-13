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
    
    public function pay_ptpro($session_id = 0)
    {
        $session_info = array();
        $session_info_array = $this->gympro_library->get_session_info($session_id)->result_array();
        if(!empty($session_info_array)){
            $session_info = $session_info_array[0];
        }
        $this->data['session_info'] = $session_info;
        $this->data['schedule_id'] = $session_id;
        
        $this->data['payment_types'] = array(
            'Discover' => 'Discover',
            'MasterCard' => 'MasterCard',
            'Visa' => 'Visa'
        );
        $this->data['card_number'] = array(
            'name' => 'card_number',
            'id' => 'card_number',
            'type' => 'text',
            'value' => '5424180818927383'
        );    
        $this->data['expired_month'] = array(
            '1' => '01-January',
            '2' => '02-February',
            '3' => '03-March',
            '4' => '04-April',
            '5' => '05-May',
            '6' => '06-June',
            '7' => '07-July',
            '8' => '08-August',
            '9' => '09-September',
            '10' => '10-October',
            '11' => '11-November',
            '12' => '12-December',
        );
        $this->data['expired_year'] = array(
            '2015' => '2015',
            '2016' => '2016',
            '2017' => '2017',
            '2018' => '2018',
            '2019' => '2019',
            '2020' => '2020',
            '2021' => '2021',
            '2022' => '2022',
            '2023' => '2023',
            '2024' => '2024',
            '2025' => '2025',
            '2026' => '2026',
            '2027' => '2027',
            '2028' => '2028',
            '2029' => '2029',
            '2030' => '2030'
        );
        $this->data['ccv_code'] = array(
            'name' => 'ccv_code',
            'id' => 'ccv_code',
            'type' => 'text',
            'value' => 123
        ); 
        $this->data['submit_pay_session'] = array(
            'name' => 'submit_pay_session',
            'id' => 'submit_pay_session',
            'type' => 'submit',
            'value' => 'Submit',
        );
        $this->template->load(null, 'payment/ptpro/index', $this->data);
    }

}