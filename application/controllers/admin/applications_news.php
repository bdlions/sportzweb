<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Applications_news extends Admin_Controller{
    public $tmpl = '';
    public $user_group_array = array();
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('excel');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        $this->load->library('org/admin/access_level/admin_access_level_library');
        $this->load->library('org/admin/application/admin_news');
        $this->load->library('org/utility/Utils');

       
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
        $this->data['allow_write'] = FALSE;
        $this->data['allow_edit'] = FALSE;
        $this->data['allow_delete'] = FALSE;
        $this->data['allow_configuration'] = FALSE;
        $this->data['allow_writing'] = FALSE;
        
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
            $this->data['allow_write'] = TRUE;
            $this->data['allow_edit'] = TRUE;
            $this->data['allow_delete'] = TRUE;
            $this->data['allow_configuration'] = TRUE;   
            $this->data['allow_writing'] = TRUE;   
        }
        else
        {
            $access_level_mapping = $this->admin_access_level_library->get_access_level_info($this->session->userdata('user_id'));
            $this->tmpl = USER_DASHBOARD_TEMPLATE;
            $this->data['access_level_mapping'] = $access_level_mapping;
            
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
            {
                $this->data['allow_view'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE, $access_level_mapping))
            {
                $this->data['allow_write'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT, $access_level_mapping))
            {
                $this->data['allow_edit'] = TRUE;
            }if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE, $access_level_mapping))
            {
                $this->data['allow_delete'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION, $access_level_mapping))
            {
                $this->data['allow_configuration'] = TRUE;  
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_NEWS_ID.'_'.ADMIN_ACCESS_LEVEL_WRITING, $access_level_mapping))
            {
                $this->data['allow_writing'] = TRUE;  
            }
            if(!$this->data['allow_view'])
            {
                redirect('admin/general/restriction_view', 'refresh');
            }
        }

    } 
    /*
     * This method will load home page of news application at admin panel
     * @Author Nazmul on 20th February 2015
     */
    function index()
    {
        $this->data['message'] = '';
        $news_category_list = $this->admin_news->get_all_news_categories()->result_array();        
        $this->data['news_category_list'] = $news_category_list;
        $this->template->load($this->tmpl, "admin/applications/news_app/news_category", $this->data);
    }
    //----------------------------------News Module--------------------------------//
    /**
     * This method will create a news item
     * @author Nazmul on 4th March 2015
     */
    function create_news()
    {
        $this->data['message'] = '';
        $this->form_validation->set_rules('headline_editortext', 'HeadLine', 'xss_clean|required');
        $this->form_validation->set_rules('summary_editortext', 'Summary', 'xss_clean|required');
        $this->form_validation->set_rules('description_editortext', 'Description', 'xss_clean|required');
        $this->form_validation->set_rules('image_description_editortext', 'Image Description', 'xss_clean|required');
        if($this->input->post())
        {
            if($this->form_validation->run() == true)
            {
                $news_headline = trim(htmlentities($this->input->post('headline_editortext')));
                $news_summary = trim(htmlentities($this->input->post('summary_editortext')));
                $description = trim(htmlentities($this->input->post('description_editortext')));
                $picture_description = trim(htmlentities($this->utils->add_blank_target_in_anchor(html_entity_decode($this->input->post('image_description_editortext')))));
                $news_data = array(
                    'headline' => $news_headline,
                    'summary' => $news_summary,
                    'description' => $description,
                    'news_date' => $this->utils->get_current_date_db(),
                    'picture' => '',
                    'picture_description' => $this->utils->add_blank_target_in_anchor($picture_description),
                    'created_on' => now()
                );
                if (isset($_FILES["userfile"]))
                {
                    $file_info = $_FILES["userfile"];                    
                    $result = $this->utils->upload_image($file_info, NEWS_IMAGE_PATH);
                    if($result['status'] == 1)
                    {
                        $news_data['picture'] = $result['upload_data']['file_name'];
//                        $path = NEWS_IMAGE_PATH.$result['upload_data']['file_name'];
//                        $this->utils->resize_image($path, NEWS_IMAGE_PATH_W300_H150, NEWS_IMAGE_H150, NEWS_IMAGE_W300);
                    }
                    else
                    {
                        $this->data['message'] = $result['message'];
                        echo json_encode($this->data);
                        return;
                    }                  
                }
                $news_id = $this->admin_news->create_news($news_data);
                if($news_id !== FALSE){
                    $this->data['message'] = "News is created successfully";
                    echo json_encode($this->data);
                    return;                    
                }else{
                    $this->data['message'] = $this->admin_news->errors();
                    echo json_encode($this->data);
                    return;
                }                
            }  
            else
            {
                $this->data['message'] = validation_errors();
                echo json_encode($this->data);
                return;
            }
        }        
        $this->data['headline'] = array(
            'name' => 'headline',
            'id' => 'headline',
            'type' => 'text',
            'value' => $this->form_validation->set_value('headline'),
            'rows'  => '4',
            'cols'  => '10'
        );        
        $this->data['summary'] = array(
            'name' => 'summary',
            'id' => 'summary',
            'type' => 'text',
            'value' => $this->form_validation->set_value('summary'),
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
        $this->template->load($this->tmpl,"admin/applications/news_app/create_news",  $this->data);
    }
    /**
     * This method will update news item
     * @author Nazmul on 4th March 2015
     */
    function edit_news($news_id)
    {
        $this->data['message'] = '';
        $this->form_validation->set_rules('headline_editortext', 'HeadLine', 'xss_clean|required');
        $this->form_validation->set_rules('summary_editortext', 'Summary', 'xss_clean|required');
        $this->form_validation->set_rules('description_editortext', 'Description', 'xss_clean|required');
        $this->form_validation->set_rules('image_description_editortext', 'Image Description', 'xss_clean|required');
        $news = $this->admin_news->get_news_info($news_id)->result_array();
        if(!empty($news)) {
            $news = $news[0];
        }
        else
        {
            redirect('admin/applications_news','refresh');
        }
        $this->data['news'] = $news;        
        if($this->input->post())
        {
            if($this->form_validation->run() == true)
            { 
                $uploaded_image_data = array();
                $news_headline = trim(htmlentities($this->input->post('headline_editortext')));
                $summary_headline = trim(htmlentities($this->input->post('summary_editortext')));
                $description = trim(htmlentities($this->input->post('description_editortext')));
                $picture_description = trim(htmlentities($this->utils->add_blank_target_in_anchor(html_entity_decode($this->input->post('image_description_editortext')))));
                $news_data = array(
                    'headline' => $news_headline,
                    'summary' => $summary_headline,
                    'description' => $description,
                    'picture_description' => $picture_description,
                    'modified_on' => now(),
                );
                if (isset($_FILES["userfile"]))
                {
                    $file_info = $_FILES["userfile"];                    
                    $result = $this->utils->upload_image($file_info, NEWS_IMAGE_PATH);
                    if($result['status'] == 1)
                    {
                        $news_data['picture'] = $result['upload_data']['file_name'];
//                        $path = NEWS_IMAGE_PATH.$result['upload_data']['file_name'];
//                        $this->utils->resize_image($path, NEWS_IMAGE_PATH_W300_H150, NEWS_IMAGE_H150, NEWS_IMAGE_W300);
                    }
                    else
                    {
                        $this->data['message'] = $result['message'];
                        echo json_encode($this->data);
                        return;
                    }
                } 
                else
                {
//                    $path = NEWS_IMAGE_PATH.$news['picture'];
//                    $this->utils->resize_image($path, NEWS_IMAGE_PATH_W300_H150, NEWS_IMAGE_H150, NEWS_IMAGE_W300);
                }
                
                $id = $this->admin_news->update_news($news['id'], $news_data);
                if($id !== FALSE) {
                    $this->data['message'] = 'News is updated successfully.';
                    echo json_encode($this->data);
                    return;
                }
                else {
                    $this->data['message'] = strip_tags($this->admin_news->errors());
                    echo json_encode($this->data);
                    return;
                }
            }
            else
            {
                $this->data['message'] = validation_errors();
                echo json_encode($this->data);
                return;
            }
        }        
        $this->data['headline'] = array(
            'name' => 'headline',
            'id' => 'headline',
            'type' => 'text',
            'value' => html_entity_decode(html_entity_decode($news['headline'])),
            'rows'  => '4',
            'cols'  => '10'
        );        
        $this->data['summary'] = array(
            'name' => 'summary',
            'id' => 'summary',
            'type' => 'text',
            'value' => html_entity_decode(html_entity_decode($news['summary'])),
            'rows'  => '4',
            'cols'  => '10'
        );        
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'rows'  => '4',
            'cols'  => '10',
            'value' => html_entity_decode(html_entity_decode($news['description'])),
        );        
        $this->data['image_description'] = array(
            'name' => 'image_description',
            'id' => 'image_description',
            'type' => 'text',
            'value' => isset($news['picture_description']) ? html_entity_decode(html_entity_decode($news['picture_description'])) : '',
            'rows'  => '4',
            'cols'  => '10'
        );        
        $this->data['news_id'] = $news_id;
        $this->template->load($this->tmpl, "admin/applications/news_app/edit_news", $this->data);
    }
    //-----------------------------------News home page module---------------------//
    /*
     * This method will load a page to configure news home page
     * @Author Nazmul on 20th February 2015
     */
    public function configure_news_home_page()
    {
        $this->data['message'] = '';
        $this->data['news_list'] = $this->admin_news->get_news_list();
        $this->data = array_merge($this->data, $this->admin_news->get_news_home_page_configuration());
        $this->template->load($this->tmpl,"admin/applications/news_app/config_news_for_home_page",  $this->data);
    }
   
    /*
     * Ajax call
     * This method will save news home page configuration
     * @Author Nazmul on 20th February 2015
     */
    public function save_news_home_page_configuration()
    {
        $response = array();
        $show_advertise = $this->input->post('show_advertise');
        $region_id_news_id_map = $this->input->post('region_id_news_id_map');
        
        $position_array = array();
        for($i=0;$i<NEWS_CONFIGURATION_COUNTER;$i++)
        {
            $object = new stdClass();
            $object->region_id = $i;
            if(array_key_exists('position_'.($i+1), $region_id_news_id_map))
            {
                $object->news_id = $region_id_news_id_map['position_'.($i+1)];
            }
            else
            {
                $object->news_id = 0;
            }
            $position_array[] = $object;
        } 
        $selected_date = $this->utils->convert_date_from_user_to_db($this->input->post('configuration_date'));
        $data = array(
            'news_list' => json_encode($position_array),
            'selected_date' => $selected_date,
            'show_advertise' => $show_advertise
        );        
        $id = $this->admin_news->add_news_home_page_configuration($data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = $this->admin_news->messages_alert();       
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_news->errors_alert();
        }
        echo json_encode($response);
    }
    //-------------------------- Latest News Module -------------------------------//
    /*
     * This method will configure latest news
     * @Author Nazmul on 4th February 2015
     */
    public function configure_latest_news()
    {
        $this->data['message'] = '';
        $this->data['news_list'] = $this->admin_news->get_news_list();
        $this->template->load($this->tmpl,"admin/applications/news_app/manage_latest_news",  $this->data);
    }
    
       /*
     * Ajax call
     * This method get latest news
     * @Rashida on 4th march 2015
     */
     public function get_latest_news()
    {
        $latest_news_list = array(); 
        $this->data['news_list'] = $this->admin_news->get_news_list();
        
        $latest_news_list_info = $this->admin_news->get_latest_news_info()->result_array();
        if(!empty($latest_news_list_info)){
           $latest_news_list_info = $latest_news_list_info[0];
           $news_id_list = json_decode($latest_news_list_info['news_list']);
           $latest_news_list_array= $this->admin_news->get_selected_news_by_id($news_id_list);
           foreach($latest_news_list_array as $news_info)
             {
              $news_info['headline']= html_entity_decode(html_entity_decode($news_info['headline']));
              $latest_news_list[] = $news_info;   
              $this->data['latest_news_list']  = $latest_news_list;
             }
        }
     $this->template->load($this->tmpl,"admin/applications/news_app/manage_latest_news",  $this->data);
    }
    
    /*
     * Ajax Call
     * $this method will store configuration of latest news
     * @Author Nazmul on 4th February 2015
     */
    public function add_latest_news_configuration()
    {
        $response = array();
        $news_id_list = $this->input->post('news_id_list'); 
        $data = array(
            'news_list' => $news_id_list,
            'selected_date' => $this->utils->get_current_date_db()
        );       
        $id = $this->admin_news->add_latest_news_configuration($data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = $this->admin_news->messages_alert();        
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_news->errors_alert();
        }
        echo json_encode($response);
    }
    //-------------------------- Breaking News Module -------------------------------//
    /*
     * This method will configure breaking news
     * @Author Nazmul on 4th February 2015
     */
    public function configure_breaking_news()
    {
        $this->data['message'] = '';
        $this->data['news_list'] = $this->admin_news->get_news_list();
        $this->template->load($this->tmpl,"admin/applications/news_app/manage_breaking_news",  $this->data);
    }
    
    
    
    
     /*
     * Ajax call
     * This method get latest braking news
     * @Rashida on 4th march 2015
     */
     public function get_current_breaking_news()
    {
        $this->data['news_list'] = $this->admin_news->get_news_list();
        
        $breaking_news_list_info = $this->admin_news->get_breaking_news_info()->result_array();
        if(!empty($breaking_news_list_info))
           {
           $breaking_news_list_info = $breaking_news_list_info[0];
           $news_id_list = json_decode($breaking_news_list_info['news_list']);
           $breaking_news_list= $this->admin_news->get_selected_news_by_id($news_id_list);
           if(!empty($breaking_news_list))
               {
                $this->data['breaking_news_list']  = $breaking_news_list;
               }
            }
     $this->template->load($this->tmpl,"admin/applications/news_app/manage_breaking_news",  $this->data);
    }
    
    /*
     * Ajax Call
     * $this method will store configuration of breaking news
     * @Author Nazmul on 4th February 2015
     */
    
    
    
    public function add_breaking_news_configuration()
    {
        $response = array();
        $news_id_list = $this->input->post('news_id_list'); 
        
        $data = array(
            'news_list' => $news_id_list,
            'selected_date' => $this->utils->get_current_date_db()
        );       
        $id = $this->admin_news->add_breaking_news_configuration($data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = $this->admin_news->messages_alert();        
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_news->errors_alert();
        }
        echo json_encode($response);
    }
    /*
     * Ajax call
     * this method return selected news information
     * @author rashida 4th march 2015
     */
    public function get_selected_news_by_id()
    {
      $response = array();
      $news_id_list = $this->input->post('news_selected_id_list'); 
      $result = $this->admin_news->get_selected_news_by_id($news_id_list);
      if(!empty($result)){
             
             $response = $result;
        }
        echo json_encode($response);
    }
    //------------------------------ News Style Module ----------------------------------//
    public function configure_news_styles()
    {
        $this->data['message'] = '';
//        $this->data['news_list'] = $this->admin_news->get_news_style();
        $this->template->load($this->tmpl,"admin/applications/news_app/news_style/manage_style",  $this->data);
    }
    //------------------------------ News Category Module ----------------------------------//
    /*
     * Ajax call
     * @Author Rashida sultana on 14th february
     * this method delete news category 
     */
    public function delete_news_category()
    {
        $result = array();
        $category_id = $this->input->post('category_id');
        if($this->admin_news->remove_news_category($category_id))
        {
            $result['message'] = $this->admin_news->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_news->errors_alert();
        }
        echo json_encode($result);
    }
    /*
     * This method will confirure news category page
     * @param $news_category_id, news category id
     * @Author Nazmul on 20th February 2015
     */
    public function configure_news_category_page($news_category_id)
    {
        $this->data['message'] = '';
        $news_category_info = array();
        $news_category_info_array = $this->admin_news->get_news_category_info($news_category_id)->result_array();
        if(!empty($news_category_info_array))
        {
            $news_category_info = $news_category_info_array[0];
        }
        else
        {
            redirect('admin/applications_news','refresh');
        }
        $this->data['news_category_info'] = $news_category_info;
        $this->data['news_list'] = $this->admin_news->get_news_list();
        $this->data = array_merge($this->data, $this->admin_news->get_news_category_page_configuration($news_category_id));
        $this->template->load($this->tmpl,"admin/applications/news_app/config_news_for_catagory_page",  $this->data);
    }
    /*
     * Ajax call
     * This method will save news category page configuration
     * @Author Nazmul on 20th February 2015
     */
    public function save_news_category_page_configuration()
    {
        $response = array();
        $region_id_news_id_map = $this->input->post('region_id_news_id_map');
        $region_id_is_ignored_map = $this->input->post('region_id_is_ignored_map');
        $show_advertise = $this->input->post('show_advertise');
        $news_category_id = $this->input->post('news_category_id');
        
        $position_array = array();
        for($i=0;$i<NEWS_CONFIGURATION_COUNTER;$i++)
        {
            $object = new stdClass();
            $object->region_id = $i;
            if(array_key_exists('position_'.($i+1), $region_id_news_id_map))
            {
                $object->news_id = $region_id_news_id_map['position_'.($i+1)];
            }
            else
            {
                $object->news_id = 0;
            }
            if(array_key_exists('position_'.($i+1), $region_id_is_ignored_map))
            {
                $object->is_ignored = $region_id_is_ignored_map['position_'.($i+1)];
            }
            else
            {
                $object->is_ignored = 1;
            } 
            $position_array[] = $object;
        }
        $selected_date = $this->utils->convert_date_from_user_to_db($this->input->post('selected_date'));
        $data = array(
          'news_list' => json_encode($position_array),
          'show_advertise' => $show_advertise,
          'news_category_id' => $news_category_id,
          'selected_date' => $selected_date
        );
        
        $id = $this->admin_news->add_news_category_page_configuration($data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = $this->admin_news->messages_alert();   
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_news->errors_alert();
        }
        echo json_encode($response);
    }
    //------------------------------ News Sub Category Module ---------------------------//
    /*
     * Ajax call
     * Author Rashida on 14th february 2015
     * this method delete news sub category 
     */
    public function delete_news_sub_category()
    {
        $result = array();
        $sub_category_id = $this->input->post('sub_category_id');
        if($this->admin_news->remove_news_sub_category($sub_category_id))
        {
            $result['message'] = $this->admin_news->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_news->errors_alert();
        }
        echo json_encode($result);
    }
    /*
     * This method will confirure news subcategory page
     * @param $news_sub_category_id, new sub category id
     * @Author Nazmul on 20th February 2015
     */
    public function configure_news_subcategory_page($news_sub_category_id)
    {
        $this->data['message'] = '';
        $news_sub_category_info = array();
        $news_sub_category_info_array = $this->admin_news->get_news_sub_category_info($news_sub_category_id)->result_array();
        if(!empty($news_sub_category_info_array))
        {
            $news_sub_category_info = $news_sub_category_info_array[0];
        }
        else
        {
            redirect('admin/applications_news','refresh');
        }
        $this->data['news_sub_category_info'] = $news_sub_category_info;
        $this->data['news_list'] = $this->admin_news->get_news_list();
        $this->data = array_merge($this->data, $this->admin_news->get_news_sub_category_page_configuration($news_sub_category_id));
        $this->template->load($this->tmpl,"admin/applications/news_app/config_news_for_sub_category_page",  $this->data);
    }
    /*
     * Ajax call
     * This method will save news sub category page configuration
     * @Author Nazmul on 20th February 2015
     */
    public function save_news_subcategory_page_configuration()
    {
        $response = array();
        $region_id_news_id_map = $this->input->post('region_id_news_id_map');
        $region_id_is_ignored_map = $this->input->post('region_id_is_ignored_map');
        $show_advertise = $this->input->post('show_advertise');
        $news_sub_category_id = $this->input->post('news_sub_category_id');
        
        $position_array = array();
        for($i=0;$i<NEWS_CONFIGURATION_COUNTER;$i++)
        {
            $object = new stdClass();
            $object->region_id = $i;
            if(array_key_exists('position_'.($i+1), $region_id_news_id_map))
            {
                $object->news_id = $region_id_news_id_map['position_'.($i+1)];
            }
            else
            {
                $object->news_id = 0;
            }
            if(array_key_exists('position_'.($i+1), $region_id_is_ignored_map))
            {
                $object->is_ignored = $region_id_is_ignored_map['position_'.($i+1)];
            }
            else
            {
                $object->is_ignored = 1;
            } 
            $position_array[] = $object;
        }
        $selected_date = $this->utils->convert_date_from_user_to_db($this->input->post('selected_date'));
        $data = array(
          'news_list' => json_encode($position_array),
          'show_advertise' => $show_advertise,
          'news_sub_category_id' => $news_sub_category_id,
          'selected_date' => $selected_date
        );
        
        $id = $this->admin_news->add_news_sub_category_page_configuration($data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = $this->admin_news->messages_alert();   
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_news->errors_alert();
        }
        echo json_encode($response);
    }
    /*
     * Ajax call
     * @Author Rashida Sultana on 14th february2015
     * this method delete news
     * 
     */
    public function delete_news()
    {
        $result = array();
        $news_id = $this->input->post('news_id');
        if($this->admin_news->remove_news($news_id))
        {
            $result['message'] = $this->admin_news->messages_alert();
        }
        else
        {
            $result['message'] = $this->admin_news->errors_alert();
        }
        echo json_encode($result);
    }
    /*
     * This method will load a page to diplay news list
     * @Author Nazmul on 20th February 2015
     */
    function news_list()
    {
        $this->data['message'] = '';
        $news_lists = $this->admin_news->get_news_list();
        $this->data['news_lists'] = $news_lists;
        $this->template->load($this->tmpl, "admin/applications/news_app/news_list", $this->data);
    }
    
    //Ajax call for create news category
    //Written by Omar Faruk
    function create_news_category()
    {
        $response = array();
        $news_category_name = $_POST['news_category_name'];

        $additional_data = array(
            'application_id' => APPLICATION_NEWS_APP_ID
        );    
        
        $id = $this->admin_news->create_news_category($news_category_name, $additional_data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'News Category is added successfully.';
            $news_category_info_array = $this->admin_news->get_news_category_info($id)->result_array();
            if(!empty($news_category_info_array))
            {
                $response['news_category_info'] = $news_category_info_array;
                
            }
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_news->errors_alert();
        }
        echo json_encode($response);
        return;
    }
    
    public function get_news_data()
    {
        $response = array();
        $news_category_id = $this->input->post('news_category_id');
        
        $news_category_array = $this->admin_news->get_news_category_info($news_category_id)->result_array();
        if(!empty($news_category_array))
        {
            $response = $news_category_array[0];
        }
        echo json_encode($response);
    }
    
    //Ajax call for create recipe category
    //Written by Omar Faruk
    function edit_news_category() {
        $response = array();
        $news_category_id = $_POST['news_category_id'];
        $news_category_name = $_POST['news_category_name'];
        $additional_data = array(
            'title' => $news_category_name,
            'application_id' => APPLICATION_NEWS_APP_ID
        );
        $id = $this->admin_news->update_news_category($news_category_id, $additional_data);
        if ($id !== FALSE) {
            $response['status'] = 1;
            $response['message'] = 'News Category is Update successfully.';
//            $news_category_info_array = $this->admin_news->get_news_category_info($news_category_id);
//            if (!empty($news_category_info_array)) {
//                $response['news_category_info'] = $news_category_info_array;
//            }
        } else {
            $response['status'] = 0;
            $response['message'] = $this->admin_healthy_recipes->errors_alert();
        }
        echo json_encode($response);
    }
    
    function news_sub_category($sub_category_id)
    {
        $this->data['message'] = '';
        $news_sub_category = $this->admin_news->get_all_news_sub_category($sub_category_id)->result_array();
        $news = $this->admin_news->get_news_category_info($sub_category_id)->result_array();
        $this->data['news_sub_category'] = $news_sub_category;
        $this->data['news'] = $news;
        $this->data['news_category_id'] = $sub_category_id;
        $this->template->load($this->tmpl, "admin/applications/news_app/news_sub_category", $this->data);
    }
    
    function sub_category_news_list($id)
    {
        $this->data['message'] = '';
        
        $sub_category_news = $this->admin_news->get_news_sub_category_info($id);
        $this->data['news'] = $sub_category_news;
        $this->data['category_id'] = $sub_category_news['news_category_id'];
        
        $this->template->load($this->tmpl, "admin/applications/news_app/sub_category_news_list", $this->data);
    }
    
    function news_details($news_id)
    {
        $comment_list = $this->admin_news->get_all_comments($news_id, NEWEST_FIRST,DEFAULT_VIEW_PER_PAGE)->result_array();
        $this->data['comments'] = $comment_list;
        $this->data['user_info'] = $this->ion_auth->get_user_info();
        $news = $this->admin_news->get_news_info($news_id)->result_array();
        if(count($news)>0)
        {
            $news = $news[0];
        }
        $this->data['news'] = $news;
        $this->data['application_id'] = APPLICATION_NEWS_APP_ID;
        $this->data['item_id'] = $news['id'];
        $this->template->load($this->tmpl, "admin/applications/news_app/news_details", $this->data);
    }
    
    
    public function image_upload($file_info)
    {
        $data = null;
        if (isset($file_info))
        {
            $config['image_library'] = 'gd2';
            $config['upload_path'] = NEWS_IMAGE_PATH;
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
    
    function create_news_sub_category()
    {
        $response = array();
        $news_sub_category_name = $_POST['news_sub_category_name'];
        $news_category_id = $_POST['news_category_id'];

        $additional_data = array(
            'news_category_id' => $news_category_id
        );    
        
        $id = $this->admin_news->create_news_sub_category($news_sub_category_name, $additional_data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'News Sub Category is added successfully.';
            $news_sub_category_info_array = $this->admin_news->get_news_sub_category_info($id)->result_array();
            if(!empty($news_sub_category_info_array))
            {
                $response['news_sub_category_info'] = $news_sub_category_info_array[0];
                
            }       
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_news->errors_alert();
        }
         echo json_encode($response); return;
    }
    
    public function get_news_sub_category_data()
    {
        $response = array();
        $news_sub_category_id = $_POST['news_sub_category_id'];
        
        $news_sub_category_array = $this->admin_news_model->get_news_sub_category_info($news_sub_category_id)->result_array();
 
        if(!empty($news_sub_category_array))
        {
            $response = $news_sub_category_array[0];
        }
        echo json_encode($response);
    }
    
    function update_news_sub_category()
    {
        $response = array();
        $news_category_id = $_POST['news_category_id'];
        $news_sub_category_name = $_POST['news_sub_category_name'];
        $news_sub_category_id = $_POST['news_sub_category_id'];
        $additional_data = array(
            'title' => $news_sub_category_name,
            'news_category_id' => $news_category_id
        );
        $id = $this->admin_news->update_news_sub_category($news_sub_category_id, $additional_data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'News sub category is update successfully.';
            $news_sub_category_info_array = $this->admin_news->get_news_sub_category_info($news_sub_category_id);
            if(!empty($news_sub_category_info_array))
            {
                $response['news_sub_category_info'] = $news_sub_category_info_array;
            }             
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_news->errors_alert();
        }
        echo json_encode($response);
    }
    
    function update_news()
    {
        return False;
    }
    public function import_date_validation($date)
    {
        if(preg_match("/^[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}$/", $date) === 0) {
            return 0;
        } else {
           return 1;
        }
    }
    
    public function page_import_news()
    {
        $success_counter = 0;
        $this->data['message'] = '';
        $result_array = array();
        if($this->input->post('button_submit'))
        {
            $config['upload_path'] = './././resources/import/applications/news/';
            $config['allowed_types'] = 'xlsx';
            $config['file_name'] = 'news.xlsx';
            $config['overwrite'] = TRUE;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload())
            {
                $this->data['message'] = $this->upload->display_errors();
            }
            else
            {
                $file = 'resources/import/applications/news/news.xlsx';

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
                
                //send the data in an array format
                $data['header'] = $header;
                $data['values'] = $arr_data;
                $i = 0;
                
                
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
                    
                    if(sizeof($result_data)!=$header_len || (array_key_exists('E', $result_data) && !$this->import_date_validation($result_data['E'])))
                    {
                        $result_array[$i] = 'Row no ' . $i . ' contains invalid data';
                        continue;
                    }

                    $additional_data = array(
                        'news_category_name' => strip_tags($result_data['A']),
                        'headline' => strip_tags($result_data['B']),
                        'summary' => strip_tags($result_data['C']),
                        'description' => strip_tags($result_data['D']),
                        'news_date' => $result_data['E'],
                        'created_on' => now()
                    );
                    $flag = $this->admin_news->add_imported_news_info($additional_data);

                    if($flag != FALSE)
                    {
                        $success_counter++;
                    }
                    else {
                        $result_array[$i] = 'News of row no '.$i.' is not added succefully';
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
        $this->template->load($this->tmpl, "admin/applications/news_app/import_news_view", $this->data);
    }
    

    public function import_news()
    {
        $lines = file('resources/import/applications/news/news.txt');
        $result_array = array();
        $i = 0;
        
        foreach ($lines as $line) 
        {
            $i++;
            $splited_content = explode("~", $line);
            
            $news_category_name = $splited_content[0];
            $news_category_info_array = $this->admin_news->get_news_category_info_by_name($news_category_name)->result_array();

            if(!empty($news_category_info_array))
            {
                $news_category_info_array = $news_category_info_array[0];
            }
            else
            {
                $id = $this->admin_news->create_news_category($news_category_name, $additional_data = array());
                if($id !== FALSE)
                {
                    $news_category_info_array = $this->admin_news->get_news_category_info($id);       
                }
            }
            
            $news_category_id = $news_category_info_array['id'];
            
            $additional_data = array(
                'headline' => $splited_content[1],
                'summary' => $splited_content[2],
                'description' => $splited_content[3],
                'picture' => $splited_content[4],
                'news_date' => $splited_content[5],
                'created_on' => now()
            );
            $news_id = $this->admin_news->create_news($additional_data);
            
            if ($news_id !== FALSE) {
                $id = $this->admin_news->get_news_category_info_for_update($news_category_id, $news_id);
                if ($id !== FALSE) {
                    $result_array[$i] = 'News of row no ' . $i . ' inserted sucessfully';
                } else {
                    $result_array[$i] = 'News of row no ' . $i . ' inserted sucessfully but it is not under any news category';
                }
            } else {
                $result_array[$i] = 'row no ' . $i . ' contain duplicated news title';
            }
        }
        echo '<pre/>';print_r($result_array); exit;
    }
    
    function create_sub_news($news_sub_category_id=0)
    {
        $this->data['message'] = '';
        $this->form_validation->set_rules('headline_editortext', 'HeadLine', 'xss_clean|required');
        $this->form_validation->set_rules('summary_editortext', 'Summary', 'xss_clean|required');
        $this->form_validation->set_rules('description_editortext', 'Description', 'xss_clean|required');
        
        if($this->input->post())
        {
            if($this->form_validation->run() == true)
            {
                $news_sub_category_id= $this->input->post('news_sub_category_id');
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
                
                $news_headline = trim(htmlentities($this->input->post('headline_editortext')));
                $news_summary = trim(htmlentities($this->input->post('summary_editortext')));
                $description = trim(htmlentities($this->input->post('description_editortext')));
                
                $data = array(
                    'headline' => $news_headline,
                    'summary' => $news_summary,
                    'news_sub_category_id' => $news_sub_category_id,
                    'description' => $description,
                    'news_date' => date('Y-m-d'),
                    'picture' => empty($uploaded_image_data['upload_data']['file_name'])? '' : $uploaded_image_data['upload_data']['file_name'],
                    'created_on' => now()
                );
               
                
                $news_id = $this->admin_news->create_news($data);
                if($news_id !== FALSE){
                    $id = $this->admin_news->get_news_sub_category_info_for_update($news_sub_category_id,$news_id);
                    if($id !== FALSE) {
                        $this->data['message'] = "News create is successful";
                        echo json_encode($this->data);
                        return;
                    } else {
                        $this->data['message'] = "News has been created but it's not under any sub category";
                        echo json_encode($this->data);
                        return;
                    }
                    
                }else{
                    $this->data['message'] = $this->admin_news->errors();
                    echo json_encode($this->data);
                    return;
                }
                
            }  else {
                $this->data['message'] = "Check your every input";
                echo json_encode($this->data);
                return;
            }
        }
        $this->data['headline'] = array(
            'name' => 'headline',
            'id' => 'headline',
            'type' => 'text',
            'value' => $this->form_validation->set_value('headline'),
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['summary'] = array(
            'name' => 'summary',
            'id' => 'summary',
            'type' => 'text',
            'value' => $this->form_validation->set_value('summary'),
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
        
        $this->data['news_sub_category_id'] = $news_sub_category_id;
        
        $this->template->load($this->tmpl,"admin/applications/news_app/create_sub_news",  $this->data);
    }
    
    public function news_list_for_home_page()
    {
        $response = array();
        $news_items_id = $_POST['selected_news_array_list'];
        $selected_date_for_item = $_POST['selected_date_for_item'];
        
        $data = array(
                'news_list' => $news_items_id,
                'date' => $selected_date_for_item
            );
       
        $id = $this->admin_news->config_news_for_home_page($data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'News list is added successfully.';        
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_news->errors_alert();
        }
        echo json_encode($response);
    }
    function all_comments($news_id)
    {
        $comment_list = $this->admin_news->get_all_comments($news_id)->result_array();
        $this->data['comment_list'] = $comment_list;
        $this->data['news_id'] = $news_id;
        $this->template->load($this->tmpl,"admin/applications/news_app/comment_list",  $this->data);
    }
    
    function comment_details($comment_id)
    {
        $comment = $this->admin_news->get_comment_info($comment_id)->result_array();
        $comment = $comment[0];
        
        $this->data['comment'] = $comment;
        $this->template->load($this->tmpl,"admin/applications/news_app/comment_details",  $this->data);
    }
    
    function remove_comment()
    {
        $comment_id = $this->input->post('comment_id');
        
        $id = $this->admin_news->remove_comment($comment_id);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Comment is removed successfully.';          
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_news->errors_alert();
        }
        echo json_encode($response);
    }
    
    public function get_selected_news_data()
    {
        $response = array();
        $news_id = $_POST['news_id'];
        
        $news_array = $this->admin_news->get_news_info($news_id)->result_array();
        if(!empty($news_array))
        {
            $response = $news_array[0];
        }
        
        echo json_encode($response);
    }


    /*
     * This method search news items by date range 
     * @Rashida 3rd March 2015
     */
    public function search_news_items_by_date()
    {
        $response = array();
        $search_news_start_date = $this->input->post('search_news_start_date');
        $search_news_end_date = $this->input->post('search_news_end_date');
        $start_date = $this->utils->convert_date_from_user_to_db($search_news_start_date);
        $end_date = $this->utils->convert_date_from_user_to_db($search_news_end_date);
        $search_news_result_array = $this->admin_news->get_selected_news_by_date_range($start_date,$end_date)->result_array();
        
        if(!empty($search_news_result_array))
        {
            $response = $search_news_result_array;
        }
        
        echo json_encode($response);
    }
    /*
     * Ajax call
     * This method search news items by news type result
     * @Rashida 3rd March 2015
     */
    public function search_items_by_news_type()
    {
        $response = array();
        $news_list = array();
        $search_news_type = $_GET['query'];
        $search_news_result_array = $this->admin_news->get_search_news_info_by_type($search_news_type)->result_array();
        foreach($search_news_result_array as $news_info)
        {
         $news_info['headline']= html_entity_decode(html_entity_decode($news_info['headline']));
         $news_list[] = $news_info;   
        }
        echo json_encode($news_list);
    }
    public function config_news_for_category($news_category_id)
    {
        $this->data['message'] = '';
        $result = $this->admin_news->get_news_category_info($news_category_id)->result_array();
        if(!empty($result))
        {
            $result = $result[0];
        }
        $this->data['title'] = $result['title'];
        $news_list = $this->admin_news->get_all_news()->result_array();
        $this->data['news_list_old'] = $news_list;
        $this->data['news_category_id'] = $news_category_id;
        
        $this->data = array_merge($this->data, $this->admin_news->get_news_category_configuration($news_category_id));
        
        $this->template->load($this->tmpl,"admin/applications/news_app/config_news_for_catagory_new",  $this->data);
    }
    
    public function set_news_list_for_category()
    {
        $response = array();
        $region_id_news_id_map = $_POST['region_id_news_id_map'];
        $region_id_is_ignored_map = $_POST['region_id_is_ignored_map'];
        $is_hide_advertisement = $_POST['is_hide_advertisement'];
        $selected_date = $_POST['selected_date'];
        $news_category_id = $_POST['news_category_id'];
        //store into news_category_configuration table
        
        $position_array = array();
        for($i=0;$i<NEWS_CONFIGURATION_COUNTER;$i++)
        {
            $object = new stdClass();
            $object->region_id = $i;
            $object->news_id = $region_id_news_id_map['position_'.($i+1)];
            $object->is_ignored = $region_id_is_ignored_map['position_'.($i+1)];
            $position_array[] = $object;
        }
        
        $data = array(
          'news_list' => json_encode($position_array),
          'show_advertise' => $is_hide_advertisement,
          'news_category_id' => $news_category_id,
          'selected_date' => $selected_date
        );
        
        $id = $this->admin_news->add_news_category_configuration($data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'News list is added successfully for category.';        
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_news->errors_alert();
        }
        echo json_encode($response);
    }
    
    public function config_news_for_sub_category($sub_category_id)
    {
        $this->data['message'] = '';
        $result = $this->admin_news->get_news_sub_category_info($sub_category_id)->result_array();
        if(!empty($result))
        {
            $result = $result[0];
        }
        $this->data['title'] = $result['title'];
        $news_list = $this->admin_news->get_all_news()->result_array();//print_r($news_list);exit;
        $this->data['news_list_old'] = $news_list;
        //$news_list = $this->admin_news->get_news_for_sub_category($sub_category_id);
        $this->data['sub_category_id'] = $sub_category_id;
        
        //$this->data['news_list']  = $news_list;
        
        $this->data = array_merge($this->data, $this->admin_news->get_news_sub_category_configuration($sub_category_id));
        $this->template->load($this->tmpl,"admin/applications/news_app/config_news_for_sub_category",  $this->data);
    }
    
    public function set_news_list_for_sub_category()
    {
        $response = array();
        $region_id_news_id_map = $_POST['region_id_news_id_map'];
        $region_id_is_ignored_map = $_POST['region_id_is_ignored_map'];
        $is_hide_advertisement = $_POST['is_hide_advertisement'];
        $selected_date = $_POST['selected_date'];
        $news_sub_category_id = $_POST['news_sub_category_id'];
        
        
        $position_array = array();
        for($i=0;$i<NEWS_CONFIGURATION_COUNTER;$i++)
        {
            $object = new stdClass();
            $object->region_id = $i;
            $object->news_id = $region_id_news_id_map['position_'.($i+1)];
            $object->is_ignored = $region_id_is_ignored_map['position_'.($i+1)];
            $position_array[] = $object;
        }
        
        $data = array(
          'news_list' => json_encode($position_array),
          'show_advertise' => $is_hide_advertisement,
          'news_sub_category_id' => $news_sub_category_id,
          'selected_date' => $selected_date
        );
        
        $id = $this->admin_news->add_news_sub_category_configuration($data);
        
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'News list is added successfully for category.';        
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_news->errors_alert();
        }
        
        echo json_encode($response);
    }
}
