<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Member_general extends Role_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library("org/footer/contact_us_library");
        $this->load->helper('url');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    public function index() {
        //add your logic if required
    }
    
    /*
     * This method will forward user message to admin related to site error
     * @Author Nazmul on 23rd January 2015
     */
    public function contact_us()
    {
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('description', 'Description', 'xss_clean|required');
        $this->data['message']='';        
        if($this->input->post('submit_feedback'))
        {
            if ($this->form_validation->run() == true) 
            {
                /*$additional_data = array(
                    'user_id' => $this->session->userdata('user_id),
                    'topic_id' => $this->input->post('topic_list'),
                    'os_id' => $this->input->post('os_list'),
                    'browser_id' => $this->input->post('browser_list'),
                    'description' => $this->input->post('description'),
                    'created_on' => now()
                );
                $this->contact_us_library->add_feedback($additional_data);*/
                $this->session->set_flashdata('message', 'Your message is sent successfully');
                redirect('member_general/contact_us', 'refresh');
            }
            else
            {
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            }
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message');
        }
        
        
        $topic_list = array();
        $os_list = array();
        $browser_list = array();
        $topic_list_array = $this->contact_us_library->get_all_topics()->result_array();
        foreach($topic_list_array as $topic_info)
        {
            $topic_list[$topic_info['id']] = $topic_info['title'];
        }
        $this->data['topic_list'] = $topic_list;
        
        $os_list_array = $this->contact_us_library->get_all_operating_systems()->result_array();
        foreach($os_list_array as $os_info)
        {
            $os_list[$os_info['id']] = $os_info['title'];
        }
        $this->data['os_list'] = $os_list;
        
        $browser_list_array = $this->contact_us_library->get_all_browers()->result_array();
        foreach($browser_list_array as $browser_info)
        {
            $browser_list[$browser_info['id']] = $browser_info['title'];
        }
        $this->data['browser_list'] = $browser_list;

        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'textarea',
            'rows' => '13'            
        );
        $this->data['submit_feedback'] = array(
            'name' => 'submit_feedback',
            'id' => 'submit_feedback',
            'type' => 'submit',
            'value' => 'Submit',
        );
        $this->template->load(null, "footer/contact_us/member", $this->data);
    }
}
