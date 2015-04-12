<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Member_profile extends Role_Controller{

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library("follower");
        $this->load->library('form_validation');
        $this->load->library("statuses");
        $this->load->helper('url');
        $this->load->helper('captcha');
        $this->load->model("dataprovider_model");
        $this->load->library("org/interest/special_interest");
        $this->load->library("visitors");
        $this->load->library('org/question/security_question_library');
        $this->load->library('basic_profile');
        $this->load->library("recent_activities");
        $this->load->library("profile");

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

    function index(){
        
        
        $visit_success = $this->visitors->store_page_visitor(VISITOR_PAGE_PROFILE_ID);
        $this->show();
    }
    function show( $user_id = 0) {
        $this->data['profile_type'] = PROFILE_NON_FOLLOWER;
        $this->data['is_myself'] = FALSE;
        if($user_id == 0 || $user_id == $this->ion_auth->get_user_id()){
            $this->data['myself'] = $this->basic_profile->get_profile_info();
            $user_id = $this->ion_auth->get_user_id();
            $this->data['is_myself'] = TRUE;
            $this->data['profile_type'] = PROFILE_MYSELF;
        }
        else
        {
            $this->data = array_merge($this->data, $this->follower->get_relation_with_user($user_id));            
        }
        $this->data['newsfeeds'] = $this->statuses->get_statuses(STATUS_LIST_USER_PROFILE, $user_id);
        $this->data['status_list_id'] = STATUS_LIST_USER_PROFILE;
        $this->data['mapping_id'] = $user_id;
        $this->data['user_info'] = $this->ion_auth->get_user_info();
        
                
        $this->data['status_or_comment_in'] = STATUS_POSTED_IN_BASIC_PROFILE;
        $this->data['basic_profile'] = $this->basic_profile->get_profile_info($user_id);
        $this->data['myself'] = $this->data['basic_profile'];
                
        
        //$this->data['user_id'] = $this->ion_auth->get_user_id();
        $this->data['user_id'] = $user_id;
        
        $photo_list = $this->profile->get_photo_list($user_id)->result_array();
        $photo = array();
            
        //for($i=0;$i<6;$i++){
        //    $photo[$i]= USER_PHOTO_DEFAULT_IMAGE;
        //}
        $photo[0]= USER_PHOTO_DEFAULT_IMAGE1;
        $photo[1]= USER_PHOTO_DEFAULT_IMAGE2;
        $photo[2]= USER_PHOTO_DEFAULT_IMAGE3;
        $photo[3]= USER_PHOTO_DEFAULT_IMAGE4;
        $photo[4]= USER_PHOTO_DEFAULT_IMAGE5;
        $photo[5]= USER_PHOTO_DEFAULT_IMAGE6;
        
        if(!empty($photo_list))
        {
            $photo_list = $photo_list[0];
            
            $photo_list = json_decode($photo_list['photo_list']);
            for($i=0;$i<count($photo_list);$i++)
            {
                $photo[$photo_list[$i]->id] = $photo_list[$i]->photo_name;
            }
        }
        
        $this->data['photo_list'] = $photo;
        
        $this->template->load(null, "member/profile/show", $this->data);
    }
    function followers($user_id = 0){
        $this->data['basic_profile'] = $this->basic_profile->get_profile_info($user_id);
        $this->template->load("templates/business_tmpl", "followers/show", $this->data);
    }
    
    function info($user_id = 0){
        $this->data['basic_profile'] = $this->basic_profile->get_profile_info($user_id);
        $this->data["gender_list"] = $this->dataprovider_model->getGenderList()->dropDownList('id', 'gender_name');
        $this->data["country_list"] = $this->dataprovider_model->getCountryList()->dropDownList('id', 'country_name');
        $profile_info = $this->basic_profile->get_profile_info($user_id);

        $this->data['first_name'] = $profile_info->first_name;
        $this->data['last_name'] = $profile_info->last_name;
        $this->data['about_me'] = $profile_info->about_me;
                
        $home_town = '';
        $clg_or_uni = '';
        $employer = '';
        $gender_id = '';
        $dob = '';
        $country_id = '';
        $fav_team = '';
        $fav_player = '';
        $photo = '';
        $occupation ='';
        $selected_special_interest = '';
        $telephone = '';
        $email = '';
        $skype_name = '';
        $twitter_name = '';
        $facebook_name = '';
        $linkedin = '';

        if ($profile_info) {
            $home_town = $profile_info->home_town;
            $clg_or_uni = $profile_info->clg_or_uni;
            $employer = $profile_info->employer;
            $gender_id = $profile_info->gender_id;
            $dob = $profile_info->dob;
            $country_id = $profile_info->country_id;
            $fav_team = $profile_info->fav_team;
            $fav_player = $profile_info->fav_player;
            $photo = $profile_info->photo;
            $occupation = $profile_info->occupation;
            $selected_interests = json_decode($profile_info->special_interests);
            $telephone = $profile_info->telephone;
            $email = $profile_info->email;
            
            //print_r($selected_interests);
            if (is_array($selected_interests)) {
                $selected_special_interest = array();
                foreach ($selected_interests as $value) {
                    $selected_special_interest[] = ($value->interest_id . "_" . $value->sub_interest_id);
                }
            }
        }

        $this->data['home_town'] = $home_town;
        $this->data['college'] = $clg_or_uni;
        $this->data['employer'] = $employer;
        $this->data['gender_id'] = $gender_id;
        $this->data['dob'] = $dob;
        $this->data['country_id'] = $country_id;
        $this->data['sports_team'] = $fav_team;
        $this->data['fav_player'] = $fav_player;
        $this->data['photo'] = $photo;
        $this->data['occupation'] = $occupation;
        $this->data['telephone'] = $telephone;
        $this->data['email'] = $email;
        $this->data['skype_name'] = $skype_name;
        $this->data['twitter_name'] = $twitter_name;
        $this->data['facebook_name'] = $facebook_name;
        $this->data['linkedin'] = $linkedin;
        
        $this->data['selected_special_interest'] = json_encode($selected_special_interest);
        $this->data['special_interests'] = json_encode($this->special_interest->get_all_special_interests());
        $this->data['user_id'] = $user_id;
        $this->template->load(null, "member/profile/info", $this->data);
    }
    
    
    function update_info($member_id = 0){
        $this->data['basic_profile'] = $this->basic_profile->get_profile_info($member_id);
        $this->data["gender_list"] = $this->dataprovider_model->getGenderList()->dropDownList('id', 'gender_name');
        $this->data["country_list"] = $this->dataprovider_model->getCountryList()->dropDownList('id', 'country_name');
        $profile_info = $this->basic_profile->get_profile_info($member_id);

        $this->data['first_name'] = $profile_info->first_name;
        $this->data['last_name'] = $profile_info->last_name;
        $this->data['about_me'] = $profile_info->about_me;
                
        $home_town = '';
        $clg_or_uni = '';
        $employer = '';
        $gender_id = '';
        $dob = '';
        $country_id = '';
        $fav_team = '';
        $fav_player = '';
        $photo = '';
        $occupation ='';
        $selected_special_interest = '';
        $telephone = '';
        $email = '';
        $skype_name = '';
        $twitter_name = '';
        $facebook_name = '';
        $linkedin_name = '';

        if ($profile_info) {
            $home_town = $profile_info->home_town;
            $clg_or_uni = $profile_info->clg_or_uni;
            $employer = $profile_info->employer;
            $gender_id = $profile_info->gender_id;
            $dob = $profile_info->dob;
            $country_id = $profile_info->country_id;
            $fav_team = $profile_info->fav_team;
            $fav_player = $profile_info->fav_player;
            $photo = $profile_info->photo;
            $occupation = $profile_info->occupation;
            $selected_interests = json_decode($profile_info->special_interests);
            $telephone = $profile_info->telephone;
            $email = $profile_info->email;
            
            $skype_name = $profile_info->skype_name;
            $facebook_name = $profile_info->facebook_name;;
            $linkedin_name = $profile_info->linkedin_name;
            $twitter_name = $profile_info->twitter_name;
            
            //print_r($selected_interests);
            if (is_array($selected_interests)) {
                $selected_special_interest = array();
                foreach ($selected_interests as $value) {
                    $selected_special_interest[] = ($value->interest_id . "_" . $value->sub_interest_id);
                }
            }
        }

        $this->data['home_town'] = $home_town;
        $this->data['college'] = $clg_or_uni;
        $this->data['employer'] = $employer;
        $this->data['gender_id'] = $gender_id;
        $this->data['dob'] = $dob;
        $this->data['country_id'] = $country_id;
        $this->data['sports_team'] = $fav_team;
        $this->data['fav_player'] = $fav_player;
        $this->data['photo'] = $photo;
        $this->data['occupation'] = $occupation;
        $this->data['telephone'] = $telephone;
        $this->data['email'] = $email;
        $this->data['skype_name'] = $skype_name;
        $this->data['twitter_name'] = $twitter_name;
        $this->data['facebook_name'] = $facebook_name;
        $this->data['linkedin_name'] = $linkedin_name;
        
        $this->data['selected_special_interest'] = json_encode($selected_special_interest);
        $this->data['special_interests'] = json_encode($this->special_interest->get_all_special_interests());
        $this->template->load("templates/member_tmpl", "member/profile/edit", $this->data);
    }
    
    public function update_basic_profile(){
        $password = $this->input->post('password');
        $user = $this->ion_auth->user()->row();
        if($this->ion_auth->hash_password_db($user->id, $password)){
            $this->basic_profile->update_profile($this->input->post());
        }
        redirect("member_profile/update_info/".$this->ion_auth->get_user_id(), "refresh");
    }
    
    public function update_interests(){
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
            $this->basic_profile->update_profile($profile_data);
        }
        redirect("member_profile/update_info/".$this->ion_auth->get_user_id(), "refresh");
    }
    
    function view_shared_status($status_id)
    {        
        $this->data['newsfeed'] = array();
        $this->data['basic_profile'] = $this->basic_profile->get_profile_info();
        $this->data['recent_activities'] = $this->recent_activities->get_recent_activites();
        $this->data['user_info'] = $this->ion_auth->get_user_info();
        $this->data['status_list_id'] = 0;
        $this->data['mapping_id'] = 0;
        $newsfeeds = $this->statuses->get_statuses(0, 0, 0, 0, $status_id);
        if(!empty($newsfeeds))
        {
            $this->data['newsfeed'] = $newsfeeds[0];
        }
        $this->template->load(NULL, "member/status/index", $this->data);
    }
    
    function upload_photo_on_list()
    {
        $user_id = $this->session->userdata('user_id');
        $position_id = $this->input->post('img_place');
        $result = $this->utils->upload_image($position_id, USER_PHOTO_LIST_IMAGE_PATH);
        if ($result['status'] == 1) {
            $upload_data = $result['upload_data'];
            $file_name = $upload_data['file_name'];
            $this->utils->resize_image(USER_PHOTO_LIST_IMAGE_PATH . $file_name, USER_PHOTO_LIST_IMAGE_PATH_W100_H100 . $file_name, USER_PHOTO_LIST_IMAGE_H100, USER_PHOTO_LIST_IMAGE_W100);
        } else {
            $this->data['message'] = $result['message'];
            echo json_encode($this->data);
            return;
        }
        $photo_list = $this->profile->get_photo_list($user_id)->result_array();
        if(empty($photo_list))
        {
            $photo = new stdClass();
            $photo->id = $position_id;
            $photo->photo_name = $upload_data['file_name'];
            $photo = json_encode(array($photo));
            $data = array(
                'user_id' => $user_id,
                'photo_list' => $photo,
                'created_on' => now()
            );
            
            $id = $this->profile->create_photo_list($data);
            $data = array('upload_data' => $upload_data['file_name']);
            echo json_encode($data);
        }
        else{
            $photo_list = $photo_list[0];
            $data = json_decode($photo_list['photo_list']);
            $length = count($data);
            $i=0;
            
            for($i=0;$i<$length;$i++)
            {
                if($data[$i]->id == $position_id)
                {
                    $data[$i]->photo_name = $upload_data['file_name'];
                    break;
                }
            }
            if($i>=$length)
            {
                $new_data = new stdClass();
            
                $new_data->id = $position_id;
                $new_data->photo_name = $upload_data['file_name'];
                
                array_push($data,$new_data);
            }
            $data = json_encode($data);
            
            $additional_data = array(
                'user_id' => $user_id,
                'photo_list' => $data,
                'modified_on' => now(),
            );
            
            $this->profile->update_photo_list($user_id,$additional_data);
            
            $data = array('upload_data' => $upload_data['file_name']);
            echo json_encode($data);
        }
       
    }
}
?>