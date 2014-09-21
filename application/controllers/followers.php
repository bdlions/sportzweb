<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Followers extends Role_Controller{

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('captcha');
        $this->load->library('basic_profile');
        $this->load->library('follower');
        $this->load->library('permission');
        $this->load->library('visitors');
        
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
        $this->data['current_user_id'] = $this->session->userdata('user_id');
    }

    function index(){
        
        $visit_success = $this->visitors->store_page_visitor(VISITOR_PAGE_FOLLOWERS_ID);
        $this->show();
    }
    function show( $user_id = 0) {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }        
        $this->data['user_id'] = $user_id;
        $this->data['follow_permission'] = $this->follower ->get_acceptance_type();
        $this->data['basic_profile'] = $this->basic_profile->get_profile_info($user_id);
        $this->data['followers'] = $this->follower->get_followers($user_id);
        $this->template->load(null, "followers/show", $this->data);
    }
    
    /*function pending_followers(){
        $this->data['basic_profile'] = $this->basic_profile->get_profile_info();
        $this->data['followers'] = $this->follower->get_pending_followers();
        $this->template->load("templates/business_tmpl", "followers/show_pending_users", $this->data);
    }*/
    
    function pending_followers($user_id = 0){
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        } 
        $this->data['user_id'] = $user_id;
        $this->data['basic_profile'] = $this->basic_profile->get_profile_info();
        $this->data['followers'] = $this->follower->get_pending_followers($user_id);
        $this->template->load(null, "followers/show_pending_users", $this->data);
    }
    
    function blocked_followers($user_id = 0){
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        } 
        $this->data['user_id'] = $user_id;
        $this->data['basic_profile'] = $this->basic_profile->get_profile_info();
        $this->data['followers'] = $this->follower->get_blocked_followers($user_id);
        $this->template->load(null, "followers/show_blocked_users", $this->data);
    }
    
    /*function accept_request($follower_id){
        if($this->follower->accept_request($follower_id) == true){
            redirect("followers/pending_followers", "refresh");
        }
    }*/
    
    function accept_request($follower_id){
        $user_id = $this->session->userdata('user_id');
        if($this->follower->accept_follower($user_id, $follower_id) == true){
            redirect("followers/pending_followers/".$user_id, "refresh");
        }
    }
    /*Remote call*/
    function follow_user($follower_id){
        echo $this->follower->follow_user($follower_id);
    }
    
    /*
     * Ajax Call
     * This method will add a follower
     * @Author Nazmul on 20th september 2014
     */
    function add_follower($follower_id){
        $user_id = $this->session->userdata('user_id');
        echo $this->follower->add_follower($user_id, $follower_id);
    }
    
    /*
     * This method will remove a follower
     * @Author Nazmul on 20th september 2014
     */
    function remove_follower($follower_id){
        $user_id = $this->session->userdata('user_id');
        $this->follower->remove_follower($user_id, $follower_id);
        redirect("followers");
    }
    
    /*
     * This method will block a follower
     * @Author Nazmul on 20th september 2014
     */
    function block_follower($follower_id){
        $user_id = $this->session->userdata('user_id');
        $this->follower->block_follower($user_id, $follower_id);
        redirect("followers");
    }
    
    function user_follow($follower_id){
       $this->follower->follow_user($follower_id);
       redirect('member_profile/show/'.$follower_id,'refresh');
    }

    function unfollow_user($follower_id){
        $this->follower->unfollow_user($follower_id);
        redirect("followers");
    }
    
    function user_unfollow($follower_id){
        $this->follower->unfollow_user($follower_id);
        redirect('member_profile/show/'.$follower_id,'refresh');
    }
    
    function invite(){
        $result = array();
        for ($i = 1; $i <= 5; $i ++) {
            $result[ "email".$i ] = array('status' => '', 'message' => '', 'email' => '');
        }
        $senderList = array();
        if($this->input->post()){
            $emailList = $this->input->post();
            foreach ($emailList as $key => $email) {
                if($email != ''){
                    if($this->ion_auth->email_check($email) >= 1){
                        $result[ $key ] = array('status' => 'has-error', 'message' => 'Member already exists', 'email' => $email);
                    }
                    else{
                        $senderList[] = $email;
                        $result[ $key ] = array('status' => 'has-success', 'message' => 'sent', 'email' => $email);
                    }
                }
            }
        }
        if(count($senderList) > 0){
            $message = "need a template for invition";
            $this->email->clear();
            $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
            $this->email->to($senderList);
            $this->email->subject($this->config->item('site_title', 'ion_auth') . ' - ' . 'invitaion');
            $this->email->message($message);

            if (!$this->email->send()) {
                echo "Email cannot be sent. Sorry for your patience.";
            }
        }
        $this->data['emailList'] = $result;
        $this->template->load(null, "followers/invite", $this->data);
    }
    
    public function get_followers_infor(){
        $response = array();
        $follwers_id = $_POST['follwers_id'];
        
        $follower_info_array = $this->follower->follow_user($follwers_id)->result_array();
        echo '<pre/>';print_r();exit('here');
        if(!empty($follower_info_array))
        {
            $response = $follower_info_array[0];
        }
        echo json_encode($response);
    }
    
}
?>