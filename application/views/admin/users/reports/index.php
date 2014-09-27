<div class="row">                
    <div class="table-responsive table-left-padding">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Report Type</th>
                </tr>
            </thead>
            <tbody id="tbody_report_list">                
                <?php foreach($report_list as $report_info){?>
                    <tr>
                        <td><?php echo $report_info['first_name'].' '.$report_info['last_name']?></td>
                        <td><?php echo $report_info['description']?></td>
                    </tr>                                
                <?php } ?>
            </tbody>
        </table>
    </div>           
</div>