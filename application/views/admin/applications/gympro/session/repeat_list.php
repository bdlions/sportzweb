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
                        <?php foreach($session_repeat_list as $repeat_list){?>
                        <tr>
                            <td><?php echo $repeat_list['id']?></td>
                            <td><?php echo $repeat_list['title']?></td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>