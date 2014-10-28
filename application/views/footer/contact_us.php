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
                <div class="form-group">
                    <div class ="row">
                        Topic
                    </div> 
                    <div class ="row">
                        <?php echo form_dropdown('topic_list', $topic_list, '', 'class=form-control id=topic_list'); ?>
                    </div> 
                </div>
                <div class="form-group">
                    <div class ="row">
                        Operating System :
                    </div> 
                    <div class ="row">
                        <?php echo form_dropdown('os_list', $os_list, '', 'class=form-control id=os_list'); ?> 
                    </div> 
                </div>
                <div class="form-group">
                    <div class ="row">
                        Browser :
                    </div> 
                    <div class ="row">
                        <?php echo form_dropdown('browser_list', $browser_list, '', 'class=form-control id=browser_list'); ?> 
                    </div> 
                </div>
                <div class="form-group">
                    <div class ="row">
                        Name :
                    </div> 
                    <div class ="row">
                        <?php echo form_input($name+array('class'=>'form-control')); ?>
                    </div> 
                </div>
                <div class="form-group">
                    <div class ="row">
                        Email address :
                    </div> 
                    <div class ="row">
                        <?php echo form_input($email+array('class'=>'form-control')); ?>
                    </div> 
                </div>
                <div class="form-group">
                    <div class ="row">
                        Phone (optional) :
                    </div> 
                    <div class ="row">
                        <?php echo form_input($phone+array('class'=>'form-control')); ?>
                    </div> 
                </div>                
            </div>
        </div>
        <div class="col-md-7 pull-right" style="font-size: 16px">
            <div class="form-group">
                <div class ="row" style="padding-bottom:25px;">
                    Please describe your question, comment or concern. If you are reporting a site error, please include all relevent details (e.g. operating system, browser etc)
                </div> 
                <div class ="row">
                    <?php echo form_textarea($description+array('class'=>'form-control')); ?>
                </div> 
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
