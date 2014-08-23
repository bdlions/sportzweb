<?php
    class JsonDB{
        /**
        * Select
        *
        * @var array
        * */
        public $jsondb_select = array();
        /**
        * table
        *
        * @var array
        * */
        public $json_table = array();
        /**
        * Select
        *
        * @var where clause condition list
        * */
        public $condition_list = array();
        
        public $last_id = 0;
        
        public $affected_rows = 0;
        
        public function select($select){
            $selected_items = explode(",", $select);
            foreach ($selected_items as $item){
                $this->jsondb_select[] = trim($item);
            }
            return $this;
        }
        
        public function where($key, $value){
            $condition = new stdClass();
            $condition->key = $key;
            $condition->value = $value;
            $this->condition_list[] = $condition;
            return $this;
        }
        
        public function from($table){
            $this->json_table = $table;
            $this->filter_column();
            foreach ($this->condition_list as $condition) {
                $this->filter_row($condition->key, $condition->value);
            }
            return $this;
        }
        public function insert($table, $data){
            $this->json_table = $table;
            foreach ($table as $row) {
                foreach ($data as $key => $value) {
                    if( !property_exists($row, $key)){
                        throw new Exception("Unknown column ".$key);
                    }
                }
                $this->last_id = $row->id;
            }
            $this->last_id ++;
            $data->id = $this->last_id;
            array_push($this->json_table, $data);
            
            return $this;
        }
        
        public function delete($table){
            $this->json_table = $table;
            foreach ($this->condition_list as $condition) {
                $this->remove_row($condition->key, $condition->value);
            }
            return $this;
        }
        
        public function get_last_inserted_id(){
            return $this->last_id;
        }
        public function get_affected_rows(){
            return $this->affected_rows;
        }
        
        public function result(){
            return $this->json_table;
        }
        
        public function row(){
            return $this->json_table[0];
        }
        private function filter_row($key, $value){
            $new_table = array();
            foreach ($this->json_table as $row) {
                if(!isset($row->{$key})){
                    throw new Exception("No column found with name ". $key);
                }
                if ($row->{$key} == $value) {
                    $new_table[] = $row;
                }
            }
            $this->json_table = $new_table;
        }
        
        private function remove_row($key, $value){
            $new_table = array();
            foreach ($this->json_table as $row) {
                if(!isset($row->{$key})){
                    throw new Exception("No column found with name ". $key);
                }
                if ($row->{$key} != $value) {
                    $new_table[] = $row;
                }
                else{
                    $this->affected_rows ++;
                }
                
            }
            $this->json_table = $new_table;
        }
        
        private function filter_column(){
            $new_table = array();
            foreach ($this->json_table as $row) {
                foreach ($row as $key => $value) {
                    if(!in_array($key, $this->jsondb_select)){
                        unset($row->{$key});
                    }
                }
                $new_table[] = $row;
            }
            $this->json_table = $new_table;
            return $this;
        }
        
        
    }
?>
