<div class="panel panel-default">
    <div class="panel-heading">Update Match</div>
    <div class="panel-body">
        <div class="form-background top-bottom-padding">
            <div class="row">
                <div class ="col-md-8 margin-top-bottom">
                    <?php echo form_open("admin/applications_shop/update_color/".$color_id, array('id' => 'form_update_color', 'class' => 'form-horizontal')); ?>
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
                            <label for="description" class="col-md-6 control-label requiredField">
                                Description:
                            </label>
                            <div class ="col-md-6">
                                <?php echo form_input($description + array('class' => 'form-control')); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="submit_update_color" class="col-md-6 control-label requiredField">

                            </label>
                            <div class ="col-md-3 pull-right">
                                <?php echo form_input($submit_update_color+array('class'=>'form-control button-custom')); ?>
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