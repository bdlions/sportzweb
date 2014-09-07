<?php foreach ($newsfeeds as $newsfeed) {
    $this->data['newsfeed'] = $newsfeed;  
    $this->load->view("member/newsfeed/status", $this->data); 
} ?>
<a href='<?php echo base_url(). "feed/get_statuses/". $status_list_id."/".$mapping_id."/".STATUS_LIMIT_PER_REQUEST."/". $next_start."/".$hashtag?>' >next</a>