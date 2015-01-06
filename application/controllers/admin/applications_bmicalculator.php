<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Applications_bmicalculator extends CI_Controller{
    public $tmpl = '';
    public $user_group_array = array();
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('org/admin/application/admin_bmi_calculator_library');
        $this->load->library('org/admin/access_level/admin_access_level_library');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
        
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        }
        
        $this->data['allow_view'] = FALSE;
        $this->data['allow_edit'] = FALSE;
        $this->data['allow_delete'] = FALSE;
        $this->data['allow_configuration'] = FALSE;
        $this->data['allow_writing'] = FALSE;
        
        $selected_user_group = $this->session->userdata('user_type');
        if(isset($selected_user_group ) && $selected_user_group != ""){
            $this->user_group_array = array($selected_user_group);
        }
        else
        {
            $this->user_group_array = $this->ion_auth->get_current_user_types();
        } 
        if (in_array(ADMIN, $this->user_group_array)) {
            $this->tmpl = ADMIN_DASHBOARD_TEMPLATE;
            $this->data['allow_view'] = TRUE;
            $this->data['allow_edit'] = TRUE;
            $this->data['allow_delete'] = TRUE;
            $this->data['allow_configuration'] = TRUE;
            $this->data['allow_writing'] = TRUE;
        }
        else
        {
            $access_level_mapping = $this->admin_access_level_library->get_access_level_info($this->session->userdata('user_id'));
            $this->tmpl = USER_DASHBOARD_TEMPLATE;
            $this->data['access_level_mapping'] = $access_level_mapping;
            
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_BMI_CALCULATOR_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
            {
                $this->data['allow_view'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_BMI_CALCULATOR_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT, $access_level_mapping))
            {
                $this->data['allow_edit'] = TRUE;
            }if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_BMI_CALCULATOR_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE, $access_level_mapping))
            {
                $this->data['allow_delete'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_BMI_CALCULATOR_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION, $access_level_mapping))
            {
                $this->data['allow_configuration'] = TRUE;  
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_BMI_CALCULATOR_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING, $access_level_mapping))
            {
                $this->data['allow_writing'] = TRUE;  
            }
            if(!$this->data['allow_view'])
            {
                redirect('admin/general/restriction_view', 'refresh');
            }
        }
    }
    
    public function index()
    {
        $questions_list = $this->admin_bmi_calculator_library->get_question_list()->result_array();
        $this->data['questions_list'] = $questions_list;
        $this->template->load($this->tmpl, "admin/applications/bmi_calculator/bmi_admin_home", $this->data);
    }
    public function add_question()
    {
        $this->data['message'] = '';
        
        $this->form_validation->set_rules('question', 'Question', 'xss_clean|required');
        $this->form_validation->set_rules('answer', 'Answer', 'xss_clean|required');
        
        if($this->input->post('submit_add_question'))
        {
            if ($this->form_validation->run() == true) 
            {
                $data = array(
                    'question' => $this->input->post('question'),
                    'answer' => $this->input->post('answer'),
                    'created_on' => now()
                );

                $question_id = $this->admin_bmi_calculator_library->add_question($data);
                
                if($question_id!=FALSE)
                {
                    $this->data['flag'] = 1;
                    $this->data['message'] = 'Question is added successfully';
                }
                else
                {
                    $this->data['flag'] = 0;
                    $this->data['message'] = 'Question add is unsuccessful';
                }
            }
            else
            {
                $this->data['message'] = validation_errors();
            }
        }
        
        $this->data['question'] = array(
            'name' => 'question',
            'id' => 'question',
            'type' => 'text',
            'value' => '',
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['answer'] = array(
            'name' => 'answer',
            'id' => 'answer',
            'type' => 'text',
            'value' => '',
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['submit_add_question'] = array(
            'name' => 'submit_add_question',
            'id' => 'submit_add_question',
            'type' => 'submit',
            'value' => 'Add',
        );
        
        $this->template->load($this->tmpl, "admin/applications/bmi_calculator/add_question", $this->data);
    }
    public function edit_question($question_id)
    {
        $this->data['message'] = '';
        
        $this->form_validation->set_rules('question', 'Question', 'xss_clean|required');
        $this->form_validation->set_rules('answer', 'Answer', 'xss_clean|required');
        
        
        if($this->input->post('submit_edit_question'))
        {
            if ($this->form_validation->run() == true) 
            {
                $additional_data = array(
                    'question' => $this->input->post('question'),  
                    'answer' => $this->input->post('answer'),
                    'modified_on' => now()
                );
                
                $flag = $this->admin_bmi_calculator_library->update_question($question_id,$additional_data);
                
                if($flag==FALSE)
                {
                    $this->data['message'] = 'Question update is unsuccessful';
                }
                else
                {
                    $this->data['message'] = 'Question update is successful';
                }
            }
            else
            {
                $this->data['message'] = validation_errors();
            }
        }
        
        $question_details = $this->admin_bmi_calculator_library->get_question_info($question_id)->result_array();
        
        if(!empty($question_details))
        {
            $question_details = $question_details[0];
        }
        
        $this->data['question'] = array(
            'name' => 'question',
            'id' => 'question',
            'type' => 'text',
            'value' => $question_details['question'],
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['answer'] = array(
            'name' => 'answer',
            'id' => 'answer',
            'type' => 'text',
            'value' => $question_details['answer'],
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['submit_edit_question'] = array(
            'name' => 'submit_edit_question',
            'id' => 'submit_edit_question',
            'type' => 'submit',
            'value' => 'Update',
        );
        
        $this->data['question_id'] = $question_details['id'];
        $this->template->load($this->tmpl, "admin/applications/bmi_calculator/edit_question", $this->data);
    }
    
    public function delete_question()
    {
        $question_id = $_POST['question_id'];
        $response = array();
        $present_date = date('d-m-Y');
        
        $date_array = $this->admin_bmi_calculator_library->check_for_homepage_configuration($present_date,$question_id);
        
        if(!empty($date_array))
        {
            $response['status'] = 0;
            $response['message'] = 'This question is configed in following date: ';
            
            foreach ($date_array as $date)
            {
                $response['message'] = $response['message'].' '.$date;
            }
            
            echo json_encode($response);
            return;
        }
        else{
        
            $flag = $this->admin_bmi_calculator_library->delete_question($question_id);
        
            if($flag!=FALSE)
            {
                $response['status'] = 1;
                $response['message'] = 'Question successfully deleted';
            }
            else 
            {
                $response['status'] = 0;
                $response['message'] = 'Question deletion is not successful';
            }

            echo json_encode($response);
        }
    }
    
    public function confirmation_for_delete()
    {
        $question_id  = $_POST['question_id'];
        
        $present_date = date('d-m-Y');
        $date_array = $this->admin_bmi_calculator_library->check_for_homepage_configuration($present_date,$question_id);
        
        $flag_homepage = $this->admin_bmi_calculator_library->delete_homepage_configuration($date_array);
        
        $flag = $this->admin_bmi_calculator_library->delete_question($question_id);
        
        
        if($flag!=FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Question successfully deleted';
        }
        else 
        {
            $response['status'] = 0;
            $response['message'] = 'Question deletion is not successful';
        }

        echo json_encode($response);
    }
    
    public function manage_homepage()
    {
        $this->data['message'] = '';
        $question_list = array();
        $question_list = $this->admin_bmi_calculator_library->get_question_list()->result_array();
        $this->data['question_list'] = $question_list;
        if( count($question_list) > 0)
        {
            $this->data['question_list_array'] = $question_list;
        }
        
        $homepage_question_list = array();
        $homepage_config = $this->admin_bmi_calculator_library->get_homepage_question_list_configuration();
        
        $this->data['homepage_question_list'] = $homepage_config['question_list'];
        $this->data['show_advertise'] = $homepage_config['show_advertise'];
        
        $this->template->load($this->tmpl, "admin/applications/bmi_calculator/manage_homepage", $this->data);
    }
    
    public function question_list_for_home_page() {
        $response = array();
        
        $selected_question_id_list = json_decode($_POST['selected_questions_list']);
        $question_order_list = json_decode($_POST['selected_questions_order_list']);
        $selected_date_for_item = $_POST['selected_date_for_item'];
        $show_advertise = $_POST['show_advertise'];
        $length = count($question_order_list);
        $config_array = array();
        
        if( count($selected_question_id_list) == count($question_order_list) ) {
            for($i=0;$i<$length;$i++) {
                $object = new stdClass();
                $object->order_id = $question_order_list[$i];
                $object->question_id = $selected_question_id_list[$i];
                $config_array[] = $object;
            }
        }
        
        
        $data = array(
                'question_list' => json_encode($config_array),
                'selected_date' => $selected_date_for_item,
                'show_advertise' => $show_advertise,
                'created_on' => now()
            );

        $id = $this->admin_bmi_calculator_library->add_homepage_question_list_configuration($data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Question item list is added successfully.';        
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_bmi_calculator_library->errors_alert();
        }
        echo json_encode($response);
    }
    
}

