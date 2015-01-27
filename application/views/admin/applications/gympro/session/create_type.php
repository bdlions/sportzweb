<div class="panel panel-default" style="margin-top: 30px">
    <div class="panel-heading">
        Create Session Type
    </div>
    <div class="panel-body">
        <?php if (isset($message) && ($message != NULL)): ?>
            <div class="alert alert-info alert-dismissible"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php echo form_open("admin/applications_gympro/create_session_type", array('id' => 'form_type', 'class' => 'form-horizontal')); ?>
        <div class="row form-group">
            <label class="col-sm-offset-2 col-sm-1 control-label">Title:</label>
            <div class ="col-sm-4">
                <?php echo form_input($title + array('class' => 'form-control'));?>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-sm-offset-5 col-sm-2">
                <?php echo form_input($create_type_button + array('class' => 'form-control btn button-custom'));?>
            </div>
        </div>
        <?php echo form_close(); ?>
        <div class="row">
            <div class="col-sm-2">
                <a href="<?php echo base_url();?>admin/applications_gympro/session_type_list">
                <input type="button" value="Back" id="back_button" class="form-control btn button-custom">
                </a>
            </div>
        </div>
    </div>
</div>