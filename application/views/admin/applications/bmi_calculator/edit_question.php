<div class="panel panel-default">
    <div class="panel-heading">Edit Question</div>
    <div class="panel-body">
        <?php echo form_open("admin/applications_bmicalculator/edit_question/".$question_id, array('class' => 'form-horizontal')); ?>
            <div class="row">
                
                <div class ="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8" style="color: red;"><?php echo $message; ?></div>
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
                <label for="address" class="col-md-5 control-label requiredField">

                </label>
                <div class ="col-md-2 col-md-offset-4" style="margin-top: 10px">
                    <?php echo form_input($submit_edit_question+array('class'=>'form-control  btn button-custom')); ?>
                </div>
            </div>
            </div>    
        <?php echo form_close(); ?>
    </div>
</div>

