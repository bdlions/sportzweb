<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<div class="container-fluid">    
    <div class="row top_margin">
        <?php
        if ($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT) {
            $this->load->view("applications/gympro/template/sections/client_left_pane");
        } else {
            $this->load->view("applications/gympro/template/sections/pt_left_pane");
        }
        ?>
        <div class="col-md-7">
            <?php echo form_open("applications/gympro/preference/" . $gympro_user_info['user_id'], array('id' => 'form_preference', 'class' => 'form-horizontal')); ?>
            <div class ="row form-group">
                <div class="col-md-12">
                    <?php if (isset($message) && ($message != NULL)): ?>
                        <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-4 col-sm-4 col-xs-4 control-label content_text requiredField">
                    PayPal Account: 
                </div>
                <div class ="col-md-6 col-sm-6 col-xs-6">
                     <input type="text" class="form-control" name="account_email" value="<?php echo $account_email; ?>"> 
                </div>
                <div class ="col-md-2 col-sm-2 col-xs-2">
                    <div class="paypal_img_margir">
                        <a style="cursor: pointer;" data-toggle="tooltip" data-placement="right" title=" A PayPal account is required to receive payment for PT sessions"><img src="<?php echo base_url(); ?>resources/images/applications/gympro/info.png"></a>
                    </div>
                </div>
            </div> 
            <div class="row form-group">
                <div class="col-md-4 col-sm-4 col-xs-4 control-label content_text requiredField">
                    Height unit: 
                </div>
                <div class ="col-md-6 col-sm-6 col-xs-6">
                    <?php echo form_dropdown('height_unit_list', $height_unit_list, $gympro_user_info['height_unit_id'], 'class=form-control id=height_unit_list'); ?>
                </div>
            </div> 
            <div class="row form-group">
                <div class="col-md-4 col-sm-4 col-xs-4 control-label content_text requiredField">
                    Weight unit: 
                </div>
                <div class ="col-md-6 col-sm-6 col-xs-6">
                    <?php echo form_dropdown('weight_unit_list', $weight_unit_list, $gympro_user_info['weight_unit_id'], 'class=form-control id=weight_unit_list'); ?>
                </div>
            </div> 
            <div class="row form-group">
                <div class="col-md-4 col-sm-4 col-xs-4 control-label content_text requiredField">
                    Girth unit: 
                </div>
                <div class ="col-md-6 col-sm-6 col-xs-6">
                    <?php echo form_dropdown('girth_unit_list', $girth_unit_list, $gympro_user_info['girth_unit_id'], 'class=form-control id=girth_unit_list'); ?>
                </div>
            </div> 
            <div class="row form-group">
                <div class="col-md-4 col-sm-4 col-xs-4 control-label content_text requiredField">
                    Time zone: 
                </div>
                <div class ="col-md-6 col-sm-6 col-xs-6">
                    <?php echo form_dropdown('time_zone_list', $time_zone_list, $gympro_user_info['time_zone_id'], 'class=form-control id=time_zone_list'); ?>
                </div>
            </div> 
            <div class="row form-group">
                <div class="col-md-4 col-sm-4 col-xs-4 control-label content_text requiredField">
                    Currency: 
                </div>
                <div class ="col-md-6 col-sm-6 col-xs-6">
                    <?php echo form_dropdown('currency_list', $currency_list, $gympro_user_info['currency_id'], 'class=form-control id=currency_list'); ?>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-4 col-sm-4 col-xs-4 control-label content_text requiredField">
                    Hourly rate: 
                </div>
                <div class ="col-md-6 col-sm-6 col-xs-6">
                    <?php echo form_dropdown('hourly_rate_list', $hourly_rate_list, $gympro_user_info['hourly_rate_id'], 'class=form-control id=hourly_rate_list'); ?>
                </div>
            </div>                 
            <div class="row form-group">
                <div for="submit_update_preference" class="col-md-4 col-sm-4 col-xs-4 control-label content_text requiredField">

                </div>
                <div class ="col-md-offset-3 col-md-3">
                    <?php echo form_input($submit_update_preference + array('class' => 'form-control button-custom')); ?>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>