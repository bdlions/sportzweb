<div class="panel panel-default">
    <div class="panel-heading">User Manage</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registration Date</th>
                                <th>Last Login</th>                            
                            </tr>
                        </thead>
                        <tbody id="tbody_business_profiles">                
                            <?php foreach($user_list as $user_info){?>
                                <tr>
                                    <td><a href="<?php echo base_url()."admin/users/display_user_info/".$user_info['user_id']; ?>"><?php echo $user_info['first_name'].' '.$user_info['last_name']?></a></td>
                                    <td><?php echo $user_info['email']?></td>
                                    <td><?php echo $user_info['created_on']?></td>
                                    <td><?php echo $user_info['last_login']?></td>
                                </tr>
                            <?php }?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

