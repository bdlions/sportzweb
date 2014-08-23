<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/profile_setting.css">
<script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#next_btn').on('click', function() {
            if ($("#registration-form").valid() === true) {
                $('#step2').removeAttr("class").show(300);
                $("#left_box").remove();
                $("#middle_box").remove();
                //$("#right_box").empty();
                $("#step1").hide(300);
                Recaptcha.create('<?php echo $public_key?>',
                    "captcha_div",
                    {
                      theme: "clean",
                      callback: Recaptcha.focus_response_field
                    }
                );
                
            }
            return false;
        });
        
        $("#r_captcha_input").on("keypress", function(e){
            if(e.which === 13){
                e.preventDefault();
                $('#register_btn').trigger("click");
            }
        });
        
        $('#register_btn').on('click', function(event) {
            $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() ?>auth/captcha_check_client',
                    dataType: 'json',
                    data:$("#registration-form").serialize(),
                    success: function(data) {
                        if(data.is_valid){
                            $("#registration-form").submit();
                        }
                        else{
                            $("#message").text('<?php echo lang('captcha_error_msg')?>').attr('class', "error-message");
                            Recaptcha.create('<?php echo $public_key?>',
                                "captcha_div",
                                {
                                  theme: "clean",
                                  callback: Recaptcha.focus_response_field
                                }
                            );
                        }
                    }
                });
                return false;
         });
		 
        // Setup form validation on the #register-form element
        $("#registration-form").validate({
            // Specify the validation rules
            rules: {
                r_first_name: {
                    required: true
                },
                r_last_name: {
                    required: true
                },
                r_email: {
                    required: true,
                    email: true,
                    remote: {
                        url: '<?php echo base_url() ?>auth/check_email_client',
                        type: "post"
                    }
                },
                r_password: {
                    required: true,
                    minlength: 5
                },
                r_email_conf: {
                    required: true,
                    equalTo: "#r_email"
                }
            },
            // Specify the validation error messages
            messages: {
                r_first_name: {
                    required: "required"
                },
                r_last_name: {
                    required: "required"
                },
                r_password: {
                    required: "required",
                    minlength: "<?php echo lang('create_user_password_invalid_tooltip_label') ?>"
                },
                r_email: {
                    required: "required",
                    email: "<?php echo lang('create_user_email_invalid_tooltip_label') ?>",
                    remote: "<?php echo lang('create_user_email_duplicate') ?>"
                },
                r_email_conf: {
                    required: "required",
                    equalTo: "<?php echo lang('create_user_confirm_email_match_tooltip_label') ?>",
                }

            }
        });
    });    
</script>

<div class="row main">
    <div class="col-md-1" id="middle_box"></div>
    <div class="col-md-4" id="left_box">
        <?php echo form_open("business_profile", array('id' => 'login-form')); ?>
        <div class="form-group">
            <div class="home-left-tit home-left-tit12">Existing Members</div>
            <?php echo form_input($identity + array('class' => 'form-control')); ?>
        </div>
        <div class="form-group">
            <?php echo form_input($password + array('class' => 'form-control')); ?>
        </div>
        <div class="form-group">
            <?php echo form_input($login_btn + array('class' => 'btn button-custom pull-right')); ?>
        </div>  
        <?php echo form_close() ?>
    </div>
    
    <div class="col-md-2" id="middle_box"></div>
    
    <div class="col-md-4" id="right_box">
        <?php echo form_open("business_profile", array('id' => 'registration-form')); ?>

        <div id="step1">
            <div class="form-group">
                <div class="home-left-tit home-left-tit12">New Members</div>
                <?php echo form_input($r_first_name + array('class' => 'form-control')); ?>
            </div>

            <div class="form-group">
                <?php echo form_input($r_last_name + array('class' => 'form-control')); ?>
            </div>
            <div class="form-group">
                <?php echo form_input($r_email + array('class' => 'form-control')); ?>
            </div>
            <div class="form-group">
                <?php echo form_input($r_email_conf + array('class' => 'form-control')); ?>
            </div>
            <div class="form-group">
                <?php echo form_input($r_password + array('class' => 'form-control')); ?>
            </div>
            <div class="form-group">
                <?php echo form_input($next_btn + array('class' => 'btn button-custom pull-right')); ?>
            </div>   
        </div>

        <div id="step2" class="security-captcha">
            <div class="home-left-tit"><h2 class="home-left-title home-left-title2">Sign Up</h2></div>
            <h1><?php echo lang('security_check_label'); ?></h1>
            <?php echo lang('please_enter_the_characters_below_label'); ?>

            <div class="form-group">
                <div  id="captcha_div"> 
                </div>
            </div>
            <div class="form-group">
                <?php echo form_input($register_btn + array('class' => 'btn button-custom')); ?>
            </div>
        </div>

        <?php echo form_close(); ?>
        <div id="message"></div>
    </div>
</div>

