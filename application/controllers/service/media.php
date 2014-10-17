<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Media extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Basic_profile');
        $this->load->library('ion_auth');
        $this->load->library('org/utility/Utils');

        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        //$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
    }

    public function upload_profile_picture() {
        $name = $_POST['name'];
        $data = $_POST['data'];
        $user_id = $_POST['user_id'];
        $result = array();
        if (isset($_FILES["userfile"])) {
            $file_info = $_FILES["userfile"];
            $result = $this->utils->upload_image($file_info, SERVICE_MEDIA_PROFILE_PICTURE_PATH);
            $image_name = $result['upload_data']['file_name'];
            $this->utils->resize_image(SERVICE_MEDIA_PROFILE_PICTURE_PATH.$image_name, PROFILE_PICTURE_PATH_W100_H100.$image_name, PROFILE_PICTURE_H100, PROFILE_PICTURE_W100);
            $this->utils->resize_image(SERVICE_MEDIA_PROFILE_PICTURE_PATH.$image_name, PROFILE_PICTURE_PATH_W50_H50.$image_name, PROFILE_PICTURE_H50, PROFILE_PICTURE_W50);
            $this->utils->resize_image(SERVICE_MEDIA_PROFILE_PICTURE_PATH.$image_name, PROFILE_PICTURE_PATH_W32_H32.$image_name, PROFILE_PICTURE_H32, PROFILE_PICTURE_W32);
            //update database related to profile picture
            $data = array(
                'photo' => $image_name
            );
            $this->basic_profile->update_profile_info($data, $user_id);            
        } 
        else
        {
            $result['status'] = "0";
            $result['message'] = 'Please select and image to upload';
        }
        echo json_encode($result); 

        //Receive the file
        /*$objFile = & $_FILES["image"];
        $strPath = basename($objFile["name"]);
        $save_file_status = "";
        if (move_uploaded_file($objFile["tmp_name"], $strPath)) {
            $save_file_status = "The file " . $strPath . " has been uploaded.";
        } else {
            $save_file_status = "There was an error uploading the file, please try again!";
        }
        //process the data
        //return response to the server

        echo json_encode(
                array(
                    'result' => 'success',
                    'msg' => "file added successfully. and name was '{$name }' and data was '{$data}'",
                    'status' => $save_file_status
                )
        );*/
    }

}
