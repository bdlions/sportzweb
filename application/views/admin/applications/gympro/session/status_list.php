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
                        </tr>
                        <?php foreach($session_status_list as $status_list){?>
                        <tr>
                            <td><?php echo $status_list['id']?></td>
                            <td><?php echo $status_list['title']?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="btn-group" style="padding-left: 25px;">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
                </div>
        </div>
    </div>
</div>