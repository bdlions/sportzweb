<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Footer extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library("org/utility/utils");
        $this->load->library("org/footer/about_us");
        $this->load->library("org/footer/contact_us_library");
        $this->load->helper('url');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
       
    }

    public function index() {
        //add your logic if required
    }
    
    public function about_us() {
        
        $result = $this->about_us->get_about_us_info();
        $region_id_text_map_db = $result['region_id_text_map'];
        $region_id_image_map_db = $result['region_id_image_map'];
        $region_text_map = array();
        $region_image_map = array();
        if(array_key_exists(ABOUT_US_IMAGE_REGION1_ID, $region_id_image_map_db))
        {
            $region_image_map[ABOUT_US_IMAGE_REGION1_ID] = $region_id_image_map_db[ABOUT_US_IMAGE_REGION1_ID];
        }
        else
        {
            $region_image_map[ABOUT_US_IMAGE_REGION1_ID] = 'social_networing.jpg';
        }
        if(array_key_exists(ABOUT_US_IMAGE_REGION2_ID, $region_id_image_map_db))
        {
            $region_image_map[ABOUT_US_IMAGE_REGION2_ID] = $region_id_image_map_db[ABOUT_US_IMAGE_REGION2_ID];
        }
        else
        {
            $region_image_map[ABOUT_US_IMAGE_REGION2_ID] = 'social_community.jpg';
        }
        if(array_key_exists(ABOUT_US_IMAGE_REGION3_ID, $region_id_image_map_db))
        {
            $region_image_map[ABOUT_US_IMAGE_REGION3_ID] = $region_id_image_map_db[ABOUT_US_IMAGE_REGION3_ID];
        }
        else
        {
            $region_image_map[ABOUT_US_IMAGE_REGION3_ID] = 'application_img.jpg';
        }
        if(array_key_exists(ABOUT_US_IMAGE_REGION4_ID, $region_id_image_map_db))
        {
            $region_image_map[ABOUT_US_IMAGE_REGION4_ID] = $region_id_image_map_db[ABOUT_US_IMAGE_REGION4_ID];
        }
        else
        {
            $region_image_map[ABOUT_US_IMAGE_REGION4_ID] = 'sportz_logo.png';
        }
        
        if(array_key_exists(NAVIGATION_HEADER_ID, $region_id_text_map_db))
        {
            $region_text_map[NAVIGATION_HEADER_ID] = $region_id_text_map_db[NAVIGATION_HEADER_ID];
        }
        else
        {
            $region_text_map[NAVIGATION_HEADER_ID] = '';
        }
        
        if(array_key_exists(VISSION_OBJECT_MISSION_ID, $region_id_text_map_db))
        {
            $region_text_map[VISSION_OBJECT_MISSION_ID] = $region_id_text_map_db[VISSION_OBJECT_MISSION_ID];
        }
        else
        {
            $region_text_map[VISSION_OBJECT_MISSION_ID] = '';
        }
        if(array_key_exists(MISSION_STATEMENT_ID, $region_id_text_map_db))
        {
            $region_text_map[MISSION_STATEMENT_ID] = $region_id_text_map_db[MISSION_STATEMENT_ID];
        }
        else
        {
            $region_text_map[MISSION_STATEMENT_ID] = '';
        }
        
        // 4 middle image
        if(array_key_exists(IMAGE1_ID, $region_id_text_map_db))
        {
            $region_text_map[IMAGE1_ID] = $region_id_text_map_db[IMAGE1_ID];
        }
        else
        {
            $region_text_map[IMAGE1_ID] = '';
        }
        
        if(array_key_exists(IMAGE2_ID, $region_id_text_map_db))
        {
            $region_text_map[IMAGE2_ID] = $region_id_text_map_db[IMAGE2_ID];
        }
        else
        {
            $region_text_map[IMAGE2_ID] = '';
        }
        
        if(array_key_exists(IMAGE3_ID, $region_id_text_map_db))
        {
            $region_text_map[IMAGE3_ID] = $region_id_text_map_db[IMAGE3_ID];
        }
        else
        {
            $region_text_map[IMAGE3_ID] = '';
        }
        
        if(array_key_exists(IMAGE4_ID, $region_id_text_map_db))
        {
            $region_text_map[IMAGE4_ID] = $region_id_text_map_db[IMAGE4_ID];
        }
        else
        {
            $region_text_map[IMAGE4_ID] = '';
        }
        
        // 4 middle heading of image
        if(array_key_exists(MIDDLE_HEADING1_ID, $region_id_text_map_db))
        {
            $region_text_map[MIDDLE_HEADING1_ID] = $region_id_text_map_db[MIDDLE_HEADING1_ID];
        }
        else
        {
            $region_text_map[MIDDLE_HEADING1_ID] = '';
        }
        
        if(array_key_exists(MIDDLE_HEADING2_ID, $region_id_text_map_db))
        {
            $region_text_map[MIDDLE_HEADING2_ID] = $region_id_text_map_db[MIDDLE_HEADING2_ID];
        }
        else
        {
            $region_text_map[MIDDLE_HEADING2_ID] = '';
        }
        
        if(array_key_exists(MIDDLE_HEADING3_ID, $region_id_text_map_db))
        {
            $region_text_map[MIDDLE_HEADING3_ID] = $region_id_text_map_db[MIDDLE_HEADING3_ID];
        }
        else
        {
            $region_text_map[MIDDLE_HEADING3_ID] = '';
        }
        
        if(array_key_exists(MIDDLE_HEADING4_ID, $region_id_text_map_db))
        {
            $region_text_map[MIDDLE_HEADING4_ID] = $region_id_text_map_db[MIDDLE_HEADING4_ID];
        }
        else
        {
            $region_text_map[MIDDLE_HEADING4_ID] = '';
        }
        
        if(array_key_exists(SOCIAL_ID, $region_id_text_map_db))
        {
            $region_text_map[SOCIAL_ID] = $region_id_text_map_db[SOCIAL_ID];
        }
        else
        {
            $region_text_map[SOCIAL_ID] = '';
        }
        
        if(array_key_exists(FEATURES_ID, $region_id_text_map_db))
        {
            $region_text_map[FEATURES_ID] = $region_id_text_map_db[FEATURES_ID];
        }
        else
        {
            $region_text_map[FEATURES_ID] = '';
        }
        
        if(array_key_exists(SECURITY_ID, $region_id_text_map_db))
        {
            $region_text_map[SECURITY_ID] = $region_id_text_map_db[SECURITY_ID];
        }
        else
        {
            $region_text_map[SECURITY_ID] = '';
        }
        
        if(array_key_exists(MOBILE_ID, $region_id_text_map_db))
        {
            $region_text_map[MOBILE_ID] = $region_id_text_map_db[MOBILE_ID];
        }
        else
        {
            $region_text_map[MOBILE_ID] = '';
        }
        $this->data['region_text_map'] = $region_text_map;
        $this->data['region_image_map'] = $region_image_map;
        
        $this->data['message']='';
        $this->data['business_profile_info']=0;
        if (!$this->ion_auth->logged_in()) {
            $this->template->load("templates/about_us_tmpl", "footer/about_us", $this->data);
        }
    }
    
    /*
     * This method will forward non member feed back to the admin
     * @Author Nazmul on 23rd January 2015
     */
    public function contact_us()
    {
        $this->form_validation->set_error_delimiters("<div style='color:red'>", '</div>');
        $this->form_validation->set_rules('name', 'Name', 'xss_clean|required');
        $this->form_validation->set_rules('email', 'Email', 'xss_clean|required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'xss_clean');
        $this->form_validation->set_rules('description', 'Description', 'xss_clean|required');
        $this->data['message']='';
        
        if($this->input->post('submit_feedback'))
        {
            if ($this->form_validation->run() == true) 
            {
                /*$additional_data = array(
                    'topic_id' => $this->input->post('topic_list'),
                    'os_id' => $this->input->post('os_list'),
                    'browser_id' => $this->input->post('browser_list'),
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'phone' => $this->input->post('phone'),
                    'description' => $this->input->post('description'),
                    'created_on' => now()
                );
                $this->contact_us_library->add_feedback($additional_data);*/
                $this->session->set_flashdata('message', 'Your message is sent successfully');
                redirect('footer/contact_us', 'refresh');
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
        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('name'),
        );
        
        $this->data['email'] = array(
            'name' => 'email',
            'id' => 'email',
            'type' => 'text',
            'value' => $this->form_validation->set_value('email'),
        );
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone'),
        );
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
        $this->template->load("templates/non_member_tmpl", "footer/contact_us/non_member", $this->data);
    }
    /*
     * This method will load terms page
     * @Author Nazmul on 25th January 2015
     */
    public function terms()
    {
        $this->data['message'] = '';
        $this->template->load("templates/non_member_tmpl", "footer/terms", $this->data);
    }
        /*
     * This method will load privacy page
     * @Author Nazmul on 25th January 2015
     */
    public function privacy()
    {
        $this->data['message'] = '';
        $this->template->load("templates/non_member_tmpl", "footer/privacy", $this->data);
    }
}
