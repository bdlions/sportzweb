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
                <div class="row">
                    <div class="col-md-8">
                        <span>Client Info</span>
                    </div>                     
                </div>
            </div>
            <div style="border-top: 2px solid lightgray; margin-left: 20px"></div>
            <div class="pad_body">
                <?php if (isset($message) && ($message != NULL)){?>
                    <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
                <?php } ?>
                    <!--Personal details-->
                    <div class="row hidden_tab" id="add_client" style="display: block">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-sm-4 ">First Name:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['first_name'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Last Name:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['last_name'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Gender:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['gender_name'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Email:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['email'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Start Date:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['start_date'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">End Date:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['end_date'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Date of birth:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['dob'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Client Status:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['status_title'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Occupation:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['occupation'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Employer:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['employer'];?></label>
                            </div>
                            <div class="form-group">
                                <label for="website" class="col-md-4  requiredField">
                                    Picture: 
                                </label>
                                <div class ="col-md-6">                                    
                                    <div class="col-md-12">
                                        <div class="profile-picture-box pull-right" >
                                            <div id="files" class="files">
                                                <?php if(!empty($client_info['photo'])): ?>
                                                    <img style="width: 50px; height: 50px;" src="<?php echo base_url() . PROFILE_PICTURE_PATH_W50_H50 . $client_info['photo']; ?>" class="img-responsive"/>
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
                                <label class="col-sm-4 ">Telephone:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['telephone'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Mobile:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['mobile'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Address:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['address'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Emergency contact:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['emergency_contact'];?></label>                                
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Emergency phone:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['emergency_phone'];?></label>
                            </div>
                        </div>
                    </div>
                    <!--Health details-->
                    <div class="row hidden_tab" id="health">
                        <div class="col-md-12">
                            <?php foreach ($question_list as $question_info){ ?>
                                <div class="row form-group">
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
                            <div class="row form-group">
                                <label class="col-sm-4 ">Height (cm):</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['height'];?></label>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-4 ">Resting Heart Rate:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['resting_heart_rate'];?></label>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-4 ">Blood Pressure:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['blood_pressure'];?></label>
                            </div>
                        </div>
                    </div>
                    <!--Notes-->
                    <div class="row hidden_tab" id="notes">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-sm-4 ">Notes:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['notes'];?></label>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>