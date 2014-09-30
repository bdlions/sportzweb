<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_album extends Role_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library("albums");
        $this->load->library('statuses');
        $this->load->helper('url');
        $this->load->library('visitors');
        $this->load->library('Basic_profile');
        $this->load->library('org/utility/Utils');
        
        $this->load->library("users_album");
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
        
        $visit_success = $this->visitors->store_page_visitor(VISITOR_PAGE_PHOTO_ID);
        $this->data['my_photos'] = $this->users_album->get_my_photos(ALBUM_TYPE_USER_PROFILE);
        
        
        $this->data['feedback_list'] = $this->users_album->get_photo_comments();
        
        $this->template->load("templates/business_tmpl", "member/album/add_photo", $this->data);
    }
    
    /*public function show_albums($user_id = 0){
        $this->data["albums"] = $this->users_album->get_users_albums_cover_photo($user_id, ALBUM_TYPE_USER_PROFILE);
        $this->template->load("templates/business_tmpl", "member/album/show_all", $this->data);
    }*/
    
    /*public function show_album($album_id){
        $this->data['photos'] = $this->users_album->get_album_photos($album_id);
        $this->template->load("templates/business_tmpl", "member/album/show_album_photos", $this->data);
    }*/
    
    /*public function add_photo_in_album($album_id){
        $config['image_library'] = 'gd2';
        $config['upload_path'] = './resources/uploads/albums/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '10240';
        $config['maintain_ratio'] = FALSE;
        $config['create_thumb'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        } else {
            $upload_data = $this->upload->data();
            $photo_data = array('photo' => $upload_data['file_name']);
            $photo_id = $this->users_album->add_photo_in_album($album_id, $photo_data);
            if($photo_id){
                $data = array('upload_data' => $upload_data);
                echo json_encode(array_merge($data, array('photo_id' => $photo_id)));
            }
            else{
                echo FALSE;
            }
        }
    }*/
    /*public function create_album(){
        $this->data['album_id'] = $this->users_album->create_album(ALBUM_TYPE_USER_PROFILE);
        $this->template->load("templates/member_tmpl", "member/album/create", $this->data);
    }*/
    
    /*public function complete_uploading_album($album_id){
        $this->users_album->update_album($album_id, $this->input->post());
        redirect("user_album");
    }*/
    
    public function add_my_photos(){
        $config['image_library'] = 'gd2';
        $config['upload_path'] = './resources/uploads/albums/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '10240';
        $config['maintain_ratio'] = FALSE;
        $config['width'] = 120;
        $config['height'] = 120;
        $config['create_thumb'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        } else {
            $upload_data = $this->upload->data();
            $photo_data = array('photo' => $upload_data['file_name']);
            $photo_id = $this->users_album->add_my_photos( $photo_data, ALBUM_TYPE_USER_PROFILE);
            if($photo_id){
                $data = array('upload_data' => $upload_data);
                echo json_encode(array_merge($data, array('photo_id' => $photo_id)));
                return;
            }
            $data = array('upload_data' => $upload_data);
            
            echo json_encode($data);
        }
    }
    
    public function add_status_photos()
    {
        $data = $this->statuses->status_upload_image(STATUS_IMAGE_UPLOAD_TEMP_PATH);
        echo json_encode(array_merge($data, array('album_id' => 1, 'photo_id' => 1)));
    }
    /*public function add_status_photos(){
        $config['image_library'] = 'gd2';
        $config['upload_path'] = './resources/uploads/albums/';
        $config['allowed_types'] = 'gif|jpg|png|avi|mpg|mpeg|avi|flv|wmv|mp3';
        //$config['max_size'] = '10240';
        //$config['maintain_ratio'] = FALSE;
        //$config['width'] = 120;
        //$config['height'] = 120;
        //$config['create_thumb'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        } else {
            $upload_data = $this->upload->data();
            $photo_data = array('photo' => $upload_data['file_name']);
            $album_id = 0;
            if($this->input->post("attachments") == null){
                $album_id = $this->users_album->create_album(ALBUM_TYPE_USER_PROFILE);
            }
            else{
                $album_id = $this->input->post("attachments");
            }
            if($album_id){
                $photo_id = $this->users_album->add_photo_in_album($album_id, $photo_data);
                //$photo_id = $this->users_album->add_my_photos( $photo_data, ALBUM_TYPE_USER_PROFILE);
                if($photo_id){
                    $data = array('upload_data' => $upload_data);
                    echo json_encode(array_merge($data, array('album_id' => $album_id, 'photo_id' => $photo_id)));
                }else{
                    echo "photo not created.";
                }
            }
            else{
                echo "album not exists";
            }
        }
    }*/
    
    /*public function get_photo_details()
    {
        $result = array();
        $photo_id = $_POST['photo_id'];
        $result['photo_id'] = $photo_id;
        $result = array_merge($result, $this->users_album->get_album_photos_info($photo_id));
        $result['status'] = 1;
        echo json_encode($result);
    }*/
    
    /*public function post_photo_comment()
    {
        $photo_id = $_POST['photo_id'];
        $feedback = $_POST['feedback'];
        
        $this->users_album->add_feedback($photo_id, $feedback);
        $user_info = $this->ion_auth->get_user_info();
        $feedback_info = array(
            'user_info' => $user_info,
            'description' => $feedback,
            'created_on' => '1 second ago'
        );
        echo json_encode($feedback_info);        
    }*/
    
    /*public function store_like_photo()
    {
        $result = array();
        $photo_id = $_POST['photo_id'];
        $result = array_merge($result, $this->users_album->store_photo_like($photo_id));
        $result['photo_id'] = $photo_id;
        echo json_encode($result);
        
    }*/
    
    /*public function remove_like_photo()
    {
        $result = array();
        $photo_id = $_POST['photo_id'];
        $result = array_merge($result, $this->users_album->remove_photo_like($photo_id));
        $result['photo_id'] = $photo_id;
        echo json_encode($result);
    }*/
    
    /*
     * Ajax call
     * This method will crop a picture
     * @Author Nazmul on 12th July 2014
     */
    /*public function crop_picture()
    {
        $result = array();
        $user_id = $this->session->userdata('user_id');
        $targ_w = $_POST['w'];
        $targ_h = $_POST['h'];
        //$targ_w = $targ_h = 200;
	$jpeg_quality = 100;

        $src = $_POST['src'];
        $src_w = $_POST['src_w'];
        $src_h = $_POST['src_h'];        
        $src_relative_path = str_replace(base_url(),'',$src);
        
        $temp_src_name = $user_id.'_'.now().'.jpg';
        $temp_src_relative_path = "resources/uploads/temp/".$temp_src_name;
        $this->utils->resize_image($src_relative_path, $temp_src_relative_path, $src_h, $src_w);
        $img_r = imagecreatefromjpeg($temp_src_relative_path);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);

        //creating image destination directory if not exists
        if( !is_dir(PROFILE_PICTURE_UPLOAD_PATH) )
        {
            mkdir(PROFILE_PICTURE_UPLOAD_PATH, 0777, TRUE);
        }
	imagejpeg($dst_r,PROFILE_PICTURE_UPLOAD_PATH.$temp_src_name ,$jpeg_quality);
        $this->utils->resize_image(PROFILE_PICTURE_UPLOAD_PATH.$temp_src_name, PROFILE_PICTURE_PATH_W50_H50.$temp_src_name, PROFILE_PICTURE_H50, PROFILE_PICTURE_W50);
        $this->utils->resize_image(PROFILE_PICTURE_UPLOAD_PATH.$temp_src_name, PROFILE_PICTURE_PATH_W32_H32.$temp_src_name, PROFILE_PICTURE_H32, PROFILE_PICTURE_W32);
        //delete temp src image
        //update database related to profile picture
        $data = array(
            'photo' => $temp_src_name
        );
        $this->basic_profile->update_profile_info($data, $user_id);
        //add status in user profile related to the change of profile picture
        $status_data = array(
            'user_id' => $user_id,
            'mapping_id' => $user_id,
            'status_type_id' => STATUS_TYPE_PROFILE_PIC_CHANGE,
            'status_category_id' => STATUS_CATEGORY_USER_PROFILE,
            'created_on' => now(),
            'modified_on' => now()
        );
        $attachment_array = array();
        $current_attachment = new stdClass();
        $current_attachment->type = STATUS_ATTACHMENT_IMAGE;
        $current_attachment->name = $temp_src_name;
        $attachment_array[] = $current_attachment;
        $status_data["attachments"] = json_encode($attachment_array);
        if($this->statuses->post_status($status_data) !== FALSE)
        {
            $result['status'] = 1;
            $result['user_id'] = $user_id;
        }
        else
        {
            $result['status'] = 0;
            $result['user_id'] = $user_id;
        }
        
        echo json_encode($result);
    }*/
    
    public function photos($user_id = 0)
    {
        $visit_success = $this->visitors->store_page_visitor(VISITOR_PAGE_PHOTO_ID);
        $current_user_id = $this->session->userdata('user_id');
        $this->data['current_user_id'] = $current_user_id;
        if($user_id == 0)
        {
            $user_id = $current_user_id;
        }
        $this->data['user_id'] = $user_id;
        $this->data['photos'] = $this->albums->get_user_album_photos(ALBUM_TYPE_USER_PHOTOS, $user_id)->result_array(); 
        $this->template->load("templates/business_tmpl", "member/album/photos", $this->data);
    }
    
    public function add_my_photo(){
        $result = array();
        if (isset($_FILES["userfile"])) {
            $file_info = $_FILES["userfile"];
            $result = $this->utils->upload_image($file_info, ALBUM_IMAGE_PATH);
            if($result['status'] == 1)
            {
                $path = ALBUM_IMAGE_PATH.$result['upload_data']['file_name'];
                $height = ALBUM_IMAGE_MAX_HEIGHT;
                $width = ALBUM_IMAGE_MAX_WIDTH;
                //if uploaded image width and height is less than max then don't resize the image
                //add the above logic
                $this->utils->resize_image($path, $path, $height, $width);
                $additional_data = array(
                    'img' => $result['upload_data']['file_name']
                );
                $id = $this->albums->add_photo($additional_data);
                if($id !== FALSE)
                {
                    $result['message'] = 'Photo is stored successfully.';
                }
                else
                {
                    $result['status'] = 0;
                    $result['message'] = 'Error while storing photo.';
                }
            }
        }
        else
        {
            $result['status'] = 0;
            $result['message'] = 'Please select an image.';
        }
        echo json_encode($result);
        return;        
    }
    
    public function get_photo_details()
    {
        $result = array();
        $photo_id = $_POST['photo_id'];
        $result['photo_id'] = $photo_id;
        $result = array_merge($result, $this->albums->get_photo_details($photo_id));
        $result['status'] = 1;
        echo json_encode($result);
    }
    
    public function post_photo_comment()
    {
        $photo_id = $_POST['photo_id'];
        $feedback = $_POST['feedback'];
        
        $this->albums->add_feedback($photo_id, $feedback);
        $user_info = $this->ion_auth->get_user_info();
        $feedback_info = array(
            'user_info' => $user_info,
            'description' => $feedback,
            'created_on' => '1 second ago'
        );
        echo json_encode($feedback_info);        
    }
    
    public function store_like_photo()
    {
        $result = array();
        $photo_id = $_POST['photo_id'];
        $result = array_merge($result, $this->albums->store_photo_like($photo_id));
        $result['photo_id'] = $photo_id;
        echo json_encode($result);
        
    }
    
    public function remove_like_photo()
    {
        $result = array();
        $photo_id = $_POST['photo_id'];
        $result = array_merge($result, $this->albums->remove_photo_like($photo_id));
        $result['photo_id'] = $photo_id;
        echo json_encode($result);
    }
    
    public function crop_picture()
    {
        $result = array();
        $user_id = $this->session->userdata('user_id');
        $targ_w = $_POST['w'];
        $targ_h = $_POST['h'];
        //$targ_w = $targ_h = 200;
	$jpeg_quality = 100;

        $src = $_POST['src'];
        $src_w = $_POST['src_w'];
        $src_h = $_POST['src_h'];        
        $src_relative_path = str_replace(base_url(),'',$src);
        
        $temp_src_name = $user_id.'_'.now().'.jpg';
        $temp_src_relative_path = "resources/uploads/temp/".$temp_src_name;
        $this->utils->resize_image($src_relative_path, $temp_src_relative_path, $src_h, $src_w);
        $img_r = imagecreatefromjpeg($temp_src_relative_path);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);

        //creating image destination directory if not exists
        if( !is_dir(ALBUM_IMAGE_PATH) )
        {
            mkdir(ALBUM_IMAGE_PATH, 0777, TRUE);
        }
	imagejpeg($dst_r,ALBUM_IMAGE_PATH.$temp_src_name ,$jpeg_quality);
        $this->utils->resize_image(ALBUM_IMAGE_PATH.$temp_src_name, PROFILE_PICTURE_PATH_W100_H100.$temp_src_name, PROFILE_PICTURE_H100, PROFILE_PICTURE_W100);
        $this->utils->resize_image(ALBUM_IMAGE_PATH.$temp_src_name, PROFILE_PICTURE_PATH_W50_H50.$temp_src_name, PROFILE_PICTURE_H50, PROFILE_PICTURE_W50);
        $this->utils->resize_image(ALBUM_IMAGE_PATH.$temp_src_name, PROFILE_PICTURE_PATH_W32_H32.$temp_src_name, PROFILE_PICTURE_H32, PROFILE_PICTURE_W32);
        //delete temp src image
        //update database related to profile picture
        $data = array(
            'photo' => $temp_src_name
        );
        $this->basic_profile->update_profile_info($data, $user_id);
        //adding this picture into profile picture album
        $photo_data = array(
            'img' => $temp_src_name
        );
        $photo_id = $this->albums->add_profile_picture($photo_data);
        //add status in user profile related to the change of profile picture
        $status_data = array(
            'user_id' => $user_id,
            'mapping_id' => $user_id,
            'status_type_id' => STATUS_TYPE_PROFILE_PIC_CHANGE,
            'status_category_id' => STATUS_CATEGORY_USER_PROFILE,
            'reference_id' => $photo_id,
            'created_on' => now(),
            'modified_on' => now()
        );
        //$attachment_array = array();
        //$current_attachment = new stdClass();
        //$current_attachment->type = STATUS_ATTACHMENT_IMAGE;
        //$current_attachment->name = $temp_src_name;
        //$attachment_array[] = $current_attachment;
        //$status_data["attachments"] = json_encode($attachment_array);
        if($this->statuses->post_status($status_data) !== FALSE)
        {
            $result['status'] = 1;
            $result['user_id'] = $user_id;
        }
        else
        {
            $result['status'] = 0;
            $result['user_id'] = $user_id;
        }
        
        echo json_encode($result);
    }
    
    public function albums($user_id = 0){
        $current_user_id = $this->session->userdata('user_id');
        $this->data['current_user_id'] = $current_user_id;
        $this->data['user_id'] = $user_id;
        $this->data["albums"] = $this->albums->get_user_albums_cover_photo($user_id)->result_array();
        $this->template->load("templates/business_tmpl", "member/album/albums", $this->data);
    }
    
    public function show_album($album_id){
        
        $this->data['user_id'] = 0;
        $album_info_array = $this->albums->get_album_info($album_id)->result_array();
        if(!empty($album_info_array))
        {
            $album_info = $album_info_array[0];
            $this->data['user_id'] = $album_info['reference_id'];
        }
        $current_user_id = $this->session->userdata('user_id');
        $this->data['current_user_id'] = $current_user_id;
        $this->data['photos'] = $this->albums->get_album_photos($album_id)->result_array();
        $this->data['album_id'] = $album_id;
        $this->template->load("templates/business_tmpl", "member/album/show_album_photos", $this->data);
    }
    
    public function create_album(){
        $user_id = $this->session->userdata('user_id');
        $current_time = now();
        $additional_data = array(
            'reference_id' => $user_id,
            'album_type_id' => ALBUM_TYPE_USER_ALBUM_PHOTOS,
            'created_on' => $current_time
        );
        $album_id = $this->albums->create_album($additional_data);
        if($album_id !== FALSE)
        {
            $this->data['album_id'] = $album_id;
            $this->template->load("templates/member_tmpl", "member/album/create_album", $this->data);
        }
        
    }
    
    public function add_photo_in_album($album_id){
        $result = array();
        if (isset($_FILES["userfile"])) {
            $file_info = $_FILES["userfile"];
            $result = $this->utils->upload_image($file_info, ALBUM_IMAGE_PATH);
            if($result['status'] == 1)
            {
                $path = ALBUM_IMAGE_PATH.$result['upload_data']['file_name'];
                $height = ALBUM_IMAGE_MAX_HEIGHT;
                $width = ALBUM_IMAGE_MAX_WIDTH;
                //if uploaded image width and height is less than max then don't resize the image
                //add the above logic
                $this->utils->resize_image($path, $path, $height, $width);
                $additional_data = array(
                    'album_id' => $album_id,
                    'img' => $result['upload_data']['file_name']
                );
                $photo_id = $this->albums_model->add_photo($additional_data);
                if($photo_id !== FALSE)
                {
                    $result['message'] = 'Photo is stored successfully.';
                    $result['photo_id'] = $photo_id;
                    $result['upload_data'] = $result['upload_data'];
                }
                else
                {
                    $result['status'] = 0;
                    $result['message'] = 'Error while storing photo.';
                }
            }
        }
        else
        {
            $result['status'] = 0;
            $result['message'] = 'Please select an image.';
        }
        echo json_encode($result);
    }
    
    public function complete_uploading_album($album_id){
        $this->albums->update_album($album_id, $this->input->post());
        redirect("user_album/show_album/".$album_id);
    }
}
?>
