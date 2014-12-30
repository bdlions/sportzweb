<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-10">
           
            <div class="pad_title">
              MISSION INFO
                <div class="col-md-3 pull-right">
                    <?php $this->load->view("applications/gympro/template/user_category_dropdown"); ?>
                </div>
            </div>
            <div class="pad_body">
                <?php if (isset($message) && ($message != NULL)): ?>
                    <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
                <?php endif; ?>            
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Label: </label>
                    <label class="col-md-4 control-label"><?php echo $mission_info['label'];?></label>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Mission Starts: </label>
                    <label class="col-md-4 control-label"><?php echo $mission_info['start_date'];?></label>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Mission Ends: </label>
                    <label class="col-md-4 control-label"><?php echo $mission_info['end_date'];?></label>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Monday: </label>
                    <label class="col-md-4 control-label"><?php echo $mission_info['monday'];?></label>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Tuesday: </label>
                    <label class="col-md-4 control-label"><?php echo $mission_info['tuesday'];?></label>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Wednesday: </label>
                    <label class="col-md-4 control-label"><?php echo $mission_info['wednesday'];?></label>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Thursday: </label>
                    <label class="col-md-4 control-label"><?php echo $mission_info['thursday'];?></label>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Friday: </label>
                    <label class="col-md-4 control-label"><?php echo $mission_info['friday'];?></label>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Saturday: </label>
                    <label class="col-md-4 control-label"><?php echo $mission_info['saturday'];?></label>
                </div>
                <div class="row form-group">
                    <label class="col-sm-2 control-label">Sunday: </label>
                    <label class="col-md-4 control-label"><?php echo $mission_info['sunday'];?></label>
                </div>
            </div>
        </div>
    </div>
</div>