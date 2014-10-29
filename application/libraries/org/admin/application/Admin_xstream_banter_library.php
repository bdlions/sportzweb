<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Admin Xstream Banter Library
 *
 * Author: @Nazmul
 * 
 * Requirements: PHP5 or above
 *
 */
class Admin_xstream_banter_library {
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');
        $this->load->library('org/utility/utils');
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
                        $this->load->model('org/admin/application/admin_xstream_banter_model');

        $this->admin_xstream_banter_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->admin_xstream_banter_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in admin_xstream_banter_model');
        }

        return call_user_func_array(array($this->admin_xstream_banter_model, $method), $arguments);
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
    
    public function get_all_matches($tournament_id)
    {
        $match_list = array();
        $match_list_array = $this->admin_xstream_banter_model->get_all_matches($tournament_id)->result_array();
        foreach($match_list_array as $match_info)
        {
            $match_info['date'] = $this->utils->convert_date_from_yyyymmdd_to_ddmmyyyy($match_info['date']);
            $match_list[] = $match_info;
        }
        return $match_list;
    }
    
    public function process_imported_match($match_data)
    {
        $sports_title = $match_data['sports'];
        $tournament_title = $match_data['tournament'];
        $season = $match_data['season'];
        $home_team_title = $match_data['home_team'];
        $away_team_title = $match_data['away_team'];
        $date = $match_data['date'];
        $time = $match_data['time'];
        
        $sports_id = 0;
        $sports_id_array = $this->admin_xstream_banter_model->get_sports_id($sports_title)->result_array();
        if(!empty($sports_id_array))
        {
            $sports_id = $sports_id_array[0]['sports_id'];
        }
        else
        {
            $sports_id = $this->admin_xstream_banter_model->create_sports(array('title' => $sports_title));
        }
        if($sports_id <= 0)
        {
            return FALSE;
        }
        
        $tournament_id = 0;
        $tournament_id_array = $this->admin_xstream_banter_model->get_tournament_id($tournament_title, $season)->result_array();
        if(!empty($tournament_id_array))
        {
            $tournament_id = $tournament_id_array[0]['tournament_id'];
        }
        else
        {
            $additional_data = array(
                'title' => $tournament_title,
                'sports_id' => $sports_id,
                'season' => $season,
                'created_on' => now()
            );
            $tournament_id = $this->admin_xstream_banter_model->create_tournament($additional_data);
        }
        if($tournament_id <= 0)
        {
            return FALSE;
        }
        
        $team_id_home = 0;
        $home_team_id_array = $this->admin_xstream_banter_model->get_team_id($home_team_title)->result_array();
        if(!empty($home_team_id_array))
        {
            $team_id_home = $home_team_id_array[0]['team_id'];
        }
        else
        {
            $home_team_data = array(
                'title' => $home_team_title,
                'sports_id' => $sports_id
            );
            $team_id_home = $this->admin_xstream_banter_model->create_team($home_team_data);
        }
        if($team_id_home <= 0)
        {
            return FALSE;
        }
        
        $team_id_away = 0;
        $away_team_id_array = $this->admin_xstream_banter_model->get_team_id($away_team_title)->result_array();
        if(!empty($away_team_id_array))
        {
            $team_id_away = $away_team_id_array[0]['team_id'];
        }
        else
        {
            $away_team_data = array(
                'title' => $away_team_title,
                'sports_id' => $sports_id
            );
            $team_id_away = $this->admin_xstream_banter_model->create_team($away_team_data);
        }
        if($team_id_away <= 0)
        {
            return FALSE;
        }
        
        $additional_data = array(
            'tournament_id' => $tournament_id,
            'team_id_home' => $team_id_home,
            'team_id_away' => $team_id_away,
            'date' => $date,
            'time' => $time
        );
        $match_id = $this->admin_xstream_banter_model->create_match($additional_data);
        if($match_id !== FALSE)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }        
    }
    
}

?>
