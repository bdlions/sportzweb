<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Applications_healthyrecipes extends CI_Controller{
    public $tmpl = '';
    public $user_group_array = array();
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->library('org/admin/application/admin_healthy_recipes');
        $this->load->library('excel');
        $this->load->library('image_lib');
        $this->load->library('org/admin/access_level/admin_access_level_library');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
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
            
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_VIEW, $access_level_mapping))
            {
                $this->data['allow_view'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_ACCESS, $access_level_mapping))
            {
                $this->data['allow_access'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_WRITE, $access_level_mapping))
            {
                $this->data['allow_write'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_APPROVE, $access_level_mapping))
            {
                $this->data['allow_approve'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_EDIT, $access_level_mapping))
            {
                $this->data['allow_edit'] = TRUE;
            }if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_DELETE, $access_level_mapping))
            {
                $this->data['allow_delete'] = TRUE;
            }
            if(array_key_exists(ADMIN_ACCESS_LEVEL_APPLICATION_HEALTHY_RECIPES_ID.'_'.ADMIN_ACCESS_LEVEL_CONFIGURATION, $access_level_mapping))
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
        $recipes_category_list = array();
        $recipe_category_list_array = $this->admin_healthy_recipes->get_all_category()->result_array();
        if(!empty($recipe_category_list_array))
        {
            $recipes_category_list = $recipe_category_list_array;
        }
        $this->data['recipes_category_list'] = $recipes_category_list;
        $this->template->load($this->tmpl, "admin/applications/healthy_recipes/recipes_category", $this->data);
    }
    
    //Written by Omar Faruk for recipe category list  
    function recipe_category($recipe_category_id = 0)
    {
        $recipes_list = array();
        $recipe_list_array = $this->admin_healthy_recipes->get_all_recipes($recipe_category_id)->result_array();
        if(!empty($recipe_list_array))
        {
            $recipes_list = $recipe_list_array;
        }
        $this->data['recipes_list'] = $recipes_list;
        $this->data['recipe_category_id'] = $recipe_category_id;
        $this->template->load($this->tmpl, "admin/applications/healthy_recipes/recipes", $this->data);
    }
    
    public function get_recipe_data()
    {
        $response = array();
        $recipe_category_id = $_POST['recipe_category_id'];
        
        $recipe_category_array = $this->admin_healthy_recipes->get_recipe_category($recipe_category_id)->result_array();
        if(!empty($recipe_category_array))
        {
            $response = $recipe_category_array[0];
        }
        echo json_encode($response);
    }
    
    public function get_selected_recipe_data()
    {
        $response = array();
        $recipe_id = $_POST['recipe_id'];
        
        $recipe_array = $this->admin_healthy_recipes->get_recipe($recipe_id)->result_array();
        if(!empty($recipe_array))
        {
            $response = $recipe_array[0];
        }
        
        echo json_encode($response);
    }
    
    public function get_selected_recipes_list()
    {
        $response = array();
        $str = '';
        $recipes_id = $this->input->post('selected_recipes_item');
        $recipe_array = $this->admin_healthy_recipes->get_all_recipes_for_home(json_decode($recipes_id))->result_array();
        if(count($recipe_array)>0)
        {
            foreach ($response as $value) {
                $str .='<a style="color: black" href="'.base_url().'applications/healthy_recipes/recipe/>'. $value['title'].'</a><br>';
                    //<a style="color: black" href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $value['id'];
            }
            $response = $recipe_array;
        }
        
        echo json_encode($response);
    }
    
    public function save_selected_recipe()
    {
        $response = array();
        $save_id = $this->input->post('save_id');
        $positon_array = array(
                    $this->input->post('value_top_left'),
                    $this->input->post('value_top_right'),
                    $this->input->post('value_bottom_left'),
                    $this->input->post('value_bottom_right'),
                    $this->input->post('value_bottom_up_extra'),
                    $this->input->post('value_bottom_down_extra'),
                    $this->input->post('value_bottom_down'),
                );
        
        if($save_id==1){
            $show_advertise = 0;
        }else{
            $show_advertise = 1;
        }
        
        $recipes_list = $this->input->post('recipes_list');
              
        $data = array(
                'recipe_view_list' => json_encode($positon_array),
                'recipe_list'   => $recipes_list,
                'selected_date' => date("d-m-Y"),
                'show_advertise_home_page' => $show_advertise
            );
       
        $id = $this->admin_healthy_recipes->create_recipe_selection($data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Recipe item list is added successfully.';        
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_healthy_recipes->errors_alert();
        }
        echo json_encode($response);
    }


    //Written by Omar Faruk add recipe  
    function create_recipe($recipe_category_id = 0)
    {
        $this->data['message'] = '';
        
        $this->form_validation->set_rules('title', ' Title', 'xss_clean|required');
        $this->form_validation->set_rules('description', 'Description', 'xss_clean|required');
        $this->form_validation->set_rules('duration_editortext', 'Duration', 'xss_clean|required');
        $this->form_validation->set_rules('ingredients_editortext', 'Ingredients', 'xss_clean|required');
        $this->form_validation->set_rules('preparation_method_editortext', 'Preparation Method', 'xss_clean|required');
        //$this->form_validation->set_rules('recommend_resserts', 'Recommend Desserts', 'xss_clean|required');
        //$this->form_validation->set_rules('alternative_recipes', 'Alternative Recipes', 'xss_clean|required');
        
        if ($this->input->post()) 
        {            
            if($this->form_validation->run() == true)
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
                        $path = FCPATH.HEALTHY_RECIPES_IMAGE_PATH.$uploaded_image_data['upload_data']['file_name'];
                        //unlink($path);
                    }
                }
                
                $recipe_name = $this->input->post('title');
                $recommend_desserts = explode(",",$this->input->post('recommend_resserts'));
                $alternative_recipes = explode(",",$this->input->post('alternative_recipes'));
                
                $duration = trim(htmlentities($this->input->post('duration_editortext')));
                $ingrediantes = trim(htmlentities($this->input->post('ingredients_editortext')));
                $preparation_method = trim(htmlentities($this->input->post('preparation_method_editortext')));
                
                $data = array(
                    'recipe_category_id' => $recipe_category_id,
                    'description' => $this->input->post('description'),
                    'duration' => $duration,
                    'ingredients' => $ingrediantes,
                    'preparation_method' => $preparation_method,
                    'recommend_desserts' => json_encode($recommend_desserts),
                    'alternative_recipes' => json_encode($alternative_recipes),
                    'main_picture' => empty($uploaded_image_data['upload_data']['file_name'])? '' : $uploaded_image_data['upload_data']['file_name'],
                    'created_on' => now(),
                );
                
                
                $id = $this->admin_healthy_recipes->create_recipe($recipe_name, $data);
                if($id !== FALSE) {
                    //$this->session->set_flashdata('success_message', 'You have created a recipe sucessfully');
                    //redirect("admin/healthyrecipes/recipe_category/".$recipe_category_id, 'refresh');
                    $this->data['message'] = "You have created a recipe sucessfully";
                    echo json_encode($this->data);
                    return;
                }else{
                    $this->data['message'] = strip_tags($this->admin_healthy_recipes->errors());
                    echo json_encode($this->data);
                    return;
                }
            }
            else 
            { 
                $this->data['message'] = strip_tags(validation_errors());
                echo json_encode($this->data);
                return;
            }            
        }
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        
        $recipes_list = array();
        $recipe_list_array = $this->admin_healthy_recipes->get_all_recipes()->result_array();
        if(!empty($recipe_list_array))
        {
            $recipes_list = $recipe_list_array;
        }
        $this->data['recipes_list'] = $recipes_list;
        
        
        $recommend_desserts_data_array = array();
        $this->data['recommend_desserts_data_array'] = $recommend_desserts_data_array;
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'value' => $this->form_validation->set_value('title'),
        );
        
        $this->data['description'] = array(
            'name'  => 'description',
            'id'    => 'description',
            'value' => $this->form_validation->set_value('description'),
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['duration'] = array(
            'name' => 'duration',
            'id' => 'duration',
            'type' => 'text',
            'value' => $this->form_validation->set_value('duration'),
            'rows'  => '10',
            'cols'  => '80'
        );
        $this->data['ingredients'] = array(
            'name' => 'ingrediantes',
            'id' => 'ingrediantes',
            'type' => 'text',
            'value' => $this->form_validation->set_value('ingrediantes'),
            'rows'  => '10',
            'cols'  => '80'
        );
        
        $this->data['preparation_method'] = array(
            'name' => 'preparation_method',
            'id' => 'preparation_method',
            'type' => 'text',
            'value' => $this->form_validation->set_value('preparation_method'),
            'rows'  => '10',
            'cols'  => '80'
        );
        
        $this->data['recommend_resserts'] = array(
            'name' => 'recommend_resserts',
            'id' => 'recommend_resserts',
            'type' => 'text',
            'value' => $this->form_validation->set_value('recommend_resserts'),
        );
        
        $alternative_desserts_data_array = array();
        $this->data['alternative_desserts_data_array'] = $alternative_desserts_data_array;
         
        $this->data['alternative_recipes'] = array(
            'name' => 'alternative_recipes',
            'id' => 'alternative_recipes',
            'type' => 'text',
            'value' => $this->form_validation->set_value('alternative_recipes'),
        );
        
        $this->data['submit_create_recipe'] = array(
            'name' => 'submit_create_recipe',
            'id' => 'submit_create_recipe',
            'type' => 'submit',
            'value' => 'Add',
        );
        $this->data['recipe_category_id'] = $recipe_category_id;
        $this->template->load($this->tmpl, "admin/applications/healthy_recipes/create_recipes", $this->data);
    }
    
    /**
     * Written by Omar Faruk for image upload
     * @param type array $file_info 
     * @return null or uploaded image name
     */
    public function image_upload($file_info)
    {
        $data = array();
        if (isset($file_info))
        {
            $config['image_library'] = 'gd2';
            $config['upload_path'] = HEALTHY_RECIPES_IMAGE_PATH;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '10240';
//            $config['file_name'] = "00katakata.jpg";
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload()) return array('error' => $this->upload->display_errors());
            else
            {
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];

                $config['image_library'] = 'gd2';
                $config['source_image'] = HEALTHY_RECIPES_IMAGE_PATH.$file_name;
                $config['new_image'] = HEALTHY_RECIPES_IMAGE_PATH.$file_name;
                $config['overwrite'] = TRUE;
                $config['maintain_ratio'] = FALSE;
                $config['width'] = HEALTHY_RECIPES_IMAGE_WIDTH;
                $config['height'] = HEALTHY_RECIPES_IMAGE_HEIGHT;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) return array( 'error' => $this->image_lib->display_errors());
                
