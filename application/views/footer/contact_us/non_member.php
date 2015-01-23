<div class="row col-md-12" style="height: 64px; font-size: 32px;padding:0px">
    Contact Us
</div>
<div class ="row col-md-12" style="padding:0px">
    <?php if (isset($message) && ($message != NULL)){?>
        <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
    <?php } ?>
</div>
<div class="row col-md-12">
    <?php echo form_open("footer/contact_us", array('id' => 'form_add_feedback', 'class' => 'form-horizontal')); ?>
        <div class="col-md-3">
            <div style="font-size: 14px">
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
                <div class="form-group">
                    <div class ="row">
                        </br>
                        Sonuto</br>
                        Westgate House</br>
                        Westgate Road</br>
                        London</br>
                        W5 1YY</br>
                        </br>
                        E:Enquired@sonuto.com</br>
                        T:020 3397 8425
                    </div> 
                     
                </div>
            </div>
        </div>
        <div class="col-md-7 pull-right" style="font-size: 14px">
            <div class="form-group">
                <div class ="row" style="padding-bottom:25px;">
                    Please describe your question, comment or concern.
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
