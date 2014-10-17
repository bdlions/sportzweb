<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  dataprovider Model
 *
 * Author:  alamgir kabir
 *
 *
 * Requirements: PHP5 or above
 *
 */
class Basic_Profile_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }

    public function get_profile_id($user_id = 0){
        if($user_id <= 0){
            $user_id = $this->ion_auth->get_user_id();
        }
        $query = $this->db->select('id')
                        ->where('user_id', $user_id)
                        ->get($this->tables['basic_profile']);
        if($query->num_rows() <= 0){
            return -1;
        }
        else{
            $result = $query->row();
            return $result->{'id'};
        }
    }
    public function get_general_info($user_id = 0){
        if($user_id <= 0){
            $user_id = $this->ion_auth->get_user_id();
        }
        
        $query = $this->db->select('email, first_name, last_name, middle_name')
                ->where('id', $user_id)
                ->limit(1)
                ->get($this->tables['users']);

        $general_info = array();
        if ($query->num_rows() == 1) {
            $general_info = $query->row();
        }
        else{
            return FALSE;
        }
        
        return $general_info;
    }
    
    public function get_profile_info($user_id = 0){
        if($user_id <= 0){
            $user_id = $this->ion_auth->get_user_id();
        }
        
        
        $query = $this->db->select('*')
                ->where($this->tables['basic_profile'].'.user_id', $user_id)
                ->join($this->tables['users'], $this->tables['users'] . '.id' . '=' . $this->tables['basic_profile'] . '.user_id')
                ->limit(1)
                ->get($this->tables['basic_profile']);
        /*$query = $this->db->select($this->tables['countries'] .'.`country_name` as country_name,'.$this->tables['gender'] .'.`gender_name` as gender_name,'.$this->tables['basic_profile'] .'.`id` as id, home_town,clg_or_uni,employer,gender_id,dob,country_id,photo,fav_team,fav_player' )
                        ->where($this->tables['basic_profile'] . '.`id`', $profile_id)
                        ->join($this->tables['gender'], $this->tables['basic_profile'] . '.' . $this->join['gender'] . '=' . $this->tables['gender'] . '.id')
                        ->join($this->tables['countries'], $this->tables['basic_profile'] . '.' . $this->join['countries'] . '=' . $this->tables['countries'] . '.id')
                        ->get($this->tables['basic_profile']);*/
        $profile_info = array();
        if ($query->num_rows() == 1) {
            $profile_info = $query->row();
        }
        else{
            return FALSE;
        }
        
        return $profile_info;
    }
    
    public function get_profile_list($user_id_list){
        if(empty($user_id_list))
        {
            return false;
        }
        $this->db->where_in($this->tables['users'].'.id',$user_id_list);
        $query = $this->db->select('*')
                ->join($this->tables['users'], $this->tables['users'] . '.id' . '=' . $this->tables['basic_profile'] . '.user_id')
                ->get($this->tables['basic_profile']);
        $profile_info = array();
        if ($query->num_rows() >= 1) {
            return $query->result();
        }
        else{
            return FALSE;
        }
    }
    
    public function create_profile($profile_data){
        $this->trigger_events('update_profile');

        if (!isset($profile_data['user_id']) || $profile_data['user_id'] <= 0) {
            $this->set_error('update_profile_unsuccessful');
            return FALSE;
        }
        
        //by default there will be 7 applicaitons for each user
        $app_list = array();
        $xb_info = new stdClass();
        $xb_info->id = APPLICATION_XSTREAM_BANTER_ID;        
        $app_list[] = $xb_info;
        $hr_info = new stdClass();
        $hr_info->id = APPLICATION_HEALTYY_RECIPES_ID;        
        $app_list[] = $hr_info;
        $sd_info = new stdClass();
        $sd_info->id = APPLICATION_SERVICE_DIRECTORY_ID;        
        $app_list[] = $sd_info;
        $news_info = new stdClass();
        $news_info->id = APPLICATION_NEWS_APP_ID;        
        $app_list[] = $news_info;
        $blog_info = new stdClass();
        $blog_info->id = APPLICATION_BLOG_APP_ID;        
        $app_list[] = $blog_info;
        $bmi_info = new stdClass();
        $bmi_info->id = APPLICATION_BMI_CALCULATOR_ID;        
        $app_list[] = $bmi_info;
        $pg_info = new stdClass();
        $pg_info->id = APPLICATION_PHOTOGRAPHY_ID;        
        $app_list[] = $pg_info;
        $profile_data['application_list'] = json_encode($app_list);
        
        $profile_data = $this->_filter_data($this->tables['basic_profile'], $profile_data);

        $this->trigger_events('extra_where');
        $this->db->insert($this->tables['basic_profile'], $profile_data);

        return $this->db->insert_id() >= 0;
    }
    
    public function update_profile($profile_data, $profile_id = 0){
        $this->trigger_events('update_profile');

        if($profile_id <= 0){
            $profile_id = $this->get_profile_id();
        }

        $data = array(
            'id' => $profile_id
        );

        $profile_data = array_merge($this->_filter_data($this->tables['basic_profile'], $profile_data), $data);
        $this->trigger_events('extra_where');
        $this->db->update($this->tables['basic_profile'], $profile_data, array('id' => $profile_id));

        $return = $this->db->affected_rows() >= 0;
        if ($return){
            $this->set_message('update_profile_successful');
        }
        else{
            $this->set_error('update_profile_unsuccessful');
        }

        return $return;
    }
    
    /*
     * This method will update profile info of a user
     * @param $profile_data, profile data to be updated
     * @param $user_id, user id
     * @Author Nazmul on 12th July 2014
     */
    public function update_profile_info($profile_data, $user_id = 0){
        $this->trigger_events('update_profile');

        if($user_id == 0){
            $user_id = $this->session->userdata('user_id');
        }
        $profile_data = $this->_filter_data($this->tables['basic_profile'], $profile_data);
        $this->trigger_events('extra_where');
        $this->db->update($this->tables['basic_profile'], $profile_data, array('user_id' => $user_id));
        $result = $this->db->affected_rows() >= 0;
        if ($result){
            $this->set_message('update_profile_successful');
        }
        else{
            $this->set_error('update_profile_unsuccessful');
        }
        return $result;
    }
    
    
}
