<div class="panel panel-default">
    <div class="panel-heading">Manage preferences</div>
    <div class="panel-body">
        <?php if ($allow_write) { ?>
        <div class="row form-group">
            <div class ="col-md-3">
                <a href="<?php echo base_url()?>admin/applications_gympro/manage_currencies"><button class="form-control btn button-custom">Manage Currencies</button></a>
            </div>
            <div class ="col-md-3">
                <a href="<?php echo base_url()?>admin/applications_gympro/manage_hourly_rates"><button class="form-control btn button-custom">Manage Hourly Rates</button></a>
            </div>
            <div class ="col-md-3">
                <a href="<?php echo base_url()?>admin/applications_gympro/manage_time_zones"><button class="form-control btn button-custom">Manage time zones</button></a>
            </div>
            
        </div>
        <div class="row form-group">
            <div class ="col-md-3">
                <a href="<?php echo base_url()?>admin/applications_gympro/manage_height_unit_types"><button class="form-control btn button-custom">Manage height unit types</button></a>
            </div>
            <div class ="col-md-3">
                <a href="<?php echo base_url()?>admin/applications_gympro/manage_weight_unit_types"><button class="form-control btn button-custom">Manage weight unit types</button></a>
            </div>
            <div class ="col-md-3">
                <a href="<?php echo base_url()?>admin/applications_gympro/manage_girth_unit_types"><button class="form-control btn button-custom">Manage girth unit types</button></a>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th style="text-align: center">USER ID</th>
                            <th style="text-align: center">HEIGHT UNIT ID</th>
                            <th style="text-align: center">WEIGHT UNIT ID</th>
                            <th style="text-align: center">GIRTH UNIT ID</th>
                            <th style="text-align: center">TIME ZONE ID</th>
                            <th style="text-align: center">HOURLY RATE ID</th>
                            <th style="text-align: center">CURRENCY ID</th>                            
                        </tr>
                    </thead>
                    <tbody id="tbody_product_category_list">
                        <?php foreach($user_list as $user_info):?>
                        <tr>
                            <td style="text-align: center"><?php echo $user_info['user_id'];?></td>
                            <td style="text-align: center"><?php echo $user_info['height_unit_id'];?></td>
                            <td style="text-align: center"><?php echo $user_info['weight_unit_id'];?></td>
                            <td style="text-align: center"><?php echo $user_info['girth_unit_id'];?></td>
                            <td style="text-align: center"><?php echo $user_info['time_zone_id'];?></td>
                            <td style="text-align: center"><?php echo $user_info['hourly_rate_id'];?></td>
                            <td style="text-align: center"><?php echo $user_info['currency_id'];?></td>                            
                        </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php 
$this->load->view("admin/applications/gympro/modal/preferences_create");
$this->load->view("admin/applications/gympro/modal/preferences_edit");
$this->load->view("admin/applications/gympro/modal/preferences_delete_confirm");
?>
