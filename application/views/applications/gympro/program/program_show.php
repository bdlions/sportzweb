
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">

    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-10">
            <div class="pad_title">
                Program info 
            </div>
            <div class="pad_body">
                <div class="row">
                    <div class="col-md-7">
                        <div class=" row form-group">
                            <label class="col-sm-3 control-label">Programme Focus: </label>
                            <div class="col-md-9 "><?php echo $program_info['focus'];?></div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 control-label">Start date: </label>
                            <div class="col-md-9 "><?php echo $program_info['start_date'];?></div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 control-label">Review In: </label>
                            incomplete 
                            <!--<div class="col-md-9 "><?php echo $program_info['review_id'];?></div>-->
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 control-label">Description: </label>
                            <div class="col-md-9 "><?php echo $program_info['description'];?></div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row form-group">
                            <label class="col-sm-3 control-label">Warm Up: </label>
                            <div class="col-md-9 "><?php echo $program_info['warm_up'];?></div>
                        </div>

                        <div class="row form-group">
                            <label class="col-sm-3 control-label">Cooldown: </label>
                            <div class="col-md-9 "><?php echo $program_info['cool_down'];?></div>
                        </div>
                    </div>
                </div>
                
                <div style="background-color: #fff; margin-bottom: 1px; padding: 10px; display: inline-block; width: 100%">
                    <span style="font-weight: bold;">Exercie name: &nbsp;&nbsp;</span>
                    <label class="col-md-6 control-label"><?php echo $exercise['ex_name'];?></label>
                </div>
                <div style="background-color: #fff; margin-bottom: 1px; padding: 10px; display: inline-block; width: 100%">
                    <div>
                        <div class="col-md-6" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Description</div>
                            <label class="col-md-6 control-label"><?php echo $exercise['ex_description'];?></label>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Sets</div>
                            <label class="col-md-6 control-label"><?php echo $exercise['ex_sets'];?></label>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Reps</div>
                            <label class="col-md-6 control-label"><?php echo $exercise['ex_reps'];?></label>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Weights</div>
                            <label class="col-md-6 control-label"><?php echo $exercise['ex_weights'];?></label>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Reps</div>
                            <label class="col-md-6 control-label"><?php echo $exercise['ex_reps2'];?></label>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Tempo</div>
                            <label class="col-md-6 control-label"><?php echo $program['ex_tempo'];?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
