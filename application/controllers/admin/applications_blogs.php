<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Applications_blogs extends CI_Controller{
    public $tmpl = '';
    public $user_group_array = array();
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        $this->load->library('org/admin/application/admin_blog');
        $this->load->library('org/admin/access_level/admin_access_level_library');
        $this->load->library('excel');
        $this->load->library('org/utility/utils');
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        }
        
        $this->data['allow_view'] = FALSE;
        $this->data['allow_access'] = FALSE;
        $this->data['allow_write'] = FALSE;
        $this->data['allow_approve'] = FALSE;
        $this->data['allow_edit'] = FALSE;
        $this->data['allow_delete'] = FALSE;
        $this->data['allow_configuration'] = FALSE; 
        
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
            $this->data['allow_access'] = TRUE;
            $this->data['allow_write'] = TRUE;
            $this->data['allow_approve'] = TRUE;
            $this->data['allow_edit'] = TRUE;
            $this->data['allow_delete'] = TRUE;
            $this->data['allow_configuration'] = TRUE;
        }
        else
        {
            $access_level_mapping = $this->admin_access_level_library->get_access_level_info($this->session->userdata('user_id'));
            $this->tmpl = USER_DASHBOARD_TEMPLATE;
            $this->data['access_level_mapping'] = $access_level_mapping;
            
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
            {
                $this->data['allow_view'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS, $access_level_mapping))
            {
                $this->data['allow_access'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE, $access_level_mapping))
            {
                $this->data['allow_write'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE, $access_level_mapping))
            {
                $this->data['allow_approve'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT, $access_level_mapping))
            {
                $this->data['allow_edit'] = TRUE;
            }if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE, $access_level_mapping))
            {
                $this->data['allow_delete'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_BLOGS_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION, $access_level_mapping))
            {
                $this->data['allow_configuration'] = TRUE;  
            }
            if(!$this->data['allow_view'])
            {
                redirect('admin/general/restriction_view', 'refresh');
            }
        }

    }
    function index()
    {
        $this->data['message'] = '';
        $category_list = $this->admin_blog->get_all_blog_category()->result_array();
        $custom_category_list = $this->admin_blog->get_all_custom_blog_category()->result_array();
        $this->data['custom_category_list'] = $custom_category_list;
        $this->data['category_list'] = $category_list;
        $this->template->load($this->tmpl, "admin/applications/blog_app/blog_categories", $this->data);
    }
    function blog_list($category_id)
    {
        $this->data['message'] = '';
        //$blog_list = $this->admin_blog->get_all_blogs($category_id)->result_array();
        $blog_list = $this->admin_blog->get_all_blog_by_category($category_id);
        $blog_count = count($blog_list);
        $order_list = array();
        for($counter = 1; $counter <= $blog_count; $counter++)
        {
            $order_list[$counter] = $counter;
        }
        $this->data['order_list'] = $order_list;
        $this->data['blog_list'] = $blog_list;
        $this->data['blog_count'] = $blog_count;
        $this->data['category_id'] = $category_id;
        $this->template->load($this->tmpl, "admin/applications/blog_app/blog_list", $this->data);
    }
    //Ajax call for create blog category
    //Written by Omar Faruk
    function create_blog_category()
    {
        
        $response = array();
        $blog_category_name = $_POST['blog_category_name'];

        $additional_data = array(
            'application_id' => APPLICATION_BLOG_APP_ID
        );
        $id = $this->admin_blog->create_blog_category($blog_category_name, $additional_data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Blog Category is added successfully.';
            $blog_category_info_array = $this->admin_blog->get_blog_category_info($id)->result_array();
            if(!empty($blog_category_info_array))
            {
                $response['blog_category_info'] = $blog_category_info_array[0];
            }             
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_blog->errors_alert();
        }
        echo json_encode($response);
    }
    
    public function get_blog_data()
    {
        $response = array();
        $blog_category_id = $_POST['blog_category_id'];
        
        $blog_category_array = $this->admin_blog->get_blog_category_info($blog_category_id)->result_array();
        if(!empty($blog_category_array))
        {
            $response = $blog_category_array[0];
        }
        echo json_encode($response);
    }
    
    public function get_custom_blog_data()
    {
        $response = array();
        $blog_category_id = $_POST['blog_category_id'];
        
        $blog_category_array = $this->admin_blog->get_custom_blog_category_info($blog_category_id)->result_array();
        if(!empty($blog_category_array))
        {
            $response = $blog_category_array[0];
        }
        echo json_encode($response);
    }
    
    //Ajax call for create blog category
    //Written by Omar Faruk
    function edit_blog_category()
    {
        
        $response = array();
        $blog_category_id = $_POST['blog_category_id'];
        $blog_category_name = $_POST['blog_category_name'];
        $additional_data = array(
            'title' => $blog_category_name,
            'application_id' => APPLICATION_BLOG_APP_ID
        );
        $id = $this->admin_blog->update_blog_categroy($blog_category_id, $additional_data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Blog Category is Update successfully.';
            $blog_category_info_array = $this->admin_blog->get_blog_category_info($blog_category_id)->result_array();
            if(!empty($blog_category_info_array))
            {
                $response['blog_category_info'] = $blog_category_info_array[0];
            }             
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_blog->errors_alert();
        }
        echo json_encode($response);
    }
    
    
    //Ajax call for create blog category
    //Written by Omar Faruk
    function edit_custom_blog_category()
    {
        
        $response = array();
        $blog_category_id = $_POST['blog_category_id'];
        $blog_category_name = $_POST['blog_category_name'];
        $additional_data = array(
            'title' => $blog_category_name,
            'application_id' => APPLICATION_BLOG_APP_ID
        );
        $id = $this->admin_blog->update_custom_blog_categroy($blog_category_id, $additional_data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Blog Category is Update successfully.';
            $blog_category_info_array = $this->admin_blog->get_custom_blog_category_info($blog_category_id)->result_array();
            if(!empty($blog_category_info_array))
            {
                $response['blog_category_info'] = $blog_category_info_array[0];
            }             
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_blog->errors_alert();
        }
        echo json_encode($response);
    }
    
    //Ajax call for Delete blog category
    //Written by Omar Faruk
    function delete_blog_category()
    {
        
        $response = array();
        $blog_category_id = $_POST['blog_category_id'];
        $id = $this->admin_blog->delete_blog_categroy($blog_category_id);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Blog Category is Deleted successfully.';       
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_blog->errors_alert();
        }
        echo json_encode($response);
    }
    
    public function image_upload($file_info)
    {
        $data = null;
        if (isset($file_info))
        {
            $config['image_library'] = 'gd2';
            $config['upload_path'] = BLOG_POST_IMAGE_PATH;
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
    
    function create_blog($category_id = 0)
    {
        $this->data['message'] = '';
        
        $this->form_validation->set_rules('title_editortext', 'Title', 'xss_clean|required');
        $this->form_validation->set_rules('description_editortext', 'Description', 'xss_clean|required');
        $this->form_validation->set_rules('image_description_editortext', 'Image Description', 'xss_clean|required');
        
        if($this->input->post())
        {
            if (isset($_FILES["userfile"]))
                {
                    $file_info = $_FILES["userfile"];
                    $uploaded_image_data = $this->image_upload($file_info);
                    if(isset($uploaded_image_data['error'])) {
                        $this->data['message'] = strip_tags($uploaded_image_data['error']);
                        echo json_encode($this->data);
                        return;
                    }else if(!empty($uploaded_image_data['upload_data']['file_name'])){
                        //$path = FCPATH.NEWS_IMAGE_PATH.$uploaded_image_data['upload_data']['file_name'];
                        //unlink($path);
                    }
                }
                
                $related_blogs = explode(",",$this->input->post('related_blogs'));
                $blog_title = trim(htmlentities($this->input->post('title_editortext')));
                $description = trim(htmlentities($this->input->post('description_editortext')));
                $picture_description = trim(htmlentities($this->utils->add_blank_target_in_anchor(html_entity_decode($this->input->post('image_description_editortext')))));
                
                $data = array(
                    'title' => $blog_title,
                    'description' => $description,
                    'user_id' => $this->session->userdata('user_id'),
                    'blog_status_id' => APPROVED,
                    'related_posts' => json_encode($related_blogs),
                    'picture' => empty($uploaded_image_data['upload_data']['file_name'])? '' : $uploaded_image_data['upload_data']['file_name'],
                    'picture_description' => $picture_description,
                    'created_on' => now()
                );
                
                $blog_id = $this->admin_blog->create_blog($data);
                $this->update_checked_blog_id($blog_id);
                foreach ($this->input->post('category_name') as $key => $category_id)
                {
                    $this->admin_blog->blog_category_list_update($category_id,$blog_id);
                }
                if($blog_id !== FALSE){
                    $this->data['message'] = "Blog create is successful";
                    echo json_encode($this->data);
                    return;
                }else{
                    $this->data['message'] = $this->admin_blog->errors();
                    echo json_encode($this->data);
                    return;
                }
        }
        
        $category_list = $this->admin_blog->get_all_blog_category()->result_array();
        $this->data['category_list'] = $category_list;
        
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'value' => $this->form_validation->set_value('title'),
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('description'),
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['image_description'] = array(
            'name' => 'image_description',
            'id' => 'image_description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('image_description'),
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['related_blogs'] = array(
            'name' => 'related_blogs',
            'id' => 'related_blogs',
            'type' => 'text',
            'value' => ''
        );
        
        $this->data['all_blog_lists'] = $this->admin_blog->get_all_blogs()->result_array();
        $selected_blog_data_array = array();
        $this->data['selected_blog_data_array'] = $selected_blog_data_array;
        
        $this->data['blog_category_id'] = $category_id;
        $this->template->load($this->tmpl, "admin/applications/blog_app/create_blog", $this->data);
    }
    
    public function edit_blog($blog_id)
    {
        $this->data['message'] = '';
        if(empty($blog_id)){
            redirect('admin/applications_blogs/approve_blog', 'refresh');
        }
        
        $this->form_validation->set_rules('title_editortext', 'Title', 'xss_clean|required');
        $this->form_validation->set_rules('description_editortext', 'Description', 'xss_clean|required');
        
        $blog_info_array = $this->admin_blog->get_blog_info($blog_id)->result_array();
        if(count($blog_info_array>0)) {
            $blog_info_array = $blog_info_array[0];
        }
        $this->data['blog_info'] = $blog_info_array;
        $selected_blog_data_array = array();
        $selected_blog_data_array = json_decode($blog_info_array['related_posts']); 
        $this->data['selected_blog_data_array'] = $selected_blog_data_array;
        
        if($this->input->post())
        {
            if (isset($_FILES["userfile"]))
                {
                    $file_info = $_FILES["userfile"];
                    $uploaded_image_data = $this->image_upload($file_info);
                    if(isset($uploaded_image_data['error'])) {
                        $this->data['message'] = strip_tags($uploaded_image_data['error']);
                        echo json_encode($this->data);
                        return;
                    }else if(!empty($uploaded_image_data['upload_data']['file_name'])){
                        //$path = FCPATH.NEWS_IMAGE_PATH.$uploaded_image_data['upload_data']['file_name'];
                        //unlink($path);
                    }
                }
                
                $related_blogs = explode(",",$this->input->post('related_blogs'));
                $blog_title = trim(htmlentities($this->input->post('title_editortext')));
                $description = trim(htmlentities($this->input->post('description_editortext')));
                $picture_description = trim(htmlentities($this->utils->add_blank_target_in_anchor(html_entity_decode($this->input->post('image_description_editortext')))));
                
                $data = array(
                    'title' => $blog_title,
                    'description' => $description,
                    'picture_description' => $picture_description,
                    'related_posts' => json_encode($related_blogs),
                    'modified_on' => now()
                );

                if(!empty($uploaded_image_data) && ($uploaded_image_data['upload_data']['file_name'] != null)) {
                    $data['picture'] = $uploaded_image_data['upload_data']['file_name'];
                }
                /*if(!empty($uploaded_image_data) && ($uploaded_image_data['upload_data']['file_name'] != null)) {
                    $path = FCPATH.BLOG_POST_IMAGE_PATH.$blog_info_array['picture'];
                    unlink($path);
                    $data['picture'] = $uploaded_image_data['upload_data']['file_name'];
                }*/
                
                $this->update_checked_blog_id($blog_id);
                foreach ($this->input->post('category_name') as $key => $category_id)
                {
                    $this->admin_blog->blog_category_list_update($category_id,$blog_id);
                }
                $blog_id_new = $this->admin_blog->update_blog($blog_info_array['id'],$data);
                if($blog_id_new !== FALSE){
                    $this->data['message'] = "Blog updated is successful";
                    echo json_encode($this->data);
                    return;
                }else{
                    $this->data['message'] = $this->admin_blog->errors();
                    echo json_encode($this->data);
                    return;
                }
        }
        
        $populated_blog_category_array = array();
        $category_list = $this->admin_blog->get_all_blog_category()->result_array();
        $blog_category_list_array_map = $this->admin_blog->get_all_category_of_this_blog($blog_id);
        
        /*if(!empty($category_list)){
            foreach ($category_list as $key => $category) {
                $flag = 0;
                if(!empty($blog_category_list_array_map)){
                   foreach ($blog_category_list_array_map as $key => $blog_category){
                        if($blog_category->blog_id == $category['id']) {
                            $category['checked'] = 1;
                            $populated_blog_category_array[$category['id']] = $category;
                            $flag = 1;
                        }
                    } 
                }
                if($flag == 0){
                    $category['checked'] = 0;
                    $populated_blog_category_array[$category['id']] = $category;
                }
            }
        }*/
        //$this->data['category_list'] = $populated_blog_category_array;
        
        if(!empty($category_list)){
            foreach ($category_list as $key => $category) {
                $category_list[$key]['checked'] = 0;
            }
            foreach ($category_list as $key => $category) {
                if(!empty($blog_category_list_array_map)){
                   foreach ($blog_category_list_array_map as $k => $blog_category){
                        if($blog_category->blog_id == $category['id']) {
                            $category_list[$key]['checked'] = 1;
                            $populated_blog_category_array[$category['id']] = $category;
                        }
                    } 
                }
            }
        }
        
        $this->data['category_list'] = $category_list;
        $this->data['all_blog_lists'] = $this->admin_blog->get_all_blogs()->result_array();
        
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'value' => html_entity_decode(html_entity_decode($blog_info_array['title'])),
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'value' => html_entity_decode(html_entity_decode($blog_info_array['description'])),
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['image_description'] = array(
            'name' => 'image_description',
            'id' => 'image_description',
            'type' => 'text',
            'value' => isset($blog_info_array['picture_description']) ? html_entity_decode(html_entity_decode($blog_info_array['picture_description'])) : '',
            'rows'  => '4',
            'cols'  => '10'
        );
        
        
        $this->data['related_blogs'] = array(
            'name' => 'related_blogs',
            'id' => 'related_blogs',
            'type' => 'text',
            'value' => empty($selected_blog_data_array[0]) ? '' : implode(",", $selected_blog_data_array)
        );
        
        $this->data['blog_id'] = $blog_id;
        $this->template->load($this->tmpl, "admin/applications/blog_app/edit_blog", $this->data);
    }
    
    /**
     * This function is for to remove a blod_id from blog_category table 
     * where this blog_id is present in blog_list JSON object
     * @param type $blog_id
     * @return type
     */
    public function update_checked_blog_id($blog_id) {
        $blog_category_list_array_map = $this->admin_blog->get_all_category_of_this_blog($blog_id);
        if(!empty($blog_category_list_array_map))
        {
            foreach ($blog_category_list_array_map as $key => $category_array)
            {
                // here $category_array->blog_id means category_id
                $categoryid = $category_array->blog_id;
                $this->admin_blog->blog_category_list_update_by_remove($categoryid,$blog_id);
            }
        }
        return ;
    }
    
    /**
     * In this function blog_id is removed from blog_category table's JSON object
     * and then update blog_blog_status_id to DELETED
     */
    public function remove_blog_by_admin() {
        $response = array();
        $delete_confirm = FALSE;
        $reference_id = null;
        $blog_id = $_POST['blog_id'];
        $blog = $this->admin_blog->get_blog_info($blog_id)->result_array();
        if(!empty($blog)){
            $blog = $blog[0];
            $reference_id = $blog['reference_id'];
        }
        $present_date = $this->utils->get_current_date();
        //check this requested blog id is not set in the home page today to future days
        $has_or_not = $this->admin_blog->check_blog_before_delete_confirm($blog_id,$present_date);
        if(!empty($has_or_not)) {
            $response['status'] = 0;
            $response['message'] = 'This blog is configured in following date:';
            foreach($has_or_not as $date)
            {
                $response['message'] = $response['message'].' '.$date;
            }
            $response['status'] = 0;
        } else {
            $delete_confirm = $this->remove_blog_by_id($blog_id);
        }
        
        if($delete_confirm !== FALSE)
        {
            //update the old blog blog_status_id to modified
            $old_blog_data = array(
                'blog_status_id' => DELETED,
                'modified_on' => now()
            );
            $this->admin_blog->update_blog($blog_id,$old_blog_data);
            $response['status'] = 1;
            $response['message'] = 'Blog is removed successfully.';          
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $response['message'];
        }
        echo json_encode($response);
    }
    
    public function remove_blog_by_id($blog_id) {
        $blog_info = array();
        if($blog_id != '' && $blog_id != NULL)
        {
            $blog_info_array = $this->admin_blog->get_blog_info($blog_id)->result_array();
            if(!empty($blog_info_array)) {
                $blog_info = $blog_info_array[0];
                $blog_category_list_array_map = $this->admin_blog->get_all_category_of_this_blog($blog_id);
                if(!empty($blog_category_list_array_map))
                {
                    foreach ($blog_category_list_array_map as $key => $category_array)
                    {
                        // here $category_array->blog_id means category_id
                        $categoryid = $category_array->blog_id;
                        $this->admin_blog->blog_category_list_update_by_remove($categoryid,$blog_id);
                    }
                    return TRUE;
                }
            }
        }
        return FALSE;
        
    }
    
    public function update_blog_by_approval($blog_id)
    {
        $data = array(
            'blog_status_id' => APPROVED
        );
        $state = $this->admin_blog->update_blog($blog_id,$data);
        if($state==False)
        {
            $this->data['message'] = 'Update is not successful';
        }
        
        $this->approve_blog();
        
    }
    
    function blog_detail($blog_id)
    {
        $this->data['message'] = '';

        $blog_array = $this->admin_blog->get_blog_info($blog_id)->result_array();
        
        $blog = array();
        $related_blogs = array();
        $related_blogs_id = null;
        if (count($blog_array) > 0) {
            $blog = $blog_array[0];
            if (!empty($blog['related_posts'])) {
                $related_blogs_id = json_decode($blog['related_posts']);
                $related_blogs = $this->admin_blog->get_relate_blog_list($related_blogs_id)->result_array();
            }
        }

        $this->data['related_blogs'] = $related_blogs;

        $comments = $this->admin_blog->get_all_comments($blog_id, NEWEST_FIRST)->result_array();
        $total_comments = count($comments);
        $temp_array = array();
        $i=0;
        foreach($comments as $comment)
        {
            $i++;
            $temp_array[] = $comment;
        
            if($i==DEFAULT_VIEW_PER_PAGE) break;
        }
        $comments = $temp_array;
        $this->data['blog'] = $blog;
        $this->data['comments'] = $comments;
        $this->data['user_info'] = $this->ion_auth->get_user_info($blog['user_id']);
        $this->data['application_id'] = APPLICATION_BLOG_APP_ID;
        $this->data['item_id'] = $blog['blog_id'];
        $this->data['total_comments'] = $total_comments;
        $this->template->load($this->tmpl, "admin/applications/blog_app/blog_detail", $this->data);
    }
    
    function blog_detail_pending($blog_id)
    {
        $this->data['message'] = '';
        $blog_detail = $this->admin_blog->get_blog_info($blog_id)->result_array();
        if(!empty($blog_detail)){
            $blog_detail = $blog_detail[0];
        }
        
        $this->data['blog_detail']=$blog_detail;
        $this->data['selected_category_id']=$blog_detail['blog_category_id'];
        $category_list = $this->admin_blog->get_all_blog_category()->result_array();
        $this->data['category_id'] = array();
        if (!empty($category_list)) {
            foreach ($category_list as $category) {
                $this->data['category_id'][$category['id']] = $category['title'];
            }
        }
        
        $this->data['blog_id'] = $blog_id;
        $this->template->load($this->tmpl, "admin/applications/blog_app/blog_detail_pending", $this->data);
    }
    
    function comment_list($blog_id)
    {
        
        $comment_list = $this->admin_blog->get_all_blog_comments($blog_id)->result_array();
        for($i=0;$i<count($comment_list);$i++)
        {
            $comment_list[$i]['user_liked_list'] = json_decode($comment_list[$i]['user_liked_list']);
            $comment_list[$i]['user_liked_list'] = count($comment_list[$i]['user_liked_list']);
        }
        
        $this->data['comment_list'] = $comment_list;
        $this->data['blog_id'] = $blog_id;
        $this->template->load($this->tmpl, "admin/applications/blog_app/comment_list", $this->data);
    }
    
    function remove_comment()
    {
        $comment_id = $this->input->post('comment_id');
        $id = $this->admin_blog->remove_blog_comment($comment_id);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Comment is removed successfully.';          
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_blog->errors_alert();
        }
        echo json_encode($response);
    }
    
    function config_blog()
    {
        $this->data['message'] = '';
        /*$all_blogs = $this->admin_blog->get_configed_blog_for_home_page();
        //echo '<pre/>';print_r($all_blogs);exit('here');
        $this->data['all_blogs'] = $all_blogs;
        $this->data['show_advertise'] = $all_blogs['show_advertise'];
        $blog_list = $this->admin_blog->get_all_blogs()->result_array();
        $this->data['blog_list'] = $blog_list;*/
        
        $this->data = array_merge($this->data, $this->admin_blog->get_home_page_blog_configuration());
        //echo '<pre/>';print_r($this->data);exit('here');
        //$result = $this->admin_blog->get_home_page_blog_configuration();
        //echo '<pre/>';print_r($result['blog_id_blog_info_map']);exit('here');
        $this->template->load($this->tmpl, "admin/applications/blog_app/config_blog", $this->data);
    }
    
    public function blog_list_for_home_page()
    {
        $response = array();
        $blog_item_id = $this->input->post('selected_blog_array_list');
        $selected_date_to_show_blog = $this->input->post('selected_date_for_item');
        
        $data = array(
                'blog_list' => $blog_item_id,
                'selected_date' => $selected_date_to_show_blog,
                'created_on' => now()
            );
       
        $id = $this->admin_blog->create_blog_for_homepage($data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Blogs list is added successfully.';        
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_blog->errors_alert();
        }
        echo json_encode($response);
    }
    
    
    public function page_import_blogs()
    {
        $success_counter = 0;
        $result_array = array();
        $this->data['message'] = '';
        if($this->input->post('button_submit'))
        {
            $config['upload_path'] = './././resources/import/applications/blogs/';
            $config['allowed_types'] = 'xlsx';
            $config['file_name'] = 'blogs.xlsx';
            $config['overwrite'] = TRUE;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload())
            {
                $this->data['message'] = $this->upload->display_errors();
            }
            else
            {
                $file = 'resources/import/applications/blogs/blogs.xlsx';

                //read file from path
                $objPHPExcel = PHPExcel_IOFactory::load($file);

                //get only the Cell Collection
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

                //extract to a PHP readable array format
                $header = array();
                $arr_data = array();
                //task_tanvir validate each row before extracting information
                foreach ($cell_collection as $cell) {
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();

                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();

                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();

                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                        $header[$row][$column] = $data_value;
                    } else {
                        $arr_data[$row][$column] = $data_value;
                    }
                }
                $header_len = sizeof($header[1]);
                //send the data in an array format
                $data['header'] = $header;
                $data['values'] = $arr_data;
                $i = 0;
                
                /*foreach ($arr_data as $result_data) 
                {
//                    if(sizeof($result_data)!= 4) continue; //the 4 here should be number of column in xlsx file
                    $data = array(

                    );
                    //task_redwan
                    $this->admin_blog_model->add_imported_blog_info($data);
                }*/
                
                $header_len = sizeof($header[1]);
                foreach ($arr_data as $result_data)
                {
                    $i++;
                    
                    $flag = FALSE;
                    foreach($header[1] as $key=>$row)
                    {
                        if(!array_key_exists($key, $result_data))
                        {
                            $result_array[$i] = 'row no ' . $i . ' contains empty field';
                        
                            $flag = TRUE;
                            break;
                        }
                    }
                    
                    if($flag) continue;
                    
                    if(sizeof($result_data)!= $header_len || array_key_exists('A', $result_data) || array_key_exists('B', $result_data) || array_key_exists('C', $result_data))
                    {
                        $result_array[$i] = 'row no ' . $i . ' contains invalid data';
                        continue;
                    }
                    $additional_data = array(
                        'blog_category_name' => strip_tags($result_data['A']),
                        'title' => strip_tags($result_data['B']),
                        'description' => strip_tags($result_data['C']),
                        'user_id' => $this->session->userdata('user_id'),
                        'blog_status_id' => APPROVED,
                        'created_on' => now()
                    );

                    $flag = $this->admin_blog->add_imported_blog_info($additional_data);
                    
                    if($flag!=FALSE)
                    {
                        $success_counter++;
                    }
                    else
                    {
                        $result_array[$i] = 'Row no '.$i.' is not inserted';
                    }
                }
            }
            
            $message = $success_counter.' rows are inserted '.'<br>';
            if(!empty($result_array)) $message = $message.'';
            foreach($result_array as $result)
            {
                $message = $message.' '.$result.'<br>';
            }
            $this->data['message'] = $message;
            
            
        }
        $this->template->load($this->tmpl, "admin/applications/blog_app/import_blogs_view", $this->data);
    }
    
    
    public function import_blogs()
    {
        $lines = file('resources/import/applications/blogs/blogs.txt');
        $i = 0;
        $result_array = array();
        
        foreach ($lines as $line) 
        {            
            $splited_content = explode("~", $line);
            $i++;
            //echo '<pre/>';print_r($splited_content);exit;
            $blog_category_name = $splited_content[0];
            $blog_category_info_array = $this->admin_blog->get_blog_category_info_by_name($blog_category_name)->result_array();
            //echo '<pre/>';print_r($blog_category_info_array);exit('here');
            if(!empty($blog_category_info_array))
            {
                $blog_category_info_array = $blog_category_info_array[0];
            } 
            else
            {
                $id = $this->admin_blog->create_blog_category($blog_category_name, $additional_data = array());
                if($id !== FALSE)
                {
                    $blog_category_info_array = $this->admin_blog->get_blog_category_info($id)->result_array();
                    if(!empty($blog_category_info_array))
                    {
                        $blog_category_info_array = $blog_category_info_array[0];
                    }             
                }
            }
            
            $additional_data = array(
                'blog_category_id' => $blog_category_info_array['id'],
                'title' => $splited_content[1],
                'description' => $splited_content[2],
                'picture' => $splited_content[3],
                'user_id' => $this->session->userdata('user_id'),
                'blog_status_id' => APPROVED,
                'created_on' => now()
            );
            $flag = $this->admin_blog->create_blog($additional_data);
            if($flag !== FALSE) {
                $result_array[$i] = 'row no '.$i.' inserted sucessfully';
            } else {
                $result_array[$i] = 'row no '.$i.' can not insert';
            }
        }
        echo '<pre/>';print_r($result_array); exit();
    }
    
    public function remove_blog($blog_id)
    {
        $state = $this->admin_blog->remove_blog($blog_id);
        
        $this->approve_blog();
    }

    public function approve_blog()
    {
        $this->data['message'] = '';
        $blog_status_list = array(PENDING,RE_APPROVAL,DELETION_PENDING);
        $pending_list = $this->admin_blog->get_all_pending_blogs($blog_status_list)->result_array();
        $this->data['pending_list'] = $pending_list;
        $this->template->load($this->tmpl, "admin/applications/blog_app/approve_blog", $this->data);
    }
    
    public function get_selected_blog_data()
    {
        $response = array();
        $blog_id = $this->input->post('blog_id');
        
        $blog_array = $this->admin_blog->get_blog_info($blog_id)->result_array();
        if(!empty($blog_array))
        {
            $response = $blog_array[0];
        }
        
        echo json_encode($response);
    }
    
    public function save_selected_blog()
    {
        $response = array();
        $region_id_blog_id_map = $_POST['region_id_blog_id_map'];
        $selected_date = $_POST['selected_date'];
        $show_advertise = $_POST['show_advertise'];
        $last_inserted_id = $this->admin_blog->add_home_page_blog_configuration($region_id_blog_id_map, $selected_date, $show_advertise);
        
        if($last_inserted_id !== FALSE) {
           $response['status'] = 1;
           $response['message'] = 'Blogs list is configured successfully.';
        } else {
            $response['status'] = 0;
            $response['message'] = $this->admin_blog->errors_alert();
        }
        
        
        /*$positon_array = array(
                    $this->input->post('position_of_blog_0'),
                    $this->input->post('position_of_blog_1'),
                    $this->input->post('position_of_blog_2'),
                    $this->input->post('position_of_blog_3'),
                    $this->input->post('position_of_blog_4'),
                    $this->input->post('position_of_blog_5'),
                    $this->input->post('position_of_blog_6'),
                    $this->input->post('position_of_blog_7')
                );
        $selected_date_to_show_blog = $this->input->post('selected_date');
        $show_advertise = $this->input->post('show_advertise');
        
        if($show_advertise==2){
            $show_advertise = 1;
        }else{
            $show_advertise = 0;
        }
        $data = array(
                'blog_list' => json_encode($positon_array),
                'selected_date' => $selected_date_to_show_blog,
                'created_on' => now(),
                'show_advertise_home_page' => $show_advertise
            );
        
        $id = $this->admin_blog->create_blog_for_homepage($data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Blogs list is added successfully.';        
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_blog->errors_alert();
        }*/
        echo json_encode($response);
    }
    
    public function update_pending_blog()
    {
        $category_id = $this->input->post('category_id');
        $blog_id = $this->input->post('blog_id');
        
        $data=array(
            'blog_category_id' => $category_id,
            'modified_on' => now()
        );
        
        $this->admin_blog->update_blog($blog_id,$data);
        
        echo json_encode($category_id);
    }
    
    function view_blog_post($blog_id)
    {
        $this->data['message'] = '';
        $blog_array = $this->admin_blog->get_blog_info($blog_id)->result_array();
        $blog = array();
        if (count($blog_array) > 0) {
            $blog = $blog_array[0];
        }

        $comments = $this->admin_blog->get_all_comments($blog_id, NEWEST_FIRST);
        $total_comments = count($comments);
        $temp_array = array();
        $i=0;
        foreach($comments as $comment)
        {
            $i++;
            $temp_array[] = $comment;
        
            if($i==DEFAULT_VIEW_PER_PAGE) break;
        }
        $comments = $temp_array;
        $this->data['blog'] = $blog;
        $this->data['user_info'] = $this->ion_auth->get_user_info();
        $this->data['application_id'] = APPLICATION_BLOG_APP_ID;
        $this->data['item_id'] = $blog['id'];
        $this->data['total_comments'] = $total_comments;
        $this->template->load($this->tmpl, "admin/applications/blog_app/blog_admin_post_view", $this->data);
    }
    function update_blog()
    {
        //$order_no = $this->input->post('order_no');
        //$blog_id = $this->input->post('blog_id');
        $selected_value_list = $this->input->post('selected_value_list'); 
        $blog_list = array();
        foreach ($selected_value_list as $value){
            if($value['order']==0)
            {
                $value['order'] = $value['created_on'];
            }

            $data = array(
                'id' => $value['id'],
                'order_no' => $value['order'],
                'modified_on' => now(),
            );
            
            $blog_list[] = $data;
        }
        
        $id = $this->admin_blog->update_blog_list($blog_list);

        if ($id != False) {
            $response['status'] = 1;
            $response['message'] = 'Blog update successful';
        } else {
            $response['status'] = 1;
            $response['message'] = 'Blog update unsuccessful';
        }

        echo json_encode($response);
    }
    
    public function blog_confirmation()
    {
        $blog_id = $_POST['blog_id'];
        $blog = $this->admin_blog->get_blog_info($blog_id)->result_array();
        
        if(!empty($blog))
        {
            $blog = $blog[0];
        }
        
        if($blog['blog_status_id']==PENDING)
        {
            $blog['blog_status_id'] = APPROVED;
            $flag = $this->admin_blog->update_blog($blog_id,$blog);
        }
        else if($blog['blog_status_id']==RE_APPROVAL)
        {
            $reference_id = $blog['reference_id'];
            /*$reference_blog = $this->admin_blog->get_blog_info($reference_id)->result_array();
            if(!empty($reference_blog))
            {
                $reference_blog = $reference_blog[0];
            }*/
            //reference blog_id is removed from blog_category's blog list and add the replica_blog_id
            $this->admin_blog->remove_reference_blog_update_replica($reference_id,$blog_id);
             //update the new blog blog_status_id to APPROVED
            $new_blog_data = array(
                'blog_status_id' => APPROVED,
                'modified_on' => now()
            );
            $flag = $this->admin_blog->update_blog($blog_id,$new_blog_data);
            
            //update the old blog blog_status_id to modified
            $old_blog_data = array(
                'blog_status_id' => MODIFIED,
                'modified_on' => now()
            );
            $flag = $this->admin_blog->update_blog($reference_id,$old_blog_data);
        }
        else if($blog['blog_status_id']==DELETION_PENDING)
        {
            $flag = FALSE;
            $response = array();
            $reference_id = $blog['reference_id'];
            $present_date = $this->utils->get_current_date();
            //check this requested blog id is not set in the home page today to future days
            $has_or_not = $this->admin_blog->check_blog_before_delete_confirm($reference_id,$present_date);
            
            if(!empty($has_or_not)) {
                //$all_blogs = $this->admin_blog->get_blog_list_without_one($reference_id)->result_array();
                $response['status'] = 0;
                $response['message'] = 'This blog is configured in following date:';
                foreach($has_or_not as $date)
                {
                    $response['message'] = $response['message'].' '.$date;
                }
                echo json_encode($response);
                return;
            } else {
                
                $delete_confirm = $this->remove_blog_by_id($reference_id);
                $data = array(
                    'blog_status_id' => DELETED,
                    'modified_on' => now()
                );
                $this->admin_blog->update_blog($reference_id,$data);
                $flag = $this->admin_blog->remove_blog($blog_id);
            }
             
        }
        
        if($flag!=FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Confirmation request successful';
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = 'This id can not be deleted because this blog is set in configuration';
        }
        echo json_encode($response);
    }
    
    public function get_blog_by_status_id()
    {
        $status_id = $_POST['status_id'];
        $status_id_list = array();
        if($status_id==1)
        {
            $status_id_list = array(PENDING,RE_APPROVAL,DELETION_PENDING);
        }
        else if($status_id==2)
        {
            $status_id_list = array(PENDING);
        }
        else if($status_id==3)
        {
            $status_id_list = array(RE_APPROVAL);
        }
        else if($status_id==4)
        {
            $status_id_list = array(DELETION_PENDING);
        }
        
        $blog_list = $this->admin_blog->get_all_pending_blogs($status_id_list)->result_array();
        $response = array();
        $response['message'] = 'Successful';
        $data = array();
        foreach($blog_list as $blog)
        {
            $blog['title'] = strip_tags(html_entity_decode(html_entity_decode($blog['title'])));
            $data[] = $blog;
        }
        
        $blog_list = $data;
        
        $response['blog_list'] = $blog_list;
        echo json_encode($response);
    }
    
    public function blog_confirmation_for_delete()
    {
        $blog_id = $_POST['blog_id'];
        $blog = $this->admin_blog->get_blog_info($blog_id)->result_array();
        
        if(!empty($blog))
        {
            $blog = $blog[0];
        }
        
        $reference_id = $blog['reference_id'];
        $data = array(
            'blog_status_id' => DELETED,
            'modified_on' => now()
        );
        $reference_id = $this->admin_blog->update_blog($reference_id,$data);
        $flag = $this->admin_blog->remove_blog($blog_id);
        $present_date = $this->utils->get_current_date();
        $configed_date = $this->admin_blog->check_blog_before_delete_confirm($reference_id,$present_date);
        
        $state = $this->admin_blog->remove_homepage_configeration($configed_date);
        
        $response = array();
        
        if($flag!=FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Confirmation request successful';
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = 'This id can not be deleted because this blog is set in configuration';
        }
        
        echo json_encode($response);
        
    }
}
?>
