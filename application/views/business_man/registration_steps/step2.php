<script type="text/javascript">
    $(function() {
        $("#business_profile_description_back").on("click", function(){
            $("#business_profile_step2").removeClass("registration_steps_header_text");
            $("#business_profile_step3").removeClass("registration_steps_header_text");
            $("#business_profile_step1").addClass("registration_steps_header_text");
            kmrSimpleTabs.setStep(0);
        });
        $('#business_profile_description_save').on('click', function() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>business_profile/update_business_descripton',
                dataType: 'text',
                data: $("#form-business-desc").serialize(),
                    success: function(data) {
                        if (data === '1') {
                            $("#business_profile_step1").removeClass("registration_steps_header_text");
                            $("#business_profile_step2").removeClass("registration_steps_header_text");
                            $("#business_profile_step3").addClass("registration_steps_header_text");
                            kmrSimpleTabs.setStep(2);
                        }
                        else {
                            alert("Cannot update profile");
                        }
                    }
            });
            return false;
        });
    });
</script>
<div class="row">
    <form id="form-business-desc">
        <div class="col-md-7">
            <div class="row new_line">Add your business description</div>        
            <div class="row new_line">
                <div class="form-group">
                    <?php echo form_textarea($business_description + array('class' => 'form-control new_line', 'rows' => '10', 'style' => 'width:100%')); ?>
                    <!--<textarea name="business_description" id="business_description" rows="10" style="width: 100%"></textarea>-->
                </div>            
            </div>
            <div class="row">
                <img src="resources/images/back.png">
                <a href="" id="business_profile_description_back">Back</a>
                <button id="business_profile_description_save" class="btn button-custom pull-right">Save & Continue</button>
            </div>
        </div>
    </form>
</div>