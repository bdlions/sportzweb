<div class="row">
    <div class="table-responsive table-left-padding">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>                   
                </tr>
            </thead>
            <tbody id="tbody_business_profiles">                
                <?php foreach($message_user_list as $message_user_info){?>
                    <tr>
                        <td><a href="<?php echo base_url() . "admin/users/user_conversation/".$user_info['user_id']."/".$message_user_info['user_id'].""; ?>"><?php echo $message_user_info['first_name'].' '.$message_user_info['last_name']?></a></td>
                    </tr>
                <?php } ?>          
            </tbody>
        </table>
    </div>
</div>