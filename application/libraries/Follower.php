<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Follower {
    public function __construct() {
        $this->load->helper('cookie');

        // Load the session, CI2 as a library, CI3 uses it as a driver
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->load->library('session');
        } else {
            $this->load->driver('session');
        }

        // Load IonAuth MongoDB model if it's set to use MongoDB,
        // We assign the model object to "ion_auth_model" variable.
        $this->load->model("follower_model");

        $this->follower_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->follower_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in business_profile_model');
        }

        return call_user_func_array(array($this->follower_model, $method), $arguments);
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
    
    /*
     * This method will add a new follower under a user
     * @param $user_id, user id
     * @param $follower_id, follower id
     */
    public function add_follower($user_id, $follower_id)
    {
        $current_time = now();
        $from_follower = new stdClass();
        $from_follower->user_id = $follower_id;
        $from_follower->created_on = $current_time;
        $from_follower->modified_on = $current_time;
        $from_follower->blocks = 0;
        $from_follower->is_blocked = 0;
        
        $to_follower = new stdClass();
        $to_follower->user_id = $user_id;
        $to_follower->created_on = $current_time;
        $to_follower->modified_on = $current_time;
        $to_follower->blocks = 0;
        $to_follower->is_blocked = 0;
        
        $from_follower_list = array();        
        $from_user_mutual_relation_array = $this->follower_model->get_user_mutual_relations($user_id)->result_array();
        if(!empty($from_user_mutual_relation_array))
        {
            $from_user_mutual_relation = $from_user_mutual_relation_array[0];
            $from_relations = $from_user_mutual_relation['relations'];
            if( $from_relations != "" && $from_relations != NULL )
            {
                $from_relations_array = json_decode($from_relations);
                foreach($from_relations_array as $from_relation_info)
                {
                    //skipping current follower if exists
                    if($from_relation_info->user_id != $follower_id)
                    {
                        $from_follower_list[] = $from_relation_info;
                    }
                }
            }
        }
        $to_follower_list = array();
        $to_user_mutual_relation_array = $this->follower_model->get_user_mutual_relations($follower_id)->result_array();
        if(!empty($to_user_mutual_relation_array))
        {
            $to_user_mutual_relation = $to_user_mutual_relation_array[0];
            $to_relations = $to_user_mutual_relation['relations'];
            if( $to_relations != "" && $to_relations != NULL )
            {
                $to_relations_array = json_decode($to_relations);
                foreach($to_relations_array as $to_relation_info)
                {
                    //skipping current follower if exists
                    if($to_relation_info->user_id != $user_id)
                    {
                        $to_follower_list[] = $to_relation_info;
                    }
                }
            }
        }
        if($this->follower_model->get_acceptance_type($follower_id)->value == FOLLOWER_ACCEPTANCE_TYPE_MANUAL)
        {
            $from_follower->is_pending = 1;
            $to_follower->is_pending = 1;            
            $from_follower->pending = 1;
            $to_follower->pending = 0;
            
            $from_follower->is_follower = 0;
            $to_follower->is_follower = 0;            
            $from_follower->follows = 0;
            $to_follower->follows = 0;
        }
        else
        {
            $from_follower->is_follower = 1;
            $to_follower->is_follower = 1;            
            $from_follower->follows = 1;
            $to_follower->follows = 0;
            
            $from_follower->is_pending = 0;
            $to_follower->is_pending = 0;            
            $from_follower->pending = 0;
            $to_follower->pending = 0;
        }
        $from_follower_list[] = $from_follower;
        $to_follower_list[] = $to_follower;
        $from_data = array(
            'relations' => json_encode($from_follower_list)
        );
        $to_data = array(
            'relations' => json_encode($to_follower_list)
        );
        if(empty($from_user_mutual_relation_array))
        {
            $from_data['user_id'] = $user_id;
            $this->follower_model->add_user_mutual_relations($from_data);
        }
        else
        {
            $this->follower_model->update_user_mutual_relations($user_id, $from_data);
        }
        
        if(empty($to_user_mutual_relation_array))
        {
            $to_data['user_id'] = $follower_id;
            $this->follower_model->add_user_mutual_relations($to_data);
        }
        else
        {
            $this->follower_model->update_user_mutual_relations($follower_id, $to_data);
        }
        return TRUE;
    }
    
    public function remove_follower($user_id, $follower_id)
    {
        $from_follower_list = array();        
        $from_user_mutual_relation_array = $this->follower_model->get_user_mutual_relations($user_id)->result_array();
        if(!empty($from_user_mutual_relation_array))
        {
            $from_user_mutual_relation = $from_user_mutual_relation_array[0];
            $from_relations = $from_user_mutual_relation['relations'];
            if( $from_relations != "" && $from_relations != NULL )
            {
                $from_relations_array = json_decode($from_relations);
                foreach($from_relations_array as $from_relation_info)
                {
                    //skipping current follower if exists
                    if($from_relation_info->user_id != $follower_id)
                    {
                        $from_follower_list[] = $from_relation_info;
                    }
                }
            }
        }
        $to_follower_list = array();
        $to_user_mutual_relation_array = $this->follower_model->get_user_mutual_relations($follower_id)->result_array();
        if(!empty($to_user_mutual_relation_array))
        {
            $to_user_mutual_relation = $to_user_mutual_relation_array[0];
            $to_relations = $to_user_mutual_relation['relations'];
            if( $to_relations != "" && $to_relations != NULL )
            {
                $to_relations_array = json_decode($to_relations);
                foreach($to_relations_array as $to_relation_info)
                {
                    //skipping current follower if exists
                    if($to_relation_info->user_id != $user_id)
                    {
                        $to_follower_list[] = $to_relation_info;
                    }
                }
            }
        }
        $from_data = array(
            'relations' => json_encode($from_follower_list)
        );
        $to_data = array(
            'relations' => json_encode($to_follower_list)
        );
        $this->follower_model->update_user_mutual_relations($user_id, $from_data);
        $this->follower_model->update_user_mutual_relations($follower_id, $to_data);
        return TRUE;
    }
    
    public function accept_follower($user_id, $follower_id)
    {
        $current_time = now();
        $from_follower_list = array();        
        $from_user_mutual_relation_array = $this->follower_model->get_user_mutual_relations($user_id)->result_array();
        if(!empty($from_user_mutual_relation_array))
        {
            $from_user_mutual_relation = $from_user_mutual_relation_array[0];
            $from_relations = $from_user_mutual_relation['relations'];
            if( $from_relations != "" && $from_relations != NULL )
            {
                $from_relations_array = json_decode($from_relations);
                foreach($from_relations_array as $from_relation_info)
                {
                    //updating current follower
                    if($from_relation_info->user_id == $follower_id)
                    {
                        $from_relation_info->pending = 0;
                        $from_relation_info->is_pending = 0;
                        $from_relation_info->follows = 0;
                        $from_relation_info->is_follower = 1;
                        $from_relation_info->blocks = 0;
                        $from_relation_info->is_blocked = 0;
                        $from_relation_info->modified_on = $current_time;
                    }
                    $from_follower_list[] = $from_relation_info;
                }
            }
        }
        $to_follower_list = array();
        $to_user_mutual_relation_array = $this->follower_model->get_user_mutual_relations($follower_id)->result_array();
        if(!empty($to_user_mutual_relation_array))
        {
            $to_user_mutual_relation = $to_user_mutual_relation_array[0];
            $to_relations = $to_user_mutual_relation['relations'];
            if( $to_relations != "" && $to_relations != NULL )
            {
                $to_relations_array = json_decode($to_relations);
                foreach($to_relations_array as $to_relation_info)
                {
                    //updating current follower
                    if($to_relation_info->user_id == $user_id)
                    {
                        $to_relation_info->pending = 0;
                        $to_relation_info->is_pending = 0;
                        $to_relation_info->follows = 1;
                        $to_relation_info->is_follower = 1;
                        $to_relation_info->blocks = 0;
                        $to_relation_info->is_blocked = 0;
                        $to_relation_info->modified_on = $current_time;
                    }
                    $to_follower_list[] = $to_relation_info;
                }
            }
        }
        $from_data = array(
            'relations' => json_encode($from_follower_list)
        );
        $to_data = array(
            'relations' => json_encode($to_follower_list)
        );
        $this->follower_model->update_user_mutual_relations($user_id, $from_data);
        $this->follower_model->update_user_mutual_relations($follower_id, $to_data);
        return TRUE;
    }
    
    public function block_follower($user_id, $follower_id)
    {
        $current_time = now();
        $from_follower_list = array();        
        $from_user_mutual_relation_array = $this->follower_model->get_user_mutual_relations($user_id)->result_array();
        if(!empty($from_user_mutual_relation_array))
        {
            $from_user_mutual_relation = $from_user_mutual_relation_array[0];
            $from_relations = $from_user_mutual_relation['relations'];
            if( $from_relations != "" && $from_relations != NULL )
            {
                $from_relations_array = json_decode($from_relations);
                foreach($from_relations_array as $from_relation_info)
                {
                    //updating current follower
                    if($from_relation_info->user_id == $follower_id)
                    {
                        $from_relation_info->pending = 0;
                        $from_relation_info->is_pending = 0;
                        $from_relation_info->follows = 0;
                        $from_relation_info->is_follower = 0;
                        $from_relation_info->blocks = 1;
                        $from_relation_info->is_blocked = 1;
                        $from_relation_info->modified_on = $current_time;
                    }
                    $from_follower_list[] = $from_relation_info;
                }
            }
        }
        $to_follower_list = array();
        $to_user_mutual_relation_array = $this->follower_model->get_user_mutual_relations($follower_id)->result_array();
        if(!empty($to_user_mutual_relation_array))
        {
            $to_user_mutual_relation = $to_user_mutual_relation_array[0];
            $to_relations = $to_user_mutual_relation['relations'];
            if( $to_relations != "" && $to_relations != NULL )
            {
                $to_relations_array = json_decode($to_relations);
                foreach($to_relations_array as $to_relation_info)
                {
                    //updating current follower
                    if($to_relation_info->user_id == $user_id)
                    {
                        $to_relation_info->pending = 0;
                        $to_relation_info->is_pending = 0;
                        $to_relation_info->follows = 0;
                        $to_relation_info->is_follower = 0;
                        $to_relation_info->blocks = 0;
                        $to_relation_info->is_blocked = 1;
                        $to_relation_info->modified_on = $current_time;
                    }
                    $to_follower_list[] = $to_relation_info;
                }
            }
        }
        $from_data = array(
            'relations' => json_encode($from_follower_list)
        );
        $to_data = array(
            'relations' => json_encode($to_follower_list)
        );
        $this->follower_model->update_user_mutual_relations($user_id, $from_data);
        $this->follower_model->update_user_mutual_relations($follower_id, $to_data);
        return TRUE;
    }
    
    public function get_pending_followers($user_id)
    {
        $pending_follower_list = array();  
        $follower_id_list = array();
        $user_mutual_relation_array = $this->follower_model->get_user_mutual_relations($user_id)->result_array();
        if(!empty($user_mutual_relation_array))
        {
            $user_mutual_relation = $user_mutual_relation_array[0];
            $relations = $user_mutual_relation['relations'];
            if( $relations != "" && $relations != NULL )
            {
                $relations_array = json_decode($relations);
                foreach($relations_array as $relation_info)
                {
                    if($relation_info->pending == 0 && $relation_info->is_pending == 1 && !in_array($relation_info->user_id, $follower_id_list))
                    {
                        $follower_id_list[] = $relation_info->user_id;
                    }
                }
            }
        }
        if(!empty($follower_id_list))
        {
            $pending_follower_list = $this->follower_model->get_users($follower_id_list)->result();
        }
        return $pending_follower_list;
    }
    
    public function get_user_followers($user_id)
    {
        
    }
    
    public function get_blocked_followers($user_id)
    {
        $blocked_follower_list = array();  
        $follower_id_list = array();
        $user_mutual_relation_array = $this->follower_model->get_user_mutual_relations($user_id)->result_array();
        if(!empty($user_mutual_relation_array))
        {
            $user_mutual_relation = $user_mutual_relation_array[0];
            $relations = $user_mutual_relation['relations'];
            if( $relations != "" && $relations != NULL )
            {
                $relations_array = json_decode($relations);
                foreach($relations_array as $relation_info)
                {
                    if($relation_info->blocks == 1 && $relation_info->is_blocked == 1 && !in_array($relation_info->user_id, $follower_id_list))
                    {
                        $follower_id_list[] = $relation_info->user_id;
                    }
                }
            }
        }
        if(!empty($follower_id_list))
        {
            $blocked_follower_list = $this->follower_model->get_users($follower_id_list)->result();
        }
        return $blocked_follower_list;
    }

}

?>
