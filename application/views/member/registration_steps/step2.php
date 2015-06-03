<script type="text/javascript">
    $(function() {
        $("#profile_information_back").on("click", function() {
            $("#member_profile_step2").removeClass("registration_steps_header_text");
            $("#member_profile_step3").removeClass("registration_steps_header_text");
            $("#member_profile_step1").addClass("registration_steps_header_text");
            kmrSimpleTabs.setStep(0);
        });

        // Setup form validation on the #register-form element
        $("#form-step2").validate({
            // Specify the validation rules
            rules: {
                birthday_month: {
                    required: true
                },
                birthday_day: {
                    required: true
                },
                birthday_year: {
                    required: true
                },
                gender_list: {
                    required: true
                },
                country_list: {
                    required: true
             },
            },
            // Specify the validation error messages
            messages: {
                birthday_month: {
                    required: "required"
                },
                birthday_day: {
                    required: "required"
                },
                birthday_year: {
                    required: "required"
                },
                gender_list: {
                    required: "required"
                },
                country_list: {
                    required: "required"               
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() ?>register/step2',
                    dataType: 'json',
                    data: $("#form-step2").serialize(),
                    success: function(data) {
                        
                        if (data === 1) {
                            $("#infoMessageProfile").text('Profile is updated.');
                            $("#member_profile_step1").removeClass("registration_steps_header_text");
                            $("#member_profile_step2").removeClass("registration_steps_header_text");
                            $("#member_profile_step3").addClass("registration_steps_header_text");
                            kmrSimpleTabs.setStep(2);
                        }
                        else {
                            $("#infoMessageProfile").text('Profile has not been updated.');
                        }
                    }
                });
                return false;
            }
        });

        //set the date of birth to 3 dropdown
        var dob = '<?php echo $dob ?>';
        if (dob) {
            var d = dob.split("-");
            $('#birthday_month').val(parseInt(d[1]));
            $('#birthday_day').val(parseInt(d[2]));
            $('#birthday_year').val(parseInt(d[0]));
        }

    });
</script>

<?php echo form_open("register/step2", array('id' => 'form-step2', 'role' => 'form', 'class' => 'form-horizontal')); ?>
<div class="row">
    <div class="col-md-7">
        <div class="row">
            <div class="form-group">
                <label for="gender_list" class="col-sm-4 control-label requiredField">Gender:</label>
                <div class="col-sm-8">
                    <?php echo form_dropdown("gender_list", (array('' => 'Select gender') + $gender_list), $gender_id, "class='form-control'") ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label requiredField">Country:</label>
                <div class="col-sm-8">
                    <?php echo form_dropdown("country_list", (array('' => 'Select country') + $country_list), $country_id, 'class="form-control"') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="country_list" class="col-sm-4 control-label   requiredField">Date Of Birth:</label>
                <div class="col-sm-8" >
                    <div class="col-sm-4 disable_padding_left">
                        
                        <?php echo form_dropdown('birthday_month', $month_list, 0, 'class=form-control id=birthday_month'); ?>
                    </div>
                    <div class="col-sm-4 disable_padding_left">
                        <?php echo form_dropdown('birthday_day', $date_list, 0, 'class=form-control id=birthday_day'); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php echo form_dropdown('birthday_year', $year_list, 0, 'class=form-control id=birthday_year'); ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Home Town:</label>
                <div class="col-sm-8">
                    <?php echo form_input(array('name' => 'home_town', 'id' => 'home_town', 'value' => $home_town, 'class' => 'form-control', 'type' => 'text')); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">School/College/University:</label>
                <div class="col-sm-8">
                    <?php echo form_input(array('name' => 'college', 'id' => 'college', 'value' => $college, 'class' => 'form-control', 'type' => 'text')); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Employer:</label>
                <div class="col-sm-8">
                    <?php echo form_input(array('name' => 'employer', 'id' => 'employer', 'value' => $employer, 'class' => 'form-control', 'type' => 'text')); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Occupation:</label>
                <div class="col-sm-8">
                    <?php echo form_input(array('name' => 'occupation', 'id' => 'occupation', 'value' => $occupation, 'class' => 'form-control', 'type' => 'text')); ?>
                </div>
            </div>

        </div>
        <div class="row">
            <img src="resources/images/back.png">
            <a href="" id="profile_information_back">Back</a>
            <?php echo form_submit(array('id' => 'submit_profile', 'name' => 'submit_profile', 'value' => 'Save & Continue', 'type' => 'submit', 'class' => 'btn button-custom pull-right spacer')); ?>
        </div>
        <div class="row">
            <div id="message"></div>
        </div>
    </div>

</div>

<?php echo form_close(); ?>
