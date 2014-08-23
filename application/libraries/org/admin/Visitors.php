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
class Visitors {
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
                        $this->load->model('org/admin/visitors_model');

        $this->visitors_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->visitors_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in visitors_model');
        }

        return call_user_func_array(array($this->visitors_model, $method), $arguments);
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
    
    public function get_most_visited_pages($counter, $user_id = 0)
    {
        //
        $page_visit=array();
        if($user_id!=0){
            $data = $this->visitors_model->get_page_visitor_list(0,$user_id)->result_array();
        
            $length = count($data);
            
            for($i=0;$i<$length;$i++){
                $visit_count = count(json_decode($data[$i]['access_history']));
                $data[$i]['access_count'] = $visit_count;
            }
        }
        else{
            $data = $this->visitors_model->get_page_visitor_list()->result_array();
            $page = $this->visitors_model->get_all_pages()->result_array();
//            echo '<pre/>';print_r($data);exit;
            $data_array = array();
            $filtered_array = array();
            $length= count($data);
            $k=0;
            for($i=0;$i<count($page);$i++)
            {
                $data_array[$i]['access_count']=0;
                $data_array[$i]['title'] = $page[$i]['title'];
                $data_array[$i]['page_id'] = $page[$i]['id'];
                
                for($j=0;$j<$length;$j++)
                {
                    if($page[$i]['id'] == $data[$j]['page_id'])
                    {
                        $visit_count = count(json_decode($data[$j]['access_history']));
                    
                        $data_array[$i]['access_count']+=$visit_count;
                    }
                }
                if($data_array[$i]['access_count']!=0){
                    $filtered_array[$k++] = $data_array[$i];
                }
            }
            //print_r($filtered_array);exit;
            $data = $filtered_array;
            //echo '<pre/>';print_r($data_array);exit;
        }
        
        
        
        //echo '<pre/>';print_r($data);exit;
        
        $length = count($data);
        for($i=0;$i<$length;$i++)
        {
            $mx =0;$id=0;$array_index=0;
            for($j=0;$j<$length;$j++)
            {
                if($data[$j]['access_count']>$mx){
                    $mx = $data[$j]['access_count'];
                    $id = $data[$j]['page_id'];
                    $array_index=$j;
                }
            }
            array_push($page_visit,$data[$array_index]['title']);
            $data[$array_index]['access_count']=0;
            $counter--;
            if($counter==0) break;
        }
        
        return $page_visit;
    }
    
    public function get_most_visited_applications($counter, $user_id = 0)
    {
        //
        $application_visit=array();
        if($user_id!=0){
            $data = $this->visitors_model->get_application_visitor_list(0,$user_id)->result_array();
        
            $length = count($data);
            
            for($i=0;$i<$length;$i++){
                $visit_count = count(json_decode($data[$i]['access_history']));
                $data[$i]['access_count'] = $visit_count;
            }
        }
        else{
            $data = $this->visitors_model->get_application_visitor_list()->result_array();
            $page = $this->visitors_model->get_all_applications()->result_array();
            
            $data_array = array();
            $filtered_array = array();
            $length= count($data);
            $k=0;
            for($i=0;$i<count($page);$i++)
            {
                $data_array[$i]['access_count']=0;
                $data_array[$i]['title'] = $page[$i]['title'];
                $data_array[$i]['application_id'] = $page[$i]['id'];
                
                for($j=0;$j<$length;$j++)
                {
                    if($page[$i]['id'] == $data[$j]['application_id'])
                    {
                        $visit_count = count(json_decode($data[$j]['access_history']));
                    
                        $data_array[$i]['access_count']+=$visit_count;
                    }
                }
                if($data_array[$i]['access_count']!=0){
                    $filtered_array[$k++] = $data_array[$i];
                }
            }
            $data = $filtered_array;
            //echo '<pre/>';print_r($data_array);exit;
        }
        
        
        
        //echo '<pre/>';print_r($data);exit;
        
        $length = count($data);
        for($i=0;$i<$length;$i++)
        {
            $mx =0;$id=0;$array_index=0;
            for($j=0;$j<$length;$j++)
            {
                if($data[$j]['access_count']>$mx){
                    $mx = $data[$j]['access_count'];
                    $id = $data[$j]['application_id'];
                    $array_index=$j;
                }
            }
            array_push($application_visit,$data[$array_index]['title']);
            $data[$array_index]['access_count']=0;
            $counter--;
            if($counter==0) break;
        }
        
        return $application_visit;
    }
    
    public function get_most_visited_business_profiles($counter, $user_id = 0)
    {
        //
        $application_visit=array();
        if($user_id!=0){
            $data = $this->visitors_model->get_business_profile_visitor_list(0,$user_id)->result_array();
        
            $length = count($data);
            
            for($i=0;$i<$length;$i++){
                $visit_count = count(json_decode($data[$i]['access_history']));
                $data[$i]['access_count'] = $visit_count;
            }
        }
        else{
            $data = $this->visitors_model->get_business_profile_visitor_list()->result_array();
            $page = $this->visitors_model->get_all_business_profile()->result_array();
            
            $data_array = array();
            $filtered_array = array();
            $length= count($data);
            $k=0;
            for($i=0;$i<count($page);$i++)
            {
                $data_array[$i]['access_count']=0;
                $data_array[$i]['business_name'] = $page[$i]['business_name'];
                $data_array[$i]['business_profile_id'] = $page[$i]['id'];
                
                for($j=0;$j<$length;$j++)
                {
                    if($page[$i]['id'] == $data[$j]['business_profile_id'])
                    {
                        $visit_count = count(json_decode($data[$j]['access_history']));
                    
                        $data_array[$i]['access_count']+=$visit_count;
                    }
                }
                
                if($data_array[$i]['access_count']!=0){
                    $filtered_array[$k++] = $data_array[$i];
                }
            }
            $data = $filtered_array;
            //echo '<pre/>';print_r($data_array);exit;
        }
        
        
        
        //echo '<pre/>';print_r($data);exit;
        
        $length = count($data);
        for($i=0;$i<$length;$i++)
        {
            $mx =0;$id=0;$array_index=0;
            for($j=0;$j<$length;$j++)
            {
                if($data[$j]['access_count']>$mx){
                    $mx = $data[$j]['access_count'];
                    $id = $data[$j]['business_profile_id'];
                    $array_index=$j;
                }
            }
            array_push($application_visit,$data[$array_index]['business_name']);
            $data[$array_index]['access_count']=0;
            $counter--;
            if($counter==0) break;
        }
        
        return $application_visit;
    }
    
    public function get_page_visitors()
    {
        $result = array();
        $page_id_list = array();
        $page_visitors_array = $this->visitors_model->get_page_visitors()->result_array();
        foreach($page_visitors_array as $page_visitors)
        {
            if(!in_array($page_visitors['page_id'], $page_id_list))
            {
                $result[$page_visitors['page_id']] = array();
                $result[$page_visitors['page_id']]['page_name'] = $page_visitors['title'];
                $result[$page_visitors['page_id']]['total_male_members'] = 0;
                $result[$page_visitors['page_id']]['total_female_members'] = 0;
                $page_id_list[] = $page_visitors['page_id'];                
            }
            if($page_visitors['gender_id'] == 1)
            {
                $result[$page_visitors['page_id']]['total_male_members'] = $page_visitors['total_users'];
            }
            else if($page_visitors['gender_id'] == 2)
            {
                $result[$page_visitors['page_id']]['total_female_members'] = $page_visitors['total_users'];
            }
        }
        return $result;
    }
    
}

?>
