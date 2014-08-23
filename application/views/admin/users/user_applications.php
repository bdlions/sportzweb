<div class="row">                
    <div class="table-responsive table-left-padding table-top-padding">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Applications</th>
                    <th>First used time</th>
                    <th>Last used date</th>
                </tr>
            </thead>
            <tbody id="tbody_business_profiles">                
                <?php foreach($application_log_list as $application_log_info){?>
                    <tr>
                        <td><?php echo $application_log_info['application_name']?></td>
                        <td><?php echo $application_log_info['first_used_date']?></td>
                        <td><?php echo $application_log_info['last_used_date']?></td>
                    </tr>
                <?php } ?>                
            </tbody>
        </table>
    </div>           
</div>