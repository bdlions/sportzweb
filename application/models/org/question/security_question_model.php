<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Security_question_model extends Ion_auth_model {

    
    public function __construct() {
        parent::__construct();
        $this->trigger_events('model_constructor');
    }
    
    //-------------------------------Security question module----------------------------------------
    /*
     * This method will return all security questions
     */
    public function get_all_security_questions()
    {
        $query = $this->db->select('*')
		        ->from($this->tables['security_questions'])
		        ->get();
        
        $result = $query->result();
        $question_sets = array();
        
        foreach ($result as $value) {
            $question_sets[$value->security_question_types_id - 1][] = array('id' => $value->id, 'description' => $value->description);
        }
        return $question_sets;
    }
    
    public function is_answer_correct($user_id, $answers){
        $is_correct = false;
        foreach ($answers as $value) {
            $query = $this->db->select('*')
		        ->from($this->tables['security_questions_answers'])
                        ->where('user_id', $user_id)
                        ->where('security_question_id', $value['question_id'])
		        ->get();
            if($query->num_rows() <= 0){
                $is_correct = false;
                break;
            }
            $result = $query->row();
            if($result -> answer != $value['answer']){
                $is_correct = false;
                break;
            }
            else{
                $is_correct = true;
            }
        }
        if( !$is_correct){
            $this->set_error('incorrect_security_answer');
        }
        return $is_correct;
    }
    
    public function insert_security_answer($data){
        $this->db->insert_batch('security_questions_answers', $data); 
    }
}
