<div class="panel panel-default">
    <div class="panel-heading">
        Manage Types
    </div>
    <div class="panel-body">
        <div class="row form-group">
            <div class="col-md-2">
                <a href="<?php echo base_url();?>admin/applications_gympro/create_session_type">
                <input type="button" value="Create Type" id="" class="form-control btn button-custom">
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <th>ID</th>
                            <th>TITLE</th>
                            <th>EDIT</th>
                            <th>DELETE</th>
                        </tr>
                        <?php foreach($session_type_list as $type_list){?>
                        <tr>
                            <td><?php echo $type_list['id']?></td>
                            <td><?php echo $type_list['title']?></td>
                            <td><a onclick="open_modal_update(<?php echo $type_list['id'] ?>)">Edit</a></td>
                            <td><a onclick="open_modal_delete_confirm(<?php echo $type_list['id'] ?>)">Delete</a></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <a href="<?php echo base_url();?>admin/applications_gympro/manage_sessions">
                <input type="button" value="Back" id="back_button" class="form-control btn button-custom">
                </a>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("admin/applications/gympro/session/delete_modal/type_list_delete_confirm_modal");?>
<?php $this->load->view("admin/applications/gympro/session/update_modal/type_list_update_confirm_modal");?>
