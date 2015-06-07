<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gympro extends Role_Controller {

    private $my_user_id = 0;
    private $account_type_id = APP_GYMPRO_ACCOUNT_TYPE_ID_EXTERNAL;
    private $gympro_user_info = array();

    function __construct() {
        parent::__construct();
        $this->lang->load('auth');
        $this->load->library('form_validation');
        $this->load->library('org/application/gympro_library');
        $this->load->library('org/utility/Utils');
        $this->load->helper('language');
        $this->load->helper('url');
        $this->lang->load('ion_auth');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $this->my_user_id = $this->session->userdata('user_id');
        $gympro_user_info_array = $this->gympro_library->get_gympro_user_info($this->my_user_id)->result_array();
        if (!empty($gympro_user_info_array)) {
            $this->gympro_user_info = $gympro_user_info_array[0];
            $this->account_type_id = $this->gympro_user_info['account_type_id'];
            $this->data['account_type_id'] = $this->gympro_user_info['account_type_id'];
        } else {
            $this->account_type_id = APP_GYMPRO_ACCOUNT_TYPE_ID_EXTERNAL;
            $this->data['account_type_id'] = APP_GYMPRO_ACCOUNT_TYPE_ID_EXTERNAL;
        }
        $this->data['application_id'] = APPLICATION_GYMPRO_ID;
    }

    /*
     * Gympro home page 
     * @Author Nazmul on 11th December 2014
     */

    public function index() {
        if ($this->account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_EXTERNAL) {
            $account_type_list = array();
            $account_types_array = $this->gympro_library->get_all_account_types()->result_array();
            foreach ($account_types_array as $account_type) {
                $account_type_list[$account_type['account_type_id']] = $account_type['title'];
            }
            $this->data['account_type_list'] = $account_type_list;
            $this->data['user_id'] = $this->my_user_id;
            $this->template->load(null, 'applications/gympro/init', $this->data);
        } else if ($this->account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT) {
            redirect('applications/gympro/client_home', 'refresh');
        } else {
            redirect('applications/gympro/pt_home', 'refresh');
        }
    }

    //-----------------------------------Account Type Module-------------------------------//
    /*
     * This method will load account info of a client
     * @Author Nazmul on 17th November 2014
     */
    public function account($user_id = 0) {
        if ($user_id == 0) {
            $user_id = $this->my_user_id;
        }
        $this->data['message'] = '';
        if ($this->input->post('account_type_list')) {
            $account_type_id = $this->input->post('account_type_list');
            $data = array(
                'account_type_id' => $account_type_id
            );
            $status = $this->gympro_library->store_gympro_user_info($user_id, $data);
            if ($status === FALSE) {
                redirect('applications/gympro', 'refresh');
            } else {
                $this->data['message'] = $this->gympro_library->messages();
                if ($account_type_id <= 0) {
                    redirect('applications/gympro', 'refresh');
                } else if ($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT) {
                    redirect('applications/gympro/client_home', 'refresh');
                } else {
                    redirect('applications/gympro/pt_home', 'refresh');
                }
            }
        }
        $account_type_list = array();
        $account_types_array = $this->gympro_library->get_all_account_types()->result_array();
        foreach ($account_types_array as $account_type) {
            $account_type_list[$account_type['account_type_id']] = $account_type['title'];
        }
        $this->data['account_type_list'] = $account_type_list;
        $this->data['selected_account_type'] = APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT;

        $gympro_user_info = array();
        $gympro_user_info_array = $this->gympro_library->get_gympro_user_info($user_id)->result_array();
        if (!empty($gympro_user_info_array)) {
            $gympro_user_info = $gympro_user_info_array[0];
            $this->data['selected_account_type'] = $gympro_user_info['account_type_id'];
        }
        $this->data['user_id'] = $user_id;

        $this->data['submit_update_account'] = array(
            'name' => 'submit_update_account',
            'id' => 'submit_update_account',
            'type' => 'submit',
            'value' => 'Update',
        );
        $this->template->load(null, 'applications/gympro/account', $this->data);
    }

    //----------------------------------- Preference Module ---------------------------------//
    /*
     * This method will load preference info of a client
     * @Author Nazmul on 17th November 2014
     */
    public function preference($user_id = 0) {
        //if external user tries to load this
        if ($this->account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_EXTERNAL) {
            redirect('applications/gympro');
        }
        if ($user_id == 0) {
            $user_id = $this->my_user_id;
        }
        $this->data['message'] = '';
        if ($this->input->post('submit_update_preference')) {
            $data = array(
                'account_email' => $this->input->post('account_email'),
                'height_unit_id' => $this->input->post('height_unit_list'),
                'weight_unit_id' => $this->input->post('weight_unit_list'),
                'girth_unit_id' => $this->input->post('girth_unit_list'),
                'time_zone_id' => $this->input->post('time_zone_list'),
                'hourly_rate_id' => $this->input->post('hourly_rate_list'),
                'currency_id' => $this->input->post('currency_list')
            );
            
            $status = $this->gympro_library->store_gympro_user_info($user_id, $data);
            if ($status) {
                $this->data['message'] = $this->gympro_library->messages();
            } else {
                $this->data['message'] = $this->gympro_library->errors();
            }
        }

        $user_gympro_email_array = array();
        $user_email_array = array();
        $user_gympro_email_array = $this->gympro_library->get_gympro_user_email($user_id)->result_array();
        if ((!empty($user_gympro_email_array))&& $user_gympro_email_array[0]['account_email'] != null) {
            $this->data['account_email'] = $user_gympro_email_array[0]['account_email'];
        } else {
            $user_email_array = $this->gympro_library->get_user_email($user_id)->result_array();
            if (!empty($user_email_array)) {
                $this->data['account_email'] = $user_email_array[0]['email'];
            }
        }
        $height_unit_list = array();
        $height_unit_array = $this->gympro_library->get_all_height_units()->result_array();
        foreach ($height_unit_array as $height_unit) {
            $height_unit_list[$height_unit['height_unit_id']] = $height_unit['title'];
        }
        $this->data['height_unit_list'] = $height_unit_list;
        $weight_unit_list = array();
        $weight_unit_array = $this->gympro_library->get_all_weight_units()->result_array();
        foreach ($weight_unit_array as $weight_unit) {
            $weight_unit_list[$weight_unit['weight_unit_id']] = $weight_unit['title'];
        }
        $this->data['weight_unit_list'] = $weight_unit_list;
        $girth_unit_list = array();
        $girth_unit_array = $this->gympro_library->get_all_girth_units()->result_array();
        foreach ($girth_unit_array as $girth_unit) {
            $girth_unit_list[$girth_unit['girth_unit_id']] = $girth_unit['title'];
        }
        $this->data['girth_unit_list'] = $girth_unit_list;
        $time_zone_list = array();
        $time_zone_array = $this->gympro_library->get_all_time_zones()->result_array();
        foreach ($time_zone_array as $time_zone) {
            $time_zone_list[$time_zone['time_zone_id']] = $time_zone['title'];
        }
        $this->data['time_zone_list'] = $time_zone_list;
        $hourly_rate_list = array();
        $hourly_rate_array = $this->gympro_library->get_all_hourly_rates()->result_array();
        foreach ($hourly_rate_array as $hourly_rate) {
            $hourly_rate_list[$hourly_rate['hourly_rate_id']] = $hourly_rate['title'];
        }
        $this->data['hourly_rate_list'] = $hourly_rate_list;
        $currency_list = array();
        $currency_array = $this->gympro_library->get_all_currencies()->result_array();
        foreach ($currency_array as $currency) {
            $currency_list[$currency['currency_id']] = $currency['title'];
        }
        $this->data['currency_list'] = $currency_list;
        $this->data['gympro_user_info'] = $this->gympro_user_info;
        $this->data['submit_update_preference'] = array(
            'name' => 'submit_update_preference',
            'id' => 'submit_update_preference',
            'type' => 'submit',
            'value' => 'Update',
        );
        $this->template->load(null, 'applications/gympro/preference', $this->data);
    }

    //-----------------------------------Personal Trainer Module-------------------------------//
    public function pt_home() {
        $this->template->load(null, 'applications/gympro/pt_home', $this->data);
    }

    //----------------------------------- Client Module --------------------------------//
    public function client_home() {
        $this->template->load(null, 'applications/gympro/client_home', $this->data);
    }

    public function my_programmes() {
        $program_list = $this->gympro_library->get_all_client_programs($this->session->userdata('user_id'))->result_array();
        $this->data['program_list'] = $program_list;
        $this->template->load(null, 'applications/gympro/client/my_programmes', $this->data);
    }

    public function my_nutritions() {
        $nutrition_list = $this->gympro_library->get_all_client_nutritions($this->session->userdata('user_id'));
        $this->data['nutrition_list'] = $nutrition_list;
        $this->template->load(null, 'applications/gympro/client/my_nutritions', $this->data);
    }

    public function my_assessments() {
        $assessment_list = $this->gympro_library->get_all_client_assessments($this->session->userdata('user_id'))->result_array();
        $this->data['assessment_list'] = $assessment_list;
        $this->template->load(null, 'applications/gympro/client/my_assessments', $this->data);
    }

    public function my_missions() {
        $mission_list = $this->gympro_library->get_all_client_missions($this->session->userdata('user_id'))->result_array();
        $this->data['mission_list'] = $mission_list;
        $this->template->load(null, 'applications/gympro/client/my_missions', $this->data);
    }

    public function my_exercises() {
        $exercise_list = $this->gympro_library->get_all_client_exercises($this->session->userdata('user_id'))->result_array();
        $this->data['exercise_list'] = $exercise_list;
        $this->template->load(null, 'applications/gympro/client/my_exercises', $this->data);
    }

    /*
     * This method will show client list of gympro user
     * @Author Nazmul on 10th December 2014
     */

    public function manage_clients() {
        $client_list = $this->gympro_library->get_all_clients($this->session->userdata('user_id'))->result_array();
        $this->data['client_list'] = $client_list;
        $this->data['message'] = '';
        $this->template->load(null, 'applications/gympro/client/clients', $this->data);
    }

    public function search_client() {
        $this->template->load(null, 'applications/gympro/client/client_search', $this->data);
    }

    /*
     * This method will create a new client under the gympro user
     * @param $member_id, user if of the main site
     * @Author Nazmul on 10th December 2014
     */

    public function create_client($member_id = 0) {
        if ($member_id == 0) {
            redirect('applications/gympro/manage_clients', 'refresh');
        }
        //CHECK IF THE CLIENT CREATE LIMIT HAS EXCEED
        //CHECK IF THE CLIENT IS PREVIOUSLY ADDED OR NOT
        if ($this->gympro_library->is_client_exist($this->my_user_id, $member_id)) {
            redirect('applications/gympro/manage_clients');
        }
        $this->data['message'] = '';
        $this->form_validation->set_rules('notes', 'Note', 'xss_clean');

        $question_list = $this->gympro_library->get_all_health_questions()->result_array();
        $this->data['question_list'] = $question_list;

        if ($this->input->post()) {
            $result = array();
            $result['message'] = '';
            if ($this->form_validation->run() == true) {
                $picture = "";
                if (isset($_FILES["userfile"])) {
                    $result = $this->utils->upload_image($_FILES["userfile"], CLIENT_PROFILE_PIC_IMAGEPATH);
                    if ($result['status'] == 1) {
                        $source_path = CLIENT_PROFILE_PIC_IMAGEPATH . $result['upload_data']['file_name'];
                        $destination_path = CLIENT_PROFILE_PICTURE_PATH_W50_H50 . $result['upload_data']['file_name'];
                        $this->utils->resize_image($source_path, $destination_path, CLIENT_PROFILE_PICTURE_H50, CLIENT_PROFILE_PICTURE_W50);
                        $picture = $result['upload_data']['file_name'];
                    }
                }
                $answer_list = array();
                foreach ($question_list as $question_info) {
                    $answer_list[] = array(
                        'id' => $question_info['question_id'],
                        'answer' => $this->input->post('question_radio_' . $question_info['question_id']),
                        'additional_info' => $this->input->post('question_additional_info_' . $question_info['question_id'])
                    );
                }
                $data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'member_id' => $member_id,
                    'start_date' => $this->input->post('start_date'),
                    'end_date' => $this->input->post('end_date'),
                    'status_id' => $this->input->post('client_status_list'),
                    'mobile' => $this->input->post('mobile'),
                    'address' => $this->input->post('address'),
                    'emergency_contact' => $this->input->post('emergency_contact'),
                    'emergency_phone' => $this->input->post('emergency_phone'),
                    'height' => $this->input->post('height'),
                    'resting_heart_rate' => $this->input->post('resting_heart_rate'),
                    'blood_pressure' => $this->input->post('blood_pressure'),
                    'notes' => $this->input->post('notes'),
                    'question_answer_list' => json_encode($answer_list)
                );
                $client_id = $this->gympro_library->create_client($data);
                if ($client_id !== FALSE) {
                    $result['message'] = $this->gympro_library->messages_alert();
                } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $result['message'] = validation_errors();
            }
            echo json_encode($result);
            return;
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }

        $member_info = array();
        $member_info_array = $this->ion_auth_model->get_users(array($member_id))->result_array();
        if (!empty($member_info_array)) {
            $member_info = $member_info_array[0];
            $member_info['dob'] = $this->utils->convert_date_from_db_to_user($member_info['dob']);
        } else {
            redirect('applications/gympro/manage_clients', 'refresh');
        }
        $this->data['member_info'] = $member_info;

        $gender_array = $this->gympro_library->get_all_genders()->result_array();
        $this->data['gender_list'] = array();
        foreach ($gender_array as $gender_info) {
            $this->data['gender_list'][$gender_info['gender_id']] = $gender_info['gender_name'];
        }
        $client_status_array = $this->gympro_library->get_all_client_statuses()->result_array();
        $this->data['client_status_list'] = array();
        foreach ($client_status_array as $client_status_info) {
            $this->data['client_status_list'][$client_status_info['client_status_id']] = $client_status_info['title'];
        }
        $this->data['start_date'] = array(
            'name' => 'start_date',
            'id' => 'start_date',
            'type' => 'text'
        );
        $this->data['end_date'] = array(
            'name' => 'end_date',
            'id' => 'end_date',
            'type' => 'text'
        );
        $this->data['status_id'] = array(
            'name' => 'status_id',
            'id' => 'status_id',
            'type' => 'text'
        );
        $this->data['picture'] = array(
            'name' => 'picture',
            'id' => 'picture',
            'type' => 'file'
        );
        $this->data['mobile'] = array(
            'name' => 'mobile',
            'id' => 'mobile',
            'type' => 'text'
        );
        $this->data['address'] = array(
            'name' => 'address',
            'id' => 'address',
            'type' => 'text'
        );
        $this->data['emergency_contact'] = array(
            'name' => 'emergency_contact',
            'id' => 'emergency_contact',
            'type' => 'text'
        );
        $this->data['emergency_phone'] = array(
            'name' => 'emergency_phone',
            'id' => 'emergency_phone',
            'type' => 'text'
        );
        $this->data['height'] = array(
            'name' => 'height',
            'id' => 'height',
            'type' => 'text'
        );
        $this->data['resting_heart_rate'] = array(
            'name' => 'resting_heart_rate',
            'id' => 'resting_heart_rate',
            'type' => 'text'
        );
        $this->data['blood_pressure'] = array(
            'name' => 'blood_pressure',
            'id' => 'blood_pressure',
            'type' => 'text'
        );
        $this->data['notes'] = array(
            'name' => 'notes',
            'id' => 'notes',
            'type' => 'text'
        );
        $this->data['submit_create_client'] = array(
            'name' => 'submit_create_client',
            'id' => 'submit_create_client',
            'type' => 'submit',
            'value' => 'Save Client'
        );
        $this->template->load(null, 'applications/gympro/client/client_create', $this->data);
    }

    /*
     * This method will update a client
     * @param $client_id, client id
     * @Author Nazmul on 10th December 2014
     */

    public function edit_client($client_id = 0) {
        $this->data['message'] = '';
        $this->form_validation->set_rules('note', 'Note', 'xss_clean');
        //getting health question list
        $question_list = $this->gympro_library->get_all_health_questions()->result_array();
        $this->data['question_list'] = $question_list;
        if ($this->input->post()) {
            $result = array();
            $result['message'] = '';
            if ($this->form_validation->run() == true) {
                $data = array(
                    'start_date' => $this->input->post('start_date'),
                    'end_date' => $this->input->post('end_date'),
                    'status_id' => $this->input->post('client_status_list'),
                    'mobile' => $this->input->post('mobile'),
                    'address' => $this->input->post('address'),
                    'emergency_contact' => $this->input->post('emergency_contact'),
                    'emergency_phone' => $this->input->post('emergency_phone'),
                    'height' => $this->input->post('height'),
                    'resting_heart_rate' => $this->input->post('resting_heart_rate'),
                    'blood_pressure' => $this->input->post('blood_pressure'),
                    'notes' => $this->input->post('notes'),
                    'user_id' => $this->session->userdata('user_id')
                );
                $picture = "";
                if (isset($_FILES["userfile"])) {
                    $result = $this->utils->upload_image($_FILES["userfile"], CLIENT_PROFILE_PIC_IMAGEPATH);
                    if ($result['status'] == 1) {
                        $source_path = CLIENT_PROFILE_PIC_IMAGEPATH . $result['upload_data']['file_name'];
                        $destination_path = CLIENT_PROFILE_PICTURE_PATH_W50_H50 . $result['upload_data']['file_name'];
                        $this->utils->resize_image($source_path, $destination_path, CLIENT_PROFILE_PICTURE_H50, CLIENT_PROFILE_PICTURE_W50);
                        $picture = $result['upload_data']['file_name'];
                        $data['picture'] = $picture;
                    }
                }
                $answer_list = array();
                foreach ($question_list as $question_info) {
                    $answer_list[] = array(
                        'id' => $question_info['question_id'],
                        'answer' => $this->input->post('question_radio_' . $question_info['question_id']),
                        'additional_info' => $this->input->post('question_additional_info_' . $question_info['question_id'])
                    );
                }
                $data['question_answer_list'] = json_encode($answer_list);
                if ($this->gympro_library->update_client($client_id, $data)) {
                    $result['message'] = $this->gympro_library->messages_alert();
                } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $result['message'] = validation_errors();
            }
            echo json_encode($result);
            return;
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
        $client_info = array();
        $client_info_array = $this->gympro_library->get_client_info($client_id)->result_array();
        if (!empty($client_info_array)) {
            $client_info = $client_info_array[0];
        } else {
            $this->template->load(null, 'applications/gympro/client/client_edit_validation', $this->data);
            return;
        }
        if ($client_info['user_id'] == $this->my_user_id) {

            $this->data['question_id_answer_map'] = $this->gympro_library->get_question_answers($client_id);

            $member_id = $client_info['member_id'];
            $member_info = array();
            $member_info_array = $this->ion_auth_model->get_users(array($member_id))->result_array();
            if (!empty($member_info_array)) {
                $member_info = $member_info_array[0];
            } else {
                redirect('applications/gympro/manage_clients', 'refresh');
            }
            $this->data['member_info'] = $member_info;

            $gender_array = $this->gympro_library->get_all_genders()->result_array();
            $this->data['gender_list'] = array();
            foreach ($gender_array as $gender_info) {
                $this->data['gender_list'][$gender_info['gender_id']] = $gender_info['gender_name'];
            }
            $this->data['selected_gender_id'] = $client_info['gender_id'];
            $client_status_array = $this->gympro_library->get_all_client_statuses()->result_array();
            $this->data['client_status_list'] = array();
            foreach ($client_status_array as $client_status_info) {
                $this->data['client_status_list'][$client_status_info['client_status_id']] = $client_status_info['title'];
            }

            $this->data['selected_status_id'] = $client_info['status_id'];
            $this->data['start_date'] = array(
                'name' => 'start_date',
                'id' => 'start_date',
                'type' => 'text',
                'value' => $client_info['start_date']
            );
            $this->data['end_date'] = array(
                'name' => 'end_date',
                'id' => 'end_date',
                'type' => 'text',
                'value' => $client_info['end_date']
            );
            $this->data['status_id'] = array(
                'name' => 'status_id',
                'id' => 'status_id',
                'type' => 'text',
                'value' => $client_info['status_id']
            );
            $this->data['phone'] = array(
                'name' => 'phone',
                'id' => 'phone',
                'type' => 'text',
                'value' => $client_info['phone']
            );
            $this->data['mobile'] = array(
                'name' => 'mobile',
                'id' => 'mobile',
                'type' => 'text',
                'value' => $client_info['mobile']
            );
            $this->data['address'] = array(
                'name' => 'address',
                'id' => 'address',
                'type' => 'text',
                'value' => $client_info['address']
            );
            $this->data['emergency_contact'] = array(
                'name' => 'emergency_contact',
                'id' => 'emergency_contact',
                'type' => 'text',
                'value' => $client_info['emergency_contact']
            );
            $this->data['emergency_phone'] = array(
                'name' => 'emergency_phone',
                'id' => 'emergency_phone',
                'type' => 'text',
                'value' => $client_info['emergency_phone']
            );
            $this->data['height'] = array(
                'name' => 'height',
                'id' => 'height',
                'type' => 'text',
                'value' => $client_info['height']
            );
            $this->data['resting_heart_rate'] = array(
                'name' => 'resting_heart_rate',
                'id' => 'resting_heart_rate',
                'type' => 'text',
                'value' => $client_info['resting_heart_rate']
            );
            $this->data['blood_pressure'] = array(
                'name' => 'blood_pressure',
                'id' => 'blood_pressure',
                'type' => 'text',
                'value' => $client_info['blood_pressure']
            );
            $this->data['notes'] = array(
                'name' => 'notes',
                'id' => 'notes',
                'type' => 'text',
                'value' => $client_info['notes']
            );
            $this->data['submit_edit_client'] = array(
                'name' => 'submit_edit_client',
                'id' => 'submit_edit_client',
                'type' => 'submit',
                'value' => 'Save'
            );
            $this->data['client_info'] = $client_info;
            $this->template->load(null, 'applications/gympro/client/client_edit', $this->data);
        } else {
            $this->template->load(null, 'applications/gympro/client/client_edit_validation', $this->data);
        }
    }

    /*
     * This method will show client info
     * @param @client_id, client id
     * @Author Nazmul on 14th December 2014
     */

    public function show_client($client_id) {
        $client_info = array();
        $client_info_array = $this->gympro_library->get_client_detail($client_id)->result_array();

        if (!empty($client_info_array)) {
            $client_info = $client_info_array[0];
        } else {
            $this->data['message'] = "Invalid Client id.";
            $this->template->load(null, 'applications/gympro/client/client_show_validation', $this->data);
            return;
            // redirect('applications/gympro/manage_clients', 'refresh');
        }
        if ($client_info['ptpro_user_id'] == $this->my_user_id) {
            $this->data['question_list'] = $this->gympro_library->get_all_health_questions()->result_array();
            $this->data['question_id_answer_map'] = $this->gympro_library->get_question_answers($client_id);
            $this->data['client_info'] = $client_info;

            $program_list = $this->gympro_library->get_all_client_programs(0, $client_id)->result_array();
            $this->data['program_list'] = $program_list;
            $assessment_list = $this->gympro_library->get_all_client_assessments(0, $client_id)->result_array();
            $this->data['assessment_list'] = $assessment_list;
            $mission_list = $this->gympro_library->get_all_client_missions(0, $client_id)->result_array();
            $this->data['mission_list'] = $mission_list;
            $nutrition_list = $this->gympro_library->get_all_client_nutritions(0, $client_id);
            $this->data['nutrition_list'] = $nutrition_list;

            $this->template->load(null, 'applications/gympro/client/client_show', $this->data);
        } else {
            $this->data['message'] = "Sorry! You are not permitted to show this client information";
            $this->template->load(null, 'applications/gympro/client/client_show_validation', $this->data);
        }
    }

    /*
     * This method will delete a client
     * @param @client_id, client id
     * @Author Nazmul on 14th December 2014
     */

    public function delete_client() {
        $result = array();
        $client_id = $this->input->post('client_id');
        if ($this->gympro_library->delete_client($client_id)) {
            $result['message'] = $this->gympro_library->messages_alert();
        } else {
            $result['message'] = $this->gympro_library->errors_alert();
        }
        echo json_encode($result);
    }

    //----------------------------------- Group Module ---------------------------------//
    /* This method will show all groups of a gympro user
     * @Author Nazmul on 11th December 2014
     */
    public function manage_groups() {
        $this->data['message'] = '';
        $this->data['group_list'] = $this->gympro_library->get_all_groups($this->session->userdata('user_id'));
        $this->template->load(null, 'applications/gympro/group/groups', $this->data);
    }

    /*
     * Ajax Call
     * This method will create a group under a gympro user
     * @Author Nazmul on 11th December 2014
     */

    public function create_group() {
        $this->data['message'] = '';
        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_rules('title', 'title', 'xss_clean|required');
        $this->data['client_list'] = $this->gympro_library->get_all_clients($user_id)->result_array();
        if ($this->input->post()) {
            $result = array();
            $result['message'] = '';
            if ($this->form_validation->run() == true) {
                $client_id_list = array();
                if ($this->input->post('selected_client_list')) {
                    $client_id_list = explode(",", $this->input->post('selected_client_list'));
                }
                $data = array(
                    'title' => $this->input->post('title'),
                    'phone' => $this->input->post('phone'),
                    'mobile' => $this->input->post('mobile'),
                    'notes' => $this->input->post('notes'),
                    'user_id' => $user_id
                );
                $group_id = $this->gympro_library->create_group($data, $client_id_list);
                if ($group_id !== FALSE) {
                    $result['message'] = $this->gympro_library->messages_alert();
                } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $result['message'] = strip_tags(validation_errors());
            }
            echo json_encode($result);
            return;
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
        $exercise_categories_array = $this->gympro_library->get_all_exercise_categories()->result_array();
        $this->data['exercise_category_list'] = array();
        foreach ($exercise_categories_array as $exercise_category_info) {
            $this->data['exercise_category_list'][$exercise_category_info['exercise_category_id']] = $exercise_category_info['title'];
        }


        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text'
        );
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text'
        );
        $this->data['mobile'] = array(
            'name' => 'mobile',
            'id' => 'mobile',
            'type' => 'text'
        );
        $this->data['notes'] = array(
            'name' => 'notes',
            'id' => 'notes',
            'type' => 'text'
        );
        $this->data['submit_create_group'] = array(
            'name' => 'submit_create_group',
            'id' => 'submit_create_group',
            'type' => 'submit',
            'value' => 'Save Changes'
        );
        $this->template->load(null, 'applications/gympro/group/group_create', $this->data);
    }

    /*
     * Ajax Call
     * This method will edit a group
     * @param $group_id, group id
     * @Author Nazmul on 11th December 2014
     */

    public function edit_group($group_id = 0) {
        $this->data['message'] = '';
        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_rules('title', 'title', 'xss_clean|required');
        $this->data['client_list'] = $this->gympro_library->get_all_clients($user_id)->result_array();
        $this->data['selected_client_id_list'] = $this->gympro_library->get_client_id_list_in_group($group_id);
        if ($this->input->post()) {
            $result = array();
            $result['message'] = '';
            if ($this->form_validation->run() == true) {
                $client_id_list = array();
                if ($this->input->post('selected_client_list')) {
                    $client_id_list = explode(",", $this->input->post('selected_client_list'));
                }
                $data = array(
                    'title' => $this->input->post('title'),
                    'phone' => $this->input->post('phone'),
                    'mobile' => $this->input->post('mobile'),
                    'notes' => $this->input->post('notes'),
                    'user_id' => $user_id
                );
                if ($this->gympro_library->update_group($group_id, $data, $client_id_list)) {
                    $result['message'] = $this->gympro_library->messages_alert();
                } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $result['message'] = validation_errors();
            }
            echo json_encode($result);
            return;
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
        $group_info = array();
        $group_info_array = $this->gympro_library->get_group_info($group_id)->result_array();
        if (!empty($group_info_array)) {
            $group_info = $group_info_array[0];
        } else {
            $this->template->load(null, 'applications/gympro/group/group_edit_validation', $this->data);
            return;
        }
        if ($group_info['user_id'] == $this->my_user_id) {
            $this->data['title'] = array(
                'name' => 'title',
                'id' => 'title',
                'type' => 'text',
                'value' => $group_info['title']
            );
            $this->data['phone'] = array(
                'name' => 'phone',
                'id' => 'phone',
                'type' => 'text',
                'value' => $group_info['phone']
            );
            $this->data['mobile'] = array(
                'name' => 'mobile',
                'id' => 'mobile',
                'type' => 'text',
                'value' => $group_info['mobile']
            );
            $this->data['notes'] = array(
                'name' => 'notes',
                'id' => 'notes',
                'type' => 'text',
                'value' => $group_info['notes']
            );
            $this->data['submit_edit_group'] = array(
                'name' => 'submit_edit_group',
                'id' => 'submit_edit_group',
                'type' => 'submit',
                'value' => 'Save Changes'
            );
            $this->data['group_info'] = $group_info;
            $this->template->load(null, 'applications/gympro/group/group_edit', $this->data);
        } else {
            $this->template->load(null, 'applications/gympro/group/group_edit_validation', $this->data);
        }
    }

    /*
     * This method will show a group
     * @param $group_id, group id
     * @Author Nazmul on 14th December 2014
     */

    public function show_group($group_id) {

        $group_info = array();
        $group_info_array = $this->gympro_library->get_group_info($group_id)->result_array();
        $client_info_in_group = $this->gympro_library->get_clients_info_in_group($group_id);

//        $user_id = $this->session->userdata('user_id');
//        $this->data['client_list'] = $this->gympro_library->get_all_clients($user_id)->result_array();
//        $this->data['selected_client_id_list'] = $this->gympro_library->get_client_id_list_in_group($group_id);
        if (!empty($group_info_array)) {
            $group_info = $group_info_array[0];
        } else {
            $this->template->load(null, 'applications/gympro/group/group_show_validation', $this->data);
            return;
        }
        if ($group_info['user_id'] == $this->my_user_id) {
            $this->data['group_info'] = $group_info;
            $this->data['client_info_in_group'] = $client_info_in_group;
            $this->template->load(null, 'applications/gympro/group/group_show', $this->data);
        } else {
            $this->template->load(null, 'applications/gympro/group/group_show_validation', $this->data);
        }
    }

    /*
     * Ajax call
     * This method will delete a group
     * @Author Nazmul on 11th December 2014
     */

    public function delete_group() {
        $result = array();
        $group_id = $this->input->post('group_id');
        if ($this->gympro_library->delete_group($group_id)) {
            $result['message'] = $this->gympro_library->messages_alert();
        } else {
            $result['message'] = $this->gympro_library->errors_alert();
        }
        echo json_encode($result);
    }

    public function program_subcategory_list() {
        $result = array();
        $category_id = $this->input->post('category_id');
        $result['subcategory_list'] = $this->gympro_library->get_all_exercise_subcategories($category_id)->result_array();
        echo json_encode($result);
    }

    //-----------------------------------------Program Module------------------------------------//
    /*
     * This method will show all programs of this gympro user
     * @Author Nazmul on 7th December 2014
     */
    public function programs() {
        $program_list = $this->gympro_library->get_all_programs($this->session->userdata('user_id'));
        $this->data['program_list'] = $program_list;
        $this->data['message'] = '';
        $this->template->load(null, 'applications/gympro/program/programs', $this->data);
    }

    /*
     * This method will creae a new nutrition
     * @Author Nazmul on 7th December 2014
     */

    public function create_program() {
        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_rules('focus', 'Focus', 'xss_clean|required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'xss_clean');

        if ($this->input->post()) {
            $result = array();
            $result['message'] = '';
            if ($this->form_validation->run() == true) {
                $exercise_list = array();
//                $counter=$this->input->post('weight_counter');
                $counter = $this->input->post('counter');
                for ($i = 1; $i <= $counter; $i++) {
                    if (($this->input->post('weight_is_present_' . $i) ) != NULL) {
                        $exercise_list[] = array(
                            'type' => "weight",
                            'name' => $this->input->post('name_' . $i),
                            'description' => $this->input->post('description_' . $i),
                            'sets' => $this->input->post('sets_' . $i),
                            'reps' => $this->input->post('reps_' . $i),
                            'weights' => $this->input->post('weights_' . $i),
                            'reps2' => $this->input->post('reps2_' . $i),
                            'tempo' => $this->input->post('tempo_' . $i)
                        );
                        continue;
                    } elseif (($this->input->post('cardio_is_present_' . $i) ) != NULL) {
                        $exercise_list[] = array(
                            'type' => "cardio",
                            'name' => $this->input->post('name_' . $i),
                            'description' => $this->input->post('description_' . $i),
                            'level' => $this->input->post('level_' . $i),
                            'speed' => $this->input->post('speed_' . $i),
                            'time' => $this->input->post('time_' . $i),
                            'target' => $this->input->post('target_' . $i)
                        );
                    }
                }
                $data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'focus' => $this->input->post('focus'),
                    'start_date' => $this->input->post('start_date'),
                    'review_id' => $this->input->post('review_id'),
                    'description' => $this->input->post('description'),
                    'warm_up' => $this->input->post('warm_up'),
                    'cool_down' => $this->input->post('cool_down'),
                    'exercise_list' => json_encode($exercise_list)
                );
                $client_id = $this->input->post('client_list');
                if ($client_id > 0) {
                    $data['client_id'] = $client_id;
                }
                $create_program_id = $this->gympro_library->create_program($data);
                if ($create_program_id !== FALSE) {
                    $result['message'] = $this->gympro_library->messages_alert();
                    //redirect('applications/gympro/programs', 'refresh');
                } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $result['message'] = validation_errors();
            }
            echo json_encode($result);
            return;
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
        $this->data['client_list'] = $this->gympro_library->get_all_clients($user_id)->result_array();
        $this->data['selected_client_id'] = 0;
        $this->data['exercise_category_list'] = array(
            0 => '---SELECT A CATEGORY---'
        );
        $exercise_categories_array = $this->gympro_library->get_all_exercise_categories()->result_array();
        foreach ($exercise_categories_array as $exercise_category_info) {
            $this->data['exercise_category_list'][$exercise_category_info['exercise_category_id']] = $exercise_category_info['title'];
        }
        $this->data['review_array'] = $this->gympro_library->get_all_reviews()->result_array();
        $this->data['message'] = '';
        $this->template->load(null, 'applications/gympro/program/program_create', $this->data);
    }

    public function edit_program($program_id = 0) {
        $this->form_validation->set_rules('focus', 'Focus', 'xss_clean|required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'xss_clean');

        if ($this->input->post()) {
            $result = array();
            $result['message'] = '';
            if ($this->form_validation->run() == true) {
                $exercise_list = array();
//                $counter=$this->input->post('weight_counter');
                $counter = $this->input->post('counter');
                for ($i = 1; $i <= $counter; $i++) {
                    if (($this->input->post('weight_is_present_' . $i) ) != NULL) {
                        $exercise_list[] = array(
                            'type' => "weight",
                            'name' => $this->input->post('name_' . $i),
                            'description' => $this->input->post('description_' . $i),
                            'sets' => $this->input->post('sets_' . $i),
                            'reps' => $this->input->post('reps_' . $i),
                            'weights' => $this->input->post('weights_' . $i),
                            'reps2' => $this->input->post('reps2_' . $i),
                            'tempo' => $this->input->post('tempo_' . $i)
                        );
                        continue;
                    } elseif (($this->input->post('cardio_is_present_' . $i) ) != NULL) {
                        $exercise_list[] = array(
                            'type' => "cardio",
                            'name' => $this->input->post('name_' . $i),
                            'description' => $this->input->post('description_' . $i),
                            'level' => $this->input->post('level_' . $i),
                            'speed' => $this->input->post('speed_' . $i),
                            'time' => $this->input->post('time_' . $i),
                            'target' => $this->input->post('target_' . $i)
                        );
                    }
                }
                $data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'focus' => $this->input->post('focus'),
                    'start_date' => $this->input->post('start_date'),
                    'review_id' => $this->input->post('review_id'),
                    'description' => $this->input->post('description'),
                    'warm_up' => $this->input->post('warm_up'),
                    'cool_down' => $this->input->post('cool_down'),
                    'exercise_list' => json_encode($exercise_list)
                );
                $client_id = $this->input->post('client_list');
                if ($client_id > 0) {
                    $data['client_id'] = $client_id;
                } else {
                    $data['client_id'] = NULL;
                }
                $update_program_id = $this->gympro_library->update_program($program_id, $data);
                if ($update_program_id !== FALSE) {
                    $result['message'] = $this->gympro_library->messages_alert();
                    //redirect('applications/gympro/programs', 'refresh');
                } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $result['message'] = validation_errors();
            }
            echo json_encode($result);
            return;
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }

        $this->data['client_list'] = $this->gympro_library->get_all_clients($this->my_user_id)->result_array();
        $this->data['exercise_category_list'] = array(
            0 => '---SELECT A CATEGORY---'
        );
        $exercise_categories_array = $this->gympro_library->get_all_exercise_categories()->result_array();
        foreach ($exercise_categories_array as $exercise_category_info) {
            $this->data['exercise_category_list'][$exercise_category_info['exercise_category_id']] = $exercise_category_info['title'];
        }
        $program_info = array();
        $program_info_array = $this->gympro_library->get_program_info($program_id)->result_array();
        if (!empty($program_info_array)) {
            $program_info = $program_info_array[0];
        } else {
            $this->template->load(null, 'applications/gympro/program/program_edit_validation', $this->data);
            return;
        }
        if ($program_info['user_id'] == $this->my_user_id) {
            $this->data['program'] = $program_info;
            $this->data['exercise_list'] = json_decode($program_info['exercise_list'], TRUE);
            $this->data['review_array'] = $this->gympro_library->get_all_reviews()->result_array();
            $this->data['program_id'] = $program_id;
            $this->data['message'] = '';
            if ($program_info['client_id'] > 0) {
                $this->data['selected_client_id'] = $program_info['client_id'];
            } else {
                $this->data['selected_client_id'] = 0;
            }
            $this->template->load(null, 'applications/gympro/program/program_edit', $this->data);
        } else {
            $this->template->load(null, 'applications/gympro/program/program_edit_validation', $this->data);
        }
    }

    public function subcategry_select() {
        $result = array();
        $category_id = $this->input->post('category_id');
        if ($this->gympro_library->get_all_exercise_subcategories($category_id)) {
            $result['message'] = $this->gympro_library->messages_alert();
        } else {
            $result['message'] = $this->gympro_library->errors_alert();
        }
        echo json_encode($result);
    }

    /*
     * Ajax call to delete program
     * @param $program_id, program id
     * @Author Nazmul on 7th December 2014
     */

    public function delete_program() {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if ($this->gympro_library->delete_program($delete_id)) {
            $result['message'] = $this->gympro_library->messages_alert();
        } else {
            $result['message'] = $this->gympro_library->errors_alert();
        }
        echo json_encode($result);
    }

    /*
     * This method will show program info
     * @param $program_id, program id
     * @Author Nazmul on 31st December 2014
     */

    public function show_program($program_id = 0) {
        if ($program_id == 0) {
            redirect('applications/gympro', 'refresh');
        }
        $program_info = array();
        $program_info_array = $this->gympro_library->get_program_info($program_id)->result_array();
        if (!empty($program_info_array)) {
            $program_info = $program_info_array[0];
        } else {
            $this->template->load(null, 'applications/gympro/program/program_show_validation', $this->data);
            return;
        }
        if ($program_info['user_id'] == $this->my_user_id) {
            $this->data['program_info'] = $program_info;
            $this->data['exercise_list'] = json_decode($program_info['exercise_list'], TRUE);
            $this->data['review_array'] = $this->gympro_library->get_all_reviews()->result_array();
            $this->data['program_id'] = $program_id;
            $this->template->load(null, 'applications/gympro/program/program_show', $this->data);
        } else {
            $this->template->load(null, 'applications/gympro/program/program_show_validation', $this->data);
        }
    }

    //---------------------------------------Exercise Module---------------------------------------//
    /*
     * This method will show all exercises of this gympro user
     * @Author Nazmul on 7th December 2014
     */
    public function manage_exercises() {
        $this->data['message'] = '';
        $this->data['exercise_list'] = $this->gympro_library->get_all_exercises($this->session->userdata('user_id'));
        $this->template->load(null, 'applications/gympro/exercise/exercises', $this->data);
    }

    /*
     * Ajax call
     * This method will creae a new exercise
     * @Author Nazmul on 7th December 2014
     */

    public function create_exercise() {
        $this->data['message'] = '';
        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_rules('name', 'name', 'xss_clean|required');
        if ($this->input->post()) {
            $result = array();
            $result['message'] = '';
            if ($this->form_validation->run() == true) {
                $picture = "";
                if (isset($_FILES["userfile"])) {
                    $result = $this->utils->upload_image($_FILES["userfile"], EXERCISE_IMAGEPATH);
                    if ($result['status'] == 1) {
                        $source_path = EXERCISE_IMAGEPATH . $result['upload_data']['file_name'];
                        $destination_path = EXERCISE_IMAGES_PATH_W50_H50 . $result['upload_data']['file_name'];
                        $this->utils->resize_image($source_path, $destination_path, EXERCISE_IMAGES_PICTURE_W50, EXERCISE_IMAGES_PICTURE_H50);
                        $picture = $result['upload_data']['file_name'];
                    }
                }
                $additional_data = array(
                    'category_id' => $this->input->post('exercise_category_list'),
                    'picture' => $picture,
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'user_id' => $user_id
                );
                $client_id = $this->input->post('client_list');
                if ($client_id > 0) {
                    $additional_data['client_id'] = $client_id;
                }
                $exercise_id = $this->gympro_library->create_exercise($additional_data);
                if ($exercise_id !== FALSE) {
                    $result['message'] = $this->gympro_library->messages_alert();
                } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $result['message'] = validation_errors();
            }
            echo json_encode($result);
            return;
        }
        $this->data['client_list'] = $this->gympro_library->get_all_clients($user_id)->result_array();
        $this->data['selected_client_id'] = 0;
        $exercise_categories_array = $this->gympro_library->get_all_exercise_categories()->result_array();
        $this->data['exercise_category_list'] = array();
        foreach ($exercise_categories_array as $exercise_category_info) {
            $this->data['exercise_category_list'][$exercise_category_info['exercise_category_id']] = $exercise_category_info['title'];
        }

        $this->data['name'] = array(
            'name' => 'name',
            'id' => 'name',
            'type' => 'text'
        );
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text'
        );
        $this->data['picture'] = array(
            'name' => 'picture',
            'id' => 'picture',
            'type' => 'file'
        );
        $this->data['submit_create_exercise'] = array(
            'name' => 'submit_create_exercise',
            'id' => 'submit_create_exercise',
            'type' => 'submit',
            'value' => 'Save'
        );
        $this->template->load(null, 'applications/gympro/exercise/exercise_create', $this->data);
    }

    /*
     * This method will edit an exercise
     * @param $exercise_id, exercise id
     * @Author Nazmul on 7th December 2014
     */

    public function edit_exercise($exercise_id) {
        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_rules('name', 'name', 'xss_clean|required');
        if ($this->input->post()) {
            $result = array();
            $result['message'] = '';
            if ($this->form_validation->run() == true) {
                $additional_data = array(
                    'category_id' => $this->input->post('exercise_category_list'),
                    'name' => $this->input->post('name'),
                    'description' => $this->input->post('description'),
                    'user_id' => $user_id
                );

                $picture = "";
                if (isset($_FILES["userfile"])) {
                    $result = $this->utils->upload_image($_FILES["userfile"], EXERCISE_IMAGEPATH);
                    if ($result['status'] == 1) {
                        $source_path = EXERCISE_IMAGEPATH . $result['upload_data']['file_name'];
                        $destination_path = EXERCISE_IMAGES_PATH_W50_H50 . $result['upload_data']['file_name'];
                        $this->utils->resize_image($source_path, $destination_path, EXERCISE_IMAGES_PICTURE_H50, EXERCISE_IMAGES_PICTURE_W50);
                        $picture = $result['upload_data']['file_name'];
                        $additional_data['picture'] = $picture;
                    }
                }

                $newValue = $this->gympro_library->update_exercise($exercise_id, $additional_data);
                if ($newValue) {
                    $result['message'] = $this->gympro_library->messages_alert();
                } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $result['message'] = validation_errors();
            }
            echo json_encode($result);
            return;
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
        $this->data['client_list'] = $this->gympro_library->get_all_clients($user_id)->result_array();
        $exercise_info = array();
        $exercise_array = $this->gympro_library->get_exercise_info($exercise_id)->result_array();
        if (!empty($exercise_array)) {
            $exercise_info = $exercise_array[0];
        } else {
            $this->template->load(null, 'applications/gympro/exercise/exercise_edit_validation', $this->data);
            return;
        }
        if ($exercise_info['user_id'] == $this->my_user_id) {
            $exercise_categories_array = $this->gympro_library->get_all_exercise_categories()->result_array();
            $this->data['exercise_category_list'] = array();
            foreach ($exercise_categories_array as $exercise_category_info) {
                $this->data['exercise_category_list'][$exercise_category_info['exercise_category_id']] = $exercise_category_info['title'];
            }
            $this->data['selected_exercise_category_id'] = $exercise_info['category_id'];

            $this->data['name'] = array(
                'name' => 'name',
                'id' => 'name',
                'type' => 'text',
                'value' => $exercise_info['name']
            );
            $this->data['description'] = array(
                'name' => 'description',
                'id' => 'description',
                'type' => 'text',
                'value' => $exercise_info['description']
            );
            $this->data['submit_edit_exercise'] = array(
                'name' => 'submit_edit_exercise',
                'id' => 'submit_edit_exercise',
                'type' => 'submit',
                'value' => 'Save'
            );
            if ($exercise_info['client_id'] > 0) {
                $this->data['selected_client_id'] = $exercise_info['client_id'];
            } else {
                $this->data['selected_client_id'] = 0;
            }
            $this->data['exercise_info'] = $exercise_info;
            $this->template->load(null, 'applications/gympro/exercise/exercise_edit', $this->data);
        } else {
            $this->template->load(null, 'applications/gympro/exercise/exercise_edit_validation', $this->data);
        }
    }

    /*
     * This method will show an exercise
     * @param $exercise_id, exercise id
     * @Author Nazmul on 14th December 2014
     */

    public function show_exercise($exercise_id = 0) {
        if ($exercise_id == 0) {
            redirect('applications/gympro', 'refresh');
        }
        $exercise_info = array();
        $exercise_array = $this->gympro_library->get_exercise_details($exercise_id)->result_array();
        if (!empty($exercise_array)) {
            $exercise_info = $exercise_array[0];
        } else {
            $this->template->load(null, 'applications/gympro/exercise/exercise_show_validation', $this->data);
            return;
        }
        if ($exercise_info['user_id'] == $this->my_user_id) {
            $this->data['exercise_info'] = $exercise_info;
            $this->template->load(null, 'applications/gympro/exercise/exercise_show', $this->data);
        } else {
            $this->template->load(null, 'applications/gympro/exercise/exercise_show_validation', $this->data);
        }
    }

    /*
     * This method will delete an exercise
     * @Author Nazmul on 14th December 2014
     */

    public function delete_exercise() {
        $result = array();
        $exercise_id = $this->input->post('exercise_id');
        if ($this->gympro_library->delete_exercise($exercise_id)) {
            $result['message'] = $this->gympro_library->messages_alert();
        } else {
            $result['message'] = $this->gympro_library->errors_alert();
        }
        echo json_encode($result);
    }

    //-----------------------------------------Nutrition Module------------------------------------//
    /*
     * This method will show all nutritions of this gympro user
     * @Author Nazmul on 7th December 2014
     */
    public function nutrition() {
        $nutrition_list = $this->gympro_library->get_all_nutritions($this->session->userdata('user_id'));
        $this->data['nutrition_list'] = $nutrition_list;
        $this->data['message'] = '';
        $this->template->load(null, 'applications/gympro/nutrition', $this->data);
    }

    /*
     * This method will creae a new nutrition
     * @Author Nazmul on 7th December 2014
     */

    public function create_nutrition() {
        $user_id = $this->session->userdata('user_id');
        if ($this->input->post()) {
            $result = array();
            $result['message'] = '';

            $meal_list = array();
            $index_gr = 0;
            $index_rw = 0;
            $group_counter = $this->input->post('group_counter');
            $row_counter = $this->input->post('row_counter');
            for ($i = 1; $i <= $group_counter; $i++) {
                if (($this->input->post('group_is_present_' . $i) ) != NULL) {
                    for ($j = 1; $j <= $row_counter; $j++) {
                        if (($this->input->post('row_is_present_' . $i . '_' . $j) ) != NULL) {
                            $meal_list[$index_gr][$index_rw] = array(
                                'meal_time' => $this->input->post('meal_time_' . $i),
                                'work_out' => $this->input->post('work_out_' . $i),
                                'label' => $this->input->post('label_' . $i . '_' . $j),
                                'quan' => $this->input->post('quan_' . $i . '_' . $j),
                                'unit' => $this->input->post('unit_' . $i . '_' . $j),
                                'cal' => $this->input->post('cal_' . $i . '_' . $j),
                                'prot' => $this->input->post('prot_' . $i . '_' . $j),
                                'carb' => $this->input->post('carb_' . $i . '_' . $j),
                                'fats' => $this->input->post('fats_' . $i . '_' . $j)
                            );
                            $index_rw++;
                        }
                    }
                    $index_gr++;
                }
            }
            $data = array(
                'user_id' => $this->session->userdata('user_id'),
                'meal_list' => json_encode($meal_list)
            );
            $client_id = $this->input->post('client_list');
            if ($client_id > 0) {
                $data['client_id'] = $client_id;
            }
            $create_program_id = $this->gympro_library->create_nutrition($data);
            if ($create_program_id !== FALSE) {
                $result['message'] = $this->gympro_library->messages_alert();
                //redirect('applications/gympro/nutrition', 'refresh');
            } else {
                $result['message'] = $this->gympro_library->errors_alert();
            }
            echo json_encode($result);
            return;
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
        $this->data['client_list'] = $this->gympro_library->get_all_clients($user_id)->result_array();
        $this->data['selected_client_id'] = 0;
        $meal_time_list = array();
        $meal_time_array = $this->gympro_library->get_all_meal_times()->result_array();
        foreach ($meal_time_array as $meal_time) {
            $meal_time_list[$meal_time['meal_time_id']] = $meal_time['title'];
        }
        $this->data['meal_time_list'] = $meal_time_list;

        $workout_list = array();
        $workout_array = $this->gympro_library->get_all_workouts()->result_array();
        foreach ($workout_array as $workout) {
            $workout_list[$workout['workout_id']] = $workout['title'];
        }
        $this->data['workout_list'] = $workout_list;
        $this->template->load(null, 'applications/gympro/nutrition_create', $this->data);
    }

    /*
     * This method will edit nutrition
     * @param $nutrition_id, nutrition id
     * @Author Nazmul on 7th December 2014
     */

    public function edit_nutrition($nutrition_id = 0) {
        if ($this->input->post()) {
            $result = array();
            $result['message'] = '';

            $meal_list = array();
            $index_gr = 0;
            $index_rw = 0;
            $group_counter = $this->input->post('group_counter');
            $row_counter = $this->input->post('row_counter');
            for ($i = 1; $i <= $group_counter; $i++) {
                if (($this->input->post('group_is_present_' . $i) ) != NULL) {
                    for ($j = 1; $j <= $row_counter; $j++) {
                        if (($this->input->post('row_is_present_' . $i . '_' . $j) ) != NULL) {
                            $meal_list[$index_gr][$index_rw] = array(
                                'meal_time' => $this->input->post('meal_time_' . $i),
                                'work_out' => $this->input->post('work_out_' . $i),
                                'label' => $this->input->post('label_' . $i . '_' . $j),
                                'quan' => $this->input->post('quan_' . $i . '_' . $j),
                                'unit' => $this->input->post('unit_' . $i . '_' . $j),
                                'cal' => $this->input->post('cal_' . $i . '_' . $j),
                                'prot' => $this->input->post('prot_' . $i . '_' . $j),
                                'carb' => $this->input->post('carb_' . $i . '_' . $j),
                                'fats' => $this->input->post('fats_' . $i . '_' . $j)
                            );
                            $index_rw++;
                        }
                    }
                    $index_gr++;
                }
            }
            $data = array(
                'user_id' => $this->session->userdata('user_id'),
                'meal_list' => json_encode($meal_list)
            );
            $client_id = $this->input->post('client_list');
            if ($client_id > 0) {
                $data['client_id'] = $client_id;
            } else {
                $data['client_id'] = NULL;
            }
            $update_nutrition_id = $this->gympro_library->update_nutrition($nutrition_id, $data);
            if ($update_nutrition_id !== FALSE) {
                $result['message'] = $this->gympro_library->messages_alert();
                //redirect('applications/gympro/nutrition', 'refresh');
            } else {
                $result['message'] = $this->gympro_library->errors_alert();
            }
            echo json_encode($result);
            return;
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
        $this->data['client_list'] = $this->gympro_library->get_all_clients($this->my_user_id)->result_array();
        $meal_time_list = array();
        $meal_time_array = $this->gympro_library->get_all_meal_times()->result_array();
        foreach ($meal_time_array as $meal_time) {
            $meal_time_list[$meal_time['meal_time_id']] = $meal_time['title'];
        }
        $this->data['meal_time_list'] = $meal_time_list;

        $workout_list = array();
        $workout_array = $this->gympro_library->get_all_workouts()->result_array();
        foreach ($workout_array as $workout) {
            $workout_list[$workout['workout_id']] = $workout['title'];
        }
        $nutrition_info = array();
        $nutrition_info_array = $this->gympro_library->get_nutrition_info($nutrition_id)->result_array();
        if (!empty($nutrition_info_array)) {
            $nutrition_info = $nutrition_info_array[0];
        } else {
            $this->template->load(null, 'applications/gympro/nutrition_edit_validation', $this->data);
            return;
        }
        if ($nutrition_info['user_id'] == $this->my_user_id) {
            $this->data['nutrition_info'] = json_decode($nutrition_info['meal_list'], TRUE);
            $this->data['workout_list'] = $workout_list;
            $this->data['nutrition_id'] = $nutrition_id;
            if ($nutrition_info['client_id'] > 0) {
                $this->data['selected_client_id'] = $nutrition_info['client_id'];
            } else {
                $this->data['selected_client_id'] = 0;
            }
            $this->template->load(null, 'applications/gympro/nutrition_edit', $this->data);
        } else {
            $this->template->load(null, 'applications/gympro/nutrition_edit_validation', $this->data);
        }
    }

    public function edit_nutrition_prev($nutrition_id = 0) {
        $this->form_validation->set_rules('label', 'Focus', 'xss_clean|required');
        $this->form_validation->set_rules('quan', 'Start Date', 'xss_clean');

        if ($this->input->post()) {
            if ($this->form_validation->run() == true) {
                $meal_list = array(
                    'meal_time' => $this->input->post('meal_time'),
                    'work_out' => $this->input->post('work_out'),
                    'label' => $this->input->post('label'),
                    'quan' => $this->input->post('quan'),
                    'unit' => $this->input->post('unit'),
                    'cal' => $this->input->post('cal'),
                    'prot' => $this->input->post('prot'),
                    'carb' => $this->input->post('carb'),
                    'fats' => $this->input->post('fats')
                );

                $data = array(
                    'user_id' => $this->session->userdata('user_id'),
                    'meal_list' => json_encode($meal_list)
                );
                $update_id = $this->gympro_library->update_nutrition($nutrition_id, $data);
                if ($update_id !== FALSE) {
                    $result['message'] = 'Nutrition is updated successfully.';
                    redirect('applications/gympro/nutrition', 'refresh');
                } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }

        $meal_time_list = array();
        $meal_time_array = $this->gympro_library->get_all_meal_times()->result_array();
        foreach ($meal_time_array as $meal_time) {
            $meal_time_list[$meal_time['meal_time_id']] = $meal_time['title'];
        }
        $this->data['meal_time_list'] = $meal_time_list;

        $workout_list = array();
        $workout_array = $this->gympro_library->get_all_workouts()->result_array();
        foreach ($workout_array as $workout) {
            $workout_list[$workout['workout_id']] = $workout['title'];
        }

        $nutrition_info = $this->gympro_library->get_nutrition_info($nutrition_id)->result_array();
        $this->data['nutrition'] = json_decode($nutrition_info[0]['meal_list'], TRUE);
        $this->data['workout_list'] = $workout_list;
        $this->template->load(null, 'applications/gympro/nutrition_edit', $this->data);
    }

    /*
     * Ajax call to delete nutrition
     * @param $nutrition_id, nutrition id
     * @Author Nazmul on 7th December 2014
     */

    public function delete_nutrition() {
        $result = array();
        $delete_id = $this->input->post('delete_id');
        if ($this->gympro_library->delete_nutrition($delete_id)) {
            $result['message'] = $this->gympro_library->messages_alert();
        } else {
            $result['message'] = $this->gympro_library->errors_alert();
        }
        echo json_encode($result);
    }

    /*
     * This method will show nutrition info
     * @param $nutrition_id, nutrition id
     * @Author Nazmul on 31st December 2014
     */

    public function show_nutrition($nutrition_id = 0) {
        if ($nutrition_id == 0) {
            redirect('applications/gympro', 'refresh');
        }
        $meal_time_list = array();
        $meal_time_array = $this->gympro_library->get_all_meal_times()->result_array();
        foreach ($meal_time_array as $meal_time) {
            $meal_time_list[$meal_time['meal_time_id']] = $meal_time['title'];
        }
        $this->data['meal_time_list'] = $meal_time_list;

        $workout_list = array();
        $workout_array = $this->gympro_library->get_all_workouts()->result_array();
        foreach ($workout_array as $workout) {
            $workout_list[$workout['workout_id']] = $workout['title'];
        }
        $nutrition_info = array();
        $nutrition_info_array = $this->gympro_library->get_nutrition_info($nutrition_id)->result_array();
        if (!empty($nutrition_info_array)) {
            $nutrition_info = $nutrition_info_array[0];
        } else {
            $this->template->load(null, 'applications/gympro/nutrition_show_validation', $this->data);
            return;
        }
        if ($nutrition_info['user_id'] == $this->my_user_id) {
            $this->data['nutrition_info'] = $nutrition_info;
            $this->data['meal_list'] = json_decode($nutrition_info['meal_list'], TRUE);
            $this->data['workout_list'] = $workout_list;
            $this->data['nutrition_id'] = $nutrition_id;
            $this->template->load(null, 'applications/gympro/nutrition_show', $this->data);
        } else {
            $this->template->load(null, 'applications/gympro/nutrition_show_validation', $this->data);
        }
    }

    //----------------------------------------Assessment Module------------------------------------//
    /*
     * This method will show all assessments of this gympro user
     * @Author Nazmul on 7th December 2014
     */
    public function manage_assessments() {
        $this->data['message'] = '';
        $this->data['assessment_list'] = $this->gympro_library->get_all_assessments($this->session->userdata('user_id'));
        $this->template->load(null, 'applications/gympro/assessment/assessments', $this->data);
    }

    /*
     * This method will create an assessment
     * @Author Nazmul on 7th December 2014
     */

    public function create_assessment() {
        $this->data['message'] = '';
        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_rules('date', 'date', 'xss_clean|required');
        if ($this->input->post()) {
            $result = array();
            $result['message'] = '';
            if ($this->form_validation->run() == true) {
                $additional_data = array(
                    'date' => $this->input->post('date'),
                    'weight' => $this->input->post('weight'),
                    'head' => $this->input->post('head'),
                    'neck' => $this->input->post('neck'),
                    'chest' => $this->input->post('chest'),
                    'reassess_id' => $this->input->post('reassess_list'),
                    'body_fat' => $this->input->post('body_fat'),
                    'abdominal' => $this->input->post('abdominal'),
                    'waist' => $this->input->post('waist'),
                    'hip' => $this->input->post('hip'),
                    'user_id' => $user_id,
                    'ls_arm_relaxed' => $this->input->post('ls_arm_relaxed'),
                    'ls_arm_flexed' => $this->input->post('ls_arm_flexed'),
                    'ls_forearm' => $this->input->post('ls_forearm'),
                    'ls_wrist' => $this->input->post('ls_wrist'),
                    'ls_thigh_gluteal' => $this->input->post('ls_thigh_gluteal'),
                    'ls_thigh_mid' => $this->input->post('ls_thigh_mid'),
                    'ls_calf' => $this->input->post('ls_calf'),
                    'ls_ankle' => $this->input->post('ls_ankle'),
                    'rs_arm_relaxed' => $this->input->post('rs_arm_relaxed'),
                    'rs_arm_flexed' => $this->input->post('rs_arm_flexed'),
                    'rs_forearm' => $this->input->post('rs_forearm'),
                    'rs_wrist' => $this->input->post('rs_wrist'),
                    'rs_thigh_gluteal' => $this->input->post('rs_thigh_gluteal'),
                    'rs_thigh_mid' => $this->input->post('rs_thigh_mid'),
                    'rs_calf' => $this->input->post('rs_calf'),
                    'rs_ankle' => $this->input->post('rs_ankle')
                );
                $client_id = $this->input->post('client_list');
                if ($client_id > 0) {
                    $additional_data['client_id'] = $client_id;
                }
                $assessment_id = $this->gympro_library->create_assessment($additional_data);
                if ($assessment_id !== FALSE) {
                    //$this->session->set_flashdata('message', $this->gympro_library->messages());
                    //redirect('applications/gympro/manage_assessments', 'refresh');
                    $result['message'] = $this->gympro_library->messages_alert();
                } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $result['message'] = validation_errors();
            }
            echo json_encode($result);
            return;
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
        $this->data['client_list'] = $this->gympro_library->get_all_clients($user_id)->result_array();
        $reassess_array = $this->gympro_library->get_all_reassess()->result_array();
        $this->data['reassess_list'] = array();
        foreach ($reassess_array as $reassess_info) {
            $this->data['reassess_list'][$reassess_info['id']] = $reassess_info['title'];
        }
        $this->data['date'] = array(
            'name' => 'date',
            'id' => 'date',
            'type' => 'text'
        );
        $this->data['weight'] = array(
            'name' => 'weight',
            'id' => 'weight',
            'type' => 'text'
        );
        $this->data['head'] = array(
            'name' => 'head',
            'id' => 'head',
            'type' => 'text'
        );
        $this->data['neck'] = array(
            'name' => 'neck',
            'id' => 'neck',
            'type' => 'text'
        );
        $this->data['chest'] = array(
            'name' => 'chest',
            'id' => 'chest',
            'type' => 'text'
        );
        $this->data['body_fat'] = array(
            'name' => 'body_fat',
            'id' => 'body_fat',
            'type' => 'text'
        );
        $this->data['abdominal'] = array(
            'name' => 'abdominal',
            'id' => 'abdominal',
            'type' => 'text'
        );
        $this->data['waist'] = array(
            'name' => 'waist',
            'id' => 'waist',
            'type' => 'text'
        );
        $this->data['hip'] = array(
            'name' => 'hip',
            'id' => 'hip',
            'type' => 'text'
        );
        $this->data['ls_arm_relaxed'] = array(
            'name' => 'ls_arm_relaxed',
            'id' => 'ls_arm_relaxed',
            'type' => 'text'
        );
        $this->data['ls_arm_flexed'] = array(
            'name' => 'ls_arm_flexed',
            'id' => 'ls_arm_flexed',
            'type' => 'text'
        );
        $this->data['ls_forearm'] = array(
            'name' => 'ls_forearm',
            'id' => 'ls_forearm',
            'type' => 'text'
        );
        $this->data['ls_wrist'] = array(
            'name' => 'ls_wrist',
            'id' => 'ls_wrist',
            'type' => 'text'
        );
        $this->data['ls_thigh_gluteal'] = array(
            'name' => 'ls_thigh_gluteal',
            'id' => 'ls_thigh_gluteal',
            'type' => 'text'
        );
        $this->data['ls_thigh_mid'] = array(
            'name' => 'ls_thigh_mid',
            'id' => 'ls_thigh_mid',
            'type' => 'text'
        );
        $this->data['ls_calf'] = array(
            'name' => 'ls_calf',
            'id' => 'ls_calf',
            'type' => 'text'
        );
        $this->data['ls_ankle'] = array(
            'name' => 'ls_ankle',
            'id' => 'ls_ankle',
            'type' => 'text'
        );
        $this->data['rs_arm_relaxed'] = array(
            'name' => 'rs_arm_relaxed',
            'id' => 'rs_arm_relaxed',
            'type' => 'text'
        );
        $this->data['rs_arm_flexed'] = array(
            'name' => 'rs_arm_flexed',
            'id' => 'rs_arm_flexed',
            'type' => 'text'
        );
        $this->data['rs_forearm'] = array(
            'name' => 'rs_forearm',
            'id' => 'rs_forearm',
            'type' => 'text'
        );
        $this->data['rs_wrist'] = array(
            'name' => 'rs_wrist',
            'id' => 'rs_wrist',
            'type' => 'text'
        );
        $this->data['rs_thigh_gluteal'] = array(
            'name' => 'rs_thigh_gluteal',
            'id' => 'rs_thigh_gluteal',
            'type' => 'text'
        );
        $this->data['rs_thigh_mid'] = array(
            'name' => 'rs_thigh_mid',
            'id' => 'rs_thigh_mid',
            'type' => 'text'
        );
        $this->data['rs_calf'] = array(
            'name' => 'rs_calf',
            'id' => 'rs_calf',
            'type' => 'text'
        );
        $this->data['rs_ankle'] = array(
            'name' => 'rs_ankle',
            'id' => 'rs_ankle',
            'type' => 'text'
        );
        $this->data['submit_button'] = array(
            'name' => 'submit_button',
            'id' => 'submit_button',
            'type' => 'submit',
            'value' => 'Save'
        );
        $this->data['selected_client_id'] = 0;
        $this->template->load(null, 'applications/gympro/assessment/assessment_create', $this->data);
    }

    /*
     * This method will edit an assessment
     * @param $assessment_id, assessment id
     * @Author Nazmul on 7th December 2014
     */

    public function edit_assessment($assessment_id = 0) {
        if ($assessment_id == 0) {
            redirect('applications/gympro/manage_assessments', 'refresh');
        }
        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_rules('date', 'Date', 'xss_clean|required');
        if ($this->input->post()) {
            $result = array();
            $result['message'] = '';
            if ($this->form_validation->run() == true) {
                $additional_data = array(
                    'date' => $this->input->post('date'),
                    'weight' => $this->input->post('weight'),
                    'head' => $this->input->post('head'),
                    'neck' => $this->input->post('neck'),
                    'chest' => $this->input->post('chest'),
                    'reassess_id' => $this->input->post('reassess_list'),
                    'body_fat' => $this->input->post('body_fat'),
                    'abdominal' => $this->input->post('abdominal'),
                    'waist' => $this->input->post('waist'),
                    'hip' => $this->input->post('hip'),
                    'user_id' => $this->session->userdata('user_id'),
                    'ls_arm_relaxed' => $this->input->post('ls_arm_relaxed'),
                    'ls_arm_flexed' => $this->input->post('ls_arm_flexed'),
                    'ls_forearm' => $this->input->post('ls_forearm'),
                    'ls_wrist' => $this->input->post('ls_wrist'),
                    'ls_thigh_gluteal' => $this->input->post('ls_thigh_gluteal'),
                    'ls_thigh_mid' => $this->input->post('ls_thigh_mid'),
                    'ls_calf' => $this->input->post('ls_calf'),
                    'ls_ankle' => $this->input->post('ls_ankle'),
                    'rs_arm_relaxed' => $this->input->post('rs_arm_relaxed'),
                    'rs_arm_flexed' => $this->input->post('rs_arm_flexed'),
                    'rs_forearm' => $this->input->post('rs_forearm'),
                    'rs_wrist' => $this->input->post('rs_wrist'),
                    'rs_thigh_gluteal' => $this->input->post('rs_thigh_gluteal'),
                    'rs_thigh_mid' => $this->input->post('rs_thigh_mid'),
                    'rs_calf' => $this->input->post('rs_calf'),
                    'rs_ankle' => $this->input->post('rs_ankle')
                );
                $client_id = $this->input->post('client_list');
                if ($client_id > 0) {
                    $additional_data['client_id'] = $client_id;
                } else {
                    $additional_data['client_id'] = NULL;
                }
                if ($this->gympro_library->update_assessment($assessment_id, $additional_data)) {
                    $result['message'] = $this->gympro_library->messages_alert();
                    //$this->session->set_flashdata('message', $this->gympro_library->messages());
                    //redirect('applications/gympro/manage_assessments', 'refresh');
                } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $result['message'] = validation_errors();
            }
            echo json_encode($result);
            return;
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
        $this->data['client_list'] = $this->gympro_library->get_all_clients($user_id)->result_array();
        $reassess_array = $this->gympro_library->get_all_reassess()->result_array();
        $this->data['reassess_list'] = array();
        foreach ($reassess_array as $reassess_info) {
            $this->data['reassess_list'][$reassess_info['id']] = $reassess_info['title'];
        }
        $assessment_info = array();
        $assessment_array = $this->gympro_library->get_assessment_info($assessment_id)->result_array();
        if (!empty($assessment_array)) {
            $assessment_info = $assessment_array[0];
        } else {
            $this->template->load(null, 'applications/gympro/assessment/assessment_edit_validation', $this->data);
            return;
        }
        if ($assessment_info['user_id'] == $this->my_user_id) {
            $this->data['date'] = array(
                'name' => 'date',
                'id' => 'date',
                'type' => 'text',
                'value' => $assessment_info['date']
            );
            $this->data['weight'] = array(
                'name' => 'weight',
                'id' => 'weight',
                'type' => 'text',
                'value' => $assessment_info['weight']
            );
            $this->data['head'] = array(
                'name' => 'head',
                'id' => 'head',
                'type' => 'text',
                'value' => $assessment_info['head']
            );
            $this->data['neck'] = array(
                'name' => 'neck',
                'id' => 'neck',
                'type' => 'text',
                'value' => $assessment_info['neck']
            );
            $this->data['chest'] = array(
                'name' => 'chest',
                'id' => 'chest',
                'type' => 'text',
                'value' => $assessment_info['chest']
            );

            $this->data['body_fat'] = array(
                'name' => 'body_fat',
                'id' => 'body_fat',
                'type' => 'text',
                'value' => $assessment_info['body_fat']
            );
            $this->data['abdominal'] = array(
                'name' => 'abdominal',
                'id' => 'abdominal',
                'type' => 'text',
                'value' => $assessment_info['abdominal']
            );
            $this->data['waist'] = array(
                'name' => 'waist',
                'id' => 'waist',
                'type' => 'text',
                'value' => $assessment_info['waist']
            );
            $this->data['hip'] = array(
                'name' => 'hip',
                'id' => 'hip',
                'type' => 'text',
                'value' => $assessment_info['hip']
            );
            $this->data['ls_arm_relaxed'] = array(
                'name' => 'ls_arm_relaxed',
                'id' => 'ls_arm_relaxed',
                'type' => 'text',
                'value' => $assessment_info['ls_arm_relaxed']
            );
            $this->data['ls_arm_flexed'] = array(
                'name' => 'ls_arm_flexed',
                'id' => 'ls_arm_flexed',
                'type' => 'text',
                'value' => $assessment_info['ls_arm_flexed']
            );
            $this->data['ls_forearm'] = array(
                'name' => 'ls_forearm',
                'id' => 'ls_forearm',
                'type' => 'text',
                'value' => $assessment_info['ls_forearm']
            );
            $this->data['ls_wrist'] = array(
                'name' => 'ls_wrist',
                'id' => 'ls_wrist',
                'type' => 'text',
                'value' => $assessment_info['ls_wrist']
            );
            $this->data['ls_thigh_gluteal'] = array(
                'name' => 'ls_thigh_gluteal',
                'id' => 'ls_thigh_gluteal',
                'type' => 'text',
                'value' => $assessment_info['ls_thigh_gluteal']
            );
            $this->data['ls_thigh_mid'] = array(
                'name' => 'ls_thigh_mid',
                'id' => 'ls_thigh_mid',
                'type' => 'text',
                'value' => $assessment_info['ls_thigh_mid']
            );
            $this->data['ls_calf'] = array(
                'name' => 'ls_calf',
                'id' => 'ls_calf',
                'type' => 'text',
                'value' => $assessment_info['ls_calf']
            );
            $this->data['ls_ankle'] = array(
                'name' => 'ls_ankle',
                'id' => 'ls_ankle',
                'type' => 'text',
                'value' => $assessment_info['ls_ankle']
            );
            $this->data['rs_arm_relaxed'] = array(
                'name' => 'rs_arm_relaxed',
                'id' => 'rs_arm_relaxed',
                'type' => 'text',
                'value' => $assessment_info['rs_arm_relaxed']
            );
            $this->data['rs_arm_flexed'] = array(
                'name' => 'rs_arm_flexed',
                'id' => 'rs_arm_flexed',
                'type' => 'text',
                'value' => $assessment_info['rs_arm_flexed']
            );
            $this->data['rs_forearm'] = array(
                'name' => 'rs_forearm',
                'id' => 'rs_forearm',
                'type' => 'text',
                'value' => $assessment_info['rs_forearm']
            );
            $this->data['rs_wrist'] = array(
                'name' => 'rs_wrist',
                'id' => 'rs_wrist',
                'type' => 'text',
                'value' => $assessment_info['rs_wrist']
            );
            $this->data['rs_thigh_gluteal'] = array(
                'name' => 'rs_thigh_gluteal',
                'id' => 'rs_thigh_gluteal',
                'type' => 'text',
                'value' => $assessment_info['rs_thigh_gluteal']
            );
            $this->data['rs_thigh_mid'] = array(
                'name' => 'rs_thigh_mid',
                'id' => 'rs_thigh_mid',
                'type' => 'text',
                'value' => $assessment_info['rs_thigh_mid']
            );
            $this->data['rs_calf'] = array(
                'name' => 'rs_calf',
                'id' => 'rs_calf',
                'type' => 'text',
                'value' => $assessment_info['rs_calf']
            );
            $this->data['rs_ankle'] = array(
                'name' => 'rs_ankle',
                'id' => 'rs_ankle',
                'type' => 'text',
                'value' => $assessment_info['rs_ankle']
            );
            $this->data['submit_button'] = array(
                'name' => 'submit_button',
                'id' => 'submit_button',
                'type' => 'submit',
                'value' => 'Save'
            );
            if ($assessment_info['client_id'] > 0) {
                $this->data['selected_client_id'] = $assessment_info['client_id'];
            } else {
                $this->data['selected_client_id'] = 0;
            }
            $this->data['assessment_id'] = $assessment_id;
            $this->template->load(null, 'applications/gympro/assessment/assessment_edit', $this->data);
        } else {
            $this->template->load(null, 'applications/gympro/assessment/assessment_edit_validation', $this->data);
        }
    }

    /*
     * This method will show an assessment
     * @param $assessment_id, assessment id
     * @Author Nazmul on 14th December 2014
     */

    public function show_assessment($assessment_id = 0) {
        if ($assessment_id == 0) {
            redirect('applications/gympro', 'refresh');
        }
        $assessment_info = array();
        $assessment_array = $this->gympro_library->get_assessment_info($assessment_id)->result_array();
        if (!empty($assessment_array)) {
            $assessment_info = $assessment_array[0];
        } else {
            $this->template->load(null, 'applications/gympro/assessment/assessment_show_validation', $this->data);
            return;
        }
        if ($assessment_info['user_id'] == $this->my_user_id) {
            $reassess_array = $this->gympro_library->get_all_reassess()->result_array();
            foreach ($reassess_array as $reassess_info) {
                if ($reassess_info['id'] == $assessment_info['reassess_id']) {
                    $this->data['reassess_in'] = $reassess_info['title'];
                    break;
                }
            }
            $this->data['assessment_info'] = $assessment_info;
            $this->template->load(null, 'applications/gympro/assessment/assessment_show', $this->data);
        } else {
            $this->template->load(null, 'applications/gympro/assessment/assessment_show_validation', $this->data);
        }
    }

    /*
     * Ajax call to delete an assessment
     * @Author Nazmul on 7th December 2014
     */

    public function delete_assessment() {
        $result = array();
        $assessment_id = $this->input->post('assessment_id');
        if ($this->gympro_library->delete_assessment($assessment_id)) {
            $result['message'] = $this->gympro_library->messages_alert();
        } else {
            $result['message'] = $this->gympro_library->errors_alert();
        }
        echo json_encode($result);
    }

    //-----------------------------------------Mission Module------------------------------------//
    /*
     * This method will show all missions of this gympro user
     * @Author Nazmul on 7th December 2014
     */
    public function manage_missions() {
        $mission_list = $this->gympro_library->get_all_missions($this->session->userdata('user_id'));
        $this->data['mission_list'] = $mission_list;
        $this->data['message'] = '';
        $this->template->load(null, 'applications/gympro/mission/missions', $this->data);
    }

    /*
     * This method will create a mission
     * @Author Nazmul on 7th December 2014
     */

    public function create_mission() {
        $this->data['message'] = '';
        $user_id = $this->session->userdata('user_id');
        $this->form_validation->set_rules('label', 'label', 'xss_clean|required');
        if ($this->input->post()) {
            $result = array();
            $result['message'] = '';
            if ($this->form_validation->run() == true) {
                $additional_data = array(
                    'label' => $this->input->post('label'),
                    'start_date' => $this->input->post('start_date'),
                    'end_date' => $this->input->post('end_date'),
                    'sunday' => $this->input->post('sunday'),
                    'monday' => $this->input->post('monday'),
                    'tuesday' => $this->input->post('tuesday'),
                    'wednesday' => $this->input->post('wednesday'),
                    'thursday' => $this->input->post('thursday'),
                    'friday' => $this->input->post('friday'),
                    'saturday' => $this->input->post('saturday'),
                    'user_id' => $user_id
                );
                $client_id = $this->input->post('client_list');
                if ($client_id > 0) {
                    $additional_data['client_id'] = $client_id;
                }
                $value = $this->gympro_library->create_mission($additional_data);
                if ($value !== FALSE) {
                    $result['message'] = $this->gympro_library->messages_alert();
                    //$this->session->set_flashdata('message', $this->gympro_library->messages());
                    //redirect('applications/gympro/manage_missions', 'refresh');
                } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $result['message'] = validation_errors();
            }
            echo json_encode($result);
            return;
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
        $this->data['client_list'] = $this->gympro_library->get_all_clients($user_id)->result_array();
        $this->data['label'] = array(
            'name' => 'label',
            'id' => 'label',
            'type' => 'text'
        );

        $this->data['end_date'] = array(
            'name' => 'end_date',
            'id' => 'end_date',
            'type' => 'text'
        );

        $this->data['start_date'] = array(
            'name' => 'start_date',
            'id' => 'start_date',
            'type' => 'text'
        );

        $this->data['start_data'] = array(
            'name' => 'start_data',
            'id' => 'start_data',
            'type' => 'text'
        );

        $this->data['sunday'] = array(
            'name' => 'sunday',
            'id' => 'sunday',
            'type' => 'text',
            'rows' => '4'
        );
        $this->data['monday'] = array(
            'name' => 'monday',
            'id' => 'monday',
            'type' => 'text',
            'rows' => '4'
        );
        $this->data['tuesday'] = array(
            'name' => 'tuesday',
            'id' => 'tuesday',
            'type' => 'text',
            'rows' => '4'
        );
        $this->data['wednesday'] = array(
            'name' => 'wednesday',
            'id' => 'wednesday',
            'type' => 'text',
            'rows' => '4'
        );
        $this->data['thursday'] = array(
            'name' => 'thursday',
            'id' => 'thursday',
            'type' => 'text',
            'rows' => '4'
        );
        $this->data['friday'] = array(
            'name' => 'friday',
            'id' => 'friday',
            'type' => 'text',
            'rows' => '4'
        );
        $this->data['saturday'] = array(
            'name' => 'saturday',
            'id' => 'saturday',
            'type' => 'text',
            'rows' => '4'
        );
        $this->data['submit_button'] = array(
            'name' => 'submit_button',
            'id' => 'submit_button',
            'type' => 'submit',
            'value' => 'Save'
        );
        $this->data['selected_client_id'] = 0;
        $this->template->load(null, 'applications/gympro/mission/mission_create', $this->data);
    }

    /*
     * This method will edit a mission
     * @param $mission_id, mission id
     * @Author Nazmul on 7th December 2014
     */

    public function edit_mission($mission_id = 0) {
        if ($mission_id == 0) {
            redirect('applications/gympro/manage_missions', 'refresh');
        }
        $user_id = $this->session->userdata('user_id');
        $mission_info = array();
        $mission_array = $this->gympro_library->get_mission_info($mission_id)->result_array();
        if (!empty($mission_array)) {
            $mission_info = $mission_array[0];
        } else {
            $this->template->load(null, 'applications/gympro/mission/mission_edit_validation', $this->data);
            return;
        }
        $this->data['message'] = '';
        $this->form_validation->set_rules('label', 'label', 'xss_clean|required');
        if ($this->input->post()) {
            $result = array();
            $result['message'] = '';
            if ($this->form_validation->run() == true) {
                $additional_data = array(
                    'label' => $this->input->post('label'),
                    'start_date' => $this->input->post('start_date'),
                    'end_date' => $this->input->post('end_date'),
                    'sunday' => $this->input->post('sunday'),
                    'monday' => $this->input->post('monday'),
                    'tuesday' => $this->input->post('tuesday'),
                    'wednesday' => $this->input->post('wednesday'),
                    'thursday' => $this->input->post('thursday'),
                    'friday' => $this->input->post('friday'),
                    'saturday' => $this->input->post('saturday')
                );
                $client_id = $this->input->post('client_list');
                if ($client_id > 0) {
                    $additional_data['client_id'] = $client_id;
                } else {
                    $additional_data['client_id'] = NULL;
                }
                if ($this->gympro_library->update_mission($mission_id, $additional_data)) {
                    $result['message'] = $this->gympro_library->messages_alert();
                    //$this->session->set_flashdata('message', $this->gympro_library->messages());
                    //redirect('applications/gympro/manage_missions', 'refresh');
                } else {
                    $result['message'] = $this->gympro_library->errors_alert();
                }
            } else {
                $result['message'] = validation_errors();
            }
            echo json_encode($result);
            return;
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
        if ($mission_info['user_id'] == $this->my_user_id) {
            $this->data['client_list'] = $this->gympro_library->get_all_clients($user_id)->result_array();
            $this->data['label'] = array(
                'name' => 'label',
                'id' => 'label',
                'type' => 'text',
                'value' => $mission_info['label']
            );

            $this->data['end_date'] = array(
                'name' => 'end_date',
                'id' => 'end_date',
                'type' => 'text',
                'value' => $mission_info['end_date']
            );

            $this->data['start_date'] = array(
                'name' => 'start_date',
                'id' => 'start_date',
                'type' => 'text',
                'value' => $mission_info['start_date']
            );
            $this->data['sunday'] = array(
                'name' => 'sunday',
                'id' => 'sunday',
                'type' => 'text',
                'rows' => '4',
                'value' => $mission_info['sunday']
            );
            $this->data['monday'] = array(
                'name' => 'monday',
                'id' => 'monday',
                'type' => 'text',
                'rows' => '4',
                'value' => $mission_info['monday']
            );
            $this->data['tuesday'] = array(
                'name' => 'tuesday',
                'id' => 'tuesday',
                'type' => 'text',
                'rows' => '4',
                'value' => $mission_info['tuesday']
            );
            $this->data['wednesday'] = array(
                'name' => 'wednesday',
                'id' => 'wednesday',
                'type' => 'text',
                'rows' => '4',
                'value' => $mission_info['wednesday']
            );
            $this->data['thursday'] = array(
                'name' => 'thursday',
                'id' => 'thursday',
                'type' => 'text',
                'rows' => '4',
                'value' => $mission_info['thursday']
            );
            $this->data['friday'] = array(
                'name' => 'friday',
                'id' => 'friday',
                'type' => 'text',
                'rows' => '4',
                'value' => $mission_info['friday']
            );
            $this->data['saturday'] = array(
                'name' => 'saturday',
                'id' => 'saturday',
                'type' => 'text',
                'rows' => '4',
                'value' => $mission_info['saturday']
            );
            $this->data['submit_button'] = array(
                'name' => 'submit_button',
                'id' => 'submit_button',
                'type' => 'submit',
                'value' => 'Save'
            );
            if ($mission_info['client_id'] > 0) {
                $this->data['selected_client_id'] = $mission_info['client_id'];
            } else {
                $this->data['selected_client_id'] = 0;
            }
            $this->data['mission_info'] = $mission_info;
            $this->data['mission_id'] = $mission_id;
            $this->template->load(null, 'applications/gympro/mission/mission_edit', $this->data);
        } else {
            $this->template->load(null, 'applications/gympro/mission/mission_edit_validation', $this->data);
        }
    }

    /*
     * This method will show a mission
     * @param $mission_id, mission id
     * @Author Nazmul on 14th December 2014
     */

    public function show_mission($mission_id = 0) {
        //CHECK WHETHER THIS USEr HAS PERMISSION OF THIS MISSION    
        $mission_info = array();
        $mission_array = $this->gympro_library->get_mission_info($mission_id)->result_array();
        if (!empty($mission_array)) {
            $mission_info = $mission_array[0];
        } else {
            $this->template->load(null, 'applications/gympro/mission/mission_show_validation', $this->data);
            return;
        }
        if ($mission_info['user_id'] == $this->my_user_id) {
            $this->data['mission_info'] = $mission_info;
            $this->template->load(null, 'applications/gympro/mission/mission_show', $this->data);
        } else {
            $this->template->load(null, 'applications/gympro/mission/mission_show_validation', $this->data);
        }
    }

    /*
     * Ajax call to delete mission
     * @Author Nazmul on 7th December 2014
     */

    public function delete_mission() {
        $result = array();
        $mission_id = $this->input->post('mission_id');
        if ($this->gympro_library->delete_mission($mission_id)) {
            $result['message'] = $this->gympro_library->messages_alert();
        } else {
            $result['message'] = $this->gympro_library->errors_alert();
        }
        echo json_encode($result);
    }

    //-----------------------------------------Earnings Module------------------------------------//
    /*
     * This method will load session list in calendar
     * @Author Nazmul on 4th February 2015
     */
    public function schedule() {
        $this->data['message'] = '';
        $user_id = $this->session->userdata('user_id');
        $sessions_array = $this->gympro_library->get_sessions_in_calendar($user_id, $this->account_type_id);
        $this->data['events'] = json_encode($sessions_array);
        $this->template->load(null, 'applications/gympro/schedules', $this->data);
    }

    /*
     * @Author Tanveer Ahmed
     * Loads view page and handels creating ptpro session
     */

    public function create_session() {
        $this->data['message'] = '';
        $user_id = $this->session->userdata('user_id');
        $gympro_user_data = $this->gympro_library->get_gympro_user_info($user_id)->result_array();
        if (empty($gympro_user_data)) {
            redirect('applications/gympro/pt_home', 'refresh');
        }
        $this->form_validation->set_rules('title', 'Title', 'xss_clean|required');
        $this->form_validation->set_rules('session_date', 'Date', 'xss_clean|required');
        $this->form_validation->set_rules('location', 'Location', 'xss_clean');
        if ($this->input->post()) {
            $result = array();
            $result['message'] = '';
            if ($this->form_validation->run() == true) {
                $group_client = $this->input->post('group_client');
                $group_client = explode(SESSION_CREATED_FOR_TYPE_EXPLODER, $group_client);
                $created_for_type_id = $group_client[0];
                $reference_id = $group_client[1];
                $repeat = $this->input->post('repeat');
                $type_id = $this->input->post('type_id');
                if ($type_id == GYMPRO_SINGLE_SESSION_TYPE_ID)
                    $repeat = NULL;
                $additional_data = array(
                    'title' => $this->input->post('title'),
                    'user_id' => $user_id,
                    'created_for_type_id' => $created_for_type_id,
                    'reference_id' => $reference_id,
                    'date' => $this->utils->convert_date_from_user_to_db($this->input->post('session_date')),
                    'start' => $this->input->post('start'),
                    'end' => $this->input->post('end'),
                    'location' => $this->input->post('location'),
                    'type_id' => $type_id,
                    'repeat' => $repeat,
                    'cost' => $this->input->post('cost'),
                    'currency_id' => $this->input->post('currency_list'),
                    'status_id' => $this->input->post('status'),
                    'note' => $this->input->post('note')
                );
                $session_id = $this->gympro_library->create_session($additional_data);
                if ($session_id !== FALSE) {
                    redirect('applications/gympro/schedule', 'refresh');
                } else {
                    $this->data['message'] = $this->gympro_library->errors();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
        $currency_array = $this->gympro_library->get_all_currencies()->result_array();
        foreach ($currency_array as $currency) {
            $currency_list[$currency['currency_id']] = $currency['title'];
        }
        $this->data['currency_list'] = $currency_list;
        $this->data['session_statuses'] = $this->gympro_library->get_all_session_statuses()->result_array();
        $this->data['session_times'] = $this->gympro_library->get_all_session_times()->result_array();
        $this->data['session_types'] = $this->gympro_library->get_all_session_types()->result_array();
        $this->data['session_repeats'] = $this->gympro_library->get_all_session_repeats()->result_array();
        $this->data['session_costs'] = $this->gympro_library->get_all_session_costs()->result_array();
        $this->data['client_list'] = $this->gympro_library->get_all_clients($user_id)->result_array();
        $this->data['group_list'] = $this->gympro_library->get_all_groups($user_id);
        $this->template->load(null, 'applications/gympro/session_create', $this->data);
    }

    /*
     * @Author Tanveer Ahmed
     * Loads view page and handels editing ptpro session
     */

    public function update_session($session_id = 0) {
        $this->data['message'] = '';
        $user_id = $this->session->userdata('user_id');
        $gympro_user_data = $this->gympro_library->get_gympro_user_info($user_id)->result_array();
        if (empty($gympro_user_data)) {
            redirect('applications/gympro/pt_home', 'refresh');
        }
        $session_info = $this->gympro_library->get_session_info($session_id)->result_array();
        if (!empty($session_info)) {
            $session_info = $session_info[0];
            if ($session_info['user_id'] != $user_id) {
                $this->data['message'] = $this->lang->line('user_sessionid_mismatch');
                $this->template->load(null, 'applications/gympro/display_message', $this->data);
                return;
            }
            $session_info['date'] = $this->utils->convert_date_from_yyyymmdd_to_ddmmyyyy($session_info['date']);
        } else {
            redirect('applications/gympro/schedule', 'refresh');
        }
        $this->form_validation->set_rules('title', 'Title', 'xss_clean|required');
        $this->form_validation->set_rules('session_date', 'Date', 'xss_clean|required');
        if ($this->input->post()) {
            $result = array();
            $result['message'] = '';
            if ($this->form_validation->run() == true) {
                $group_client = $this->input->post('group_client');
                $group_client = explode(SESSION_CREATED_FOR_TYPE_EXPLODER, $group_client);
                $created_for_type_id = $group_client[0];
                $reference_id = $group_client[1];
                $repeat = $this->input->post('repeat');
                $type_id = $this->input->post('type_id');
                $status_id = $this->input->post('status');
                if ($type_id == GYMPRO_SINGLE_SESSION_TYPE_ID)
                    $repeat = NULL;
                $additional_data = array(
                    'title' => $this->input->post('title'),
                    'user_id' => $user_id,
                    'created_for_type_id' => $created_for_type_id,
                    'reference_id' => $reference_id,
                    'date' => $this->utils->convert_date_from_ddmmyyyy_to_yyyymmdd($this->input->post('session_date')),
                    'start' => $this->input->post('start'),
                    'end' => $this->input->post('end'),
                    'location' => $this->input->post('location'),
                    'type_id' => $type_id,
                    'repeat' => $repeat,
                    'cost' => $this->input->post('cost'),
                    'currency_id' => $this->input->post('currency_list'),
                    'note' => $this->input->post('note')
                );

                if ($status_id != null) {
                    $additional_data['status_id'] = $status_id;
                }
                $session_update_id = $this->gympro_library->update_session($session_id, $additional_data);
                if ($session_update_id == TRUE) {
                    redirect('applications/gympro/schedule', 'refresh');
                } else {
                    $this->data['message'] = $this->gympro_library->errors();
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        } else {
            $this->data['message'] = $this->session->flashdata('message');
        }
        $currency_array = $this->gympro_library->get_all_currencies()->result_array();
        foreach ($currency_array as $currency) {
            $currency_list[$currency['currency_id']] = $currency['title'];
        }
        $this->data['currency_list'] = $currency_list;
        $this->data['session_id'] = $session_id;
        $this->data['session_info'] = $session_info;
        $this->data['session_statuses'] = $this->gympro_library->get_all_session_statuses()->result_array();
        $this->data['session_times'] = $this->gympro_library->get_all_session_times()->result_array();
        $this->data['session_types'] = $this->gympro_library->get_all_session_types()->result_array();
        $this->data['session_repeats'] = $this->gympro_library->get_all_session_repeats()->result_array();
        $this->data['session_costs'] = $this->gympro_library->get_all_session_costs()->result_array();
        $this->data['client_list'] = $this->gympro_library->get_all_clients($this->session->userdata('user_id'))->result_array();
        $this->data['group_list'] = $this->gympro_library->get_all_groups($this->session->userdata('user_id'));
        $this->data['dont_show_cost_text'] = 0;
        foreach ($this->data['session_costs'] as $cost) {
            if ($cost['title'] == $session_info['cost']) {
                $this->data['dont_show_cost_text'] = 1;
            }
        }
        $this->template->load(null, 'applications/gympro/session_edit', $this->data);
    }

    /*
     * @Author Tanveer Ahmed
     * Loads view page and show ptpro session
     */

    public function show_session($session_id = 0) {
        $this->data['message'] = '';
        $user_id = $this->session->userdata('user_id');
        $gympro_user_data = $this->gympro_library->get_gympro_user_info($user_id)->result_array();
        if (empty($gympro_user_data)) {
            redirect('applications/gympro/pt_home', 'refresh');
        }
        $session_info = $this->gympro_library->get_session_info($session_id)->result_array();
        if (!empty($session_info)) {
            $session_info = $session_info[0];
            $session_created_type_id = $session_info['reference_id'];
            if (($session_info['created_for_type_id']) == SESSION_CREATED_FOR_CLIENT_TYPE_ID) {
                $this->data['client_list'] = $this->gympro_library->get_client_info($session_created_type_id)->result_array();
            } else if (($session_info['created_for_type_id']) == SESSION_CREATED_FOR_GROUP_TYPE_ID) {
                $this->data['group_list'] = $this->gympro_library->get_group_info($session_created_type_id)->result_array();
            }
            $session_info['date'] = $this->utils->convert_date_from_yyyymmdd_to_ddmmyyyy($session_info['date']);
        } else {
            redirect('applications/gympro/schedule', 'refresh');
        }
        $this->data['session_id'] = $session_id;
        $this->data['session_info'] = $session_info;
        $this->data['session_statuses'] = $this->gympro_library->get_all_session_statuses()->result_array();
        $this->data['session_times'] = $this->gympro_library->get_all_session_times()->result_array();
        $this->data['session_types'] = $this->gympro_library->get_all_session_types()->result_array();
        $this->data['session_repeats'] = $this->gympro_library->get_all_session_repeats()->result_array();
        $this->data['session_costs'] = $this->gympro_library->get_all_session_costs()->result_array();
        $this->data['dont_show_cost_text'] = 0;
        foreach ($this->data['session_costs'] as $cost) {
            if ($cost['title'] == $session_info['cost']) {
                $this->data['dont_show_cost_text'] = 1;
            }
        }
        $this->template->load(null, 'applications/gympro/session_show', $this->data);
    }

    /*
     * @Author Tanveer Ahmed
     * responds to ajax call of deleting session
     */

    public function delete_session() {
        $result = array();
        $session_id = $this->input->post('session_id');
        if ($this->gympro_library->delete_session($session_id)) {
            $result['message'] = $this->gympro_library->messages_alert();
        } else {
            $result['message'] = $this->gympro_library->errors_alert();
        }
        echo json_encode($result);
        return;
    }

    public function earnings_summary() {
        $start_date = date('Y-m-d');
        $nextWeek = time() + (7 * 24 * 60 * 60);
        $end_date = date('Y-m-d', $nextWeek);
        $u_data = $this->ion_auth_model->get_users($this->session->userdata('user_id'))->result_array();
        if (!empty($u_data)) {
            $current_date = $this->utils->get_current_date($u_data[0]['country_code']);
        }
        $this->data['current_date'] = $current_date;
        $this->data['start_date'] = $this->utils->convert_date_from_db_to_user($start_date);
        $this->data['end_date'] = $this->utils->convert_date_from_db_to_user($end_date);
        $this->data['status_list'] = $this->gympro_library->get_all_session_statuses()->result_array();
        $this->data['group_list'] = $this->gympro_library->get_all_groups($this->session->userdata('user_id'));
        $this->data['client_list'] = $this->gympro_library->get_all_clients($this->session->userdata('user_id'))->result_array();
        $this->template->load(null, 'applications/gympro/earnings_summary', $this->data);
    }

    /*
     * @Author Tanveer Ahmed
     * responds to ajax call of updating session payment status
     */

    public function update_sessions() {
        $result = array();
        $session_id_array = $this->input->post('session_id_array');
        $session_status = $this->input->post('status_id');
        $additional_data = array(
            'status_id' => $session_status
        );
        if ($this->gympro_library->update_sessions($session_id_array, $additional_data)) {
            $result['message'] = $this->gympro_library->messages_alert();
        } else {
            $result['message'] = $this->gympro_library->errors_alert();
        }
        echo json_encode($result);
        return;
    }

    /*
     * @Author Tanveer Ahmed
     * responds to ajax call of retriving earning sunnery data
     */

    public function get_earning_summary() {
        $group_client_data = $this->input->post();
        $start_date = $this->utils->convert_date_from_user_to_db($group_client_data['start']);
        $end_date = $this->utils->convert_date_from_user_to_db($group_client_data['end']);

        $where = array(
            'date >=' => $start_date,
            'date <=' => $end_date,
            'reference_id' => $group_client_data['gr_cl_id'],
            'created_for_type_id' => $group_client_data['created_for_type_id'],
        );

        if ($group_client_data['status_id'] > 0) {
            $where['status_id'] = $group_client_data['status_id'];
        }
        $get_sessions = $this->gympro_library->where($where)->get_sessions()->result_array();
        if (empty($get_sessions)) {
            $result_array = array();
            echo json_encode($result_array);
            return;
        }
        //group view can change, so two cases:
        if ($group_client_data['created_for_type_id'] == SESSION_CREATED_FOR_GROUP_TYPE_ID) {    //for group
            foreach ($get_sessions as $session) {
                $group_data[$session['date']]['date'] = $this->utils->convert_date_from_yyyymmdd_to_ddmmyyyy($session['date']);
                $group_data[$session['date']]['sessions'][] = $session;
            }
            foreach ($group_data as $data) {
                $result[] = $data;
            }
            $group_data = $result;
            echo json_encode($group_data);
            return;
        } else if ($group_client_data['created_for_type_id'] == SESSION_CREATED_FOR_CLIENT_TYPE_ID) { //for client
            foreach ($get_sessions as $session) {
                $client_data[$session['date']]['date'] = $this->utils->convert_date_from_yyyymmdd_to_ddmmyyyy($session['date']);
                $client_data[$session['date']]['sessions'][] = $session;
            }
            foreach ($client_data as $data) {
                $result[] = $data;
            }
            $client_data = $result;
            echo json_encode($client_data);
            return;
        }
    }

}
