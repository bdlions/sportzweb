<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Healthy_recipes extends Role_Controller{
    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('org/application/healthy_recipes_library');
        $this->load->library('visitors');
        
        // Load MongoDB library instead of native db driver if required
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->library('mongo_db') :
                        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        $this->data['recipe_menu'] = $this->get_all_menu_item();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
    }   
    
    /*
    * Writen by Omar faruk
    */
    function index()
    {
        $present_date = date("d-m-Y");
        
        $result = $this->healthy_recipes_library->get_selected_recipe_for_home_page($present_date);
        //echo '<pre/>';print_r($result);exit;
        if(count($result) > 0) {
            $this->data['recipe_view_list_item'] = $result['recipe_view_list_item'];
            $this->data['recipe_list_item'] =  $result['recipe_list_item'];
            $this->data['show_advertise'] = $result['show_advertise'];
        } else {
            /**
            * for random selection but if you want to config from admin panel then
            *  it should not be like random selection
            */
            $results = $this->healthy_recipes_library->get_random_recipe_for_home_page();
            $this->data['recipe_view_list_item'] = $results['recipe_view_list_item'];
            $this->data['recipe_list_item'] =  $results['recipe_list_item'];
            $this->data['show_advertise'] = 0;
        }
        
        $visit_success = $this->visitors->store_application_visitor(APPLICATION_HEALTYY_RECIPES_ID);
        $this->template->load(null, "applications/health_recipes/index", $this->data);
    }
    
    /*
    * Writen by Omar faruk
    */
    public function get_all_menu_item()
    {
        $result = $this->healthy_recipes_library->get_recipe_category_for_menu()->result_array();
        return $result;
    }
    
    /*
    * Writen by Omar faruk
    */
    function recipe_category($category_id)
    {
        $result = $this->healthy_recipes_library->get_total_recipes($category_id)->result_array();
        $recipe_category_info = $this->healthy_recipes_library->get_recipe_category_info($category_id)->result_array();

        if(count($recipe_category_info)>0){
            $recipe_category_info = $recipe_category_info[0];
        }
        $this->data['recipe_category_info'] = $recipe_category_info;
        $this->data['results'] = $result;
        $this->template->load(null, "applications/health_recipes/recipe_list_by_category", $this->data);
    }
    
    /*
    * Writen by Omar faruk
    */
    function recipe_category_letters()
    {
        $results = $this->healthy_recipes_library->get_all_recipes_by_letter()->result_array();
        
        $final_array = array(array());
        $final_array = array_pop($final_array);

        $alphas = range('A', 'Z');
        $i = 0;
        foreach ($alphas as $alpha) {
            foreach ($results as $key => $value) {
                $string = strtoupper($value['title']);  
                if($alpha == $string[0]) {
                    $final_array[$alpha][$i++] = $value;  
                }
            }
        }
        $this->data['final_array'] = $final_array;
        $this->template->load(null, "applications/health_recipes/recipe_list_letters", $this->data);
    }
    
    /*
    * Writen by Omar faruk
    */
    public function get_recipe_by_alphabet()
    {
        $alphabet_value = $_GET['value'];
        $recipe_item = $this->healthy_recipes_library->get_recipe_by_alphabet($alphabet_value)->result_array();
        $this->data['results'] = $recipe_item;
        $this->data['alphabet_value'] = $alphabet_value;
        $this->template->load(null, "applications/health_recipes/recipe_list_by_letter", $this->data);
    }
      
    /*
    * Writen by Omar faruk
    */
    function recipe($recipe_id)
    {
        $recipe_item = array();
        $recipe_and_recommend_desserts_item = $this->healthy_recipes_library->get_recipe_item($recipe_id);
        $recipe_comments_array = $this->healthy_recipes_library->get_all_comments($recipe_id,NEWEST_FIRST,DEFAULT_VIEW_PER_PAGE);
        $this->data['comments'] = $recipe_comments_array;
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
        $this->template->load(null, "applications/health_recipes/dishes/recipe", $this->data);
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
            'recipe_id' => $_POST['recipe_id'],
            'created_on' => now()
        );

        $id = $this->healthy_recipes_library->create_comment($data);

        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Comments is added successfully.';
            $recipe_comment_info_array = $this->healthy_recipes_library->get_all_comments(0, 0, 0, $id);
            if(!empty($recipe_comment_info_array))
            {
                $response['comment_info'] = $recipe_comment_info_array[0];
            }             
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_recipe->errors_alert();
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
            'recipe_id' => $_POST['recipe_id'],
            'modified_on' => now()
        );

        $id = $this->healthy_recipes_library->update_comment($comment_id, $data);

        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Comments is update successfully.';
            $recipe_comments_array = $this->healthy_recipes_library->get_all_comments(0, 0, 0, $comment_id);
            if(!empty($recipe_comments_array))
            {
                $response['comment_info'] = $recipe_comments_array[0];
            }     
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_healthy_recipes->errors_alert();
        }
        
       echo json_encode($response);
    }
    
    function remove_comment()
    {
        $response = array();
        $comment_id = $this->input->post('comment_id');

        $id = $this->healthy_recipes_library->remove_comment($comment_id);
        if($id !== FALSE)
        {
            $response['status'] = 1;
            $response['message'] = 'Comments is removed successfully.';   
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->admin_healthy_recipes->errors_alert();
        }
        
       echo json_encode($response);
    }
    
    function sorted_comment_list()
    {
        $result=array();
        $value = $_POST['value'];
        $recipe_id = $_POST['recipe_id'];
        $list = $_POST['list'];
        
        $recipe_list = $this->healthy_recipes_library->get_all_comments($recipe_id,$value,$list);
    
        $result['comment_list'] = $recipe_list;
        //echo '<pre>';print_r($recipe_list);
        //exit;
        echo json_encode($result);
    }
}
?>
