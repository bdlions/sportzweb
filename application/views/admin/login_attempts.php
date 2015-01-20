<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Login attempts
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-offset-1 col-sm-10">
                        <div class="table-responsive">
                            <table class="table table-condensed table-bordered">
                                <tr>
                                    <th>No.</th>
                                    <th>IP address</th>
                                    <th>Action</th>
                                </tr>

                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><button class="btn btn-default btn-small" onclick="remove_ip(<?php echo ''; ?>)" value="Remove"></button></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--codes for model

	     public function get_ip()
    {
        return $this->db->select($this->tables['login_attempts'].'.*')
                    ->from($this->tables['login_attempts'])
                    ->get();
    }




for controller(rashida)


    public function login_attampts(){
        $login_info = array();
        $login_info_array = $this->gympro_library->get_ip()->result_array();
        if (!empty($login_info_array)) {
            $login_info = $login_info_array[0];
        } else {
           redirect('', 'refresh');
        }
        $this->data['$login_info'] = $login_info;
        $this->template->load(null, '', $this->data);
        
    }


-->