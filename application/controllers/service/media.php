<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Media extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Basic_profile');
        $this->load->library('ion_auth');
        $this->load->library('org/utility/Utils');
		$this->load->library('org/application/blog_app_library');
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
    
    /*
     * This method will upload blog picture and also create the blog
     * @Author Nazmul on 3rd November 2014
     */
    public function create_blog_with_picture()
    {
        $response = array();
		$result = array();
        $user_id = $this->input->post('user_id');
        if (isset($_FILES["userfile"])) {
            $file_info = $_FILES["userfile"];
            $result = $this->utils->upload_image($file_info, BLOG_POST_IMAGE_PATH);
            $image_name = $result['upload_data']['file_name'];
            $resized_image_name = $user_id.'_'.$this->utils->generateRandomString().'.jpg';
            $this->utils->resize_image(BLOG_POST_IMAGE_PATH.$image_name, BLOG_POST_IMAGE_PATH.$resized_image_name, BLOG_IMAGE_HEIGHT, BLOG_IMAGE_WIDTH);
            $result['image_name'] = $resized_image_name;
            
            $data = array(
                'user_id' => $this->input->post('user_id'),
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'picture' => $resized_image_name,
                'picture_description' => '',
                'created_on' => now(),
                'blog_status_id' => PENDING
            );
            $blog_id = $this->blog_app_library->create_blog($data);
            //based on the structure of your category id, update blog category table
            //$this->blog_app_library->blog_category_list_update($blog_category_id,$blog_id);
			$response['blog_id'] = $blog_id; 
			$response['status'] = "1";
			$response['message'] = 'Blog is created successfully';
        } 
        else
        {
            $response['status'] = "0";
            $response['message'] = 'Please select and image to upload';
        }
        echo json_encode($response); 
    }
    
    public function edit_blog()
    {
        $blog_id = $this->input->post('blog_id');
        $user_id = $this->input->post('user_id');
        $picture = $this->input->post('picture');
        $blog_info = array();
        $blog_info_array = $this->blog_app_library->get_blog_info($blog_id)->result_array();
        if(!empty($blog_info_array)) {
            $blog_info = $blog_info_array[0];
        }
        if (isset($_FILES["userfile"]))
        {
            $file_info = $_FILES["userfile"];
            $result = $this->utils->upload_image($file_info, BLOG_POST_IMAGE_PATH);
            $image_name = $result['upload_data']['file_name'];
            $resized_image_name = $user_id.'_'.$this->utils->generateRandomString().'.jpg';
            $this->utils->resize_image(BLOG_POST_IMAGE_PATH.$image_name, BLOG_POST_IMAGE_PATH.$resized_image_name, BLOG_IMAGE_HEIGHT, BLOG_IMAGE_WIDTH);
            $picture = $resized_image_name;
        }
        $data = array(
            //'blog_category_id' => $this->input->post('category_id'),
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'picture' => $picture,
            'picture_description' => $this->input->post('picture_description'),
            'user_id' => $user_id,
            'modified_on' => now()
        );
        if($blog_info['blog_status_id'] == APPROVED)
        {
            $data['blog_status_id'] = RE_APPROVAL;
            $data['reference_id'] = $blog_id;
            $new_blog_id = $this->blog_app_library->create_blog($data);
            $this->update_checked_blog_id($new_blog_id);
            if($blog_id == FALSE)
            {
                $result['status'] = false;
                $result['message'] = $this->blog_app_library->errors();
                $result['blog_info'] = $blog_info;
                echo json_encode($result);
                return;
            }
        }             
        else if($blog_info['blog_status_id'] == PENDING || $blog_info['blog_status_id'] == RE_APPROVAL)
        {
            $flag = $this->blog_app_library->update_blog($blog_id,$data);
            if($flag == FALSE)
            {
                $result['status']=FALSE;
                $result['message'] = $this->blog_app_library->errors();
            }
        }
        else if($blog_info['blog_status_id'] == DELETION_PENDING)
        {
            //implement case 4 and case 7
            $reference_blog = $this->blog_app_library->get_blog_info($blog_info['reference_id'])->result_array();
            if(!empty($reference_blog))
            {
                $reference_blog = $reference_blog[0];
            }

            if($reference_blog['blog_status_id']== PENDING)
            {
                $reference_blog['title'] = $data['title'];
                $reference_blog['description'] = $data['description'];
                $reference_blog['modified_on'] = $data['modified_on'];

                $flag = $this->blog_app_library->update_blog($reference_blog['id'],$reference_blog);
                if($flag == FALSE)
                {
                    $result['status']=FALSE;
                    $result['message'] = $this->blog_app_library->errors();
                }
            }


            $data['blog_status_id'] = RE_APPROVAL;

            $flag = $this->blog_app_library->update_blog($blog_id,$data);

            if($flag == FALSE)
            {
                $result['status']=FALSE;
                $result['message'] = $this->blog_app_library->errors();
            }   
        }
    }
    
    public function update_checked_blog_id($blog_id) {
        $blog_category_list_array_map = $this->blog_app_library->get_all_category_of_this_blog($blog_id);
        if(!empty($blog_category_list_array_map))
        {
            foreach ($blog_category_list_array_map as $key => $category_array)
            {
                // here $category_array->blog_id means category_id
                $categoryid = $category_array->blog_id;
                $this->blog_app_library->blog_category_list_update_by_remove($categoryid,$blog_id);
            }
        }

        foreach ($this->input->post('category_name') as $key => $category_id)
        {
            $this->blog_app_library->blog_category_list_update($category_id,$blog_id);
        }
    }

}
