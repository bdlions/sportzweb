<div class="row" style="height: 64px; font-size: 32px;">
    <div class="col-md-12">
        Contact Us
    </div>
</div>
<div class ="row">
      <div class="col-md-12">
    <?php if (isset($message) && ($message != NULL)){?>
        <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
    <?php } ?>
</div>
</div>
<div class="row">
    <?php echo form_open("footer/contact_us", array('id' => 'form_add_feedback', 'class' => 'form-horizontal')); ?>
        <div class="col-md-4">
            <div style="font-size: 14px">
                    <div class ="row col-md-12 form-group">
                        Name :
                    </div> 
                    <div class ="row col-md-12 form-group">
                        <?php echo form_input($name+array('class'=>'form-control')); ?>
                    </div> 
                </div>
                    <div class ="row col-md-12 form-group">
                        Email address :
                    </div> 
                    <div class ="row col-md-12 form-group">
                        <?php echo form_input($email+array('class'=>'form-control')); ?>
                    </div> 
                    <div class ="row col-md-12 form-group">
                        Phone (optional) :
                    </div> 
                    <div class ="row col-md-12 form-group">
                        <?php echo form_input($phone+array('class'=>'form-control')); ?>
                    </div> 
                <div class="row col-md-12 form-group">
                        <br/>
                        Sonuto<br/>
                        Trinity House<br/>
                        Heather Park Drive<br/>
                        Wembley<br/>
                        Greater London<br/>
                        HA0 1SU<br/>
                        <br/>
                        Tel: 020 3397 8425<br/>
                        Email: info@sonuto.com
                     
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
                <div class ="">
                    <?php echo form_input($submit_feedback+array('class'=>'btn button-custom pull-right')); ?>
                </div> 
            </div>
        </div>
    <?php echo form_close(); ?>
</div>
