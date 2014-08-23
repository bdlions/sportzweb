<?php

class jsontest extends CI_Controller{
    public function index(){
        $this->load->library("org/utility/temp_tables/Follower", "", "follower1");
        $this->load->library("org/utility/temp_tables/Follower", "", "follower2");
        
        $followers = array();
        
        $this->follower1->follower_id = 1;
        $this->follower1->follower_type = 1;
        
        $followers = $this->jsondb->insert($followers, $this->follower1)->result();
                
        $this->follower2->follower_id = 2;
        $this->follower2->follower_type = 1;
        $followers =  $this->jsondb->insert($followers, $this->follower2)->result();

        //echo json_encode($followers);
        //print_r($this->jsondb->select('id, follower_id, follower_type')
          //           ->where('follower_type', 1)
            //         ->from(json_decode(json_encode($followers)))
              //       ->result());
        
        $this->load->library("org/utility/temp_tables/Follower", "", "follower3");
        
        $this->follower3->follower_id = 3;
        $this->follower3->follower_type = 1;
        //$this->follower3->follower_typess = 1;
        $followers = $this->jsondb->insert($followers, $this->follower3)->result();
        //print_r($followers);
        
        echo $this->jsondb->get_last_inserted_id();
        
        //print_r($this->jsondb->where('follower_id', 2)
        //                     ->where('id', 1)
        //                     ->delete($followers)->result());
        //echo $this->jsondb->get_affected_rows();
    }
}
?>
