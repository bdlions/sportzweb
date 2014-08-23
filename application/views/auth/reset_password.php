<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/home.css">
<script type="text/javascript">
    $(function() {
        // Setup form validation on the #register-form element
        $("#form-forget-password").validate({
            // Specify the validation rules
            rules: {
                question: {
                    required: true
                },
                answer: {
                    required: true
                },
                email: {
                    required: true
                }

            },
            // Specify the validation error messages
            messages: {
                question: {
                    required: "required"
                },
                answer: {
                    required: "required"
                },
                email: {
                    required: "required"
                }
            }
        });
    });
</script>
<div class="row">
    <div class="col-md-5">
        <div class="home-left-tit">
            <h2 class="home-left-title home-left-title2">
                <?php echo lang('reset_password_heading'); ?>
            </h2>
        </div>

        <?php echo form_open('auth/reset_password/' . $code, array('class' => 'spacer', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'form-forget-password')); ?>

        <div class="form-group">
            <div class="col-md-4">
                <label for="new_password" class="control-label">
                    <?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length); ?>
                </label>
            </div>
            <div class="col-md-8">
                <?php echo form_input($new_password + array('class' => 'form-control')); ?>
            </div>

        </div>

        <div class="form-group">
            <div class="col-md-4">
                <label for="new_password" class="control-label">
                    <?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm'); ?> 
                </label>
            </div>
            <div class="col-md-8">
                <?php echo form_input($new_password_confirm + array('class' => 'form-control')); ?>
            </div>
            <?php echo form_input($user_id); ?>
            <?php echo form_hidden($csrf); ?>

        </div>
        <div class="form-group">
            <div class="col-md-12">
                <?php echo form_submit(array('value' => lang('reset_password_submit_btn'), 'class' => 'btn button-custom pull-right')); ?>
            </div>
        </div>
        <?php
        echo form_close();
        $class = "";
        if ($message != "") {
            $class = "error-message";
        }
        ?>
        <div id="message" class="<?php echo $class ?>"> <?php echo $message ?></div>
    </div>
</div>
