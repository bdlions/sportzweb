<div class="row">                
    <div class="table-responsive table-left-padding table-top-padding">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Friends</th>
                    <th>Gender</th>
                    <th>Connected Date</th>
                </tr>
            </thead>
            <tbody id="tbody_business_profiles">                
                <?php foreach($follower_list as $follower_info){ ?>
                    <tr>
                        <td><?php echo $follower_info['first_name'].' '.$follower_info['last_name']?></td>
                        <td><?php echo $follower_info['gender_name']?></td>
                        <td><?php echo $follower_info['following_time']?></td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </div>           
</div>