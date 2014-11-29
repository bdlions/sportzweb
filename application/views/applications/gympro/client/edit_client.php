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

        <!--ADDING CLIENT-->
        <div class="col-md-7">
            <div class="pad_title">
                EDIT CLIENT
            </div>
            <div class="pad_body">
                <?php if (isset($message) && ($message != NULL)): ?>
                    <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
                <?php endif; ?>
                <?php echo form_open("applications/gympro/create_client", array('id' => '', 'class' => 'form-horizontal')); ?>
                    <!--<div class="row" style="display: none">-->
                    <div class="row hidden_tab" id="add_client" style="display: block">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">First Name: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($first_name + array('class' => 'form-control'));?>
                                </div>
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
                                    <input type="radio" checked="" name="gender_id" value="1"> Male
                                    <br>
                                    <input type="radio" name="gender_id" value="2"> Female 
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
                                    <input type="radio" checked="" name="status_id"> Active
                                    <br>
                                    <input type="radio" name="status_id"> Inactive 
                                    <br>
                                    <input type="radio" name="status_id"> Potential 
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
                                <label class="col-sm-4 control-label">Photo: </label>
                                <div class="col-sm-4">
                                    <?php echo form_input($picture);?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--CONTACT DETAILS-->
                    <!--<div class="row" style="display: none">-->
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
                                <div class="col-sm-4"></div>
                                <div class="col-sm-8">
                                    <p>
                                    If sending SMS reminders please use an international format and include both country and area code and avoid spaces. <br>For example: <br>New Zealand: 64212614687<br>Australia: 61407142657
                                    </p>
                                    <a>See a list of supported mobile networks worldwide.</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Receive SMS alerts </label>
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="rcv_sms" value="yes"> Yes
                                    <br>
                                    <input type="radio" name="rcv_sms" value="no"> No 
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

                    <!--HEALTH QUESTIONS-->
                    <!--<div class="row" style="display: none">-->
                    <div class="row hidden_tab" id="health">
                        <div class="col-md-12">
                            <?php foreach ($question_list as $question):?>
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota"><?php echo $question['title']?></label>
                                    </div>
                                    <div  style="float: left">
                                        Additional info: 
                                    </div>
                                    <?php echo form_input($smoker_txt + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <?php endforeach;?>
<!--                            iashgdghaishduasu
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota"><?php echo $question_list[0]['title']?></label>
                                    </div>
                                    <div  style="float: left">
                                        Additional info: 
                                    </div>
                                    <?php echo form_input($smoker_txt + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota"><?php echo $question_list[1]['title']?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota"><?php echo $question_list[2]['title']?></label>
                                    </div>
                                    <div  style="float: left">
                                        Additional info: 
                                    </div>
                                    <?php echo form_input($cardiov_txt + array('class' => 'form-control'));?>
                                </div>
                            </div>                            
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota">High cholesterol?</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota">Overweight?</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota">Any injuries or orthopaedic problems?</label>
                                    </div>
                                    <div  style="float: left">
                                        Additional info: 
                                    </div>
                                    <?php echo form_input($injury_txt + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota">Taking any prescribed medication or dietary supplements?</label>
                                    </div>
                                    <div  style="float: left">
                                        Additional info: 
                                    </div>
                                    <?php echo form_input($medication_txt + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <div class="col-sm-4">
                                    <input type="radio" checked="" name="smoker" value="yes"> Yes
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="smoker" value="no"> No 
                                </div>
                                <div class="col-sm-6">
                                    <div>
                                        <label class="patapota">Any other medical conditions or problems not previously mentioned?</label>
                                    </div>
                                    <div  style="float: left">
                                        Additional info: 
                                    </div>
                                    <?php echo form_input($medicalcondition_txt + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <label class="col-sm-4 patapota">Height: </label>
                                <div class="col-sm-4">
                                    <?php echo form_input($height + array('class' => 'form-control'));?>cm
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <label class="col-sm-4 patapota">Resting Heart Rate: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($reseting_heart_rate + array('class' => 'form-control'));?>
                                </div>
                            </div>
                            <div class="form-group pad_lines">
                                <label class="col-sm-4 patapota">Blood Pressure: </label>
                                <div class="col-sm-6">
                                    <?php echo form_input($blood_pressure + array('class' => 'form-control'));?>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <!--NOTES-->
                    <!--<div class="row" style="display: none">-->
                    <div class="row hidden_tab" id="notes">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Notes: </label>
                                <div class="col-sm-8">
                                    <textarea class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                <div>
                    <?php echo form_input($submit_button);?>
                     or <a href="<?php echo base_url().'applications/gympro/manage_clients'?>" style="font-size: 16px; line-height: 22px;">Cancel</a>
                </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>