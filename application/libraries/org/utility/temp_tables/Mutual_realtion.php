<?php

class Mutual_relation {
    public $id = "";//auto increment
    public $user_id = "";
    public $is_pending = FALSE;
    public $is_follower = FALSE;
    public $is_blocked = FLASE;
    public $blocked_reason_type = "";
    public $is_reported = FALSE;
    public $reported_reason_type = "";
    
    public $created_date = "";
    public $updated_date = "";
}

?>
