<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Name:  Date Utils
 * Requirements: PHP5 or above
 *
 */
class Date_utils {
    public function __construct() {
    }    

    /**
     * __get
     *
     * Enables the use of CI super-global without having to define an extra variable.
     * @access	public
     * @param	$var
     * @return	mixed
     */
    public function __get($var) {
        return get_instance()->$var;
    }
    
    public function convert_date_to_unix_time()
    {
        
    }
    
    /*
     * This method will return local unix time of a user
     * @param $country_code, country code
     * @author nazmul hasan on 13th November 2015
     */
    public function get_local_unix_time($country_code = 'GB')
    {
        if($country_code != COUNTRY_CODE_GB)
        {
            $time_zone_array = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $country_code);
            $dateTimeZone = new DateTimeZone($time_zone_array[0]);
            $dateTime = new DateTime("now", $dateTimeZone);
            return now() + $dateTime->getOffset();
        }
        else
        {
            return now();
        }        
    }
    
    /*
     * This method will return unix time of a date. date format is yyyy-mm-dd
     * @param $country_code, country code
     * @author nazmul hasan on 13th November 2015
     */
    public function get_server_unix_time_of_date($date)
    {
        return human_to_unix($date.' 00:00 AM');
    }

}