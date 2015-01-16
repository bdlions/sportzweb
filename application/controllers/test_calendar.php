<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Test_calendar extends CI_Controller {

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
    }

    function index() {
        $json = file_get_contents(base_url() . 'resources/sample_json/full_calendar_events.json');
        $input_arrays = json_decode($json, true);

        $this->data['events'] = json_encode($input_arrays);
        $this->template->load(NULL, "calendar", $this->data);
    }

}

?>
