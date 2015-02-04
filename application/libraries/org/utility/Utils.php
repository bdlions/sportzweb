<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Utils
 * Requirements: PHP5 or above
 *
 */
class Utils {
    public function __construct() {
        $this->load->config('ion_auth', TRUE);
        $this->load->library('email');
        $this->load->library('image_lib');
        $this->lang->load('ion_auth');
        $this->load->helper('cookie');
        
        // Load the session, CI2 as a library, CI3 uses it as a driver
        if (substr(CI_VERSION, 0, 1) == '2') {
            $this->load->library('session');
        } else {
            $this->load->driver('session');
        }
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
    
    /*
     * This method will return current date for user end in DD-MM-YYYY format
     * @Author Nazmul on 14 June 2014
     */
    public function get_current_date($country_code = 'GB')
    {
        $time_zone_array = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code);
        $dateTimeZone = new DateTimeZone($time_zone_array[0]);
        $dateTime = new DateTime("now", $dateTimeZone);
        $unix_current_time = now() + $dateTime->getOffset();
        $human_current_time = unix_to_human($unix_current_time);
        $human_current_time_array= explode(" ", $human_current_time);
        $human_current_date = $human_current_time_array[0];
        $splited_date_content = explode("-", $human_current_date);
        return $splited_date_content[2].'-'.$splited_date_content[1].'-'.$splited_date_content[0];
    }
    
