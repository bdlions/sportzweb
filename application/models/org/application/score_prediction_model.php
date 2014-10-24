<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Name: Score Prediciton Model
 * 
 * Author: Nazmul
 * 
 * Requirement: PHP 5 and more
 */

class Score_prediction_model extends Ion_auth_model
{
    public function __construct() {
        parent::__construct();
    }
    
    public function test()
    {
        echo 'Score_prediction_model';
    }
}