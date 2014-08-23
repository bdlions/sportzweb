<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Role_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library("org/profile/business/business_profile_library");
        $this->load->library("basic_profile");
        $this->load->library("org/interest/special_interest");
        $this->load->model("dataprovider_model");
        $this->load->library("permission");
        $this->load->library("notification");
        $this->load->library("collaborator");
        $this->load->library("follower");
        
        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }
    public function index(){
        $menu = $this->input->get("menu", TRUE);
        $sub_menu = $this->input->get("sub_menu", TRUE);
        $section = $this->input->get("section", TRUE);
        
        //set default tab account if not set
        if(empty($menu)){
            $menu = "account";
        }

        
        $this->$menu($sub_menu, $section);
        
    }
    
    /**********All account settings**************/
    public function account($sub_menu, $section){
        if(empty($sub_menu)){
            if(empty($section)){
                return $this->general_info();
            }
            else{
                return $this->$section();
            }
        }
        else{
            if(empty($section)){
                return $this->$sub_menu();
            }
            else{
                return $this->$sub_menu($section);
            }
        }
    }
    public function general_info(){
        
        $this->form_validation->set_rules('country_list', 'Identity', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $profile_info = $this->basic_profile->get_profile_info();
            $this->data["profile_info"] = $profile_info;
            $gender_list = $this->dataprovider_model->getGenderList()->dropDownList('id', 'gender_name');
            
            $gender = "";
            foreach ($gender_list as $key => $value) {
                if($key == $profile_info->gender_id){
                    $gender = $value;
                }
            }
            $this->data["gender"] = $gender;
            $this->data["country_list"] = $this->dataprovider_model->getCountryList()->dropDownList('id', 'country_name');
            $this->template->load("templates/settings_tmpl", "settings/account/general_info", $this->data);
        }
        else {
            $profile_data = array(
                'country_id' => $this->input->post('country_list'),
                'clg_or_uni' => $this->input->post('college')
            );
            $profile_data = array_merge($profile_data, $this->input->post());
            echo $this->basic_profile->update_profile($profile_data);
        }
            
        
    }
    
    public function account_info($section = ""){
        
        $this->form_validation->set_rules('password', 'password', 'required');
        
        if($this->form_validation->run() == FALSE){
            $this->data['general_info'] = $this->basic_profile->get_general_info();
            $this->template->load("templates/settings_tmpl", "settings/account/account_info", $this->data);
        }
        else{
            
            $password = $this->input->post('password');
            $user = $this->ion_auth->user()->row();
            if($this->ion_auth->hash_password_db($user->id, $password)){
                echo $this->$section($user->id);
            }
            else{
                echo FALSE;
            }
        }
    }
    
    public function update_name($user_id){
        $this->form_validation->set_rules('first_name', 'firstname', 'required');
        $this->form_validation->set_rules('last_name', 'lastname', 'required');
        if($this->form_validation->run() == FALSE){
            echo FALSE;
        }
        else{
            echo $this->ion_auth->update($user_id, $this->input->post());
        }
    }
    public function update_email($user_id){
        $this->form_validation->set_rules('email', 'email', 'required');
        if($this->form_validation->run() == FALSE){
            echo FALSE;
        }
        else{
            echo $this->ion_auth->update_email($user_id, $this->input->post());
        }
    }
    public function update_password(){
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_rules('confirm_password', 'confirm password', 'required');
        $this->form_validation->set_rules('new_password', 'new password', 'required');
        $user = $this->ion_auth->user()->row();
        
        if($this->form_validation->run() == FALSE){
            echo FALSE;
        }
        else{
            echo $this->ion_auth->reset_password($user->email, $this->input->post('new_password'));
        }
    }
    
    public function interests(){
        if($this->input->post()){
            $interests = $this->input->post();
            if(is_array($interests))
            {
                $special_interest_list = array();
                foreach ($interests as $key => $value) {
                    $ids = explode("_", $key);
                    $category_id = $ids [ 1 ];
                    $sub_category_id = $ids [ 2 ];
                    $special_interest_list[] = array('interest_id'=>$category_id, 'sub_interest_id' => $sub_category_id);
                }
                $profile_data = array(
                    'user_id' => $this->ion_auth->get_user_id(),
                    'special_interests' => json_encode($special_interest_list)
                );

                echo $this->basic_profile->update_profile($profile_data);

            }
            else{
                echo true;
            }
        }
        else{
            $profile_info = $this->basic_profile->get_profile_info();
            if(!isset($profile_info)){
                redirect(base_url());
            }
            //print_r($profile_info);
            $this->data["profile_info"] = $profile_info;
            $selected_interests = json_decode($profile_info->special_interests);
                //print_r($selected_interests);
            if (is_array($selected_interests)) {
                $selected_special_interest = array();
                foreach ($selected_interests as $value) {
                    $selected_special_interest[] = ($value->interest_id . "_" . $value->sub_interest_id);
                }
            }
            $this->data['special_interests'] = json_encode($this->special_interest->get_all_special_interests());

            $this->data['selected_special_interest'] = json_encode($selected_special_interest);
            $this->template->load("templates/settings_tmpl", "settings/account/interests_info", $this->data);
        }
        
    }
    /******All account settings completed*******/
    
    /**********All privacy settings**************/
    public function privacy($sub_menu = "", $section = ""){
        if(empty($sub_menu)){
            if(empty($section)){
                return $this->privacy_settings();
            }
            else{
                return $this->$section();
            }
        }
        else{
            if(empty($section)){
                return $this->$sub_menu();
            }
            else{
                return $this->$sub_menu($section);
            }
        }
    }
    
    function privacy_settings(){
        //print_r($this->permission->get_permissions_state());
        //print_r( $this->permission->get_permissions_state());
        //print_r($this->permission->extract_permissions_state( $this->permission->get_permissions_state(), COLLABORATE_PERMISSION_CONTACT));
        $all_permission_list = $this->permission->get_permissions_state();
        //print_r($all_permission_list);
        
        $this->data["permission".COLLABORATE_PERMISSION_VIEW_POST] = $this->permission->extract_permissions_state( $all_permission_list, COLLABORATE_PERMISSION_VIEW_POST);
        $this->data["permission".COLLABORATE_PERMISSION_COMMENT_ON_POST] = $this->permission->extract_permissions_state( $all_permission_list, COLLABORATE_PERMISSION_COMMENT_ON_POST);
        $this->data["permission".COLLABORATE_PERMISSION_POST_ON_PROFILE] = $this->permission->extract_permissions_state( $all_permission_list, COLLABORATE_PERMISSION_POST_ON_PROFILE);
        $this->data["permission".COLLABORATE_PERMISSION_CONTACT] = $this->permission->extract_permissions_state( $all_permission_list, COLLABORATE_PERMISSION_CONTACT);
        $this->data["permission".COLLABORATE_PERMISSION_TAG_ME_IN_PHOTOS] = $this->permission->extract_permissions_state( $all_permission_list, COLLABORATE_PERMISSION_TAG_ME_IN_PHOTOS);
        $this->data["permission".COLLABORATE_PERMISSION_SEARCH_FOR_ME] = $this->permission->extract_permissions_state( $all_permission_list, COLLABORATE_PERMISSION_SEARCH_FOR_ME);
        $this->data["permission".COLLABORATE_PERMISSION_FOLLOWING] = $this->permission->extract_permissions_state( $all_permission_list, COLLABORATE_PERMISSION_FOLLOWING);

        $this->data['notification_types'] = $this->notification->get_notification_types();
        $this->data['user_notifications'] = $this->notification->get_user_notification();
        $this->data['collaborator_types'] = $this->dataprovider_model->dropDownListWithSource($this->collaborator ->get_types(), "id", "type");
        $this->data['followers_types'] = $this->dataprovider_model->dropDownListWithSource($this->follower ->get_types(), "value", "description");
        $this->data['user_follower_acceptance_type'] = $this->follower ->get_acceptance_type();
        
        $this->template->load("templates/settings_tmpl", "settings/privacy", $this->data);
        
    }
    
    public function post_viewers() {
        if ($this->input->post()) {
            if ($this->permission->change_permission(COLLABORATE_PERMISSION_VIEW_POST, $this->input->post('permission'))) {
                $this->data['message'] = "Incorrect permission.";
            }
        }
        $this->privacy();
    }

    public function post_comment() {
        if ($this->input->post()) {
            if ($this->permission->change_permission(COLLABORATE_PERMISSION_COMMENT_ON_POST, $this->input->post('permission'))) {
                $this->data['message'] = "Incorrect permission.";
            }
        }
        $this->privacy();
    }

    public function post_on_profile() {
        if ($this->input->post()) {
            if ($this->permission->change_permission(COLLABORATE_PERMISSION_POST_ON_PROFILE, $this->input->post('permission'))) {
                $this->data['message'] = "Incorrect permission.";
            }
        }
        $this->privacy();
    }

    public function contact() {
        if ($this->input->post()) {
            if ($this->permission->change_permission(COLLABORATE_PERMISSION_CONTACT, $this->input->post('permission'))) {
                $this->data['message'] = "Incorrect permission.";
            }
        }
        $this->privacy();
    }
    public function tag_photo() {
        if ($this->input->post()) {
            if ($this->permission->change_permission(COLLABORATE_PERMISSION_TAG_ME_IN_PHOTOS, $this->input->post('permission'))) {
                $this->data['message'] = "Incorrect permission.";
            }
        }
        $this->privacy();
    }

    public function search_me() {
        if ($this->input->post()) {
            if ($this->permission->change_permission(COLLABORATE_PERMISSION_SEARCH_FOR_ME, $this->input->post('permission'))) {
                $this->data['message'] = "Incorrect permission.";
            }
        }
        $this->privacy();
    }

    public function following() {
        if ($this->input->post()) {
            if ($this->follower->set_acceptance_type($this->input->post('permission'))) {
                $this->data['message'] = "Incorrect permission.";
            }
        }
        $this->privacy();
    }
    
    public function set_notification(){
        $this->notification->set_user_notification($this->input->post());
        $this->privacy();
    }
    
    /******All privacy settings completed*******/
    
    /******All business settings*******/
     public function business($sub_menu = "", $section = ""){
        if(empty($sub_menu)){
            if(empty($section)){
                return $this->business_settings();
            }
            else{
                //return $this->$section();
                $this->business_profile_library->update_profile($this->input->post());
                $this->business_settings();
            }
        }
        else{
            if(empty($section)){
                return $this->$sub_menu();
            }
            else{
                return $this->$sub_menu($section);
            }
        }
    }
    function business_settings(){
        
        $this->data["country_list"] = $this->dataprovider_model->getCountryList()->dropDownList('id', 'country_name');
        $business_profile_types = $this->business_profile_library->get_business_types_profile();
        $this->data["business_profile_types"] = $this->dataprovider_model->dropDownListWithSource($business_profile_types, 'id', 'description');
        $profile_info = $this->business_profile_library->get_profile_info();
        $this->data['profile_info'] = $profile_info;
        
        $sub_type_list = array();
        foreach ($business_profile_types as $value) {
            $sub_type_list[$value['id']] = $this->dataprovider_model->dropDownListWithSource($value["sub_type_list"], 'id', 'description');
        }
        $this->data['sub_type_list'] = $sub_type_list;
        
        $this->template->load("templates/business_tmpl", "settings/business/profile", $this->data);
        
    }
    
    
    
    /******All business settings completed*******/
    
}
?>
