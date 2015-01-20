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
                                    <th>Id</th>
                                    <th>IP address</th>
                                    <th>Login</th>
                                    <th>Time</th>
                                    <th>Delete</th>
                                </tr>
                                <?php foreach($login_attempt_list as $login_attempt){?>
                                <tr>
                                    <td><?php echo $login_attempt['id']?></td>
                                    <td><?php echo $login_attempt['ip_address']?></td>
                                    <td><?php echo $login_attempt['login']?></td>
                                    <td><?php echo $login_attempt['time']?></td>
                                    <td></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>