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
class ListMaker {

    public function __construct() {

    }
    
    public function getKeyValuePairList($source, $label_field, $value_field){
        $resultList = array();
        foreach ($source as $item) {
            $label = "";
            $value = "";
            foreach ($item as $key => $v) {
                if($key == $label_field){
                    $label = $v;
                }
                if($key == $value_field){
                    $value = $v;
                }
            }
            if($label != "" && $value != ""){
                $resultList[$label] = $value;
            }
        }
        return $resultList;
    }
}
