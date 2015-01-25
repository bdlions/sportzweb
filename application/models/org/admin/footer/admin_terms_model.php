<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Name:  Admin Terms Model
 * Author:  Nazmul Hasan
 * Requirements: PHP5 or above
 */
class Admin_terms_model extends Ion_auth_model {

    public function __construct() {
        parent::__construct();
    }
    /*
     * This method will return terms info
     * @Author Nazmul on 25th January 2015
     */
    public function get_terms_info()
    {
      return $this->db->select($this->tables['footer_terms'].'.*')
                    ->from($this->tables['footer_terms'])
                    ->get();   
    }
    /*
     * This method will update terms info
     * @Author Nazmul on 25th January 2015
     */
    public function update_terms_info($data)
    {
        $data['modified_on'] = now();
        $data = $this->_filter_data($this->tables['footer_terms'], $data);
        $this->db->update($this->tables['footer_terms'], $data);
        if ($this->db->trans_status() === FALSE) {
            $this->set_error('update_terms_fail');
            return FALSE;
        }
        $this->set_message('update_terms_successful');
        return TRUE;
        
    }
}