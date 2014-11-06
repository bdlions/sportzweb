<div class="panel panel-default">
    <div class="panel-heading">Create New Color</div>
    <div class="panel-body">
        <div class="row">            
            <div class="col-md-12">

                <div class="row form-horizontal form-background top-bottom-padding">  
                    <?php echo form_open("admin/applications_shop/create_color", array('id' => 'form_create_color', 'class' => 'form-horizontal', 'onsubmit' => 'return false;')) ?>
                    <div class="row">
                        <div class ="col-md-10 margin-top-bottom">                            
                            <div class="form-group">
                                <label for="input_color_title" class="col-md-3 control-label requiredField">
                                    Color Title
                                </label>
                                <div class ="col-md-9">
                                    <input id="input_color_title" name="input_color_title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="input_color_desc" class="col-md-3 control-label requiredField">
                                    Color Description
                                </label>
                                <div class ="col-md-9">
                                    <input id="input_color_desc" name="input_color_desc">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="website" class="col-md-3 control-label requiredField">
                                    Set picture
                                </label>
                                <div class ="col-md-9">
                                    <div class="col-md-9">
                                        <div class="row fileinput-button">
                                            <button class="btn button-custom">Upload a photo</button>
                                            <input id="fileupload" type="file" name="userfile">
                                        </div>
<!--                                        <div id="progress" class="row progress" style="margin-top: 8px;">
                                            <div class="progress-bar progress-bar-success"></div>
                                        </div>-->
                                    </div>
<!--                                    <div class="col-md-9">
                                        <div class="profile-picture-box" >
                                            <div id="files" class="files">
                                            </div>
                                        </div>
                                    </div>-->

                                    <div class="col-md-offset-8 col-md-4 disable_padding_right" id="upload">
                                        <input id="btnSubmit" type="submit" value="Save" class="btn button-custom pull-right"/>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <div>
                    <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
                </div>
            </div>          
        </div>
    </div>
</div>
<?php 
$this->load->view("admin/applications/shop/modal/product_category_create");
$this->load->view("admin/applications/shop/modal/product_category_delete_confirm");
$this->load->view("admin/applications/shop/modal/product_category_update");
?>
