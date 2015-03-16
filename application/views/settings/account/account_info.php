<script type="text/javascript">
    $(function(){
        $('a[href="#update_name"]').on("click", function(){
            collapse_all_form();
            $("#update_name_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_email"]').on("click", function(){
            collapse_all_form();
            $("#update_email_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_password"]').on("click", function(){
            collapse_all_form();
            $("#update_password_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_language"]').on("click", function(){
            collapse_all_form();
            $("#update_language_form").removeClass("hidden");
            return false;
        });
        
        
        // Setup form validation on the #register-form element
        $("#update_name_form").validate({
            // Specify the validation rules
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                password: {
                    required: true
                }
            
            },
            // Specify the validation error messages
            messages: {
                first_name: {
                    required: "required"
                },
                last_name: {
                    required: "required"
                },
                password: {
                    required: "required"
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() ?>settings?menu=account&sub_menu=account_info&section=update_name',
                    dataType: 'text',
                    data: $("#update_name_form").serialize(),
                    success: function(data) {
                        if (data === '1') {
                            window.location = window.location;
                        }
                        else {
                            alert("Error");
                        }
                    }
            });
                return false;
            }
        });
        
                
        // Setup form validation on the #register-form element
        $("#update_email_form").validate({
            // Specify the validation rules
            rules: {
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: '<?php echo base_url() ?>auth/check_email_client',
                        type: "post"
                    }
                },
                password: {
                    required: true
                }
            
            },
            // Specify the validation error messages
            messages: {
                email: {
                    required: "required",
                    email: "<?php echo lang('create_user_email_invalid_tooltip_label') ?>",
                    remote: "<?php echo lang('create_user_email_duplicate') ?>"
                },
                password: {
                    required: "required"
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() ?>settings?menu=account&sub_menu=account_info&section=update_email',
                    dataType: 'text',
                    data: $("#update_email_form").serialize(),
                    success: function(data) {
                        if (data === '1') {
                            window.location = window.location;
                        }
                        else {
                            alert("Error");
                        }
                    }
            });
                return false;
            }
        });
        
                // Setup form validation on the #register-form element
        $("#update_password_form").validate({
            // Specify the validation rules
            rules: {
                password: {
                    required: true
                },
                new_password: {
                    required: true
                },
                confirm_password: {
                    required: true,
                    equalTo: "#new_password"
                }
            
            },
            // Specify the validation error messages
            messages: {
                password: {
                    required: "required"
                },
                new_password: {
                    required: "required"
                },
                confirm_password: {
                    required: "required",
                    equalTo: "<?php echo lang('create_user_confirm_email_match_tooltip_label') ?>"
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() ?>settings?menu=account&sub_menu=account_info&section=update_password',
                    dataType: 'text',
                    data: $("#update_password_form").serialize(),
                    success: function(data) {
                        if (data === '1') {
                            window.location = window.location;
                        }
                        else {
                            alert("Error");
                        }
                    }
            });
                return false;
            }
        });
        
        function collapse_all_form(){
            $("#update_name_form").addClass("hidden");
            $("#update_email_form").addClass("hidden");
            $("#update_password_form").addClass("hidden");
            $("#update_language_form").addClass("hidden");
        }
    });
</script>
<div class="panel panel-default">
    <div class="panel-heading">Account settings</div>
    <div class="panel-body">
        <div class="col-md-12">
            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">Name:</label>
                    <div class="col-md-7">
                        <?php echo $general_info->first_name . " " . $general_info->middle_name . " " . $general_info->last_name ?>
                        <?php echo form_open("", array('id' => 'update_name_form', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                        <div class="form-group">
                            <label class="col-md-4">First:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'first_name', 'value' => $general_info->first_name, 'class' => 'form-control', 'type' => 'text')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4">Middle:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'middle_name', 'value' => $general_info->middle_name, 'placeholder' => 'Optional', 'class' => 'form-control', 'type' => 'text')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4">Last:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'last_name', 'value' => $general_info->last_name, 'class' => 'form-control', 'type' => 'text')); ?>
                            </div>
                        </div>
                        To save these settings please enter your <?php echo WEBSITE_TITLE; ?> password
                        <div class="form-group">
                            <label class="col-md-4">Password:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <?php echo form_submit(array('id' => 'update_name', 'name' => 'update_name', 'value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-2">
                        <a href="#update_name">Edit</a>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">Email:</label>
                    <div class="col-md-7">
                        <?php echo $general_info->email ?>
                        <?php echo form_open("", array('id' => 'update_email_form', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                        <div class="form-group">
                            <label class="col-md-4">New Email:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'email', 'value' => $general_info->email, 'class' => 'form-control', 'type' => 'text')); ?>
                            </div>
                            <div class="col-md-12">You will need to click the link inside your inbox to verify your new email account</div>
                        </div>
                        To save these settings please enter your <?php echo WEBSITE_TITLE; ?> password
                        <div class="form-group">
                            <label class="col-md-4">Password:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <?php echo form_submit(array('id' => 'update_name', 'name' => 'update_name', 'value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-2">
                        <a href="#update_email">Edit</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">Password:</label>
                    <div class="col-md-7">
                        *****
                        <?php echo form_open("", array('id' => 'update_password_form', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                        <div class="form-group">
                            <label class="col-md-4">Current Password:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4">New Password:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'new_password', 'id' => 'new_password', 'class' => 'form-control', 'type' => 'password')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4">Confirm Password:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'confirm_password', 'id' => 'confirm_password', 'class' => 'form-control', 'type' => 'password')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <?php echo form_submit(array('id' => 'update_name', 'name' => 'update_name', 'value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-2">
                        <a href="#update_password">Edit</a>
                    </div>
                </div>
            </div>
            <div class="row spacer">
                <div class="form-group">
                    <label class="col-md-3 control-label">Language:</label>
                    <div class="col-md-7">
                        English(UK)
                        <?php echo form_open("", array('id' => 'update_language_form', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                        <div class="form-group">
                            <label class="col-md-4">Choose Language:</label>
                            <div class="col-md-8">
                                <?php echo form_dropdown("language", array('' => 'Select Language', '1' => 'English(UK)'), "1", "class=form-control"); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <?php echo form_submit(array('id' => 'update_language', 'name' => 'update_language', 'value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-2">
                        <a href="#update_language" >Edit</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div id="message"></div>
            </div>
        </div>
    </div>
</div>