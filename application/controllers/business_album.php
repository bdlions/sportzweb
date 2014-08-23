<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_album extends Role_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');

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
        $this->data['my_photos'] = $this->users_album->get_my_photos();
        $this->template->load("templates/business_tmpl", "business_man/album/add_photo", $this->data);
    }
    
    public function show_albums(){
        $this->data["albums"] = $this->users_album->get_users_albums_cover_photo();
        $this->template->load("templates/business_tmpl", "business_man/album/show_all", $this->data);
    }
    
    public function show_album($album_id){
        $this->data['photos'] = $this->users_album->get_album_photos($album_id);
        $this->template->load("templates/business_tmpl", "business_man/album/show_album_photos", $this->data);
    }
    
    public function add_photo_in_album($album_id){
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
    }
    public function create_album(){
        $this->data['album_id'] = $this->users_album->create_album();
        $this->template->load("templates/member_tmpl", "business_man/album/create", $this->data);
    }
    public function complete_uploading_album($album_id){
        $this->users_album->update_album($album_id, $this->input->post());
        redirect("business_album/show_albums");
    }
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
            $photo_id = $this->users_album->add_my_photos( $photo_data);
            if($photo_id){
                $data = array('upload_data' => $upload_data);
                echo json_encode(array_merge($data, array('photo_id' => $photo_id)));
            }
            $data = array('upload_data' => $upload_data);
            
            echo json_encode($data);
        }
    }
}
?>
