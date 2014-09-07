<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Feed extends Role_Controller{

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library("basic_profile");
        $this->load->library("statuses");
        $this->load->library("Trending_features");
        $this->load->library("users_album");
        $this->load->library("org/utility/utils");
        
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->lang->load('auth');
        $this->load->helper('language');
        $this->load->library("newsfeed");
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    function index() {
        
    }
    
    function post_status()
    {
        $result = array();
        $status_data = $this->input->post();
        if($status_data['description'] == "" && !isset($status_data['uploaded_image']) ){
            echo STATUS_POST_EMPTY_ERROR;
            return;
        }
        $status_data["description"] = htmlentities($this->grabYoutubeVideo($status_data["description"]));
        $user_list_array = explode(",", $status_data['user_list']);
        $reference_list = array();
        foreach($user_list_array as $user_id)
        {
            if($user_id != '')
            {
                $user_info = new stdClass();
                $user_info->id = $user_id;
                //type_id 1 is user id
                $user_info->type_id = 1;
                $reference_list[] = $user_info;
            }            
        }        
        $status_data["reference_list"] = json_encode($reference_list);
        if(isset($status_data['uploaded_image']))
        {
            $attachment_array = array();
            $this->utils->copy_image_from_source_to_destination(STATUS_IMAGE_UPLOAD_TEMP_PATH, STATUS_IMAGE_UPLOAD_PATH, $status_data['uploaded_image']);
            $current_attachment = new stdClass();
            $current_attachment->type = STATUS_ATTACHMENT_IMAGE;
            $current_attachment->name = $status_data['uploaded_image'];
            $attachment_array[] = $current_attachment;
            $status_data["attachments"] = json_encode($attachment_array);
            
        }
        $status_id = $this->statuses->post_status($status_data);
        if( $status_id !== FALSE)
        {
            $hashtag_list_array = explode(",", $status_data['hashtag_list']);
            foreach($hashtag_list_array as $hashtag)
            {
                if($hashtag != '')
                {
                    $this->trending_features->store_hashtag($hashtag, $status_id);
                }            
            } 
            if(strpos($status_data["description"], "<object" ) !== false){
                echo STATUS_POST_REFRESH;
            }
            else{
                echo STATUS_POST_SUCCESS;
            }
        }
        else
        {
            echo STATUS_POST_INSERTION_ERROR;
        }
    }
    /**
     * Remote function call
     */
    function post($status_place_type, $follower_id = 0){
        $status_data = $this->input->post();
        if($status_data['description'] == "" && !isset($status_data['attachments']) ){
            echo STATUS_POST_EMPTY_ERROR;
        }
        //echo $this->grabYoutubeVideo($status_data->description);
        $status_data["description"] = htmlentities($this->grabYoutubeVideo($status_data["description"]));
        $user_list_array = explode(",", $status_data['user_list']);
        $reference_list = array();
        foreach($user_list_array as $user_id)
        {
            if($user_id != '')
            {
                $user_info = new stdClass();
                $user_info->user_id = $user_id;
                //type_id 1 is user id
                $user_info->type_id = 1;
                $reference_list[] = $user_info;
            }            
        }        
        $status_data["reference_list"] = json_encode($reference_list);
        //echo json_encode($status_data);
        $status = $this->newsfeed->post_status($status_data, array("status_in" => $status_place_type, "album_id" => $this->input->post("attachments")), $follower_id);
        if( $status == FALSE){
            echo STATUS_POST_INSERTION_ERROR;
        }
        else{
            if(strpos($status->description, "<object" ) !== false){
                echo STATUS_POST_REFRESH;
            }
            else{
                echo json_encode($status);
            }
        }
    }
    
    function get_statuses($status_list_id, $mapping_id, $limit, $offset, $hashtag = ''){
        if($status_list_id == STATUS_LIST_HASHTAG)
        {
            $status_ids = $this->trending_features->get_status_ids_hashtag($hashtag);
            $newsfeeds = $this->statuses->get_statuses($status_list_id, $mapping_id, $limit, $offset, $status_ids);
        }
        else
        {
            $newsfeeds = $this->statuses->get_statuses($status_list_id, $mapping_id, $limit, $offset);
        }        
        $this->data['user_info'] = $this->ion_auth->get_user_info();
        //$this->data['user_id'] = $user_id;
        if($newsfeeds){
            $this->data["status_list_id"] = $status_list_id;
            $this->data["mapping_id"] = $mapping_id;
            $this->data["hashtag"] = $hashtag;
            $this->data["newsfeeds"] = $newsfeeds;
            $this->data["next_start"] = $offset + $limit;
            $this->load->view("member/newsfeed/partial_feeds_renderer", $this->data);
        }
    }
    
    function get_feeds($profile_type, $limit, $start, $user_id = 0){
        $newsfeeds = $this->newsfeed->get_statuses($profile_type, $limit, $start, $user_id);
        $this->data['myself'] = $this->basic_profile->get_profile_info();
        $this->data['user_id'] = $user_id;
        if($newsfeeds){
            $this->data["status_or_comment_in"] = $profile_type;
            $this->data["newsfeeds"] = $newsfeeds;
            $this->data["next_start"] = $start + $limit;
            $this->load->view("member/newsfeed/partial_feeds_renderer", $this->data);
        }
    }
    
    function post_feedback(){
        $status_list_id = $this->input->post("status_list_id");
        $mapping_id = $this->input->post("mapping_id");
        $status_id = $this->input->post("status_id");
        $feedback = $this->input->post("feedback");
        $this->statuses->add_feedback($status_id, $feedback);
        if($status_list_id == STATUS_LIST_NEWSFEED)
        {
            redirect("auth",'refresh');
        }
        else if($status_list_id == STATUS_LIST_USER_PROFILE)
        {
            redirect("member_profile/show/".$mapping_id,'refresh');
        }
        else if($status_list_id == STATUS_LIST_BUSINESS_PROFILE)
        {
            redirect("business_profile/show/".$mapping_id,'refresh');
        }
        else
        {
            redirect("member_profile/view_shared_status/".$status_id,'refresh');
        }
    }
    
    function ajax_post_feedback(){
        $status_id = $_POST['status_id'];
        $feedback = $_POST['feedback'];
        $this->statuses->add_feedback($status_id, $feedback);
        $user_info = $this->ion_auth->get_user_info();
        $feedback_info = array(
            'user_info' => $user_info,
            'feedback' => $feedback
        );
        echo json_encode($feedback_info);
    }
    
    /*function post_feedback(){
        $comment_id = $this->input->post("comment_id");
        $status_id = $this->input->post("status_id");
        $feedback = $this->input->post("feedback");
        $this->newsfeed->add_feedback($comment_id, $status_id, $feedback);
        redirect("auth");
    }*/
    
    function grabYoutubeVideo($sText) {
        //$sText = "Check out my latest video here http://www.youtube.com/watch?v=Imh0vEnOMXU&feature=g-vrec Check out my latest video here http://www.youtube.com/watch?v=Imh0vEnOMXU&feature=g-vrec";
        //$sText =  "http://www.youtube.com/watch?v=Imh0vEnOMXU&feature=g-vrec";
        //return $sText;
        if(preg_match_all('@https?://(www\.)?youtube.com/.[^\s.,"\']+@i', $sText, $aMatches)){
            //Need only the first youtube video link
            //echo $aMatches[0][0];

            $url = $aMatches[0][0];
            //$url = 'http://www.youtube.com/watch?v=Imh0vEnOMXU&feature=g-vrec';    // some youtube url
            $parsed_url = parse_url($url);
            /*
             * Do some checks on components if necessary
             */
            parse_str($parsed_url['query'], $parsed_query_string);
            $v = $parsed_query_string['v'];

            //return $v;
            $width = '470';
            $height = '400';
            return '<object width="' . $width . '" height="' . $height . '"><param name="movie" value="http://www.youtube.com/v/' . $v . '&amp;hl=en_US&amp;fs=1?rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/' . $v . '" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="' . $width . '" height="' . $height . '"></embed></object>';
        }
        else{
            return $sText;
        }
    }
    
    function seeAllSuggestedPeople()
    {
        $this->template->load(null, "member/newsfeed/suggested_people", $this->data);
    }
    
    public function delete_status()
    {
        $status_id = $this->input->post('status_id');
        echo json_encode($this->statuses->delete_status($status_id));
    }
    

}
?>