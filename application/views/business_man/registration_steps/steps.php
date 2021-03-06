<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>resources/css/simpletabs.css">
<script type="text/javascript" src="<?php echo base_url() ?>resources/js/simpletabs_1.3.js"></script>
<script type="text/javascript">
    $(function() {
        $("#skip_step1").on("click", function() {
            kmrSimpleTabs.setStep(1);
            return false;
        });
        $("#submit_step1").on("click", function() {
            kmrSimpleTabs.setStep(1);
            return false;
        });
        $("#skip_step2").on("click", function() {
            kmrSimpleTabs.setStep(2);
            return false;
        });
        $("#submit_step2").on("click", function() {
            kmrSimpleTabs.setStep(2);
            return false;
        });
        $("#back_step2").on("click", function() {
            kmrSimpleTabs.setStep(0);
            return false;
        });
        $("#back_step3").on("click", function() {
            kmrSimpleTabs.setStep(1);
            return false;
        });
    });
</script>
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-1 steps_header registration_steps_header_text" id="business_profile_step1">
                <div class="row steps_number">1</div>
                <div class="row">Registration</div>
            </div>
            <div class="col-md-3 partial_blue_border"></div>
            <div class="col-md-1 steps_header" id="business_profile_step2">
                <div class="row steps_number">2</div>
                <div class="row">Description</div>
            </div>
            <div class="col-md-3 partial_blue_border"></div>
            <div class="col-md-1 steps_header" id="business_profile_step3">
                <div class="row">3</div>
                <div class="row">Image</div>
            </div>
	</div>
        <div class="row steps_div"></div>
        <div class="simpleTabs">
            <ul class="simpleTabsNavigation">
                <li><a href="#"></a></li>
                <li><a href="#"></a></li>
                <li><a href="#"></a></li>
            </ul>
            <div id="step1" class="simpleTabsContent">
                <?php $this->load->view("business_man/registration_steps/step1"); ?>
            </div>

            <div id="step2" class="simpleTabsContent">
                <?php $this->load->view("business_man/registration_steps/step2"); ?>
            </div>

            <div id="step3" class="simpleTabsContent">
                <?php $this->load->view("business_man/registration_steps/step3"); ?>
            </div>
        </div>
    </div>
</div>
