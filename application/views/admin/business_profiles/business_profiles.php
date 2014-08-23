<div class="panel panel-default">
    <div class="panel-heading">Business Profiles</div>
    <div class="panel-body">
        <div class="row col-md-10">
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Business profiles</th>
                                <th>Total members</th>
                                <th>Male</th>
                                <th>Female</th>                            
                            </tr>
                        </thead>
                        <tbody id="tbody_business_profiles">                
                            <?php foreach($business_profile as $profile):?>
                            <tr>
                                <td><?php echo $profile['business_name'];?></td>
                                <td><?php echo $profile['total'];?></td>
                                <td><?php echo $profile['male'];?></td>
                                <td><?php echo $profile['female'];?></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
    </div>
</div>

