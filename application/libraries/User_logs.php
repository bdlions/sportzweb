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
class User_logs {
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->load->library('email');
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
                        $this->load->model('user_logs_model');

        $this->user_logs_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->user_logs_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in user_logs_model');
        }

        return call_user_func_array(array($this->user_logs_model, $method), $arguments);
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
    
    public function store_user_log($user_id =0, $date = 0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        if($date == 0)
        {
            $date = date('Y-m-d');
        }
        $session_id = $this->session->userdata('session_id');
        $data = $this->user_logs_model->get_user_log_list($user_id,$date)->result_array();
        
        if(empty($data))
        {
            $data = new stdClass();
            $data->session = $session_id;
            $data->login_time = now();
            
            $data = json_encode(array($data));
            $data = array(
              'log_history' => $data  
            );
            $id = $this->user_logs_model->add_user_log($user_id, $date, $data);
            
        }
        else
        {
            
            $data = $data[0];
            $data = $data['log_history'];
            $data = json_decode($data);
            
            $data1 = new stdClass();            
            $data1->session = $session_id;
            $data1->login_time = now();            
            array_push($data,$data1);
            
            $data = json_encode($data);
            $data = array('log_history'=>$data);
            
            $this->user_logs_model->update_user_log($user_id, $date, $data);
            
        }
        
    }
    
    public function update_user_log_by_logout($user_id=0,$date=0)
    {
        if($user_id == 0)
        {
            $user_id = $this->session->userdata('user_id');
        }
        if($date == 0)
        {
            $date = date('Y-m-d');
        }
        
        $session_id = $this->session->userdata('session_id');
        $data = $this->user_logs_model->get_user_log_list($user_id,$date)->result_array();
        if(!empty($data)){
            $data = $data[0];
            $data = $data['log_history'];
            $data = json_decode($data);
        
            $length = count($data);
            for($i=0;$i<$length;$i++)
            {
                if($data[$i]->session == $session_id)
                {
                    $data[$i]->logout_time = now();
                    break;
                }
            }
            $data = json_encode($data);        
            $data = array('log_history' => $data);
        }
        $this->user_logs_model->update_user_log($user_id,$date,$data);
    }
    
    public function get_total_user_log_by_day($date=0)
    {
        if($date!=0){
            $data_list = $this->user_logs_model->get_total_user_log_by_day($date)->result_array();
        }
        else
        {
            $data_list = $this->user_logs_model->get_total_user_log_by_day()->result_array();
        }
        $data_array = array();
        foreach($data_list as $data)
        {
            $data['created_on'] = unix_to_human($data['created_on']);
            $data['last_login'] = unix_to_human($data['last_login']);
            $data_array[] = $data;
        }
        
        return $data_array;
        
    }
    
    public function get_total_user_log_by_this_week($date)
    {
        $data_list = $this->user_logs_model->get_total_user_log_by_this_week($date)->result_array();
        $data_array = array();
        foreach($data_list as $data)
        {
            $data['created_on'] = unix_to_human($data['created_on']);
            $data['last_login'] = unix_to_human($data['last_login']);
            $data_array[] = $data;
        }
        
        return $data_array;
        
    }
    
    public function get_total_user_log_between_dates($date1,$date2)
    {
        $data_list = $this->user_logs_model->get_total_user_log_between_dates($date1,$date2)->result_array();
        
        $data_array = array();
        foreach($data_list as $data)
        {
            $data['created_on'] = unix_to_human($data['created_on']);
            $data['last_login'] = unix_to_human($data['last_login']);
            $data_array[] = $data;
        }
        
        return $data_array;
    }
    
    public function user_login_info($user_id)
    {
        $user_log = $this->user_logs_model->get_user_log_list($user_id)->result_array();
        
        $total_time = 0;
        $login_time = 0;
        $total_login = 0;
        $add=0;
        foreach($user_log as $user)
        {
            $log_data = json_decode($user['log_history']);
            $total_login += count($log_data);
            foreach($log_data as $data)
            {
                if(property_exists($data, 'logout_time')){
                    $total_time += $data->logout_time - $data->login_time;
                    $login_time = $data->login_time;
                    $add++;
                }
            }
        }
        $data = array();
        if($add>0){
            $total_time = $total_time/$add;
        }
        $data['average_hour'] = round($total_time/3600);
        $total_time %= 3600;
        $data['average_minute'] = round($total_time/60);
        
        $data['total_login'] = $total_login;
        $data['last_login'] = unix_to_human($login_time);
        
        return $data;
    }
    
}

?>
