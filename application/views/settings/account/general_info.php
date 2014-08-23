<script type="text/javascript">
    $(function() {

        // Setup form validation on the #register-form element
        $("#form-general-info").validate({
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
                },  
                
            },
            submitHandler: function(form) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() ?>settings?menu=account',
                    dataType: 'text',
                    data: $("#form-general-info").serialize(),
                    success: function(data) {
                        if (data === '1') {
                            window.location = window.location;
                        }
                        else {

                        }
                    }
                });
                return false;
            }
        });

    });
</script>

<div class="panel panel-default">
    <div class="panel-heading">General settings</div>
    <div class="panel-body">
        <?php echo form_open("settings/general_info", array('id' => 'form-general-info', 'role' => 'form', 'class' => 'form-horizontal')); ?>
        <div class="row">
            <div class="col-md-10">
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-4"><div class="pull-right">Gender:</div></label>
                        <div class="col-sm-8"><?php echo $gender ?></div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-4"><div class="pull-right">Date Of Birth:</div></label>
                        <div class="col-sm-8" >
                            <?php 
                                $dob = explode(" ", $profile_info->dob);
                                echo $dob[0]; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label requiredField">Country:</label>
                        <div class="col-sm-8">
                            <?php echo form_dropdown("country_list", (array('' => 'Select country') + $country_list), $profile_info->country_id, 'class="form-control"') ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Home Town:</label>
                        <div class="col-sm-8">
                            <?php echo form_input(array('name' => 'home_town', 'id' => 'home_town', 'value' => $profile_info->home_town, 'class' => 'form-control', 'type' => 'text')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">School/College/University:</label>
                        <div class="col-sm-8">
                            <?php echo form_input(array('name' => 'college', 'id' => 'college', 'value' => $profile_info->clg_or_uni, 'class' => 'form-control', 'type' => 'text')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Employer:</label>
                        <div class="col-sm-8">
                            <?php echo form_input(array('name' => 'employer', 'id' => 'employer', 'value' => $profile_info->employer, 'class' => 'form-control', 'type' => 'text')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">Occupation:</label>
                        <div class="col-sm-8">
                            <?php echo form_input(array('name' => 'occupation', 'id' => 'occupation', 'value' => $profile_info->occupation, 'class' => 'form-control', 'type' => 'text')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label">About Me:</label>
                        <div class="col-sm-8">
                            <?php echo form_textarea(array('name' => 'about_me', 'rows' => '4', 'value' => $profile_info->about_me, 'class' => 'form-control', 'type' => 'text')); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php echo form_submit(array('id' => 'submit_profile', 'name' => 'submit_profile', 'value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right spacer')); ?>
                </div>
                <div class="row">
                    <div id="message"></div>
                </div>
            </div>

        </div>

        <?php echo form_close(); ?>
    </div>
</div>