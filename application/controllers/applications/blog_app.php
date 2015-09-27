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
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        $this->data['blog_category_menu'] = $this->get_all_menu_item();
        $this->data['custom_blog_category_menu'] = $this->get_all_custom_blog_category();
        $this->data['is_my_blog_exist'] = $this->blog_app_library->is_my_blog_exist($this->session->userdata['user_id']);
    }
    
    /*
     * This method will load home page of blog application
     * @author nazmul hasan
     * @created on 26th September 2015
     */

    function index() {
        $this->data = array_merge($this->data, $this->blog_app_library->get_home_page_blog_configuration());
        //$visit_success = $this->visitors->store_application_visitor(APPLICATION_BLOG_APP_ID);
        $this->template->load(null, "applications/blog_app/blog_app_home_view", $this->data);
    }
    
    /*
     * This method will display blogs under blog category
     * @param $category_id, blog category id
     * @author nazmul hasan
     * @created on 23rd September 2015
     */
    function blog_category($category_id = 0) {
        
        $blog_list = $this->blog_app_library->get_all_blogs_by_category($category_id);
        $this->data['blog_list'] = $blog_list;
        $this->data['total_blogs'] = count($blog_list);
        $this->data['total_columns'] = APP_BLOG_CATEGORY_PAGE_COLUMNS; 
        $this->data['category_id'] = $category_id;
        $this->template->load(null, "applications/blog_app/blog_list_by_catagory_view", $this->data);
    }
    
    /*
     * This method will display blog details
     * @param $blog_id, blog id
     * @author nazmul hasan
     * @created on 26th September 2015
     */
    function view_blog_post($blog_id = 0) {
        $blog_info = $this->blog_app_library->get_blog_info($blog_id);
        if (empty($blog_info)) {
            redirect('applications/blog_app', 'refresh');
        }
        $related_blogs = array();
        $related_blog_id_list = null;
        $related_posts = $blog_info['related_posts'];
        if ($related_posts != "" && strtolower($related_posts) !="null" && $related_posts != null) {
            $related_blog_id_list = json_decode($related_posts);
            if(!empty($related_blog_id_list))
            {
                $related_blogs = $this->blog_app_library->get_blogs($related_blog_id_list, array(APPROVED))->result_array();
            }            
        }
        $this->data['related_blogs'] = $related_blogs;
        $comments = $this->blog_app_library->get_all_comments($blog_id, NEWEST_FIRST, APPLICATION_ITEM_COMMENTS_PER_PAGE);

        $this->data['blog'] = $blog_info;
        $this->data['comments'] = $comments;
        $this->data['user_info'] = $this->ion_auth->get_user_info();
        $this->data['application_id'] = APPLICATION_BLOG_APP_ID;
        $this->data['item_id'] = $blog_info['blog_id'];
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
            $blog_title = trim(htmlentities($this->input->post('title_editortext')));
            $description = trim(htmlentities($this->input->post('description_editortext')));
            $picture_description = trim(htmlentities($this->input->post('image_description_editortext')));
            $data = array(
                'title' => $blog_title,
                'description' => $description,
                'user_id' => $this->session->userdata('user_id'),
                'picture' => '',
                'picture_description' => $picture_description,
                'created_on' => now(),
                'blog_status_id' => PENDING
            );
            if (isset($_FILES["userfile"])) {
                $file_info = $_FILES["userfile"];
                //uploading image
                $result = $this->utils->upload_image($file_info, BLOG_POST_IMAGE_PATH);
                if ($result['status'] == 1) {
                    $data['picture'] = $result['upload_data']['file_name'];
                } else {
                    $this->data['message'] = $result['message'];
                    echo json_encode($this->data);
                    return;
                }
            }

            $blog_id = $this->blog_app_library->create_blog($data);
            if ($blog_id !== FALSE) {
                $category_name = $this->input->post('category_name');
                if ($category_name != null) {
                    foreach ($category_name as $key => $value) {
                        $this->blog_app_library->blog_category_list_update($value, $blog_id);
                    }
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
            'rows' => '4',
            'cols' => '10'
        );

        $this->data['have_my_blogs'] = 0;
        $user_blog_list = $this->blog_app_library->get_all_blogs_by_user();
        if (!empty($user_blog_list)) {
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

    function users_blog() {
        $this->data['message'] = '';
        $blog_list = $this->blog_app_library->get_all_blogs_by_user();
        $this->data['blog_list'] = $blog_list;
        $this->data['have_my_blogs'] = 0;
        if (!empty($blog_list)) {
            $this->data['have_my_blogs'] = 1;
        }

        $this->template->load(null, "applications/blog_app/my_blogs_view", $this->data);
    }

    /*
     * This method will edit a blog by user and send the edit request to the admin
     * @Author Nazmul on 10th June 2014
     * @param $blog_id, blog id
     */

    public function edit_blog($blog_id) {
        $result = array();
        $this->data['message'] = '';
        $result['status'] = true;
        $result['message'] = "A request to edit your blog has been sent";
        $user_id = $this->session->userdata('user_id');

        $this->form_validation->set_rules('title_editortext', 'Title', 'xss_clean|required');
        $this->form_validation->set_rules('description_editortext', 'Description', 'xss_clean|required');
        $this->form_validation->set_rules('image_description_editortext', 'Image Description', 'xss_clean|required');

        $blog_info = array();
        $blog_info_array = $this->blog_app_model->get_blog_info($blog_id)->result_array();
        if (!empty($blog_info_array)) {
            $blog_info = $blog_info_array[0];
        }
        if ($this->input->post()) {
            $data = array(
                'title' => trim(htmlentities($this->input->post('title_editortext'))),
                'description' => trim(htmlentities($this->input->post('description_editortext'))),
                'picture_description' => trim(htmlentities($this->input->post('image_description_editortext'))),
                'user_id' => $user_id,
                'picture' => '',
            );
            if (isset($_FILES["userfile"])) {
                $file_info = $_FILES["userfile"];
                $result = $this->utils->upload_image($file_info, BLOG_POST_IMAGE_PATH);
                if ($result['status'] == 1) {
                $data['picture'] = $result['upload_data']['file_name'];
                }
            }
            $blog_category_id_list = array();
            foreach ($this->input->post('category_name') as $category_id) {
                $blog_category_id_list[] = $category_id;
            }
            if ($blog_info['blog_status_id'] == APPROVED) {
                $data['blog_status_id'] = RE_APPROVAL;
                $data['reference_id'] = $blog_id;
                $new_blog_id = $this->blog_app_library->create_blog($data);
                if ($new_blog_id === FALSE) {
                    print_r($new_blog_id);
                    $result['status'] = false;
                    $result['message'] = $this->blog_app_library->errors();
                    $result['blog_info'] = $blog_info;
                    
                } else {
                    $this->blog_app_library->add_blog_under_blog_category($new_blog_id, $blog_category_id_list);
                    $result['status'] = TRUE;
                    $result['message'] = 'Blog is updated successfully.';
                }
            
            } else if ($blog_info['blog_status_id'] == PENDING || $blog_info['blog_status_id'] == RE_APPROVAL) {
                $flag = $this->blog_app_library->update_blog($blog_id, $data);
                if ($flag === FALSE) {
                    $result['status'] = FALSE;
                    $result['message'] = $this->blog_app_library->errors();
                } else {
                    $this->blog_app_library->remove_blog_from_blog_category($blog_id);
                    $this->blog_app_library->add_blog_under_blog_category($blog_id, $blog_category_id_list);
                }
            } else if ($blog_info['blog_status_id'] == DELETION_PENDING) {
                //implement case 4 and case 7
                $reference_blog = $this->blog_app_model->get_blog_info($blog_info['reference_id'])->result_array();
                if (!empty($reference_blog)) {
                    $reference_blog = $reference_blog[0];
                }

                if ($reference_blog['blog_status_id'] == PENDING) {
                    $flag = $this->blog_app_library->update_blog($reference_blog['blog_id'], $data);
                    if ($flag === FALSE) {
                        $result['status'] = FALSE;
                        $result['message'] = $this->blog_app_library->errors();
                    } else {
                        $this->blog_app_library->remove_blog_from_blog_category($reference_blog['blog_id']);
                        $this->blog_app_library->add_blog_under_blog_category($reference_blog['blog_id'], $blog_category_id_list);
                    }
                }


                $data['blog_status_id'] = RE_APPROVAL;

                $flag = $this->blog_app_library->update_blog($blog_id, $data);

                if ($flag == FALSE) {
                    $result['status'] = FALSE;
                    $result['message'] = $this->blog_app_library->errors();
                }
            }
            echo json_encode($result);
            return;
        }

        $this->data['blog_category_list'] = $this->blog_app_library->get_all_blog_categories()->result_array();
        $this->data['blog_category_id_list_of_blog'] = $this->blog_app_library->get_blog_category_id_list_of_blog($blog_id);

        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'value' => html_entity_decode(html_entity_decode($blog_info['title'])),
            'rows' => '4',
            'cols' => '10'
        );

        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'value' => html_entity_decode(html_entity_decode($blog_info['description'])),
            'rows' => '4',
            'cols' => '10'
        );

        $this->data['image_description'] = array(
            'name' => 'image_description',
            'id' => 'image_description',
            'type' => 'text',
            'value' => html_entity_decode(html_entity_decode($blog_info['picture_description'])),
            'rows' => '4',
            'cols' => '10'
        );

        //MY BLOGS show. checks if user has blog
        $this->data['have_my_blogs'] = 0;
        $user_blog_list_array = $this->blog_app_library->get_all_blogs_by_user();
        if (!empty($user_blog_list_array)) {
            $this->data['have_my_blogs'] = 1;
        }
        $this->data['blog_info'] = $blog_info;
        $this->data['blog_id'] = $blog_id;
        $this->template->load("", "applications/blog_app/edit_blog", $this->data);
    }

    public function update_checked_blog_id($blog_id) {
        $blog_category_list_array_map = $this->blog_app_library->get_all_category_of_this_blog($blog_id);
        if (!empty($blog_category_list_array_map)) {
            foreach ($blog_category_list_array_map as $key => $category_array) {
                // here $category_array->blog_id means category_id
                $categoryid = $category_array->blog_id;
                $this->blog_app_library->blog_category_list_update_by_remove($categoryid, $blog_id);
            }
        }

        foreach ($this->input->post('category_name') as $key => $category_id) {
            $this->blog_app_library->blog_category_list_update($category_id, $blog_id);
        }
    }

    /*
     * This method will send the delete request to the admin
     * @Author Nazmul on 10th June 2014
     */

    public function request_to_remove_blog() {
        $response = array();
        $response['status'] = true;
        $response['message'] = "A request to delete your blog has been sent";

        $blog_id = $_POST['blog_id'];
        $blog_info = array();
        $blog_info_array = $this->blog_app_model->get_blog_info($blog_id)->result_array();
        if (!empty($blog_info_array)) {
            $blog_info = $blog_info_array[0];
        }
        if ($blog_info['blog_status_id'] == PENDING || $blog_info['blog_status_id'] == APPROVED) {
            //implement case 2,6
            unset($blog_info['id']);
            $blog_info['blog_status_id'] = DELETION_PENDING;
            $blog_info['reference_id'] = $blog_id;
            $id = $this->blog_app_library->create_blog($blog_info);

            if ($id == FALSE) {
                $response['status'] = false;
                $response['message'] = "Your request to delete the blog is unsuccessful";
            }
        } else if ($blog_info['blog_status_id'] == RE_APPROVAL) {
            //implement case 9
            $blog_info['blog_status_id'] = DELETION_PENDING;
            $flag = $this->blog_app_library->update_blog($blog_id, $blog_info);

            if ($flag == FALSE) {
                $response['status'] = false;
                $response['message'] = "Your request to delete the blog is unsuccessful";
            }
        }
        echo json_encode($response);
    }

}

?>