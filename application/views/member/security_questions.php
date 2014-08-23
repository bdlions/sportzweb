<script type="text/javascript">
    $(function(){
        $('[name="question_set_1"]').on('change', function(){
            //console.log($(this).val());
            if($(this).val() !== ""){
                $("[name='question_set_2'] option[value='"+$(this).val()+"']").remove();
                $("[name='question_set_3'] option[value='"+$(this).val()+"']").remove();
            }
        });
        $('[name="question_set_2"]').on('change', function(){
            //console.log($(this).val());
            if($(this).val() !== ""){
                $("[name='question_set_1'] option[value='"+$(this).val()+"']").remove();
                $("[name='question_set_3'] option[value='"+$(this).val()+"']").remove();
            }
        });
        $('[name="question_set_3"]').on('change', function(){
            //console.log($(this).val());
            if($(this).val() !== ""){
                $("[name='question_set_1'] option[value='"+$(this).val()+"']").remove();
                $("[name='question_set_2'] option[value='"+$(this).val()+"']").remove();
            }
        });
                // Setup form validation on the #register-form element
        $("#form-security-question").validate({
            // Specify the validation rules
            rules: {
                question_set_1: {
                    required: true
                },
                question_set_2: {
                    required: true
                },
                question_set_3: {
                    required: true
                },
                answer_1: {
                    required: true
                },
                answer_2: {
                    required: true
                },
                answer_3: {
                    required: true
                },
            
            },
            // Specify the validation error messages
            messages: {
                question_set_1: {
                    required: "required"
                },
                question_set_2: {
                    required: "required"
                },
                question_set_3: {
                    required: "required"
                },
                answer_1: {
                    required: "required"
                },
                answer_2: {
                    required: "required"
                },
                answer_3: {
                    required: "required"
                }
            },
            submitHandler: function(form) {
                //return false;
                form.submit();
            }
        });
    });
    
</script>
<?php echo "<h3 class=\"questions_header\">Please complete the following security questions</h3>";?>
<div class="col-md-4">
    <?php
    
    echo form_open("register/security_questions", array('id' => 'form-security-question', 'class' => 'spacer'));

    $question_set_no = 1;
    foreach ($question_sets as $question_set) {
        ?>
        <div class="form-group">

            <?php echo form_dropdown('question_set_' . $question_set_no, array("" => "Select a Question") + $question_set, "", "class='form-control'") ?>

        </div>
        <div class="form-group">
            <?php echo form_input(array('name' => 'answer_' . $question_set_no, 'class' => 'form-control')) ?>

        </div>
        <?php
        $question_set_no++;
    }
    ?>
    <div class="form-group">
        <input type="submit" value="Submit & continue" class="btn button-custom pull-right"/>
    </div>
    <?php echo form_close(); ?>
    <div id="message"></div>
    
</div>