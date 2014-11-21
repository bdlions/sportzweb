<div class="panel panel-default">
    <div class="panel-heading">Manage preferences</div>
    <div class="panel-body">
        <div class="row" style="padding-bottom:10px;">
            <div class ="col-md-2">
                <a href="<?php echo base_url()?>admin/applications_gympro/manage_account_types"><button class="form-control btn button-custom">Manage Account</button></a>
            </div>
            <div class ="col-md-2">
                <a href="<?php echo base_url()?>admin/applications_gympro/manage_height_unit_types"><button class="form-control btn button-custom">Manage height</button></a>
            </div>
            <div class ="col-md-2">
                <a href="<?php echo base_url()?>admin/applications_gympro/manage_weight_unit_types"><button class="form-control btn button-custom">Manage weight</button></a>
            </div>
            <div class ="col-md-2">
                <a href="<?php echo base_url()?>admin/applications_gympro/manage_girth_unit_types"><button class="form-control btn button-custom">Manage girth</button></a>
            </div>
            <div class ="col-md-2">
                <a href="<?php echo base_url()?>admin/applications_gympro/manage_time_zones"><button class="form-control btn button-custom">Manage time zones</button></a>
            </div>
            <div class ="col-md-2">
                <a href="<?php echo base_url()?>admin/applications_gympro/manage_hourly_rates"><button class="form-control btn button-custom">Manage Hourly Rates</button></a>
            </div>            
            
        </div>
        <div class="row" style="padding-bottom:10px;">
            <div class ="col-md-2">
                <a href="<?php echo base_url()?>admin/applications_gympro/manage_currencies"><button class="form-control btn button-custom">Manage Currencies</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th style="text-align: center">User</th>
                            <th style="text-align: center">Account Type</th>
                            <th style="text-align: center">Height Unit</th>
                            <th style="text-align: center">Weight Unit</th>
                            <th style="text-align: center">Girth Unit</th>
                            <th style="text-align: center">Time Zone</th>
                            <th style="text-align: center">Hourly Rate</th>
                            <th style="text-align: center">Currency</th>                            
                        </tr>
                    </thead>
                    <tbody id="tbody_product_category_list">
                        <?php foreach($user_list as $user_info):?>
                        <tr>
                            <td style="text-align: center"><?php echo $user_info['first_name'].' '.$user_info['last_name'];?></td>
                            <td style="text-align: center"><?php echo $user_info['account_type_title'];?></td>
                            <td style="text-align: center"><?php echo $user_info['height_unit_title'];?></td>
                            <td style="text-align: center"><?php echo $user_info['weight_unit_title'];?></td>
                            <td style="text-align: center"><?php echo $user_info['girth_unit_title'];?></td>
                            <td style="text-align: center"><?php echo $user_info['time_zone_title'];?></td>
                            <td style="text-align: center"><?php echo $user_info['hourly_rate_title'];?></td>
                            <td style="text-align: center"><?php echo $user_info['currency_title'];?></td>                            
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