    /*
     * This method will return current date for database purpose in YYYY-MM-DD format
     * @Author rashida on 2nd  february 2015
     */
    public function get_current_date_db($country_code = 'GB')
    {
        $time_zone_array = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code);
        $dateTimeZone = new DateTimeZone($time_zone_array[0]);
        $dateTime = new DateTime("now", $dateTimeZone);
        $unix_current_time = now() + $dateTime->getOffset();
        $human_current_time = unix_to_human($unix_current_time);
        $human_current_time_array= explode(" ", $human_current_time);
        return  $human_current_time_array[0];
    }
    
    /*
     * This method will convert date from user end format to database format i.e. dd-mm-yyyy to yyyy-mm-dd format
     * If date is invalide then this method will return invalid date
     * @param $date, date to be converted
     * @Author Nazmul on 24 September 2014
     */
    public function convert_date_from_user_to_db($date)
    {
        $splited_date_content = explode("-", $date);
        if(count($splited_date_content) == 3)
        {
            return $splited_date_content[2].'-'.$splited_date_content[1].'-'.$splited_date_content[0];
        }
        else
        {
            return $date;
        }        
    }
    /*
     * This method will convert date from database format to user end format i.e. yyyy-mm-dd to dd-mm-yyyy format
     * If date is invalide then this method will return invalid date
     * @param $date, date to be converted
     * @Author Nazmul on 24 September 2014
     */
    public function convert_date_from_db_to_user($date)
    {
        $splited_date_content = explode("-", $date);
        if(count($splited_date_content) == 3)
        {
            return $splited_date_content[2].'-'.$splited_date_content[1].'-'.$splited_date_content[0];
        }
        else
        {
            return $date;
        }        
    }
    
    /*
     * This method will return human time of a unix time
     * @param $unix_time, unix time
     * @param $user_info, user info
     * @Author Nazmul on 22nd January 2015
     */
    public function get_unix_to_human_local($unix_time, $country_code = 'GB')
    {
        $time_zone_array = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code = 'GB');
        $dateTimeZone = new DateTimeZone($time_zone_array[0]);
        $dateTime = new DateTime("now", $dateTimeZone);
        return unix_to_human($unix_time + $dateTime->getOffset());
        
    }
    
    /*
     * This method will convert unix time into human date dd-mm-yyyy format
     * @param $unix_time, time in unix format
     * @param $show_minute, whether minute will be showed or not
     * @param $country_code, country code of this user
     * @Author Nazmul on 17 June 2014
     */
    public function get_unix_to_human_date($unix_time, $show_minute = 0, $country_code = 'GB')
    {
        $time_zone_array = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code);
        $dateTimeZone = new DateTimeZone($time_zone_array[0]);
        $dateTime = new DateTime("now", $dateTimeZone);
        $relative_unix_time = $unix_time + $dateTime->getOffset();
        $human_current_time = unix_to_human($relative_unix_time);
        $human_current_time_array= explode(" ", $human_current_time);
        $human_current_date = $human_current_time_array[0];
        $splited_date_content = explode("-", $human_current_date);
        if($show_minute == 1)
        {
            return $splited_date_content[2].'-'.$splited_date_content[1].'-'.$splited_date_content[0].' '.$human_current_time_array[1];
        }
        else
        {
            return $splited_date_content[2].'-'.$splited_date_content[1].'-'.$splited_date_content[0];
        }
        
    }
    
    /*
     * This method will return current date in YYYY-mm-dd format
     * @Author Nazmul on 24 September 2014
     */
    public function get_current_date_yyyymmdd($country_code = 'GB')
    {
        $time_zone_array = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code);
        $dateTimeZone = new DateTimeZone($time_zone_array[0]);
        $dateTime = new DateTime("now", $dateTimeZone);
        $unix_current_time = now() + $dateTime->getOffset();
        $human_current_time = unix_to_human($unix_current_time);
        $human_current_time_array= explode(" ", $human_current_time);
        $human_current_date = $human_current_time_array[0];
        return $human_current_date;
    }
    
    /*
     * This method will convert date from dd-mm-yyyy to yyyy-mm-dd format
     * If date is invalide then this method will return invalid date
     * @param $date, date to be converted
     * @Author Nazmul on 24 September 2014
     */
    public function convert_date_from_ddmmyyyy_to_yyyymmdd($date)
    {
        $splited_date_content = explode("-", $date);
        if(count($splited_date_content) == 3)
        {
            return $splited_date_content[2].'-'.$splited_date_content[1].'-'.$splited_date_content[0];
        }
        else
        {
            return $date;
        }        
    }
    
    /*
     * This method will convert date from yyyy-mm-dd to dd-mm-yyyy format
     * If date is invalide then this method will return invalid date
     * @param $date, date to be converted
     * @Author Nazmul on 24 September 2014
     */
    public function convert_date_from_yyyymmdd_to_ddmmyyyy($date)
    {
        $splited_date_content = explode("-", $date);
        if(count($splited_date_content) == 3)
        {
            return $splited_date_content[2].'-'.$splited_date_content[1].'-'.$splited_date_content[0];
        }
        else
        {
            return $date;
        }        
    }
    
    /*
     * This method will return HH:MM AM/PM of a unix time for xstream banter chat room
     * @param $unix_time, unix time
     * @param $country_code, user country code
     * @Author Nazmul on 4 Nov 2014
     */
    public function get_unix_to_human_time_xb_chat_room($unix_time, $country_code = 'GB')
    {
        $time_zone_array = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code);
        $dateTimeZone = new DateTimeZone($time_zone_array[0]);
        $dateTime = new DateTime("now", $dateTimeZone);
        $relative_unix_time = $unix_time + $dateTime->getOffset();
        $human_current_time = unix_to_human($relative_unix_time);
        $human_current_time_array= explode(" ", $human_current_time);
        return $human_current_time_array[1].' '.$human_current_time_array[2];
    }
    
    public function formate_date($date_string)
    {
        $original_date = new DateTime($date_string);
        $formatted_date = date_format($original_date, 'j F Y');
        return $formatted_date;
    }
    
    public function process_time($time)
    {
        
        return unix_to_human($time);
    }
    
    public function rating_name($rating_id)
    {
        return $rating_id == 1? 'positive': ($rating_id == 2? 'negative':'neutral');
    }
    
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
    
    function copy_image_from_source_to_destination($image_source_relative_directory, $image_destination_relative_directory, $image_name)
    {
        //we don't have images in source directory
        if( !is_dir($image_source_relative_directory) )
        {
            return FALSE;
        }
        //creating image destination directory if not exists
        if( !is_dir($image_destination_relative_directory) )
        {
            mkdir($image_destination_relative_directory, 0777, TRUE);
        }
        copy(FCPATH.$image_source_relative_directory.$image_name, FCPATH.$image_destination_relative_directory.$image_name);
        //delete source image after copy
        return TRUE;
    }
    
    /*
     * This method will resize an image
     * @param $source_path, source image relative path
     * @param $new_path, destination image relative path
     * @param $height, height of destination image
     * @param $width, width of destination image
     * @Author Nazmul on 12th July 2014
     */
    public function resize_image($source_path, $new_path, $height, $width) {
        $result = array();
        $config = array(
            'image_library' => 'gd2',
            'source_image' => FCPATH.$source_path,
            'new_image' => FCPATH.$new_path,
            'maintain_ratio' => FALSE,
            'overwrite' => TRUE,
            'height' => $height,
            'width' => $width
        );
        $image_absolute_path = FCPATH.dirname($new_path);
        if( !is_dir($image_absolute_path) )
        {
            mkdir($image_absolute_path, 0777, TRUE);
        }
        $this->image_lib->clear();
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()){
            $result['status'] = 0;
            $result['message'] = $this->image_lib->display_errors();
        }
        else
        {
            $result['status'] = 1;
        }
        return $result;
    }
    
    public function upload_image($file_info, $uploaded_path) {
        $result = array();
        if (isset($file_info)) {
            $config['image_library'] = 'gd2';
            $config['upload_path'] = $uploaded_path;
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '10240';
            $config['maintain_ratio'] = FALSE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $result['status'] = 0;
                $result['message'] = $this->upload->display_errors();
            } else {
                $upload_data = $this->upload->data();
                $result['status'] = 1;
                $result['message'] = 'Image is uploaded successfully';
                $result['upload_data'] = $upload_data;
            }
        }
        return $result;
    }
    
    public function delete_image($relative_path)
    {
        $absolute_path = FCPATH.$relative_path;
        if(file_exists($absolute_path)) {
            unlink($absolute_path);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function convert_time($_entry_time) {
        $today = now();
        
        $seconds = ($today - (int)$_entry_time);
        if($seconds <= 1 ){
            return $seconds ." second ago";
        }
        else if($seconds > 1 && $seconds < 60){
            return $seconds ." seconds ago";
        }
        else{
            $minutes = ceil($seconds / 60);
            if($minutes <= 1){
                return $minutes . " minute ago.";
            }
            else if($minutes > 1 && $minutes < 60){
                return $minutes . " minutes ago.";
            }
            else{
                $hours = ceil($minutes / 60);
                if($hours <= 1){
                    return $hours . " hours ago.";
                }
                else if($hours > 1 && $hours < 24){
                    return $hours . " hours ago.";
                }
                else{
                    $days = ceil($hours / 24);
                    if($days <= 1){
                        return $days ." day ago.";
                    }
                    else if($days > 1 && $days < 30 ){
                        return $days ." days ago.";
                    }
                    else{
                        $months = ceil( $days / 30 );
                        if($months <= 1){
                            return $months . " month ago.";
                        }
                        else if($months > 1 && $months < 12){
                            return $months . " months ago.";
                        }
                        else{
                            $years = ceil($months / 12);
                            return $years . " years ago.";
                        }
                    }
                }
            }
            
        }
    }
    
    /*
     * This method will set the attribute value of target to _blank in all anchors
     * @Author Nazmul on 13October 2014
     */
    function add_blank_target_in_anchor($content)
    {
        $doc = new DOMDocument();
        $doc->loadHTML($content);
        $links = $doc->getElementsByTagName('a');
        foreach ($links as $item) {
            //if (!$item->hasAttribute('target'))
                $item->setAttribute('target','_blank');  
        }
        $content=$doc->saveHTML();
        return $content;
    }
    
    /*
     * This method will validate time in hh:mm format
     * @Author Nazmul on 28th October 2014
     */
    public function validate_time($time)
    {
        if(preg_match("/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/", $time) === 0) {
            return 0;
        } else {
           return 1;
        }
    }
    
    /*
     * This method will validate date in mm-dd-yyyy format
     * @Author Nazmul on 28th October 2014
     */
    public function validate_date($date)
    {
        if(preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\-(0[1-9]|1[0-2])\-[0-9]{4}$/", $date) === 0) {
           RETURN 0;
        } else {
           RETURN 1;
        }
    }
}

?>
