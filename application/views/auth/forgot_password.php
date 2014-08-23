<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/bootstrap3/css/home.css">
<script type="text/javascript">
    $(function(){
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
                <?php echo lang('forgot_password_heading'); ?>
            </h2>
        </div>

        <?php echo sprintf(lang('forgot_password_subheading'), $identity_label); ?>

        <?php echo form_open("auth/forgot_password", array('class' => 'spacer', 'role' => 'form', 'class' => 'form-horizontal', 'id' => 'form-forget-password')); ?>
        <div class="form-group">
            <div class="col-md-2">
                <label for="email" class="control-label">
                    <?php echo sprintf(lang('forgot_password_email_label'), $identity_label); ?>
                </label>
            </div>
            <div class="col-md-10">
                <?php echo form_input($email + array('class' => 'form-control')); ?>
            </div>

        </div>

        <div class="form-group">
            <div class="col-md-2">
                <label for="email" class="control-label">
                    Question:
                </label>
            </div>
            <div class="col-md-10">
                <?php echo form_dropdown("question", $questions + array("" => "Select a Question"), "", "class='form-control'") ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-2">
                <label for="email" class="control-label">
                    Answer:
                </label>
            </div>
            <div class="col-md-10">
                <?php echo form_input(array('name' => 'answer', 'class' => 'form-control')) ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <?php echo form_submit(array('value' => lang('forgot_password_submit_btn'), 'class' => 'btn button-custom pull-right')); ?>
            </div>
        </div>
        <?php echo form_close(); ?>

            <?php 
        $class = "";
        if($message != ""){
            $class = "error-message";
        }
    ?>
    <div id="message" class="<?php echo $class?>"> <?php echo $message?></div>
    </div>
</div>
