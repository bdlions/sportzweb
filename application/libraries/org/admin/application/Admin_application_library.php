<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Ion Auth
 *
 * Author: Ben Edmunds
 * 		  ben.edmunds@gmail.com
 *         @benedmunds
 *
 * Added Awesomeness: Phil Sturgeon
 *
 * Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
 *
 * Created:  10.01.2009
 *
 * Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
 * Original Author name has been kept but that does not mean that the method has not been modified.
 *
 * Requirements: PHP5 or above
 *
 */
class Admin_application_library {
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');
        
        // Load the session, CI2 as a library, CI3 uses it as a driver
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->load->library('session');
        } else {
            $this->load->driver('session');
        }

        // Load IonAuth MongoDB model if it's set to use MongoDB,
        // We assign the model object to "ion_auth_model" variable.
        $this->config->item('use_mongodb', 'ion_auth') ?
                        $this->load->model('ion_auth_mongodb_model', 'ion_auth_model') :
                        $this->load->model('org/admin/application/admin_application_model');

        $this->admin_application_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->admin_application_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in admin_application_model');
        }

        return call_user_func_array(array($this->admin_application_model, $method), $arguments);
    }
    

    /**
     * __get
     *
     * Enables the use of CI super-global without having to define an extra variable.
     *
     * I can't remember where I first saw this, so thank you if you are the original author. -Militis
     *
     * @access	public
     * @param	$var
     * @return	mixed
     */
    public function __get($var) {
        return get_instance()->$var;
    }
    
    public function get_all_applications()
    {
        $application_list = array();
        $application_list_array = $this->admin_application_model->get_all_applications()->result_array();
        foreach($application_list_array as $appliation)
        {
            $appliation['home_page'] = '';
//            $appliation['total_male_members'] = 0;
//            $appliation['total_female_members'] = 0;
//            $appliation['total_members'] = 0;
//            $users_counter_array = array();
            if($appliation['id'] == APPLICATION_XSTREAM_BANTER_ID)
            {
                $appliation['home_page'] = APPLICATION_XSTREAM_BANTER_HOME_PAGE_PATH;
            }
            else if($appliation['id'] == APPLICATION_HEALTYY_RECIPES_ID)
            {
                $appliation['home_page'] = APPLICATION_HEALTHY_RECIPES_HOME_PAGE_PATH;
//                $users_counter_array = $this->admin_application_model->get_healthy_recipes_user_counter_comments()->result_array();                
            }
            else if($appliation['id'] == APPLICATION_SERVICE_DIRECTORY_ID)
            {
                $appliation['home_page'] = APPLICATION_SERVICE_DIRECTORY_HOME_PAGE_PATH;
//                $users_counter_array = $this->admin_application_model->get_services_user_counter_comments()->result_array();
            }
            else if($appliation['id'] == APPLICATION_NEWS_APP_ID)
            {
                $appliation['home_page'] = APPLICATION_NEWS_HOME_PAGE_PATH;
//                $users_counter_array = $this->admin_application_model->get_news_user_counter_comments()->result_array();
            }
            else if($appliation['id'] == APPLICATION_BLOG_APP_ID)
            {
                $appliation['home_page'] = APPLICATION_BLOG_HOME_PAGE_PATH;
//                $users_counter_array = $this->admin_application_model->get_blogs_user_counter_comments()->result_array();
            }
            else if($appliation['id'] == APPLICATION_BMI_CALCULATOR_ID)
            {
                $appliation['home_page'] = APPLICATION_BMI_CALCULATOR_HOME_PAGE_PATH;
            }
            else if($appliation['id'] == APPLICATION_PHOTOGRAPHY_ID)
            {
                $appliation['home_page'] = APPLICATION_PHOTOGRAPHY_HOME_PAGE_PATH;
            }
//            foreach($users_counter_array as $users_counter            
//            {
//                if($users_counter['gender_id'] == 1)
//                {
//                    $appliation['total_male_members'] = $users_counter['total_users'];
//                }
//                else if($users_counter['gender_id'] == 2)
//                {
//                    $appliation['total_female_members'] = $users_counter['total_users'];
//                }
//            }
//            $appliation['total_members'] = ($appliation['total_male_members']+$appliation['total_female_members']);
            $application_list[] = $appliation;
        }
        $application_list_array = $application_list;
        $length = count($application_list_array);
        for($i=0;$i<$length;$i++)
        {
            $data = $this->admin_application_model->get_application_visitor_list($application_list_array[$i]['id'])->result_array();
            $length_data = count($data);
            $application_list_array[$i]['total_male_members']=0;
            $application_list_array[$i]['total_female_members']=0;
            
            for($j=0;$j<$length_data;$j++)
            {
                $info = $this->admin_application_model->get_user_info($data[$j]['user_id'])->result_array();
                if(!empty($info)){
                    $info = $info[0];
                
                    if($info['gender_id']==1) $application_list_array[$i]['total_male_members']++;
                    else $application_list_array[$i]['total_female_members']++;
                }
                
            }
            
            $application_list_array[$i]['total_members'] = $application_list_array[$i]['total_male_members'] + $application_list_array[$i]['total_female_members'];
        }
        
        //$application_list_array[0]['home_page'] = APPLICATION_XSTREAM_BANTER_HOME_PAGE_PATH;
        return $application_list_array;
    }

}

?>
