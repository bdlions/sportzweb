<div class="panel panel-default">
    <div class="panel-heading">Manage Application</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Applications</th>
                                <th>Total members</th>
                                <th>Male</th>
                                <th>Female</th>                            
                            </tr>
                        </thead>
                        <?php //echo '<pre/>';print_r($application_list);exit;?>
                        <tbody id="tbody_business_profiles">                
                            <?php foreach($application_list as $application){?>
                            <tr>
                                <td><a href="<?php echo base_url().$application['home_page']?>"><?php echo $application['title']?></a></td>
                                <td><?php echo $application['total_members']?></td>
                                <td><?php echo $application['total_male_members']?></td>
                                <td><?php echo $application['total_female_members']?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
    </div>
</div>

