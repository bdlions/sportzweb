<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<div class="container-fluid">    
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-7">
            <div class="row pad_body">
                <div class ="col-md-10">
                    <?php echo form_open("applications/gympro/account/".$gympro_user_id, array('id' => 'form_account', 'class' => 'form-horizontal')); ?>
                        <div class ="row">
                            <div class="col-md-12">
                                <?php if(isset($message) && ($message != NULL)): ?>
                                <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-4 control-label requiredField">
                                Account Type: 
                            </label>
                            <div class ="col-md-8">
                                <?php echo form_dropdown('account_type_list', $account_type_list, '', 'class=form-control id=account_type_list'); ?>
                            </div>
                        </div>                                          
                        <div class="form-group">
                            <label for="submit_update_account" class="col-md-4 control-label requiredField">

                            </label>
                            <div class ="col-md-3 pull-right">
                                <?php echo form_input($submit_update_account+array('class'=>'form-control button-custom')); ?>
                            </div> 
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            
        </div>
    </div>

</div>