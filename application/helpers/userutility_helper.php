<?php
if (!function_exists('is_myself')) {
    function is_myself($user_id) {
        if( $user_id == 0){
            return true;
        }
        $CI = & get_instance();
        $myself_id = $CI->ion_auth->get_user_id();
        return $myself_id == $user_id;
    }
}

if (!function_exists('is_follower')) {
    function is_follower($follower_id) {
        $CI = & get_instance();
        $CI->load->model("follower_model");
        return $CI->follower_model->is_follower($follower_id);
    }
}

if (!function_exists('is_follower_pending')) {
    function is_follower_pending($follower_id) {
        $CI = & get_instance();
        $CI->load->model("follower_model");
        return $CI->follower_model->is_follower_pending($follower_id);
    }
}
if (!function_exists('get_followers')) {
    function get_followers() {
        $CI = & get_instance();
        $CI->load->library("follower");
        return $CI->follower->get_user_followers();
    }
}

if (!function_exists('convert_time')) {
    function convert_time($_entry_time) {
        $today = now();
        //1392488102
        
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
}

if (!function_exists('get_like_label')) {
    function get_like_label($user_list) {
        $CI = & get_instance();
        $myself_id = $CI->ion_auth->get_user_id();
        foreach($user_list as $user_info)
        {
            if($myself_id == $user_info->id)
            {
                return 'Unlike';
            }
        }
        return 'Like';
    }
}

if (!function_exists('is_like_label')) {
    function is_like_label($user_list) {
        $CI = & get_instance();
        $myself_id = $CI->ion_auth->get_user_id();
        foreach($user_list as $user_info)
        {
            if($myself_id == $user_info['user_id'])
            {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('is_application_comment_like_label')) {
    function is_application_comment_like_label($user_id_list) {
        $CI = & get_instance();
        $myself_id = $CI->ion_auth->get_user_id();
        foreach($user_id_list as $user_id)
        {
            if($myself_id == $user_id)
            {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('test_name')) {
    function test_name($user_list) {
        $CI = & get_instance();
        $myself_id = $CI->ion_auth->get_user_id();
        foreach($user_list as $user_info)
        {
            return $user_info->first_name;
        }
        return 'vejal';
    }
}


?>