//                // to resize and copy in four folder
//                $this->resize_uploaded_image($upload_data, HEALTHY_RECIPES_IMAGE_PATH_FOR_HOME_TOP_LEFT.$file_name, HEALTHY_RECIPES_HOME_TOP_LEFT_HEIGHT, HEALTHY_RECIPES_HOME_TOP_LEFT_WIDTH);
//                $this->resize_uploaded_image($upload_data, HEALTHY_RECIPES_IMAGE_PATH_FOR_HOME_BOTTOM_RIGHT.$file_name, HEALTHY_RECIPES_HOME_BOTTOM_LEFT_HEIGHT, HEALTHY_RECIPES_HOME_BOTTOM_LEFT_WIDTH);
//                $this->resize_uploaded_image($upload_data, HEALTHY_RECIPES_IMAGE_PATH_FOR_DETAILS.$file_name, HEALTHY_RECIPES_IMAGE_DETAILS_HEIGHT, HEALTHY_RECIPES_IMAGE_DETAILS_WIDTH);
//                $this->resize_uploaded_image($upload_data, HEALTHY_RECIPES_IMAGE_PATH_FOR_LIST.$file_name, HEALTHY_RECIPES_IMAGE_LIST_HEIGHT, HEALTHY_RECIPES_IMAGE_LIST_WIDTH);
                
                $data = array('upload_data' => $upload_data);
                return $data;
            }
        }
        return $data;
    }
    
    /**
     * writen by omar faruk
     * edited by tanveerAhmed
     * to resize an uploaded image in a new directory
     * @param type $image_data
     * @param type $width
     * @param type $height
     * @param type $new_path
     */
    public function resize_uploaded_image($image_data, $new_path, $height, $width) {
        $config = array(
            'image_library' => 'gd2',
            'source_image' => $image_data['full_path'],
            'new_image' => $new_path,
            'maintain_ratio' => FALSE,
            'height' => $height,
            'width' => $width,
        );
        $image_absolute_path = FCPATH.dirname($new_path);
        if( !is_dir($image_absolute_path) ) mkdir($image_absolute_path, 0777, TRUE);
        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) return $this->image_lib->display_errors(); 
    }

    //Written by Omar Faruk edit recipe
    function edit_recipe($recipe_id = 0)
    {
        $this->data['message'] = '';
        
        $this->form_validation->set_rules('title', ' Title', 'xss_clean|required');
        $this->form_validation->set_rules('description', 'Description', 'xss_clean|required');
        //$this->form_validation->set_rules('duration', 'Duration', 'xss_clean|required');
        //$this->form_validation->set_rules('ingrediantes', 'Ingredients', 'xss_clean|required');
        //$this->form_validation->set_rules('preparation_method', 'Preparation Method', 'xss_clean|required');
        //$this->form_validation->set_rules('duration_editortext', 'Duration', 'xss_clean|required');
        //$this->form_validation->set_rules('ingredients_editortext', 'Ingredients', 'xss_clean|required');
        //$this->form_validation->set_rules('preparation_method_editortext', 'Preparation Method', 'xss_clean|required');
        
        $recipes_info = array();
        $recipe_info_array = $this->admin_healthy_recipes->get_recipe($recipe_id)->result_array();
        if(empty($recipe_info_array))
        {
            $this->session->set_flashdata('error_message', 'For this recipe no data fount');
            redirect("admin/healthyrecipes/recipe_category","refresh");
        }
        else
        {
            $recipes_info = $recipe_info_array[0];
        }
        
        $this->data['recipes_info'] = $recipes_info;
        $this->data['image'] = $recipes_info['main_picture'];
        
        if ($this->input->post()) 
        {         
            if($this->form_validation->run() == true)
            {
                $uploaded_image_data = array();
                    if (isset($_FILES["userfile"]))
                    {
                        $userfile = $_FILES["userfile"];
                        $uploaded_image_data = $this->image_upload($userfile);
                        if(isset($uploaded_image_data['error'])) {
                            $this->data['message'] = strip_tags($uploaded_image_data['error']);
                            echo json_encode($this->data);
                            return;
                        } else if(!empty($uploaded_image_data['upload_data']['file_name'])){
                            $path = FCPATH.HEALTHY_RECIPES_IMAGE_PATH.$uploaded_image_data['upload_data']['file_name'];
                            //unlink($path);
                        }
                    }
               

                $recipe_name = $this->input->post('title');
                $recommend_desserts = explode(",",$this->input->post('recommend_resserts'));
                $alternative_recipes = explode(",",$this->input->post('alternative_recipes'));
                
                $duration = trim(htmlentities($this->input->post('duration_editortext')));
                $ingrediantes = trim(htmlentities($this->input->post('ingredients_editortext')));
                $preparation_method = trim(htmlentities($this->input->post('preparation_method_editortext')));
                
                $data = array(
                    'title' => $recipe_name,
                    'recipe_category_id' => $recipes_info['recipe_category_id'],
                    'description' => $this->input->post('description'),
                    'duration' => $duration,
                    'ingredients' => $ingrediantes,
                    'preparation_method' => $preparation_method,
                    'recommend_desserts' => json_encode($recommend_desserts),
                    'alternative_recipes' => json_encode($alternative_recipes),
                    'modified_on' => now(),
                );
                
                if(!empty($uploaded_image_data) && ($uploaded_image_data['upload_data']['file_name'] != null)) {
                    $data['main_picture'] = $uploaded_image_data['upload_data']['file_name'];
                }
                
                $id = $this->admin_healthy_recipes->update_recipe($recipes_info['id'], $data);
                if($id !== FALSE) {
                    $this->data['message'] = "You have updated the recipe sucessfully";
                    echo json_encode($this->data);
                    return;
                }else{
                    $this->data['message'] = $this->admin_healthy_recipes->errors();
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
        else
        {
            $this->data['message'] = $this->session->flashdata('message'); 
        }
        
        $recipes_category_list = array();
        $recipe_category_list_array = $this->admin_healthy_recipes->get_all_category()->result_array();
        if(!empty($recipe_category_list_array))
        {
            $recipes_category_list = $recipe_category_list_array;
        }
        $this->data['recipes_category_list'] = $recipes_category_list;
        
        $recipes_list = array();
        $recipe_list_array = $this->admin_healthy_recipes->get_all_recipes()->result_array();
        if(!empty($recipe_list_array))
        {
            $recipes_list = $recipe_list_array;
        }
        $this->data['recipes_list'] = $recipes_list;
        
        $recommend_desserts_data_array = array();
        $recommend_desserts_data_array = json_decode($recipes_info['recommend_desserts']); 
        $this->data['recommend_desserts_data_array'] = $recommend_desserts_data_array;
        
        $alternative_recipes_data_array = array();
        $alternative_recipes_data_array = json_decode($recipes_info['alternative_recipes']);
        
 
        $this->data['alternative_recipes_data_array'] = $alternative_recipes_data_array;
        
        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'value' => $recipes_info['title'],
        );
        
        $this->data['description'] = array(
            'name'  => 'description',
            'id'    => 'description',
            'value' => $recipes_info['description'],
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['duration'] = array(
            'name' => 'duration',
            'id' => 'duration',
            'type' => 'text',
            'value' => html_entity_decode(html_entity_decode($recipes_info['duration'])),
            'rows'  => '4',
            'cols'  => '10'
        );
        $this->data['ingredients'] = array(
            'name' => 'ingredients',
            'id' => 'ingredients',
            'type' => 'text',
            'value' => html_entity_decode(html_entity_decode($recipes_info['ingredients'])),
            'rows'  => '4',
            'cols'  => '10'
        );
        
        $this->data['preparation_method'] = array(
            'name' => 'preparation_method',
            'id' => 'preparation_method',
            'type' => 'text',
            'value' => html_entity_decode(html_entity_decode($recipes_info['preparation_method'])),
            'rows'  => '4',
            'cols'  => '10'
        );
        
        
        $this->data['recommend_resserts'] = array(
            'name' => 'recommend_resserts',
            'id' => 'recommend_resserts',
            'type' => 'text',
            'value' => empty($recommend_desserts_data_array[0]) ? '' : implode(",", $recommend_desserts_data_array)
        );
         
        $this->data['alternative_recipes'] = array(
            'name' => 'alternative_recipes',
            'id' => 'alternative_recipes',
            'type' => 'text',
            'value' => empty($alternative_recipes_data_array[0]) ? '' : implode(",", $alternative_recipes_data_array),
        );
        
        $this->data['submit_edit_recipe'] = array(
            'name' => 'submit_edit_recipe',
            'id' => 'submit_edit_recipe',
            'type' => 'submit',
            'value' => 'Update',
        );

        $this->template->load($this->tmpl, "admin/applications/healthy_recipes/edit_recipes", $this->data);
    }
    
    //Ajax call for create recipe category
    //Written by Omar Faruk
    function create_recipe_category()
    {
        $response = array();
        $recipe_category_name = $_POST['recipe_category_name'];

        $additional_data = array(
            'application_id' => APPLICATION_HEALTYY_RECIPES_ID
        );
        $id = $this->admin_healthy_recipes->create_recipe_category($recipe_category_name, $additional_data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Recipe Category is added successfully.';
            $recipe_category_info_array = $this->admin_healthy_recipes->get_recipe_category($id)->result_array();
            if(!empty($recipe_category_info_array))
            {
                $response['recipe_category_info'] = $recipe_category_info_array[0];
            }             
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_healthy_recipes->errors_alert();
        }
        echo json_encode($response);
    }
    
    //Ajax call for create recipe category
    //Written by Omar Faruk
    function edit_recipe_category()
    {
        $response = array();
        $recipe_category_id = $_POST['recipe_category_id'];
        $recipe_category_name = $_POST['recipe_category_name'];
        $additional_data = array(
            'description' => $recipe_category_name,
            'application_id' => APPLICATION_HEALTYY_RECIPES_ID
        );
        $id = $this->admin_healthy_recipes->update_recipe_category($recipe_category_id, $additional_data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Recipe Category is Update successfully.';
            $recipe_category_info_array = $this->admin_healthy_recipes->get_recipe_category($recipe_category_id)->result_array();
            if(!empty($recipe_category_info_array))
            {
                $response['recipe_category_info'] = $recipe_category_info_array[0];
            }             
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_healthy_recipes->errors_alert();
        }
        echo json_encode($response);
    }
    
    public function all_recipe_list()
    {
        $this->data['message'] = '';
        $recipes_list = array();
        $recipe_list_array = $this->admin_healthy_recipes->get_all_recipes()->result_array();
        if(!empty($recipe_list_array))
        {
            $recipes_list = $recipe_list_array;
        }
        $this->data['recipes_list'] = $recipes_list;
        
        $present_date = date("d-m-Y");
        $result = $this->admin_healthy_recipes->get_selected_recipe_for_home_page($present_date );
        //echo '<pre/>';print_r($result);exit;
        
        if(count($result) > 0) {
            $this->data['recipe_view_list_item'] = $result['recipe_view_list_item'];
            $this->data['recipe_list_item'] =  $result['recipe_list_item'];
            $this->data['show_advertise'] = $result['show_advertise_home_page'];
        } else {
            $result = $this->admin_healthy_recipes->get_random_recipe_for_home_page();
            //echo '<pre/>';print_r($result);exit;
            $this->data['recipe_view_list_item'] = $result['recipe_view_list_item'];
            $this->data['recipe_list_item'] =  $result['recipe_list_item'];
            $this->data['show_advertise'] = 1;
        }
        
        $this->template->load($this->tmpl, "admin/applications/healthy_recipes/all_recipe_list", $this->data);
    }
    
    public function recipe_list_for_home_page()
    {
        $response = array();
        $recipe_item_id = $_POST['selected_recipe_array_list'];
        $recipes_id = $_POST['selected_recipe_item'];
        $selected_date_for_item = $_POST['selected_date_for_item'];
        //echo '<pre/>';print_r($recipe_item_id);exit;
        $data = array(
                'recipe_view_list' => $recipe_item_id,
                'recipe_list' => $recipes_id,
                'selected_date' => $selected_date_for_item
            );
       
        $id = $this->admin_healthy_recipes->create_recipe_selection($data);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Recipe item list is added successfully.';        
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_healthy_recipes->errors_alert();
        }
        echo json_encode($response);
    }
    
    
    //----------------------------Importing data for healthy recipes----------------------------------
    public function import_recipes()
    {
        $lines = file('resources/import/applications/healthy_recipes/recipes.txt');
        $result_array = array();
        $i = 0;
        foreach ($lines as $line) 
        {     
            $splited_content = explode("~", $line);
            $title = $splited_content[1];
            $i++;
            $recipe_category_name = $splited_content[0];
            $recipe_category_info_array = $this->admin_healthy_recipes->get_recipe_category_info_by_name($recipe_category_name)->result_array();
            if(!empty($recipe_category_info_array))
            {
                $recipe_category_info_array = $recipe_category_info_array[0];
            } 
            else
            {
                $id = $this->admin_healthy_recipes->create_recipe_category($recipe_category_name, $additional_data = array());
                if($id !== FALSE)
                {
                    $recipe_category_info_array = $this->admin_healthy_recipes->get_recipe_category($id)->result_array();
                    if(!empty($recipe_category_info_array))
                    {
                        $recipe_category_info_array = $recipe_category_info_array[0];
                    }          
                }
            }
            
            $additional_data = array(
                'recipe_category_id' => $recipe_category_info_array['id'],
                'description' => $splited_content[2],
                'duration' => $splited_content[3],
                'ingredients' => $splited_content[4],
                'preparation_method' => $splited_content[5],
                'main_picture' => $splited_content[6],
                'created_on' => now()
            );
            $flag = $this->admin_healthy_recipes->create_recipe($title, $additional_data);
            if($flag !== FALSE) {
                $result_array[$i] = 'row no '.$i.' inserted sucessfully';
            } else {
                $result_array[$i] = 'row no '.$i.' contain duplicated recipe title';
            }
        }
        
        echo '<pre/>';print_r($result_array); exit;
    }
    
    public function page_import_recipe()
    {
        $success_counter = 0;
        $result_array = array();
        $this->data['message'] = '';
        if($this->input->post('button_submit'))
        {
            $config['upload_path'] = './././resources/import/applications/healthy_recipes/';
            $config['allowed_types'] = 'xlsx';
            $config['file_name'] = 'healthy_recipes.xlsx';
            $config['overwrite'] = TRUE;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload())
            {
                $this->data['message'] = $this->upload->display_errors();
            }
            else
            {
                
                $file = 'resources/import/applications/healthy_recipes/healthy_recipes.xlsx';

                //read file from path
                $objPHPExcel = PHPExcel_IOFactory::load($file);

                //get only the Cell Collection
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();

                //extract to a PHP readable array format
                $header = array();
                $arr_data = array();
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
                $result_array = array();
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
                    
                    
                    if(sizeof($result_data)!= $header_len)
                    {
                        $result_array[$i] = 'row no ' . $i . ' is not containing valid data';
                        continue;
                    }

                    $additional_data = array(
                        'recipe_category_name' => $result_data['A'],
                        'title' => $result_data['B'],
                        'description' => $result_data['C'],
                        'duration' => htmlentities($result_data['D']),
                        'ingredients' => htmlentities($result_data['E']),
                        'preparation_method' => htmlentities($result_data['F']),
                        //'main_picture' => $result_data['G'],
                        'created_on' => now()
                    );
                    $flag = $this->admin_healthy_recipes->add_imported_recipe_info($additional_data);
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
        $this->template->load($this->tmpl, "admin/applications/healthy_recipes/import_healthy_recipes_view", $this->data);
    }
    
    public function import_from_xlsx_file()
    {
        $file = 'resources/import/applications/healthy_recipes/healthy_recipes.xlsx';
        
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
        $result_array = array();
        $header_len = sizeof($header[1]);
        foreach ($arr_data as $result_data)
        {
            $i++;
            if(sizeof($result_data)!= $header_len)
            {
                $result_array[$i] = 'row no ' . $i . ' contain duplicated recipe title';
                continue;
            }
            
            $additional_data = array(
                'recipe_category_name' => strip_tags($result_data['A']),
                'title' => strip_tags($result_data['B']),
                'recipe_category_id' => strip_tags($recipe_category_info_array['id']),
                'description' => strip_tags($result_data['C']),
                'duration' => strip_tags(htmlentities($result_data['D'])),
                'ingredients' => strip_tags(htmlentities($result_data['E'])),
                'preparation_method' => strip_tags(htmlentities($result_data['F'])),
                'main_picture' => strip_tags($result_data['G']),
                'created_on' => now()
            );
            $flag = $this->admin_healthy_recipes->add_imported_recipe_info($data);
            if($flag !== FALSE) {
                $result_array[$i] = 'row no '.$i.' inserted sucessfully';
            } else {
                $result_array[$i] = 'row no '.$i.' contain duplicated recipe title';
            }
        }
        echo '<pre/>';print_r($result_array); die();
    }
    
    
    public function recipes($recipe_id)
    {
        $recipe_item = array();
        $recipe_and_recommend_desserts_item = $this->admin_healthy_recipes->get_recipe_item($recipe_id);
        
        $comments = $this->admin_healthy_recipes->get_all_comments($recipe_id,NEWEST_FIRST)->result_array();
        $temp_array = array();
        $i=0;
        foreach($comments as $comment)
        {
            $i++;
            $temp_array[] = $comment;
        
            if($i==DEFAULT_VIEW_PER_PAGE) break;
        }
        $comments = $temp_array;
        
        $this->data['comments'] = $comments;
        //echo '<pre/>';print_r($recipe_comments_array);exit;
        if(array_key_exists('recipe_item', $recipe_and_recommend_desserts_item)) {
            $this->data['recipe_item'] = $recipe_and_recommend_desserts_item['recipe_item'];
            if(array_key_exists('recommend_desserts_item', $recipe_and_recommend_desserts_item)) {
               $this->data['recommend_desserts_item'] = $recipe_and_recommend_desserts_item['recommend_desserts_item'];
            }
            
            if(array_key_exists('alternative_recipes_item', $recipe_and_recommend_desserts_item)) {
               $this->data['alternative_recipes_item'] = $recipe_and_recommend_desserts_item['alternative_recipes_item'];
            }
        }
        $this->data['user_info'] = $this->ion_auth->get_user_info();
        $this->data['application_id'] = APPLICATION_HEALTYY_RECIPES_ID;
        $this->data['item_id'] = $this->data['recipe_item']['id'];
        $this->template->load($this->tmpl, "admin/applications/healthy_recipes/recipe_detail", $this->data);
    }

}
?>
