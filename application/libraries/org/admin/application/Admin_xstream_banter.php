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
class Admin_xstream_banter {
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
    
    public function get_all_teams()
    {
        $team_list = array();
        $team_list_array = $this->admin_xstream_banter_model->get_all_teams()->result_array();
        foreach($team_list_array as $team)
        {
            $team['created_on'] = date("d-m-Y H:i A",$team['created_on']);
            $team_list[] = $team;
        }
        return $team_list;
    }
    
    public function get_all_teams_not_in_tournament($tournament_id)
    {
        $team_list = array();
        $team_list_array = $this->admin_xstream_banter_model->get_all_teams_teams_tournaments()->result_array();
        foreach($team_list_array as $team)
        {
            if($team['tournament_id'] != $tournament_id)
            {
                $team['created_on'] = unix_to_human($team['created_on']);
                $team_list[] = $team;
            }            
        }
        return $team_list;
    }
    
    public function get_all_teams_tournament($tournament_id)
    {
        $team_list = array();
        $team_list_array = $this->admin_xstream_banter_model->get_all_teams_tournament($tournament_id)->result_array();
        foreach($team_list_array as $team)
        {
            $team['created_on'] = date("d-m-Y H:i A",$team['created_on']);
            $team_list[] = $team;
        }
        return $team_list;
    }
    
    public function get_team($team_id)
    {
        $team_list = array();
        $team_list_array = $this->admin_xstream_banter_model->get_team($team_id)->result_array();
        foreach($team_list_array as $team)
        {
            $team['created_on'] = date("d-m-Y H:i A",$team['created_on']);
            $team_list[] = $team;
        }
        return $team_list;
    }    
    
}

?>
