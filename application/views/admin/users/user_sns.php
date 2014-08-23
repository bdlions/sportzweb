<div class="row">                
    <div class="table-responsive table-left-padding table-top-padding">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SNS pages</th>
                    <th>Total views</th>
                    <th>Male</th>
                    <th>Female</th>
                </tr>
            </thead>
            <tbody id="tbody_business_profiles">                
                <?php foreach($sns_list as $sns_info){?>
                    <tr>
                        <td><?php echo $sns_info['page_name']?></td>
                        <td><?php echo ($sns_info['total_male_members']+$sns_info['total_female_members'])?></td>
                        <td><?php echo $sns_info['total_male_members']?></td>
                        <td><?php echo $sns_info['total_female_members']?></td>
                    </tr>
                <?php } ?>                  
            </tbody>
        </table>
    </div>           
</div>