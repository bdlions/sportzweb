<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-8">
            <?php echo form_open("applications/gympro/edit_assessment/".$assessment_id, array('id' => 'form_assesment', 'class' => 'form-horizontal')); ?>
            <div class="pad_title">
                EDIT ASSESSMENT
                <div class="col-md-3 pull-right">
                    <?php $this->load->view("applications/gympro/template/user_category_dropdown"); ?>
                </div>
            </div>
            <div class="pad_body">
                <?php if (isset($message) && ($message != NULL)){ ?>
                    <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
                <?php } ?> 
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-md-4">Date:</div>
                            <div class="col-md-5">
                                <?php echo form_input($date + array('class' => 'form-control')) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Weight:</div>
                            <div class="col-md-5">
                                <?php echo form_input($weight + array('class' => 'form-control')) ?>
                            </div>kg
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Head:</div>
                            <div class="col-md-5">
                                <?php echo form_input($head + array('class' => 'form-control')) ?>
                            </div>cm
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Neck:</div>
                            <div class="col-md-5">
                                <?php echo form_input($neck + array('class' => 'form-control')) ?>
                            </div>cm
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Chest:</div>
                            <div class="col-md-5">
                                <?php echo form_input($chest + array('class' => 'form-control')) ?>
                            </div>cm
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-md-4">Reassess in:</div>
                            <div class ="col-md-5">
                                <?php echo form_dropdown('reassess_list', $reassess_list, '', 'class=form-control id=reassess_list'); ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Body fat:</div>
                            <div class="col-md-5">
                                <?php echo form_input($body_fat + array('class' => 'form-control')) ?>
                            </div>%
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Abdominal:</div>
                            <div class="col-md-5">
                                <?php echo form_input($abdominal + array('class' => 'form-control')) ?>
                            </div>cm
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Waist:</div>
                            <div class="col-md-5">
                                <?php echo form_input($waist + array('class' => 'form-control')) ?>
                            </div>cm
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Hip:</div>
                            <div class="col-md-5">
                                <?php echo form_input($hip + array('class' => 'form-control')) ?>
                            </div>cm
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
                                        <div class="form-group">
                                            <div class="col-md-5">Arm Relaxed:</div>
                                            <div class="col-md-6">
                                                <?php echo form_input($ls_arm_relaxed + array('class' => 'form-control')) ?>
                                            </div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Arm Flexed:</div>
                                            <div class="col-md-6">
                                                <?php echo form_input($ls_arm_flexed + array('class' => 'form-control')) ?>
                                            </div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Forearm:</div>
                                            <div class="col-md-6">
                                                <?php echo form_input($ls_forearm + array('class' => 'form-control')) ?>
                                            </div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Wrist:</div>
                                            <div class="col-md-6">
                                                <?php echo form_input($ls_wrist + array('class' => 'form-control')) ?>
                                            </div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Thigh (gluteal):</div>
                                            <div class="col-md-6">
                                                <?php echo form_input($ls_thigh_gluteal + array('class' => 'form-control')) ?>
                                            </div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Thigh (mid):</div>
                                            <div class="col-md-6">
                                                <?php echo form_input($ls_thigh_mid + array('class' => 'form-control')) ?>
                                            </div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Kalf:</div>
                                            <div class="col-md-6">
                                                <?php echo form_input($ls_calf + array('class' => 'form-control')) ?>
                                            </div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Ankle:</div>
                                            <div class="col-md-6">
                                                <?php echo form_input($ls_ankle + array('class' => 'form-control')) ?>
                                            </div>cm
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-5">Arm Relaxed:</div>
                                            <div class="col-md-6">
                                                <?php echo form_input($rs_arm_relaxed + array('class' => 'form-control')) ?>
                                            </div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Arm Flexed:</div>
                                            <div class="col-md-6">
                                                <?php echo form_input($rs_arm_flexed + array('class' => 'form-control')) ?>
                                            </div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Forearm:</div>
                                            <div class="col-md-6">
                                                <?php echo form_input($rs_forearm + array('class' => 'form-control')) ?>
                                            </div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Wrist:</div>
                                            <div class="col-md-6">
                                                <?php echo form_input($rs_wrist + array('class' => 'form-control')) ?>
                                            </div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Thigh (gluteal):</div>
                                            <div class="col-md-6">
                                                <?php echo form_input($rs_thigh_gluteal + array('class' => 'form-control')) ?>
                                            </div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Thigh (mid):</div>
                                            <div class="col-md-6">
                                                <?php echo form_input($rs_thigh_mid + array('class' => 'form-control')) ?>
                                            </div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Kalf:</div>
                                            <div class="col-md-6">
                                                <?php echo form_input($rs_calf + array('class' => 'form-control')) ?>
                                            </div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Ankle:</div>
                                            <div class="col-md-6">
                                                <?php echo form_input($rs_ankle + array('class' => 'form-control')) ?>
                                            </div>cm
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="pad_footer">
                <?php echo form_input($submit_button) ?> or <a href="<?php echo base_url() ?>applications/gympro/manage_assessments">Go Back</a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>