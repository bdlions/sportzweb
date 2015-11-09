<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<div class="container-fluid">
    <div class="row top_margin">
        <?php 
        if($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT)
        {
            $this->load->view("applications/gympro/template/sections/client_left_pane"); 
        }
        else
        {
            $this->load->view("applications/gympro/template/sections/pt_left_pane"); 
        }            
        ?>
        <div class="col-md-9">           
            <div class="pad_title">
            ASSESSMENT INFO
                <div class="col-md-3 pull-right">
                    <?php 
                    if($account_type_id != APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT)
                    {
                        echo $assessment_info['first_name'].' '.$assessment_info['last_name'];
                    }         
                    ?>
                </div>
            </div>
            <div style="border-top: 2px solid lightgray; margin-left: 20px"></div>
            <div class="pad_body">
                <?php if (isset($message) && ($message != NULL)){ ?>
                    <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
                <?php } ?> 
                <div class="row">
                    <div class="col-md-5">
                        <div class="row form-group">
                            <div class="col-md-4">Date:</div>
                             <label class="col-md-4 control-label"><?php echo convert_date_from_db_to_user($assessment_info['date']);?></label>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">Weight:</div>
                             <label class="col-md-4 control-label"><?php echo $assessment_info['weight'];?></label>kg
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">Height:</div>
                             <label class="col-md-4 control-label"><?php echo $assessment_info['head'];?></label>cm
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">Neck:</div>
                             <label class="col-md-4 control-label"><?php echo $assessment_info['neck'];?></label>cm
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">Chest:</div>
                            <label class="col-md-4 control-label"><?php echo $assessment_info['chest'];?></label>cm
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row form-group">
                            <div class="col-md-4">Reassess:</div>
                            <label class ="col-md-5 control-label">
                              <?php echo convert_date_from_db_to_user($assessment_info['reassess']);?>
                            </label> 
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">Body fat:</div>
                             <label class="col-md-4 control-label"><?php echo $assessment_info['body_fat'];?></label>%
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">Abdominal:</div>
                             <label class="col-md-4 control-label"><?php echo $assessment_info['abdominal'];?></label>cm
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">Waist:</div>
                             <label class="col-md-4 control-label"><?php echo $assessment_info['waist'];?></label>cm
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">Hip:</div>
                             <label class="col-md-4 control-label"><?php echo $assessment_info['hip'];?></label>cm
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div style="background-color: white">
                            <div class="row form-group">
                                <div class="col-md-2"></div>
                                <div class="col-md-2" style="text-align: center">LEFT SIDE</div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2" style="text-align: center">RIGHT SIDE</div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="row form-group">
                                            <div class="col-md-5">Arm Relaxed:</div>
                                             <label class="col-md-4 control-label"><?php echo $assessment_info['ls_arm_relaxed'];?></label>cm
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-5">Arm Flexed:</div>
                                             <label class="col-md-4 control-label"><?php echo $assessment_info['ls_arm_flexed'];?></label>cm
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-5">Forearm:</div>
                                             <label class="col-md-4 control-label"><?php echo $assessment_info['ls_forearm'];?></label>cm
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-5">Wrist:</div>
                                             <label class="col-md-4 control-label"><?php echo $assessment_info['ls_wrist'];?></label>cm
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-5">Thigh (gluteal):</div>
                                             <label class="col-md-4 control-label"><?php echo $assessment_info['ls_thigh_gluteal'];?></label>cm
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-5">Thigh (mid):</div>
                                             <label class="col-md-4 control-label"><?php echo $assessment_info['ls_thigh_mid'];?></label>cm
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-5">Kalf:</div>
                                             <label class="col-md-4 control-label"><?php echo $assessment_info['ls_calf'];?></label>cm
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-5">Ankle:</div>
                                             <label class="col-md-4 control-label"><?php echo $assessment_info['ls_ankle'];?></label>cm
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="row form-group">
                                            <div class="col-md-5">Arm Relaxed:</div>
                                             <label class="col-md-4 control-label"><?php echo $assessment_info['rs_arm_relaxed'];?></label>cm
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-5">Arm Flexed:</div>
                                             <label class="col-md-4 control-label"><?php echo $assessment_info['rs_arm_flexed'];?></label>cm
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-5">Forearm:</div>
                                             <label class="col-md-4 control-label"><?php echo $assessment_info['rs_forearm'];?></label>cm
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-5">Wrist:</div>
                                             <label class="col-md-4 control-label"><?php echo $assessment_info['rs_wrist'];?></label>cm
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-5">Thigh (gluteal):</div>
                                             <label class="col-md-4 control-label"><?php echo $assessment_info['rs_thigh_gluteal'];?></label>cm
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-5">Thigh (mid):</div>
                                             <label class="col-md-4 control-label"><?php echo $assessment_info['rs_thigh_mid'];?></label>cm
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-5">Kalf:</div>
                                             <label class="col-md-4 control-label"><?php echo $assessment_info['rs_calf'];?></label>cm
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-5">Ankle:</div>
                                             <label class="col-md-4 control-label"><?php echo $assessment_info['rs_ankle'];?></label>cm
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
          
            <?php echo form_close(); ?>
        </div>
    </div>
</div>