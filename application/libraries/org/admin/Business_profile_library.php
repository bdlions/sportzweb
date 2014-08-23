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
class Business_profile_library {
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
                        $this->load->model('org/admin/business_profile_model');

        $this->business_profile_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->business_profile_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in business_profile_model');
        }

        return call_user_func_array(array($this->business_profile_model, $method), $arguments);
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
    
    public function get_business_profile_connection_list($id=0)
    {
        if($id!=0){
            $business_profile = $this->business_profile_model->get_business_profile_connection_list($id)->result_array();
            
        }else{
            $business_profile = $this->business_profile_model->get_business_profile_connection_list()->result_array();
        }
        
        for($i=0;$i<count($business_profile);$i++)
        {
            $business_profile[$i]['connected_user_list'] = json_decode($business_profile[$i]['connected_user_list']);
            $business_profile[$i]['male'] = 0;
            $business_profile[$i]['female'] = 0;
            $len = count($business_profile[$i]['connected_user_list']);
            
            for($j=0;$j<$len;$j++)
            {
                $data = $this->business_profile_model->get_user_info($business_profile[$i]['connected_user_list'][$j]->user_id)->result_array();
                
                $data = $data[0];
                if($data['gender_id']==1){ 
                    $business_profile[$i]['male']++;
                }
                else{
                    $business_profile[$i]['female']++;
                }
            }
            $business_profile[$i]['connected_user_list'] = $len;
        }
        
        return $business_profile;
    }
    
    public function get_total_business_profile_connection_user($user_id)
    {
        $business_profile_list = $this->business_profile_model->get_all_business_profile_list()->result_array();
        
        $total_connection = 0;
        foreach($business_profile_list as $profile)
        {
            $user_list = $this->business_profile_model->get_business_profile_connection_list($profile['id'])->result_array();
            
            if(!empty($user_list))
            {
                $user_list = $user_list[0];
                
                $user_list = json_decode($user_list['connected_user_list']);
                foreach($user_list as $user)
                {
                    if($user->user_id==$user_id){ $total_connection++; break;}
                }
            }
        }
        
        return $total_connection;
    }
}

?>
