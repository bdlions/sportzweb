<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class News_app extends Role_Controller {
    function __construct() {
        parent::__construct();
        $this->lang->load('auth');        
        $this->load->helper('language');
        $this->load->helper('url');
        $this->load->library('visitors');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('org/application/news_app_library');
        $this->data['news_header_menu'] = $this->news_app_library->get_menu_items();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }
    /*
     * This method will load news application home page
     * @Author Nazmul on 20th February 2015 
     */
    function index() {

        $this->data['message'] = '';
        $this->data = array_merge($this->data, $this->news_app_library->get_news_home_page_configuration());
        $visit_success = $this->visitors->store_application_visitor(APPLICATION_NEWS_APP_ID);
        $this->template->load(null, "applications/news_app/news_app_home_view", $this->data);
    }
    /*
     * Ajax Call
     * This method will return breaking and latest news list
     * @Author Nazmul on 4th February 2015
     */
    function get_breaking_latest_news_list()
    {
        $breaking_news_list = $this->news_app_library->get_breaking_news_list();
        if(count($breaking_news_list)!=0){
            foreach ($breaking_news_list as $news_list_key => $breaking_news) {
                $breaking_news_list[$news_list_key]['headline'] = strip_tags(html_entity_decode(html_entity_decode($breaking_news['headline'])));
            }
        }
        $latest_news_list = $this->news_app_library->get_latest_news_list();
        if(count($latest_news_list)!=0){
            foreach ($latest_news_list as $news_list_key => $breaking_news) {
                $latest_news_list[$news_list_key]['headline'] = strip_tags(html_entity_decode(html_entity_decode($breaking_news['headline'])));
            }
        }
        $result = array(
            'breaking_news_list' => $breaking_news_list,
            'latest_news_list' => $latest_news_list
        );
        echo json_encode($result);        
    }
    /*
     * This method will load news category page
     * @param $news_category_id, news category id
     * @Author Nazmul on 20th Feburary 2015
     */
    public function news_category($news_category_id)
    {
        $news_category_info = array();
        $news_category_info_array = $this->news_app_library->get_news_category_info($news_category_id)->result_array();
        if(!empty($news_category_info_array))
        {
            $news_category_info = $news_category_info_array[0];
        }
        else
        {
            redirect('applications/news_app','refresh');
        }
        $this->data['title'] = $news_category_info['title'];
        $this->data = array_merge($this->data, $this->news_app_library->get_news_category_configuration($news_category_id));
        $this->template->load(null, "applications/news_app/news_catagory_sub_category_news_list", $this->data);        
    }
    /*
     * This method will load news sub category page
     * @param $sub_category_id, sub category id
     * @Author Nazmul on 20th Feburary 2015
     */
    public function sub_category($sub_category_id)
    {
        $news_sub_category_info = array();
        $news_sub_category_info_array = $this->news_app_library->get_news_sub_category_info($sub_category_id)->result_array();
        if(!empty($news_sub_category_info_array))
        {
            $news_sub_category_info = $news_sub_category_info_array[0];
        }   
        else
        {
            redirect('applications/news_app','refresh');
        }
        $this->data['title'] = $news_sub_category_info['title'];
        $this->data = array_merge($this->data, $this->news_app_library->get_news_sub_category_configuration($sub_category_id));
        $this->template->load(null, "applications/news_app/news_catagory_sub_category_news_list", $this->data);  
    } 
    /*
     * This method will dispaly a news item
     * @param $news_id, news id
     * @Author Nazmul on 20th Feburary 2015
     */
    function news_item($news_id)
    {
        $comment_list = $this->news_app_library->get_all_comments($news_id, NEWEST_FIRST,DEFAULT_VIEW_PER_PAGE);
        $this->data['comments'] = $comment_list;
        $this->data['user_info'] = $this->ion_auth->get_user_info();
        $news = $this->news_app_library->get_news_info($news_id);
        if(empty($news))
        {
            redirect('applications/news_app','refresh');
        }
        $this->data['news'] = $news;
        $this->data['application_id'] = APPLICATION_NEWS_APP_ID;
        $this->data['item_id'] = $news['news_id'];
        $this->template->load(null, "applications/news_app/news_item_view", $this->data);
    }
    
    function get_all_comments($news_id)
    {
        $comment_list = $this->news_app_library->get_all_comments($news_id);
    
        for($i=0;$i<count($comment_list);$i++)
        {
            $comment_list[$i]['like_count'] = count($comment_list[$i]['user_liked_list']);
        }
        
        $this->data['comment_list'] = $comment_list;
        
    }
    
    function post_comment()
    {
        $response = array();
        $comment = trim($_POST['comment']);
        $comment_nature = $_POST['comment_nature'];
        if($comment_nature == 'Neutral') {
            $rate_id = 0;
        } else if($comment_nature == 'Negative') {
            $rate_id = 2;
        } else {
            $rate_id = 1;
        }
        
        $data = array(
            'comment' => $comment,
            'rate_id' => $rate_id,
            'user_id' => $this->session->userdata('user_id'),
            'news_id' => $_POST['news_id'],
            'created_on' => now()
        );

        $id = $this->news_app_library->create_comment($data);

        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Comments is added successfully.';
            $news_comment_info_array = $this->news_app_library->get_comment_info($id)->result_array();
            if(!empty($news_comment_info_array))
            {
                $response['news_comment_info'] = $news_comment_info_array[0];
            }             
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_news->errors_alert();
        }
        
       echo json_encode($response);
    }
    
    function edit_comment()
    {
        $response = array();
        $comment_id = trim($_POST['comment_id']);
        $comment = trim($_POST['comment']);
        $comment_nature = $_POST['comment_nature'];
        if($comment_nature == 'Neutral') {
            $rate_id = 0;
        } else if($comment_nature == 'Negative') {
            $rate_id = 2;
        } else {
            $rate_id = 1;
        }
        
        $data = array(
            'comment' => $comment,
            'rate_id' => $rate_id,
            'user_id' => $this->session->userdata('user_id'),
            'news_id' => $_POST['news_id'],
            'modified_on' => now()
        );

        $id = $this->news_app_library->update_comment($comment_id, $data);

        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Comments is update successfully.';
            $news_comment_info_array = $this->news_app_library->get_comment_info($comment_id)->result_array();
            if(!empty($news_comment_info_array))
            {
                $response['news_comment_info'] = $news_comment_info_array[0];
            }     
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_news->errors_alert();
        }
        
       echo json_encode($response);
    }
    
    function remove_comment()
    {
        $response = array();
        $comment_id = $this->input->post('comment_id');

        $id = $this->news_app_library->remove_comment($comment_id);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Comments is removed successfully.';   
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_news_app->errors_alert();
        }
        
       echo json_encode($response);
    }
}
