<div class="col-md-10" style="background-color: #F5F5F5">
    <div class="col-md-12" style="border-bottom: 1px solid #cccccc; padding-bottom: 8px;"><!--heading-->
        <div class="panel panel-default">
            <div class="panel-heading">Edit Configuration</div>
            <div class ="row">
                <div class="col-md-3"></div>
                <div class="col-md-9" style="padding-top: 10px;"><?php echo isset($message)? $message:""; ?></div>
            </div>
            <div class="panel-body">
                <div class="row form-horizontal form-background top-bottom-padding">  
                    <?php echo form_open("admin/applications_photography/edit_image/".$image_id, array('id' => 'form_edit_image', 'class' => 'form-horizontal'))?>
                    <div class="row">
                        <div class ="col-md-10 margin-top-bottom">                            
                            <div class="form-group">
                                <label for="type" class="col-md-3 control-label requiredField">
                                    Left Top
                                </label>
                                <div class ="col-md-9">
                                    <?php echo form_input($text1); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-md-3 control-label requiredField">
                                    Left Bottom
                                </label>
                                <div class ="col-md-9">
                                    <?php echo form_input($text2); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-md-3 control-label requiredField">
                                    Middle Top
                                </label>
                                <div class ="col-md-9">
                                    <?php echo form_input($text3); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-md-3 control-label requiredField">
                                    Middle Bottom
                                </label>
                                <div class ="col-md-9">
                                    <?php echo form_input($text4); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-md-3 control-label requiredField">
                                    Right Top
                                </label>
                                <div class ="col-md-9">
                                    <?php echo form_input($text5); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="col-md-3 control-label requiredField">
                                    Right Bottom
                                </label>
                                <div class ="col-md-9">
                                    <?php echo form_input($text6); ?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="type" class="col-md-3 control-label requiredField">
                                    
                                </label>
                                <div class ="col-md-9">   
                                    <div class="col-md-4 pull-right">
                                        <input id="btnEditImage" name="btnEditImage" type="submit" value="Update" class="btn button-custom pull-right"/>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</div>