<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Admin Score Prediction Library
 *
 * Author: @Nazmul
 * 
 * Requirements: PHP5 or above
 *
 */
class Admin_score_prediction_library {

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
                        $this->load->model('org/admin/application/admin_score_prediction_model');

        $this->admin_score_prediction_model->trigger_events('library_constructor');
    }

    /**
     * __call
     *
     * Acts as a simple way to call model methods without loads of stupid alias'
     *
     * */
    public function __call($method, $arguments) {
        if (!method_exists($this->admin_score_prediction_model, $method)) {
            throw new Exception('Undefined method ::' . $method . '() called in admin_score_prediction_model');
        }

        return call_user_func_array(array($this->admin_score_prediction_model, $method), $arguments);
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

    public function get_all_matches($tournament_id) {
        $match_list = array();
        $match_list_array = $this->admin_score_prediction_model->get_all_matches($tournament_id)->result_array();
        foreach ($match_list_array as $match_info) {
            $match_info['date'] = $this->utils->convert_date_from_yyyymmdd_to_ddmmyyyy($match_info['date']);
            $match_list[] = $match_info;
        }
        return $match_list;
    }

    public function process_imported_match($match_data) {
        $sports_title = $match_data['sports'];
        $tournament_title = $match_data['tournament'];
        $season = $match_data['season'];
        $home_team_title = $match_data['home_team'];
        $away_team_title = $match_data['away_team'];
        $date = $match_data['date'];
        $time = $match_data['time'];

        $sports_id = 0;
        $sports_id_array = $this->admin_score_prediction_model->get_sports_id($sports_title)->result_array();
        if (!empty($sports_id_array)) {
            $sports_id = $sports_id_array[0]['sports_id'];
        } else {
            $sports_id = $this->admin_score_prediction_model->create_sports(array('title' => $sports_title));
        }
        if ($sports_id <= 0) {
            return FALSE;
        }

        $tournament_id = 0;
        $tournament_id_array = $this->admin_score_prediction_model->get_tournament_id($tournament_title, $season)->result_array();
        if (!empty($tournament_id_array)) {
            $tournament_id = $tournament_id_array[0]['tournament_id'];
        } else {
            $additional_data = array(
                'title' => $tournament_title,
                'sports_id' => $sports_id,
                'season' => $season,
                'created_on' => now()
            );
            $tournament_id = $this->admin_score_prediction_model->create_tournament($additional_data);
        }
        if ($tournament_id <= 0) {
            return FALSE;
        }

        $team_id_home = 0;
        $home_team_id_array = $this->admin_score_prediction_model->get_team_id($home_team_title)->result_array();
        if (!empty($home_team_id_array)) {
            $team_id_home = $home_team_id_array[0]['team_id'];
        } else {
            $home_team_data = array(
                'title' => $home_team_title,
                'sports_id' => $sports_id
            );
            $team_id_home = $this->admin_score_prediction_model->create_team($home_team_data);
        }
        if ($team_id_home <= 0) {
            return FALSE;
        }

        $team_id_away = 0;
        $away_team_id_array = $this->admin_score_prediction_model->get_team_id($away_team_title)->result_array();
        if (!empty($away_team_id_array)) {
            $team_id_away = $away_team_id_array[0]['team_id'];
        } else {
            $away_team_data = array(
                'title' => $away_team_title,
                'sports_id' => $sports_id
            );
            $team_id_away = $this->admin_score_prediction_model->create_team($away_team_data);
        }
        if ($team_id_away <= 0) {
            return FALSE;
        }

        $additional_data = array(
            'tournament_id' => $tournament_id,
            'team_id_home' => $team_id_home,
            'team_id_away' => $team_id_away,
            'date' => $date,
            'time' => $time,
            'status_id' => MATCH_STATUS_UPCOMING
        );
        $match_id = $this->admin_score_prediction_model->create_match($additional_data);
        if ($match_id !== FALSE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_match_prediction($match_id, $status_id) {
        $match_prediction_info_array = array();
        $match_prediction_info_array = $this->admin_score_prediction_model->get_match_prediction($match_id)->result_array();
        if (!empty($match_prediction_info_array)) {
            $match_prediction_info = $match_prediction_info_array[0];
            $p_list = $match_prediction_info['prediction_list'];
            if ($p_list != NULL && $p_list != "") {
                $prediction_list = json_decode($p_list);
                foreach ($prediction_list as $prediction_info) {
                    if ($prediction_info->prediction_id == $status_id) {
                        $current_time = now();
                        $notification_info_list = new stdClass();
                        $notification_info_list->id = '';
                        $notification_info_list->created_on = $current_time;
                        $notification_info_list->modified_on = $current_time;
                        $notification_info_list->type_id = NOTIFICATION_WHILE_PREDICT_MATCH;
                        $notification_info_list->status = UNREAD_NOTIFICATION;
                        $notification_info_list->reference_id = $match_id;
                        $notification_info_list->reference_id_list = array();
                        $match_prediction_info_array = $this->admin_score_prediction_library->add_notification($prediction_info->user_id, $notification_info_list);
                    }
                }
            }
        }
    }

    public function add_notification($notified_user_id, $notification_info_list) {
        $total_notifications = 0;
        $notification_list = array();
        if ($notification_info_list->type_id != 0) {
            $notification_info_list->id = ++$total_notifications;
        }
        $notification_info_array = $this->admin_score_prediction_model->get_notification_list($notified_user_id)->result_array();
        if (!empty($notification_info_array)) {
            $notification_info = $notification_info_array[0];
            $n_list_array = json_decode($notification_info['list']);
            $isexist = FALSE;
            $notification_id = 0;
            if ($n_list_array != null && $n_list_array != "") {
                foreach ($n_list_array as $n_info) {
                    if ($n_info->type_id == $notification_info_list->type_id && $n_info->reference_id == $notification_info_list->reference_id) {
                        $isexist = TRUE;
                        if ($notification_info_list->reference_id_list != null) {
                            $n_info->reference_id_list[] = $notification_info_list->reference_id_list[0];
                        }
                        $n_info->modified_on = now();
                        $n_info->status = UNREAD_NOTIFICATION;
                    }
                    $notification_id = $n_info->id;
                    $notification_list[] = $n_info;
                }
            }
            if (!$isexist) {
                $notification_info_list->id = ++$notification_id;
                $notification_list[] = $notification_info_list;
            }
            $additional_data = array(
                'list' => json_encode($notification_list)
            );
            $response = $this->admin_score_prediction_model->update_notification($notified_user_id, $additional_data);
        } else {
            $notification_list[] = $notification_info_list;
            $additional_data = array(
                'user_id' => $notified_user_id,
                'list' => json_encode($notification_list)
            );
            $response = $this->admin_score_prediction_model->add_notification($notified_user_id, $additional_data);
        }
        return $response;
    }

}
