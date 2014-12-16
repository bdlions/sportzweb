<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <!--left nav custom for this page-->
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#add_client').show();">Personal details</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#contact_details').show();">Contact details</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#health').show();">Health details</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#notes').show();">Notes</a>
            </div>
        </div>
        <!--ADDING CLIENT-->
        <div class="col-md-7">
            <div class="pad_title">
                Client Info
            </div>
            <div class="pad_body">
                <?php if (isset($message) && ($message != NULL)){?>
                    <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
                <?php } ?>
                <?php echo form_open("applications/gympro/create_client", array('id' => 'form_create_client', 'class' => 'form-horizontal', 'onsubmit' => 'return false;'))?>
                    <!--Personal details-->
                    <div class="row hidden_tab" id="add_client" style="display: block">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">First Name: </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['first_name'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Last Name: </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['last_name'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Gender </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['gender_name'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Email: </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['email'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Start Date: </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['start_date'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">End Date: </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['end_date'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Birth Date: </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['birth_date'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Client Status </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['status_title'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Occupation: </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['occupation'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Company Name: </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['company_name'];?></label>
                            </div>
                            <div class="form-group">
                                <label for="website" class="col-md-4 control-label requiredField">
                                    Picture: 
                                </label>
                                <div class ="col-md-6">                                    
                                    <div class="col-md-12">
                                        <div class="profile-picture-box pull-right" >
                                            <div id="files" class="files">
                                                <?php if(!empty($client_info['picture'])): ?>
                                                    <img style="width: 50px; height: 50px;" src="<?php echo base_url() . CLIENT_PROFILE_PICTURE_PATH_W50_H50 . $client_info['picture']; ?>" class="img-responsive"/>
                                                <?php endif; ?>
                                            </div>
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
                                <label class="col-sm-6 control-label"><?php echo $client_info['phone'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Mobile: </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['mobile'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Address: </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['address'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Emergency contact: </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['emergency_contact'];?></label>                                
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Emergency phone: </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['emergency_phone'];?></label>
                            </div>
                        </div>
                    </div>
                    <!--Health details-->
                    <div class="row hidden_tab" id="health">
                        <div class="col-md-12">
                            <?php foreach ($question_list as $question_info){ ?>
                                <div class="form-group pad_lines">
                                    <div class="col-sm-6">
                                        <div>
                                            <label class="patapota"><?php echo $question_info['title'].' '.$question_id_answer_map[$question_info['question_id']]['answer']?></label>
                                        </div>
                                        <div style="display: <?php echo($question_info['show_additional_info'] == 1) ? 'block' : 'none' ;?>" style="float: left">
                                            Additional info: 
                                            <?php
                                            if($question_info['show_additional_info'] == 1)
                                            {
                                                echo $question_id_answer_map[$question_info['question_id']]['additional_info'];
                                            }
                                            ?>
                                        </div>                                    
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Height (cm): </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['height'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Resting Heart Rate: </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['resting_heart_rate'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Blood Pressure: </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['blood_pressure'];?></label>
                            </div>
                        </div>
                    </div>
                    <!--Notes-->
                    <div class="row hidden_tab" id="notes">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Notes: </label>
                                <label class="col-sm-6 control-label"><?php echo $client_info['notes'];?></label>
                            </div>
                        </div>
                    </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>