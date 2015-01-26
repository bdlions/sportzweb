<div class="panel panel-default">
    <div class="panel-heading">
        Manage Repeats
    </div>
    <div class="panel-body">
        <div class="row form-group">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed">
                        <tr>
                            <th>ID</th>
                            <th>TITLE</th>
                            <th>EDIT</th>
                            <th>DELETE</th>
                        </tr>
                        <?php foreach($session_cost_list as $cost_list){?>
                        <tr>
                            <td><?php echo $cost_list['id']?></td>
                            <td><?php echo $cost_list['title']?></td>
                            <td><a onclick="open_modal_update(<?php echo $cost_list['id'] ?>)">Edit</a></td>
                            <td><a onclick="open_modal_delete_confirm(<?php echo $cost_list['id'] ?>)">Delete</a></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <input type="button" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("admin/applications/gympro/session/delete_modal/cost_list_delete_confirm_modal");?>
<?php $this->load->view("admin/applications/gympro/session/update_modal/cost_list_update_confirm_modal");?>