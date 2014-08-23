<div class="panel panel-default">
    <div class="panel-heading">Log</div>
    <div class="panel-body">
        <div class="row col-md-10">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Average time spent logged in : </div></label>
                    <div class="col-sm-6"><?php echo $hour.':'.$minute.' hours';?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
                    <div class="col-sm-6"></div>
                </div>
            </div>
            <div class="row">                
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Period</th>
                                <th>Total loggged in</th>
                                <th>List</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_business_profiles">                
                            <tr>
                                <td>Today</td>
                                <td><?php echo $today_count;?></td>
                                <td><a href="<?php echo base_url("./admin/users_usermanage/user_manage/1"); ?>">Show</a></td>
                            </tr>
                            <tr>
                                <td>Yesterday</td>
                                <td><?php echo $yesterday;?></td>
                                <td><a href="<?php echo base_url("./admin/users_usermanage/user_manage/2"); ?>">Show</a></td>
                            </tr>
                            <tr>
                                <td>This week</td>
                                <td><?php echo $this_week;?></td>
                                <td><a href="<?php echo base_url("./admin/users_usermanage/user_manage/3"); ?>">Show</a></td>
                            </tr>
                            <tr>
                                <td>Last week</td>
                                <td><?php echo $last_week;?></td>
                                <td><a href="<?php echo base_url("./admin/users_usermanage/user_manage/4"); ?>">Show</a></td>
                            </tr>
                            <tr>
                                <td>This month</td>
                                <td><?php echo $this_month;?></td>
                                <td><a href="<?php echo base_url("./admin/users_usermanage/user_manage/5"); ?>">Show</a></td>
                            </tr>
                            <tr>
                                <td>Last month</td>
                                <td><?php echo $last_month;?></td>
                                <td><a href="<?php echo base_url("./admin/users_usermanage/user_manage/6"); ?>">Show</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>           
            </div>
        </div>
    </div>
</div>

