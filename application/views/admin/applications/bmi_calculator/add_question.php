<div class="panel panel-default">
    <div class="panel-heading">Add Question</div>
    <div class="panel-body">
        <?php echo form_open("admin/applications_bmicalculator/add_question/", array('class' => 'form-horizontal')); ?>
            <div class="row">
                
                <div class ="row">
                    <div class="col-md-4"></div>
                    <?php if( isset($flag) && $flag == 0):?>
                        <div class="col-md-8" style="color: red;"><?php echo $message; ?>
                        </div>
                    <?php endif;?>
                    <?php if( isset($flag) && $flag == 1):?>
                        <div class="col-md-8" style="color: blue;"><?php echo $message; ?>
                        </div>
                    <?php endif;?>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2"><div class="pull-right">Question : </div></label>
                    <div class="col-sm-9">
                        <?php echo form_textarea($question + array('class' => 'form-control')); ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-sm-2 control-label requiredField"><div class="pull-right" style="margin-top: 10px; ">Answer : </div></label>
                    <div class="col-sm-9" style="margin-top: 10px; ">
                        <?php echo form_textarea($answer + array('class' => 'form-control')); ?>
                    </div>
                </div>
                <div class="form-group">
                
                    <div class ="col-md-12" style="margin-top: 10px">
                        <div class="col-md-2 col-md-push-1">
                             <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
                        </div>
                        <div class="col-md-2 col-md-offset-7">
                             <?php echo form_input($submit_add_question+array('class'=>'form-control  btn button-custom')); ?>
                        </div>    
                    </div>
                
               </div>
            </div>    
        <?php echo form_close(); ?>
    </div>
</div>

