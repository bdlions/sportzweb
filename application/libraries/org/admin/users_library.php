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
class Users_library {
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
                        $this->load->model('org/admin/users_model');

        $this->users_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->users_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in users_model');
        }

        return call_user_func_array(array($this->users_model, $method), $arguments);
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
    
    public function get_all_users()
    {
        $user_list = array();
        $user_list_array = $this->users_model->get_all_users()->result_array();
        foreach($user_list_array as $user_info)
        {
            $user_info['created_on'] = unix_to_human($user_info['created_on']);
            $user_info['last_login'] = unix_to_human($user_info['last_login']);
            $user_list[] = $user_info;
        }
        return $user_list;
    }
    
    public function get_user_info($user_id)
    {
        $user_info = array();
        $user_info_array = $this->users_model->get_user_info($user_id)->result_array();
        if(!empty($user_info_array))
        {
            $user_info = $user_info_array[0];
            $user_info['created_on'] = unix_to_human($user_info['created_on']);
            $user_info['last_login'] = unix_to_human($user_info['last_login']);
        }
        return $user_info;
    }
    
    public function get_users_country_age($min_age = 0, $max_age = 0)
    {
        $country_id_lists = array(15, 2, 45, 73, 105, 108, 210, 1, 223);
        $result = array();
        $temp_id_list = array();
        $user_info_array = $this->users_model->get_users_country($country_id_lists, $min_age, $max_age)->result_array();
        foreach($user_info_array as $user_info)
        {
            if(!in_array($user_info['country_id'], $temp_id_list))
            {
                $temp_id_list[] = $user_info['country_id'];
                $result[$user_info['country_id']] = array();
                $result[$user_info['country_id']]['country_name'] = $user_info['country_name'];
                $result[$user_info['country_id']]['total_male_members'] = 0;
                $result[$user_info['country_id']]['total_female_members'] = 0;
            }
            if($user_info['gender_id'] == 1)
            {
                $result[$user_info['country_id']]['total_male_members'] = $user_info['total_users'];
            }
            else if($user_info['gender_id'] == 2)
            {
                $result[$user_info['country_id']]['total_female_members'] = $user_info['total_users'];
            }
        }
        return $result;
    }
        
    public function get_user_followers($user_id)
    {
        $follower_list = array();
        $user_mutual_relation_info_array = $this->users_model->get_user_mutual_relations($user_id)->result_array();
        if(!empty($user_mutual_relation_info_array))
        {
            $user_id_list = array();
            $user_id_user_info_map = array();
            $user_mutual_relation_info = $user_mutual_relation_info_array[0];
            $relations = $user_mutual_relation_info['relations'];
            if( $relations != "" && $relations != NULL )
            {
                $relations_array = json_decode($relations);
                foreach($relations_array as $relations_info)
                {
                    if(!in_array($relations_info->user_id, $user_id_list))
                    {
                        $user_id_list[] = $relations_info->user_id;
                    }
                 }
            }
            if(!empty($user_id_list))
            {
                $user_info_array = $this->users_model->get_user_list($user_id_list)->result_array();
                foreach($user_info_array as $user_info)
                {
                    $user_id_user_info_map[$user_info['user_id']] = $user_info;
                }
            }
            
            $relations = $user_mutual_relation_info['relations'];
            if( $relations != "" && $relations != NULL )
            {
                $relations_array = json_decode($relations);
                foreach($relations_array as $relations_info)
                {
                    $follower_info = $user_id_user_info_map[$relations_info->user_id];
                    $follower_info['following_time'] = unix_to_human($relations_info->created_on);
                    $follower_list[] = $follower_info;
                }
            }
        }
        return $follower_list;
    }
    public function get_user_application_log($user_id)
    {
        $application_list = array();
        $user_application_log_info_array = $this->users_model->get_user_application_visitor_info($user_id)->result_array();
        foreach($user_application_log_info_array as $user_application_log_info)
        {
            $application_info = array();
            $application_info['application_name'] = $user_application_log_info['title'];
            $application_info['first_used_date'] = '';
            $application_info['last_used_date'] = '';
            $first_used_date = '';
            $last_used_date= '';
            $access_history = $user_application_log_info['access_history'];
            if( $access_history != "" && $access_history != NULL )
            {
                $access_history_array = json_decode($access_history);
                foreach($access_history_array as $access_history_info)
                {
                    if($first_used_date == '' && $last_used_date == '')
                    {
                        $first_used_date = $access_history_info->access_time;
                        $last_used_date = $access_history_info->access_time;
                    }
                    else if($first_used_date > $access_history_info->access_time)
                    {
                        $first_used_date = $access_history_info->access_time;
                    }
                    else if($last_used_date < $access_history_info->access_time)
                    {
                        $last_used_date = $access_history_info->access_time;
                    }
                    
                }
            }
            if($first_used_date != '')
            {
                $application_info['first_used_date'] = unix_to_human($first_used_date);
            }
            if($last_used_date != '')
            {
                $application_info['last_used_date'] = unix_to_human($last_used_date);
            }
            $application_list[] = $application_info;
        }
        return $application_list;
    }
    
    public function get_user_list_of_messages($user_id)
    {
        $user_messages_array = $this->users_model->get_users_messages($user_id)->result_array();
        $user_list = array();
        $user_id_list = array();
        foreach($user_messages_array as $user_message)
        {
            if(!in_array($user_message['from'], $user_id_list) && $user_message['from'] != $user_id)
            {
                $user_id_list[] = $user_message['from'];
            }
            if(!in_array($user_message['to'], $user_id_list) && $user_message['to'] != $user_id)
            {
                $user_id_list[] = $user_message['to'];
            }
        }
        if(!empty($user_id_list))
        {
            $user_list = $this->users_model->get_user_list($user_id_list)->result_array();            
        }
        return $user_list;    
    }
    
    public function get_user_friends($user_id)
    {
        $user_mutual_relation_info_array = $this->users_library->get_user_mutual_relations($user_id)->result_array();
        $male_friend = 0;
        $female_friend = 0;
        
        if(!empty($user_mutual_relation_info_array))
        {
            $user_mutual_relation_info_array = $user_mutual_relation_info_array[0];
            
            
            
            $relation_array = json_decode($user_mutual_relation_info_array['relations']);
            
            $user_id_list = array();
            foreach($relation_array as $relations_info)
            {
                if(!in_array($relations_info->user_id, $user_id_list))
                {
                    $user_id_list[] = $relations_info->user_id;
                }
            }
            
            if(!empty($user_id_list))
            {
                $user_info_array = $this->users_model->get_user_list($user_id_list)->result_array();
                foreach($user_info_array as $user)
                {
                    if($user['gender_id']==1) $male_friend++;
                    else $female_friend ++;
                }
            }
        }
        $data = array();
        $data['male_friend'] = $male_friend;
        $data['female_friend'] = $female_friend;
        $data['total_friend'] = $male_friend + $female_friend;
        
        return $data;
    }
}
?>