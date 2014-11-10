<div class="panel panel-default">
    <div class="panel-heading">Create Match</div>
    <div class="panel-body">
        <div class="form-background top-bottom-padding">
            <div class="row">
                <div class ="col-md-8 margin-top-bottom">
                    <?php echo form_open("admin/applications_shop/create_feature/", array('id' => 'form_create_feature', 'class' => 'form-horizontal')); ?>
                        <div class ="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8"><?php echo $message; ?></div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-md-6 control-label requiredField">
                                Title:
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($title + array('class' => 'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="submit_create_feature" class="col-md-6 control-label requiredField">

                            </label>
                            <div class ="col-md-3 pull-right">
                                <?php echo form_input($submit_create_feature+array('class'=>'form-control button-custom')); ?>
                            </div> 
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class="btn-group" style="padding-left: 10px;">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
            </div>
        </div>
    </div>
</div>
<?php 
$this->load->view("admin/applications/shop/modal/product_category_create");
$this->load->view("admin/applications/shop/modal/product_category_delete_confirm");
$this->load->view("admin/applications/shop/modal/product_category_update");
?>
