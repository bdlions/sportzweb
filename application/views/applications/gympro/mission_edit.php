<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-10">
            <div class="pad_title">
                EDIT MISSION
                <div class="col-md-3 pull-right">
                    <?php $this->load->view("applications/gympro/template/user_category_dropdown"); ?>
                </div>
            </div>
            <?php if (isset($message) && ($message != NULL)): ?>
                <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
            <?php endif; ?>
            <?php echo form_open("applications/gympro/edit_mission/".$mission_id, array('id' => '', 'class' => 'form-horizontal')); ?>
            <div class="pad_body">
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Label: </label>
                    <div class="col-sm-4">
                        <!--<input class="form-control">-->
                        <?php echo form_input($label + array('class' => 'form-control')) ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Mission Starts: </label>
                    <div class="col-sm-2">
                        <?php echo form_input($start_date + array('class' => 'form-control')) ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Mission Ends: </label>
                    <div class="col-sm-2">
                        <?php echo form_input($end_date + array('class' => 'form-control')) ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-offset-1 col-sm-9 top_margin">
                        Please enter the Health & Fitness Missions for each day below.
                        If there is more than one mission for a particular day please enter it on a new line.
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Monday: </label>
                    <div class="col-sm-6">
                        <?php echo form_textarea($monday + array('class' => 'form-control')) ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Tuesday: </label>
                    <div class="col-sm-6">
                        <?php echo form_textarea($tuesday + array('class' => 'form-control')) ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Wednesday: </label>
                    <div class="col-sm-6">
                        <?php echo form_textarea($wednesday + array('class' => 'form-control')) ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Thursday: </label>
                    <div class="col-sm-6">
                        <?php echo form_textarea($thursday + array('class' => 'form-control')) ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Friday: </label>
                    <div class="col-sm-6">
                        <?php echo form_textarea($friday + array('class' => 'form-control')) ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Saturday: </label>
                    <div class="col-sm-6">
                        <?php echo form_textarea($saturday + array('class' => 'form-control')) ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Sunday: </label>
                    <div class="col-sm-6">
                        <?php echo form_textarea($sunday + array('class' => 'form-control')) ?>
                    </div>
                </div>
            </div>
            <div class="pad_footer">
                <?php echo form_input($submit_button) ?> or <a href="<?php echo base_url()?>applications/gympro/manage_missions">Go Back</a>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>
