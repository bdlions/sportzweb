<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <!--left nav custom for this page-->
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#add_client').show();">Client Info</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#contact_details').show();">Contact Details</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#health').show();">Health Questions</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#notes').show();">Notes</a>
            </div>
        </div>
        <div class="col-md-7">
            <div class="pad_title">
                SHOW CLIENT
            </div>
            <div class="pad_body">
                <?php if (isset($message) && ($message != NULL)): ?>
                    <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
                <?php endif; ?>
                <?php echo form_open("applications/gympro/edit_client/".$client_info['client_id'], array('id' => 'form_edit_client', 'class' => 'form-horizontal', 'onsubmit' => 'return false;'))?>
                    <!--Personal details-->
                    <div class="row hidden_tab" id="add_client" style="display: block">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">First Name: </label>
                                <div class="col-sm-8 info_view"><?php echo $client_info['first_name'];?></div>
<!--                                <div class="col-sm-6">
                                    <?php echo form_input($first_name + array('class' => 'form-control'));?>
                                </div>-->
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Last Name: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($last_name + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Gender </label>
                                <div class="col-sm-4">
                                    <?php echo form_dropdown('gender_list', $gender_list, $selected_gender_id, 'class=form-control id=gender_list'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Email: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($email + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Start Date: </label>
                                <div class="col-sm-4">
                                    <?php echo form_input($start_date + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">End Date: </label>
                                <div class="col-sm-4">
                                    <?php echo form_input($end_date + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Birth Date: </label>
                                <div class="col-sm-4">
                                    <?php echo form_input($birth_date + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Client Status </label>
                                <div class="col-sm-4">
                                    <?php echo form_dropdown('client_status_list', $client_status_list, $selected_status_id, 'class=form-control id=client_status_list'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Occupation: </label>
                                <div class="col-sm-4">
                                    <?php echo form_input($occupation + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Company Name: </label>
                                <div class="col-sm-4">
                                    <?php echo form_input($company_name + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="website" class="col-md-4 control-label requiredField">
                                    Set picture
                                </label>
                                <div class ="col-md-8">
                                    <div class="profile-picture-box" >
                                        <div id="files" class="files">
                                            <?php if (!empty($client_info['picture'])): ?>
                                                <img style="width: 50px; height: 50px;" src="<?php echo base_url() . CLIENT_PROFILE_PICTURE_PATH_W50_H50 . $client_info['picture']; ?>" class="img-responsive"/>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Contact details-->
                    <div class="row hidden_tab" id="contact_details">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Phone: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($phone + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Mobile: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($mobile + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Address: </label>
                                <div class="col-sm-8">
                                    <?php echo form_textarea($address);?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Emergency contact: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($emergency_contact + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Emergency phone: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($emergency_phone + array('class' => 'form-control'));?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Health questions-->
                    <div class="row hidden_tab" id="health">
                        <div class="col-md-12">
                            <?php foreach ($question_list as $question_info){ ?>
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" <?php echo($question_id_answer_map[$question_info['question_id']]['answer'] == 'yes') ? 'checked=""' : '' ;?> name="question_radio_<?php echo $question_info['question_id']?>" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" <?php echo($question_id_answer_map[$question_info['question_id']]['answer'] == 'no') ? 'checked=""' : '' ;?> name="question_radio_<?php echo $question_info['question_id']?>" value="no"> No 
                                    <input type="hidden" value="question_id_<?php echo $question_info['question_id']?>">
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota"><?php echo $question_info['title']?></label>
                                    </div>
                                    <div style="display: <?php echo($question_info['show_additional_info'] == 1) ? 'block' : 'none' ;?>" style="float: left">
                                        Additional info: 
                                    </div>
                                    <input value="<?php echo $question_id_answer_map[$question_info['question_id']]['additional_info']?>" style="display: <?php echo($question_info['show_additional_info'] == 1) ? 'block' : 'none' ;?>" class="form-control" type="text" id="question_additional_info_<?php echo $question_info['question_id']?>" name="question_additional_info_<?php echo $question_info['question_id']?>">
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Height (cm): </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($height + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Resting Heart Rate: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($resting_heart_rate + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Blood Pressure: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($blood_pressure + array('class' => 'form-control'));?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Notes-->
                    <div class="row hidden_tab" id="notes">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Notes: </label>
                                <div class="col-sm-8">
                                    <?php echo form_textarea($notes + array('class' => 'form-control'));?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>