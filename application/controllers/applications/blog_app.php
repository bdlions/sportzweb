<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog_app extends Role_Controller {

    function __construct() {
        parent::__construct();
        $this->lang->load('auth');

        $this->load->helper('language');
        $this->load->helper('url');
        $this->load->library('org/utility/Utils');
        $this->load->library('org/application/blog_app_library');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        
        $this->load->library('visitors');
        $this->data['blog_category_menu'] = $this->get_all_menu_item();
        $this->data['custom_blog_category_menu'] = $this->get_all_custom_blog_category();
        //echo '<pre/>';print_r($this->data['custom_blog_category_menu']);exit('here');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }

    /*
     * Writen by Tanveer
     */

    function index() {
        $this->data = array_merge($this->data, $this->blog_app_library->get_home_page_blog_configuration());
        //echo '<pre/>';print_r($this->data);exit('dfd');
        $this->data['show_advertise'] = $this->data['show_advertise'];
        
        /*$all_blogs = $this->blog_app_library->get_configed_blog_for_home_page();
        echo '<pre/>';print_r($all_blogs);exit('here');
        $this->data['all_blogs'] = $all_blogs;
        $this->data['show_advertise'] = $all_blogs['show_advertise'];
        $blog_arr_length = count($all_blogs) - 1;*/
        foreach ($this->data['blog_id_blog_info_map'] as $key => $blog_id) {
           $this->data['blog_id_blog_info_map'][$key]['counted_comment'] = count($this->blog_app_library->get_all_comments($key));
        }
        //echo '<pre/>';print_r($this->data);exit('dfd');
        
        $this->data['have_my_blogs'] = 0;
        $user_blog_list = $this->blog_app_library->get_all_blogs_by_user();
        if(!empty($user_blog_list))
        {
            $this->data['have_my_blogs'] = 1;
        }

        $visit_success = $this->visitors->store_application_visitor(APPLICATION_BLOG_APP_ID);
        $this->template->load(null, "applications/blog_app/blog_app_home_view", $this->data);
    }

    function blog_category($category_id = 0) {
        $this->data['category_id'] = $category_id;
        /*$catagory_info = $this->blog_app_library->get_blog_category_info($category_id)->result_array();
        if (count($catagory_info) > 0) {
            $catagory_info = $catagory_info[0];
        }
        $all_blogs_by_category = $this->blog_app_library->get_all_blogs($category_id)->result_array();
        */
        
        $all_blogs_by_category = $this->blog_app_library->get_all_blog_by_category($category_id);
        //echo '<pre/>';print_r($all_blogs_by_category);exit('c here');
        
        $blog_arr_length = count($all_blogs_by_category);
        if($blog_arr_length>0){
           for ($i = 0; $i < $blog_arr_length; $i++) {
                $all_blogs_by_category[$i]['counted_comment'] = count($this->blog_app_library->get_all_comments($all_blogs_by_category[$i]['id']));
            } 
        }
        //echo '<pre/>';print_r($all_blogs_by_category);
        $blog_col_1 = array();
        $blog_col_2 = array();
        $blog_col_3 = array();
        
//        var_dump($all_blogs_by_category);
        
//        echo '<pre>';        print_r($all_blogs_by_category); echo '</pre>';
//        echo '<pre>';        print_r($all_blogs_by_category[7]); echo '</pre>';
        
//        $all_blogs_sort_order = array();
//        $only_blogs = array();
//        for($i=0;$i<$blog_arr_length;$i++)
//        {
//            $only_blogs[$i]=$all_blogs_by_category[$i];
//        }
//        for($i=0;$i<$blog_arr_length;$i++)
//        {
//            $all_blogs_sort_order[$i]=$only_blogs[$i]['order_no'];
//        }
//        
//        echo '<pre>Order: ';        print_r($all_blogs_sort_order); echo '</pre>';
//        array_multisort($only_blogs, $all_blogs_sort_order);
//        echo '<pre>All blogs: ';        print_r($all_blogs_by_category); echo '</pre>';
//        echo '<pre>Only blogs: ';        print_r($only_blogs); echo '</pre>';
//        
        
//        if ($all_blogs_by_category['show_advertise']){
//            //3
//            $j = 0;
//            for($i=0; $i<$blog_arr_length; $i++) {
//                $blog_col_1[$i] = $all_blogs_by_category[$j];
//                $j+=3;
//                if($j>=$blog_arr_length) break;
//            }
//            $j = 1;
//            for($i=0; $i<$blog_arr_length; $i++) {
//                $blog_col_2[$i] = $all_blogs_by_category[$j];
//                $j+=3;
//                if($j>=$blog_arr_length) break;
//            }
//            $j = 2;
//            for($i=0; $i<$blog_arr_length; $i++) {
//                $blog_col_3[$i] = $all_blogs_by_category[$j];
//                $j+=3;
//                if($j>=$blog_arr_length) break;
//            }
//            $this->data['blog_col_1'] = $blog_col_1;
//            $this->data['blog_col_2'] = $blog_col_2;
//            $this->data['blog_col_3'] = $blog_col_3;
//        }
//        else{
//            $j = 0;
//            for($i=0; $i<$blog_arr_length; $i++) {
//                $blog_col_1[$i] = $all_blogs_by_category[$j];
//                $j+=4;
//                if($j>=$blog_arr_length) break;
//            }
//            $j = 1;            
//            for($i=0; $i<$blog_arr_length; $i++) {
//                $blog_col_2[$i] = $all_blogs_by_category[$j];
//                $j+=4;
//                if($j>=$blog_arr_length) break;
//            }
//            $j = 2;
//            for($i=0; $i<$blog_arr_length; $i++) {
//                $blog_col_3[$i] = $all_blogs_by_category[$j];
//                $j+=4;
//                if($j>=$blog_arr_length) break;
//            }
//            $j = 3;
//            for($i=0; $i<$blog_arr_length; $i++) {
//                $blog_col_4[$i] = $all_blogs_by_category[$j];
//                $j+=4;
//                if($j>=$blog_arr_length) break;
//            }
//            $this->data['blog_col_1'] = $blog_col_1;
//            $this->data['blog_col_2'] = $blog_col_2;
//            $this->data['blog_col_3'] = $blog_col_3;
//            $this->data['blog_col_4'] = $blog_col_4;
//        }
        
        //3
        $j = 0;
        for ($i = 0; $i < $blog_arr_length; $i++) {
            if(array_key_exists($j, $all_blogs_by_category)){
            $blog_col_1[$i] = $all_blogs_by_category[$j];
            $j+=3;}
            if ($j >= $blog_arr_length)
                break;
        }
        $j = 1;
        for ($i = 0; $i < $blog_arr_length; $i++) {
            if(array_key_exists($j, $all_blogs_by_category)){
            $blog_col_2[$i] = $all_blogs_by_category[$j];
            $j+=3;}
            if ($j >= $blog_arr_length)
                break;
        }
        $j = 2;
        for ($i = 0; $i < $blog_arr_length; $i++) {
            if(array_key_exists($j, $all_blogs_by_category)){
            $blog_col_3[$i] = $all_blogs_by_category[$j];
            $j+=3;}
            if ($j >= $blog_arr_length)
                break;
        }
        
        //echo '<pre/>';print_r($blog_col_1);exit('this is here fdf');
        
        $this->data['blog_col_1'] = $blog_col_1;
        $this->data['blog_col_2'] = $blog_col_2;
        $this->data['blog_col_3'] = $blog_col_3;
        
        $this->data['have_my_blogs'] = 0;
        $user_blog_list = $this->blog_app_library->get_all_blogs_by_user();
        if(!empty($user_blog_list))
        {
            $this->data['have_my_blogs'] = 1;
        }

        //$this->data['catagory_info'] = $catagory_info;
        $this->data['all_blogs_by_category'] = $all_blogs_by_category;
        $this->template->load(null, "applications/blog_app/blog_list_by_catagory_view", $this->data);
    }

    function view_blog_post($blog_id) {
        $this->data['message'] = '';
        
        $blog_array = $this->blog_app_library->get_blog_info($blog_id)->result_array();
        if(empty($blog_array)){
            redirect('applications/blog_app', 'refresh');
        }
        
        $blog = array();
        $related_blogs = array();
        $related_blogs_id = null;
        if (count($blog_array) > 0) {
            $blog = $blog_array[0];
            if (!empty($blog['related_posts'])) {
                $related_blogs_id = json_decode($blog['related_posts']);
                $related_blogs = $this->blog_app_library->get_relate_blog_list($related_blogs_id)->result_array();
            }
        }

        $this->data['related_blogs'] = $related_blogs;

        $comments = $this->blog_app_library->get_all_comments($blog_id, NEWEST_FIRST);
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
        
        $this->data['have_my_blogs'] = 0;
        $user_blog_list = $this->blog_app_library->get_all_blogs_by_user();
        if(!empty($user_blog_list))
        {
            $this->data['have_my_blogs'] = 1;
        }

        $this->data['blog'] = $blog;
        $this->data['comments'] = $comments;
        $this->data['user_info'] = $this->ion_auth->get_user_info();
        $this->data['application_id'] = APPLICATION_BLOG_APP_ID;
        $this->data['item_id'] = $blog['blog_id'];
        $this->data['total_comments'] = $total_comments;
        $this->template->load(null, "applications/blog_app/blog_app_post_view", $this->data);
    }

    public function get_all_menu_item() {
        $result = $this->blog_app_library->get_all_blogs_for_home_page()->result_array();
        return $result;
    }
    
    public function get_all_custom_blog_category() {
        $result = $this->blog_app_library->get_all_custom_blogs_for_home_page()->result_array();
        return $result;
    }

    function post_comment() {
        $response = array();
        $comment = trim($_POST['comment']);
        $comment_nature = $_POST['comment_nature'];
        if ($comment_nature == 'Neutral') {
            $rate_id = 0;
        } else if ($comment_nature == 'Negative') {
            $rate_id = 2;
        } else {
            $rate_id = 1;
        }

        $data = array(
            'comment' => $comment,
            'rate_id' => $rate_id,
            'user_id' => $this->session->userdata('user_id'),
            'blog_id' => $_POST['blog_id'],
            'created_on' => now()
        );

        $id = $this->blog_app_library->create_comment($data);

        if ($id !== FALSE) {
            $response['status'] = 1;
            $response['message'] = 'Comments is added successfully.';
            $blog_comment_info_array = $this->blog_app_library->get_comment_info($id)->result_array();
            if (!empty($blog_comment_info_array)) {
                $response['blog_comment_info'] = $blog_comment_info_array[0];
            }
        } else {
            $response['status'] = 0;
            $response['message'] = $this->admin_blog->errors_alert();
        }

        echo json_encode($response);
    }

    function edit_comment() {
        $response = array();
        $comment_id = trim($_POST['comment_id']);
        $comment = trim($_POST['comment']);
        $comment_nature = $_POST['comment_nature'];
        if ($comment_nature == 'Neutral') {
            $rate_id = 0;
        } else if ($comment_nature == 'Negative') {
            $rate_id = 2;
        } else {
            $rate_id = 1;
        }

        $data = array(
            'comment' => $comment,
            'rate_id' => $rate_id,
            'user_id' => $this->session->userdata('user_id'),
            'blog_id' => $_POST['blog_id'],
            'modified_on' => now()
        );

        $id = $this->blog_app_library->update_comment($comment_id, $data);

        if ($id !== FALSE) {
            $response['status'] = 1;
            $response['message'] = 'Comments is updated successfully.';
            $blog_comment_info_array = $this->blog_app_library->get_comment_info($comment_id)->result_array();
            if (!empty($blog_comment_info_array)) {
                $response['blog_comment_info'] = $blog_comment_info_array[0];
            }
        } else {
            $response['status'] = 0;
            $response['message'] = $this->admin_blog->errors_alert();
        }

        echo json_encode($response);
    }

    function remove_comment() {
        $response = array();
        $comment_id = $this->input->post('comment_id');

        $id = $this->blog_app_library->remove_comment($comment_id);
        if ($id !== FALSE) {
            $response['status'] = 1;
            $response['message'] = 'Comments is removed successfully.';
        } else {
            $response['status'] = 0;
            $response['message'] = $this->admin_blog->errors_alert();
        }

        echo json_encode($response);
    }

    public function image_upload($file_info) {
        $data = null;
        if (isset($file_info)) {
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

    function create_blog_by_user($category_id = 0) {
        $this->data['message'] = '';
       
        //$this->form_validation->set_rules('category_id', 'Category_id', 'required');
        $this->form_validation->set_rules('title_editortext', 'Title', 'xss_clean|required');
        $this->form_validation->set_rules('description_editortext', 'Description', 'xss_clean|required');
        $this->form_validation->set_rules('image_description_editortext', 'Image Description', 'xss_clean|required');


        if ($this->input->post()) {
            $blog_list_array = array();
            
            //$blog_category_id = $this->input->post('blog_category_id');
            if (isset($_FILES["userfile"])) {
                $file_info = $_FILES["userfile"];
                $uploaded_image_data = $this->image_upload($file_info);
                if (isset($uploaded_image_data['error'])) {
                    $this->data['message'] = strip_tags($uploaded_image_data['error']);
                    echo json_encode($this->data);
                    return;
                } else if (!empty($uploaded_image_data['upload_data']['file_name'])) {
                    //$path = FCPATH.NEWS_IMAGE_PATH.$uploaded_image_data['upload_data']['file_name'];
                    //unlink($path);
                }
            }

            //$related_blogs = explode(",",$this->input->post('related_blogs'));
            $blog_title = trim(htmlentities($this->input->post('title_editortext')));
            $description = trim(htmlentities($this->input->post('description_editortext')));
            $picture_description = trim(htmlentities($this->input->post('image_description_editortext')));
            
            //'blog_list' => json_encode($blog_category_list_array),
            
            $data = array(
                'title' => $blog_title,
                'description' => $description,
                'user_id' => $this->session->userdata('user_id'),
                'picture' => empty($uploaded_image_data['upload_data']['file_name']) ? '' : $uploaded_image_data['upload_data']['file_name'],
                'picture_description' => $picture_description,
                'created_on' => now(),
                'blog_status_id' => PENDING
            );

            $blog_id = $this->blog_app_library->create_blog($data);
            if ($blog_id !== FALSE) {
                
                foreach ($this->input->post('category_name') as $key => $value)
                {
                    $this->blog_app_library->blog_category_list_update($value,$blog_id);

                }
                
                $this->data['message'] = "Blog is created successfully.";
                echo json_encode($this->data);
                return;
            } else {
                $this->data['message'] = $this->blog_app_library->errors();
                echo json_encode($this->data);
                return;
            }
        }

        $category_list = $this->blog_app_library->get_all_blog_category()->result_array();
        $this->data['category_list'] = $category_list;
        $this->data['category_id'] = array();
        if (!empty($category_list)) {
            foreach ($category_list as $category) {
                //$this->data['category_id'][$category['id']] = $category['title'];
                $this->data['category_id'][$category['id']] = array(
                    'name' => $category['title'],
                    'id' => $category['id'],
                    'type' => 'checkbox'
                );
            }
        }
        

        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'value' => $this->form_validation->set_value('title'),
            'rows' => '4',
            'cols' => '10'
        );

        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('description'),
            'rows' => '4',
            'cols' => '10'
        );
        
        $this->data['image_description'] = array(
            'name' => 'image_description',
            'id' => 'image_description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('image_description'),
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['have_my_blogs'] = 0;
        $user_blog_list = $this->blog_app_library->get_all_blogs_by_user();
        if(!empty($user_blog_list))
        {
            $this->data['have_my_blogs'] = 1;
        }
        
        //$this->data['all_blog_lists'] = $this->admin_blog->get_all_blogs()->result_array();
        //$selected_blog_data_array = array();
        //$this->data['selected_blog_data_array'] = $selected_blog_data_array;
        //$this->data['blog_category_id'] = $category_id;
        $this->template->load(null, "applications/blog_app/create_blog_by_user", $this->data);
    }

    function sorted_comment_list() {
        $result = array();
        $value = $_POST['value'];
        $blog_id = $_POST['blog_id'];

        $comments = $this->blog_app_library->get_all_comments($blog_id, $value)->result_array();
        $result['comment_list'] = $comments;
        echo json_encode($result);

        //exit();
    }
    
    /*
     * This method will return blog list of a user
     * @Author Nazmul on 11June 2014
     */
    function users_blog()
    {
        $this->data['message'] = '';
        $blog_list = $this->blog_app_library->get_all_blogs_by_user();
        $this->data['blog_list'] = $blog_list;        
        $this->data['have_my_blogs'] = 0;
        if(!empty($blog_list))
        {
           $this->data['have_my_blogs'] = 1; 
        } 
        
        $this->template->load(null,"applications/blog_app/my_blogs_view",  $this->data);
    }
    
    /*public function edit_blog($blog_id)
    {
        $this->data['message'] = '';
        
        $this->form_validation->set_rules('title_editortext', 'Title', 'xss_clean|required');
        $this->form_validation->set_rules('description_editortext', 'Description', 'xss_clean|required');
        
        $blog_info_array = $this->blog_app_library->get_blog_info($blog_id)->result_array();
        if(count($blog_info_array>0)) {
            $blog_info_array = $blog_info_array[0];
        }
        $this->data['blog_info'] = $blog_info_array;
        
        if($this->input->post())
        {
            $blog_category_id = $this->input->post('blog_category_id');
            
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
                
                $blog_title = trim(htmlentities($this->input->post('title_editortext')));
                $description = trim(htmlentities($this->input->post('description_editortext')));
                
                $data = array(
                    'title' => $blog_title,
                    'description' => $description,
                    'modified_on' => now()
                );
                
                if(!empty($uploaded_image_data) && ($uploaded_image_data['upload_data']['file_name'] != null)) {
                    //if(isset($blog_info_array['picture']) && !empty($blog_info_array['picture'])){
                    //    $path = FCPATH.BLOG_POST_IMAGE_PATH.$blog_info_array['picture'];
                    //    unlink($path);
                    //}
                    $data['picture'] = $uploaded_image_data['upload_data']['file_name'];
                }
                if($blog_info_array['blog_status_id']==APPROVED)
                {
                    unset($blog_info_array['id']);
                    $blog_info_array['reference_id'] = $blog_id;
                    $id = $this->blog_app_library->create_blog($blog_info_array);
                    if($id!=FALSE)
                    {
                        $blog_id = $id;
                    }
                }
                
                if($blog_info_array['blog_status_id']!=PENDING)
                {
                    $data['blog_status_id'] = RE_APPROVAL;
                }
                
                $blog_id = $this->blog_app_library->update_blog($blog_id,$data);
                if($blog_id !== FALSE){
                        $this->data['message'] = "Blog updated is successful";
                        echo json_encode($this->data);
                        return;
                }else{
                    $this->data['message'] = $this->admin_blog->errors();
                    echo json_encode($this->data);
                    return;
                }
        }
        
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
        
        //MY BLOGS show. checks if user has blog
        $this->data['have_my_blogs'] = 0;
        $have_my_blogs = $this->blog_app_library->get_all_blogs_by_user();
        $have_my_blogs = count($have_my_blogs);
        if($have_my_blogs!=0) $this->data['have_my_blogs'] = 1;
        
        $this->data['blog_id'] = $blog_id;
        $this->template->load("", "applications/blog_app/edit_blog", $this->data);
    }*/
    
    /*
     * This method will edit a blog by user and send the edit request to the admin
     * @Author Nazmul on 10th June 2014
     * @param $blog_id, blog id
     */
    public function edit_blog($blog_id=null)
    {
        $result = array();
        $this->data['message'] = '';
        if(empty($blog_id)){
            redirect('applications/blog_app', 'refresh');
        } 
        $result['status'] = true;
        $result['message'] = "A request to edit your blog has been sent";
        $user_id = $this->session->userdata('user_id');
        
        $this->form_validation->set_rules('title_editortext', 'Title', 'xss_clean|required');
        $this->form_validation->set_rules('description_editortext', 'Description', 'xss_clean|required');
        $this->form_validation->set_rules('image_description_editortext', 'Image Description', 'xss_clean|required');
        
        $blog_info = array();
        $blog_info_array = $this->blog_app_library->get_blog_info($blog_id)->result_array();
        if(!empty($blog_info_array)) {
            $blog_info = $blog_info_array[0];
        }
        if($this->input->post())
        {
            $uploaded_image_data = array();
            if (isset($_FILES["userfile"]))
            {
                $file_info = $_FILES["userfile"];
                $uploaded_image_data = $this->image_upload($file_info);
                if(isset($uploaded_image_data['error'])) {
                    $result['status'] = false;
                    $result['message'] = strip_tags($uploaded_image_data['error']);
                    $result['blog_info'] = $blog_info;
                    echo json_encode($result);
                    return;
                }
            }

            $blog_title = trim(htmlentities($this->input->post('title_editortext')));
            $description = trim(htmlentities($this->input->post('description_editortext')));
            $picture_description = trim(htmlentities($this->input->post('image_description_editortext')));
            
            //$blog_category_id = $this->input->post('blog_category_id');
            $data = array(
                //'blog_category_id' => $this->input->post('category_id'),
                'title' => $blog_title,
                'description' => $description,
                'picture' => empty($uploaded_image_data['upload_data']['file_name'])?  $blog_info['picture'] : $uploaded_image_data['upload_data']['file_name'],
                'picture_description' => $picture_description,
                'user_id' => $user_id,
                'created_on' => now(),
                'modified_on' => now()
            );
            

            /*if(!empty($uploaded_image_data) && ($uploaded_image_data['upload_data']['file_name'] != null)) {
                $data['picture'] = $uploaded_image_data['upload_data']['file_name'];
            }*/
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
            
            $edited_blog_info = array();
            $edited_blog_info_array = $this->blog_app_library->get_blog_info($blog_id)->result_array();
            if(!empty($edited_blog_info_array)) {
                $edited_blog_info = $edited_blog_info_array[0];
            }  
            $result['blog_info'] = $edited_blog_info;
            echo json_encode($result);
            return;
        }
        
        
        $populated_blog_category_array = array();
        $category_list = $this->blog_app_library->get_all_blog_category()->result_array();
        $blog_category_list_array_map = $this->blog_app_library->get_all_category_of_this_blog($blog_id);

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
        
        //$this->data['category_list'] = $populated_blog_category_array;
        $this->data['category_list'] = $category_list;
        
        /*$this->data['selected_category_id']=$blog_info['blog_category_id'];
        $category_list = $this->blog_app_library->get_all_blog_category()->result_array();
        $this->data['category_id'] = array();
        if (!empty($category_list)) {
            foreach ($category_list as $category) {
                $this->data['category_id'][$category['id']] = $category['title'];
            }
        }*/
        
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'value' => html_entity_decode(html_entity_decode($blog_info['title'])),
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'value' => html_entity_decode(html_entity_decode($blog_info['description'])),
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['image_description'] = array(
            'name' => 'image_description',
            'id' => 'image_description',
            'type' => 'text',
            'value' => html_entity_decode(html_entity_decode($blog_info['picture_description'])),
            'rows'  => '4',
            'cols'  => '10'
        );
        
        //MY BLOGS show. checks if user has blog
        $this->data['have_my_blogs'] = 0;
        $user_blog_list_array = $this->blog_app_library->get_all_blogs_by_user();
        if(!empty($user_blog_list_array))
        {
           $this->data['have_my_blogs'] = 1; 
        }        
        $this->data['blog_info'] = $blog_info;
        $this->data['blog_id'] = $blog_id;
        $this->template->load("", "applications/blog_app/edit_blog", $this->data);
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
    
    /*
     * This method will send the delete request to the admin
     * @Author Nazmul on 10th June 2014
     */
    public function request_to_remove_blog()
    {
        $response = array();
        $response['status'] = true;
        $response['message'] = "A request to delete your blog has been sent";

        $blog_id = $_POST['blog_id'];
        $blog_info = array();
        $blog_info_array = $this->blog_app_library->get_blog_info($blog_id)->result_array();
        if(!empty($blog_info_array)) {
            $blog_info = $blog_info_array[0];
        }
        if($blog_info['blog_status_id'] == PENDING || $blog_info['blog_status_id'] == APPROVED)
        {
            //implement case 2,6
            unset($blog_info['id']);
            $blog_info['blog_status_id'] = DELETION_PENDING;
            $blog_info['reference_id'] = $blog_id;
            $id = $this->blog_app_library->create_blog($blog_info);
            
            if($id == FALSE)
            {
                $response['status'] = false;
                $response['message'] = "Your request to delete the blog is unsuccessful";
            }
        }
        else if($blog_info['blog_status_id'] == RE_APPROVAL)
        {
            //implement case 9
            $blog_info['blog_status_id'] = DELETION_PENDING;
            $flag = $this->blog_app_library->update_blog($blog_id,$blog_info);
            
            if($flag == FALSE)
            {
                $response['status'] = false;
                $response['message'] = "Your request to delete the blog is unsuccessful";
            }
        }
        echo json_encode($response);
    }
    
    /*public function remove_request_for_blog()
    {
        $response = array();
        $blog_id = $_POST['blog_id'];
        $blog = $this->blog_app_library->get_blog_info($blog_id)->result_array();
        if(!empty($blog))
        {
            $blog = $blog[0];
        }
        if($blog['blog_status_id']==DELETION_PENDING && $blog['reference_id']!=NULL)
        {
            $response['status'] = 0;
            $response['message'] = 'You have already given a request to delete';
            echo json_encode($response);
            return;
        }
        
        unset($blog['id']);
        $blog['reference_id'] = $blog_id;
        $blog['blog_status_id'] = DELETION_PENDING;
        $id = $this->blog_app_library->create_blog($blog);
        
        if($id != FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Your delete request is on process';
        }else
        {
            $response['status'] = 0;
            $response['message'] = 'Your delete request is not successful';
        }
        
        echo json_encode($response);
    }*/

}

?>