<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Footer extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('org/admin/access_level/admin_access_level_library');
        $this->load->library('org/admin/footer/admin_about_us');
        $this->load->library('org/admin/footer/admin_terms_library');
        $this->load->library('org/admin/footer/admin_privacy_library');
        $this->load->library('org/utility/Utils');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();
        
        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        }
        
        $this->data['allow_view'] = FALSE;
        $this->data['allow_edit'] = FALSE;
        
        $selected_user_group = $this->session->userdata('user_type');
        if(isset($selected_user_group ) && $selected_user_group != ""){
            $this->user_group_array = array($selected_user_group);
        }
        else
        {
            $this->user_group_array = $this->ion_auth->get_current_user_types();
        } 
        if (in_array(ADMIN, $this->user_group_array)) {
            $this->tmpl = ADMIN_DASHBOARD_TEMPLATE;
            $this->data['allow_view'] = TRUE;
            $this->data['allow_edit'] = TRUE;
        }
        else
        {
            $access_level_mapping = $this->admin_access_level_library->get_access_level_info($this->session->userdata('user_id'));
            $this->tmpl = USER_DASHBOARD_TEMPLATE;
            $this->data['access_level_mapping'] = $access_level_mapping;
            
            if(array_key_exists(ADMIN_ACCESS_LEVEL_FOOTER_ABOUT_US_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
            {
                $this->data['allow_view'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_FOOTER_ABOUT_US_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT, $access_level_mapping))
            {
                $this->data['allow_edit'] = TRUE;
            }
            if(!$this->data['allow_view'])
            {
                redirect('admin/general/restriction_view', 'refresh');
            }
        }
    }
    
    public function index()
    {
        redirect('admin/footer/about_us','refresh');
    }
    
    public function about_us()
    {
        $this->data['message'] = '';
        $result = $this->admin_about_us->get_about_us_info();
        $region_id_text_map_db = $result['region_id_text_map'];
        $region_id_image_map_db = $result['region_id_image_map'];
        $region_text_map = array();
        $region_image_map = array();
        
        if(array_key_exists(ABOUT_US_IMAGE_REGION1_ID, $region_id_image_map_db))
        {
            $region_image_map[ABOUT_US_IMAGE_REGION1_ID] = $region_id_image_map_db[ABOUT_US_IMAGE_REGION1_ID];
        }
        else
        {
            $region_image_map[ABOUT_US_IMAGE_REGION1_ID] = 'social_networing.jpg';
        }
        if(array_key_exists(ABOUT_US_IMAGE_REGION2_ID, $region_id_image_map_db))
        {
            $region_image_map[ABOUT_US_IMAGE_REGION2_ID] = $region_id_image_map_db[ABOUT_US_IMAGE_REGION2_ID];
        }
        else
        {
            $region_image_map[ABOUT_US_IMAGE_REGION2_ID] = 'social_community.jpg';
        }
        if(array_key_exists(ABOUT_US_IMAGE_REGION3_ID, $region_id_image_map_db))
        {
            $region_image_map[ABOUT_US_IMAGE_REGION3_ID] = $region_id_image_map_db[ABOUT_US_IMAGE_REGION3_ID];
        }
        else
        {
            $region_image_map[ABOUT_US_IMAGE_REGION3_ID] = 'application_img.jpg';
        }
        if(array_key_exists(ABOUT_US_IMAGE_REGION4_ID, $region_id_image_map_db))
        {
            $region_image_map[ABOUT_US_IMAGE_REGION4_ID] = $region_id_image_map_db[ABOUT_US_IMAGE_REGION4_ID];
        }
        else
        {
            $region_image_map[ABOUT_US_IMAGE_REGION4_ID] = 'sportz_logo.png';
        }
        
        if(array_key_exists(NAVIGATION_HEADER_ID, $region_id_text_map_db))
        {
            $region_text_map[NAVIGATION_HEADER_ID] = $region_id_text_map_db[NAVIGATION_HEADER_ID];
        }
        else
        {
            $region_text_map[NAVIGATION_HEADER_ID] = '';
        }
        
        if(array_key_exists(VISSION_OBJECT_MISSION_ID, $region_id_text_map_db))
        {
            $region_text_map[VISSION_OBJECT_MISSION_ID] = $region_id_text_map_db[VISSION_OBJECT_MISSION_ID];
        }
        else
        {
            $region_text_map[VISSION_OBJECT_MISSION_ID] = '';
        }
        if(array_key_exists(MISSION_STATEMENT_ID, $region_id_text_map_db))
        {
            $region_text_map[MISSION_STATEMENT_ID] = $region_id_text_map_db[MISSION_STATEMENT_ID];
        }
        else
        {
            $region_text_map[MISSION_STATEMENT_ID] = '';
        }
        
        // 4 middle image
        if(array_key_exists(IMAGE1_ID, $region_id_text_map_db))
        {
            $region_text_map[IMAGE1_ID] = $region_id_text_map_db[IMAGE1_ID];
        }
        else
        {
            $region_text_map[IMAGE1_ID] = '';
        }
        
        if(array_key_exists(IMAGE2_ID, $region_id_text_map_db))
        {
            $region_text_map[IMAGE2_ID] = $region_id_text_map_db[IMAGE2_ID];
        }
        else
        {
            $region_text_map[IMAGE2_ID] = '';
        }
        
        if(array_key_exists(IMAGE3_ID, $region_id_text_map_db))
        {
            $region_text_map[IMAGE3_ID] = $region_id_text_map_db[IMAGE3_ID];
        }
        else
        {
            $region_text_map[IMAGE3_ID] = '';
        }
        
        if(array_key_exists(IMAGE4_ID, $region_id_text_map_db))
        {
            $region_text_map[IMAGE4_ID] = $region_id_text_map_db[IMAGE4_ID];
        }
        else
        {
            $region_text_map[IMAGE4_ID] = '';
        }
        
        // 4 middle heading of image
        if(array_key_exists(MIDDLE_HEADING1_ID, $region_id_text_map_db))
        {
            $region_text_map[MIDDLE_HEADING1_ID] = $region_id_text_map_db[MIDDLE_HEADING1_ID];
        }
        else
        {
            $region_text_map[MIDDLE_HEADING1_ID] = '';
        }
        
        if(array_key_exists(MIDDLE_HEADING2_ID, $region_id_text_map_db))
        {
            $region_text_map[MIDDLE_HEADING2_ID] = $region_id_text_map_db[MIDDLE_HEADING2_ID];
        }
        else
        {
            $region_text_map[MIDDLE_HEADING2_ID] = '';
        }
        
        if(array_key_exists(MIDDLE_HEADING3_ID, $region_id_text_map_db))
        {
            $region_text_map[MIDDLE_HEADING3_ID] = $region_id_text_map_db[MIDDLE_HEADING3_ID];
        }
        else
        {
            $region_text_map[MIDDLE_HEADING3_ID] = '';
        }
        
        if(array_key_exists(MIDDLE_HEADING4_ID, $region_id_text_map_db))
        {
            $region_text_map[MIDDLE_HEADING4_ID] = $region_id_text_map_db[MIDDLE_HEADING4_ID];
        }
        else
        {
            $region_text_map[MIDDLE_HEADING4_ID] = '';
        }
        
        if(array_key_exists(SOCIAL_ID, $region_id_text_map_db))
        {
            $region_text_map[SOCIAL_ID] = $region_id_text_map_db[SOCIAL_ID];
        }
        else
        {
            $region_text_map[SOCIAL_ID] = '';
        }
        
        if(array_key_exists(FEATURES_ID, $region_id_text_map_db))
        {
            $region_text_map[FEATURES_ID] = $region_id_text_map_db[FEATURES_ID];
        }
        else
        {
            $region_text_map[FEATURES_ID] = '';
        }
        
        if(array_key_exists(SECURITY_ID, $region_id_text_map_db))
        {
            $region_text_map[SECURITY_ID] = $region_id_text_map_db[SECURITY_ID];
        }
        else
        {
            $region_text_map[SECURITY_ID] = '';
        }
        
        if(array_key_exists(MOBILE_ID, $region_id_text_map_db))
        {
            $region_text_map[MOBILE_ID] = $region_id_text_map_db[MOBILE_ID];
        }
        else
        {
            $region_text_map[MOBILE_ID] = '';
        }
        
        //echo '<pre/>';print_r($region_text_map);exit();
        $this->data['region_text_map'] = $region_text_map;
        $this->data['region_image_map'] = $region_image_map;
        $this->template->load($this->tmpl, "admin/footer/about_us/index", $this->data);
    }
    
    /*
     * Ajax call to update region of about us page content
     */
    public function update_about_us()
    {
        $result = array();
        $region_id = $this->input->post('region_id');
        $text = $this->input->post('text');
        $this->admin_about_us->save_about_us_text_info($region_id, $text);
        //exit();
        echo TRUE;
    }
    
    /*
     * Ajax call to update region of about us page content
     */
    public function get_about_us_info()
    {
        $region_id = $_POST['region_id'];
        $response = array(
            'region_text' => $this->admin_about_us->get_about_us_text_info($region_id)
        );        
        echo json_encode($response);
    }
    
    public function update_image($image_region_id)
    {
        $this->data['message'] = '';
        if(!$image_region_id) {
            redirect("admin/footer/about_us", "refresh");
        }        
        //$result = $this->admin_about_us->get_about_us_info();        
        if (isset($_FILES["userfile"])) {
            $result = array();
            $file_info = $_FILES["userfile"];
            $result = $this->utils->upload_image($file_info, ABOUT_US_IMAGE_PATH);
            if($result['status'] == 1)
            {
                $path = ABOUT_US_IMAGE_PATH.$result['upload_data']['file_name'];
                $height = ABOUT_US_IMAGE_HEIGHT;
                $width = ABOUT_US_IMAGE_WIDTH;
                //if uploaded image width and height is less than max then don't resize the image
                //add the above logic
                $this->utils->resize_image($path, $path, $height, $width);
                if($this->admin_about_us->save_about_us_image_info($image_region_id, $result['upload_data']['file_name']))
                {
                    $result['message'] = 'Photo is stored successfully.';
                    $result['image_region_id'] = $image_region_id;
                    $result['upload_data'] = $result['upload_data'];
                }
                else
                {
                    $result['status'] = 0;
                    $result['message'] = 'Error while storing photo.';
                }
            }
            echo json_encode($result);
            return;
        }
        
        $this->data['image_region_id'] = $image_region_id;
        $this->data['image_info'] = '';
        $this->template->load($this->tmpl, "admin/footer/about_us/update_image", $this->data);
    }
    
    public function middle_image_change($image_id)
    {
        $this->data['message'] = '';
        if(!$image_id) {
            redirect("admin/footer/about_us", "refresh");
        }
        
        $result = $this->admin_about_us->get_about_us_info();
        //echo '<pre/>';print_r($result);exit('here');
        if($this->input->post())
        {
            if (isset($_FILES["userfile"]))
            {
                $file_info = $_FILES["userfile"];
                print_r($file_info);exit('here');
                $uploaded_image_data = $this->image_upload($file_info);
                print_r($uploaded_image_data);exit('there');
                if(isset($uploaded_image_data['error'])) {
                    $this->data['message'] = strip_tags($uploaded_image_data['error']);
                    echo json_encode($this->data);
                    return;
                }else if(!empty($uploaded_image_data['upload_data']['file_name'])){
                    //$path = FCPATH.ABOUT_US_IMAGE_PATH.$uploaded_image_data['upload_data']['file_name'];
                    //unlink($path);
                }
            }
            die('dfgfdg');   
            echo json_encode($this->data);
            return;
        }
        
        $this->data['image_info'] = '';
        $this->template->load($this->tmpl, "admin/footer/image_update_view", $this->data);
       
    }
    
    
    public function image_upload($file_info)
    {
        $data = null;
        if (isset($file_info))
        {
            $config['image_library'] = 'gd2';
            $config['upload_path'] = ABOUT_US_IMAGE_PATH;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '10240';
            $config['maintain_ratio'] = FALSE;
            $config['width'] = 120;
            $config['height'] = 120;
            $config['create_thumb'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());
                return $data = $error;
            } else {
                $upload_data = $this->upload->data();
                $data = array('upload_data' => $upload_data);
                return $data;
            }
        }
        return $data;

    }
    /*
     * This method will show terms page
     * @Author Nazmul on 25th January 2015
     */
    public function terms()
    {
        $this->data['message'] = '';
        $terms_list = array();
        $terms_list_array = $this->admin_terms_library->get_terms_info()->result_array();
        if(!empty($terms_list_array))
        {
          $terms_list= $terms_list_array; 
        }
        $this->data['terms_list'] = $terms_list;
        $this->template->load($this->tmpl, "admin/footer/terms/index", $this->data);
    }
    /*
     * This method will update terms
     * @Author Nazmul on 25th January 2015
     */
    public function update_terms()
    {
        $this->data['message'] = '';
       
        if ($this->input->post())
        {
            $result = array();
            $result['message'] = ''; 
              $data = array(
                    'description' => $this->input->post('description'),
                  );
               if ($this->admin_terms_library->update_terms_info($data)) {
                   redirect('admin/footer/terms','refresh');
                   return;
                } else {
                    redirect('admin/footer/update_terms','refresh');
                }
        }else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        
        $terms_list = array();
        $terms_list_array = $this->admin_terms_library->get_terms_info()->result_array();
        if(!empty($terms_list_array))
        {
          $terms_list = $terms_list_array[0]; 
        }
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'value' => $terms_list['description']
        );
        $this->data['submit_update_terms'] = array(
            'name' => 'submit_update_terms',
            'id' => 'submit_update_terms',
            'type' => 'submit',
            'value' => "Update"
        );

        $this->data['terms_list'] = $terms_list;
        
        $this->template->load($this->tmpl, "admin/footer/terms/update_terms", $this->data);
    }
    /*
     * This method will show privacy page
     * @Author Nazmul on 25th January 2015
     */
    public function privacy()
    {
        $this->data['message'] = '';
        $privacy_list = array();
        $privacy_list_array = $this->admin_privacy_library->get_privacy_info()->result_array();
        
        if(!empty($privacy_list_array))
        {
          $privacy_list= $privacy_list_array; 
        }
        $this->data['privacy_list'] = $privacy_list;
        $this->template->load($this->tmpl, "admin/footer/privacy/index", $this->data);
    }
    /*
     * This method will update privacy
     * @Author Nazmul on 25th January 2015
     */
    public function update_privacy()
    {
           $this->data['message'] = '';
       
        if ($this->input->post())
        {
            $result = array();
            $result['message'] = ''; 
              $data = array(
                    'description' => $this->input->post('description'),
                  );
               if ($this->admin_privacy_library->update_privacy_info($data)) {
                   redirect('admin/footer/privacy','refresh');
                   return;
                } else {
                    redirect('admin/footer/update_privacy','refresh');
                }
        }else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        
        $privacy_list = array();
        $privacy_list_array = $this->admin_privacy_library->get_privacy_info()->result_array();
        if(!empty($privacy_list_array))
        {
          $privacy_list = $privacy_list_array[0]; 
        }
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'value' => $privacy_list['description']
        );
        $this->data['submit_update_privacy'] = array(
            'name' => 'submit_update_privacy',
            'id' => 'submit_update_privacy',
            'type' => 'submit',
            'value' => "Update"
        );

        $this->data['privacy_list'] = $privacy_list;
        $this->template->load($this->tmpl, "admin/footer/privacy/update_privacy", $this->data);
    }
    
}

