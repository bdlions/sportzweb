<script type="text/javascript">
    $(function() {

        var business_profile_types = <?php echo json_encode($business_profile_types) ?>;
        var sub_type_list = <?php echo json_encode($sub_type_list) ?>;
        var first_profile_type_id = Object.keys(business_profile_types)[0];
        $("#business_profile_types").change(function() {
            $("#sub_type_list").empty();
            $.each(sub_type_list[$(this).val()], function(key, value) {
                $("#sub_type_list").append("<option value=\"" + key + "\">" + value + "</option>");
            });
        });

        $.each(sub_type_list[first_profile_type_id], function(key, value) {
            $("#sub_type_list").append("<option value=\"" + key + "\">" + value + "</option>");
        });
        
                // Setup form validation on the #register-form element
        $("#business_profile_form").validate({
            // Specify the validation rules
            rules: {
                business_profile_types: {
                    required: true
                },
                business_name: {
                    required: true
                },
                business_email: {
                    required: true,
                    email: true
                },
                country_list: {
                    required: true
                }
            },
            // Specify the validation error messages
            messages: {
                business_profile_types: {
                    required: "required"
                },
                business_name: {
                    required: "required"
                },
                country_list: {
                    required: "required"
                },
                business_email: {
                    required: "required",
                    email: "<?php echo lang('create_user_email_invalid_tooltip_label') ?>"
                }

            }
            ,
            submitHandler: function(form) {
                    $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() ?>business_profile/create_profile',
                    dataType: 'text',
                    data: $("#business_profile_form").serialize(),
                        success: function(data) {
                            if (data === '1') {
                                $("#business_profile_step1").removeClass("registration_steps_header_text");
                                $("#business_profile_step3").removeClass("registration_steps_header_text");
                                $("#business_profile_step2").addClass("registration_steps_header_text");
                                kmrSimpleTabs.setStep(1);
                            }
                            else {
                                //alert("Cannot update profile");
                                var message = "Cannot update profile";
                                print_common_message(message);
                            }
                        }
                    });
                    return false;
                }
        });
        

    });
</script>
<?php echo form_open("",array('id' => 'business_profile_form', 'role' => 'form')) ?>
    <div class="row">
        <div class="col-md-6">
            <div class="col-md-12">Business Registration</div>
            <div class="form-group">
                <label class="control-label col-sm-4">Business profile type:</label> 
                <div class="col-sm-6">
                    <div class="row">
                        <?php echo form_dropdown('business_profile_types', $business_profile_types, '0', 'id="business_profile_types", class="form-control new_line"'); ?>
                    </div>
                    <div class="row">
                        <?php echo form_dropdown('sub_type_list', array(), '0', 'id="sub_type_list", class="form-control new_line"'); ?>
                    </div> 
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 requiredField">Business name:</label>
                <div class="col-md-6 disable_padding_all">
                    <?php echo form_input($business_name + array('class' => 'form-control new_line')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 requiredField">Street name:</label>
                <div class="col-md-6 disable_padding_all">
                    <?php echo form_input($street_name + array('class' => 'form-control new_line')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 requiredField">Address:</label>
                <div class="col-md-6 disable_padding_all">
                    <?php echo form_input($address + array('class' => 'form-control new_line')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 requiredField">City / Town:</label>
                <div class="col-md-6 disable_padding_all">
                    <?php echo form_input($business_city + array('class' => 'form-control new_line')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label requiredField">Country:</label>
                <div class="col-md-6 disable_padding_all">
                    <?php echo form_dropdown('business_country', array("" => "Select country") + $country_list, $profile_info == FALSE ? '0': $profile_info->country_id, 'class="form-control new_line"'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 requiredField">Post / Zip Code:</label>
                <div class="col-md-6 disable_padding_all">
                    <?php echo form_input($post_code + array('class' => 'form-control new_line')); ?>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label class="control-label col-md-5 requiredField">Business Tel:</label>
                <div class="col-md-7 disable_padding_all">
                    <?php echo form_input($telephone + array('class' => 'form-control new_line')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-5 requiredField">Business Email:</label>
                <div class="col-md-7 disable_padding_all">
                    <?php echo form_input($business_email + array('class' => 'form-control new_line')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-5 requiredField">Registered company number:</label>
                <div class="col-md-7 disable_padding_all">
                    <?php echo form_input($registered_company_number + array('class' => 'form-control new_line')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-5 requiredField">Business website address:</label>
                <div class="col-md-7 disable_padding_all">
                    <?php echo form_input($website_address + array('class' => 'form-control new_line')); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-5 requiredField">Business hour:</label>
                <div class="col-md-7 disable_padding_all">
                    <?php echo form_input($business_hour + array('class' => 'form-control new_line')); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-5"></div>
                <div class="col-md-7 disable_padding_all">
                    <?php echo form_submit(array('id' => 'submit_profile', 'name' => 'submit_profile', 'value' => 'Save & Continue', 'type' => 'submit', 'class' => 'btn button-custom pull-right spacer')); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12 disable_padding_all">
                    <div id="message"></div>
                </div>
            </div>
        </div>
    </div>
<?php echo form_close(); ?>
