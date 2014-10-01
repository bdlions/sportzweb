<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Media extends CI_Controller {

    function __construct() {
        parent::__construct();
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
        
        if (isset($_FILES["image"])) {
            $file_info = $_FILES["image"];
            $result = $this->utils->upload_image($file_info, SERVICE_MEDIA_PROFILE_PICTURE_PATH);   
            if($result['status'] == 1)
            {
                echo json_encode(
                array(
                            'result' => 'success',
                            'msg' => "file added successfully",
                            'status' => 1
                        )
                );
            }
        }         
         

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
