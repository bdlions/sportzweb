<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name:  Admin Privacy Model
 * Author:  Nazmul Hasan
 * Requirements: PHP5 or above
 */
class Admin_privacy_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    /*
     * This method will return privacy info
     * @Author Nazmul on 25th January 2015
     */
    public function get_privacy_info()
    {
      return $this->db->select($this->tables['footer_privacy'] . '.*')
                        ->from($this->tables['footer_privacy'])
                        ->get();  
    }
    /*
     * This method will update privacy info
     * @Author Nazmul on 25th January 2015
     */
    public function update_privacy_info($data)
    {
        $data['modified_on'] = now();
        $data = $this->_filter_data($this->tables['footer_privacy'], $data);
        $this->db->update($this->tables['footer_privacy'], $data);
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_privacy_fail');
            return FALSE;
        }
        $this->set_message('update_privacy_successful');
        return TRUE;
    }
}