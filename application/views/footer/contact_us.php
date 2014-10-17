<div class="row col-md-12" style="height: 64px; font-size: 32px;">
    Contact Us
</div>
<div class ="row">
    <div class="col-md-4"></div>
    <div class="col-md-8"><?php echo $message; ?></div>
</div>
<div class="row col-md-12">
    <?php echo form_open("footer/contact_us", array('id' => 'form_add_feedback', 'class' => 'form-horizontal')); ?>
        
        <div class="col-md-3">
            <div style="font-size: 16px">
                Topic :
                <div class = "form-group">
                    <?php echo form_dropdown('topic_list', $topic_list, '', 'class=form-control id=topic_list'); ?>
                </div>
                Operating System :
                <div class = "form-group">
                    <?php echo form_dropdown('os_list', $os_list, '', 'class=form-control id=os_list'); ?> 
                </div>
                Browser :
                <div class = "form-group">
                    <?php echo form_dropdown('browser_list', $browser_list, '', 'class=form-control id=browser_list'); ?> 
                </div>
                Email address :
                <div class="form-group">
                    <?php echo form_input($email+array('class'=>'form-control')); ?>
                </div>
                Phone (optional) :
                <div class="form-group">
                    <?php echo form_input($phone+array('class'=>'form-control')); ?>
                </div>
            </div>
        </div>
        <div class="col-md-7 pull-right" style="font-size: 16px">
            Please describe your question, comment or concern. If you are reporting a site error, please include all relevent details (e.g. operating system, browser etc)
            <div class="form-group">          
                <?php echo form_textarea($description+array('class'=>'form-control')); ?>
            </div>
            <div class="form-group">
                <label for="submit_feedback" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_feedback+array('class'=>'btn button-custom pull-right')); ?>
                </div> 
            </div>
        </div>
    <?php echo form_close(); ?>
</div>
