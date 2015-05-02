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
class Statuses_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }

    /*
     * This method will return status info
     * @param $status_id, status id
     * @Author Nazmul on 3rd May 2014 
     */

    public function get_status_info($status_id) {
        $this->db->where('id', $status_id);
        $this->response = $this->db->select('*')
                ->from($this->tables['statuses'])
                ->get();
        return $this;
    }

    /*
     * This method will update status
     * @param $status_id, status id
     * @param $additional_data, status data to be updated
     * @Author Nazmul on 3rd May 2014 
     */

    public function update_status($status_id, $additional_data) {
        $status_data = $this->_filter_data($this->tables['statuses'], $additional_data);
        $this->db->where('id', $status_id);
        return $this->db->update($this->tables['statuses'], $status_data);
    }

    public function post_status($additional_data) {
        $current_time = now();
        $data = array(
            'created_on' => $current_time,
            'modified_on' => $current_time
        );
        $status_data = array_merge($this->_filter_data($this->tables['statuses'], $additional_data), $data);
        $this->db->insert($this->tables['statuses'], $status_data);
        $id = $this->db->insert_id();
        return (isset($id)) ? $id : FALSE;
    }

    /*
     * This method will return status list
     * @param $status_id_list, list of status id. If the list is assigned then status under this list will be returned
     */

    public function get_statuses($status_category_id = STATUS_LIST_NEWSFEED, $mapping_id = 0, $limit = STATUS_LIMIT_PER_REQUEST, $offset = 0, $filtered_user_id_list = array(), $status_id_list = array()) {
        $user_id = $this->session->userdata('user_id');
        if (empty($status_id_list)) {
            if ($status_category_id == STATUS_LIST_NEWSFEED) {
                $this->db->where_in($this->tables['statuses'] . '.user_id', $filtered_user_id_list);
                //by default adding admin statuses
                $this->db->or_where($this->tables['statuses'] . '.user_id', ADMIN_USER_ID);
            } else if ($status_category_id == STATUS_LIST_USER_PROFILE) {
                $this->db->where($this->tables['statuses'] . '.status_category_id', $status_category_id);
                $this->db->where($this->tables['statuses'] . '.mapping_id', $mapping_id);
                $this->db->where_in($this->tables['statuses'] . '.user_id', $filtered_user_id_list);
                if($mapping_id == $user_id)
                {
                    //by default adding admin statuses
                    $this->db->or_where($this->tables['statuses'] . '.user_id', ADMIN_USER_ID);
                }                
            } else if ($status_category_id == STATUS_LIST_BUSINESS_PROFILE) {
                $this->db->where($this->tables['statuses'] . '.status_category_id', $status_category_id);
                $this->db->where($this->tables['statuses'] . '.mapping_id', $mapping_id);
            }
            //$this->db->where($this->tables['statuses'].'.user_id',$user_id);
            //$this->db->limit($limit, $offset);
        } else {
            $this->db->where_in($this->tables['statuses'] . '.id', $status_id_list);
        }
        if (isset($limit) && $limit > 0) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->tables['statuses'] . '.modified_on', 'desc');

        $result = $this->db->select($this->tables['statuses'] . '.id as status_id,' . $this->tables['statuses'] . '.modified_on as status_modified_on,' . $this->tables['statuses'] . '.created_on as status_created_on,' . $this->tables['statuses'] . '.*,' . $this->tables['users'] . '.*,' . $this->tables['basic_profile'] . '.*')
                ->from($this->tables['statuses'])
                ->join($this->tables['users'], $this->tables['users'] . '.id=' . $this->tables['statuses'] . '.user_id')
                ->join($this->tables['basic_profile'], $this->tables['users'] . '.id=' . $this->tables['basic_profile'] . '.user_id')
                ->get();
        return $result;
    }

    /*
     * This method will return user info with basic profile info
     * @param $user_id_list, list of user ids
     * @Author Nazmul on 3rd March 2014
     */

    public function get_users($user_id_list) {
        $this->db->where_in($this->tables['users'] . '.id', $user_id_list);
        $result = $this->db->select($this->tables['users'] . '.id as user_id,' . $this->tables['users'] . '.*,' . $this->tables['basic_profile'] . '.*')
                ->from($this->tables['users'])
                ->join($this->tables['basic_profile'], $this->tables['users'] . '.id=' . $this->tables['basic_profile'] . '.user_id')
                ->get();
        return $result;
    }

    public function get_user_mutual_relation_info($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->select('*')
                        ->from($this->tables['usres_mutual_relations'])
                        ->get();
    }

    /*
     * This method will return recipe list
     * @param $recipe_id_list, list of recipe ids
     * @Author Nazmul on 8th March 2014
     */

    public function get_recipes($recipe_id_list) {
        $this->db->where_in('id', $recipe_id_list);
        return $this->db->select('*')
                        ->from($this->tables['recipes'])
                        ->get();
    }

    /*
     * @Author Rashida on 21 April
     * this method return selected recipes less then or equal to current date 
     */

    public function get_recipe_selection($date = 0) {
        $this->db->order_by('selected_date','desc');
        $this->db->order_by('id','desc');
        $this->db->where($this->tables['recipe_selection'] . '.selected_date <=', $date);
        return $this->db->select("*")
                        ->from($this->tables['recipe_selection'])
                        ->get();
    }

    /*
     * This method will return service list
     * @param $service_id_list, list of service ids
     * @Author Nazmul on 8th March 2014
     */

    public function get_services($service_id_list) {
        $this->db->where_in('id', $service_id_list);
        return $this->db->select('*')
                        ->from($this->tables['services'])
                        ->get();
    }

    /*
     * This method will return news list
     * @param $news_id_list, list of news ids
     * @Author Nazmul on 8th March 2014
     */

    public function get_news($news_id_list) {
        $this->db->where_in('id', $news_id_list);
        return $this->db->select('*')
                        ->from($this->tables['news'])
                        ->get();
    }

    /*
     * This method will return approved blogs based on block status id
     * @author Rashida on 21th April 2015
     */

    public function get_approved_blogs($approved) {
        $this->db->where_in('blog_status_id', $approved);
        return $this->db->select($this->tables['blogs'] . '.id as blog_id,')
                        ->from($this->tables['blogs'])
                        ->order_by('id', 'desc')
                        ->limit(4)
                        ->get();
    }

    /*
     * This method will return photo list
     * @param $photo_id_list, list of photo ids
     * @Author Nazmul on 19th July 2014
     */

    public function get_photos($photo_id_list) {
        $this->db->where_in($this->tables['albums_photos'] . '.id', $photo_id_list);
        $result = $this->db->select($this->tables['albums_photos'] . '.id as photo_id,' . $this->tables['albums_photos'] . '.img,' . $this->tables['users'] . '.id as user_id,' . $this->tables['users'] . '.*')
                ->from($this->tables['albums_photos'])
                ->join($this->tables['albums'], $this->tables['albums'] . '.id=' . $this->tables['albums_photos'] . '.album_id')
                ->join($this->tables['users'], $this->tables['albums'] . '.reference_id=' . $this->tables['users'] . '.id')
                ->get();
        return $result;
    }

    public function delete_status($status_id) {
        $this->db->where('id', $status_id);
        $this->db->delete($this->tables['statuses']);
        if ($this->db->affected_rows() == 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function get_latest_photography_default_status()
    {
        return $this->db->select($this->tables['photography'] . '.*')
                    ->from($this->tables['photography'])
                    ->order_by('id', 'desc')
                    ->limit(1)
                    ->get();
    }

}

?>
