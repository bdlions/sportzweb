<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div id="topPadding" class="row form-group"></div>
        <div class="form-group">
            <img class="img-responsive" src="<?php echo base_url().SERVICE_HOME_LOGO_PATH?>" style="width: 100%">
        </div>
        <?php echo form_open("applications/service_directory/service_directory_map", array('id' => 'form_service_directory', 'class' => 'form-vertical')); ?>
            <div class="form-group">
                <input placeholder="Enter your location here" class="sd_home_input" name="towncode">
            </div>
            <div class="form-group">
                <input class="sd_home_submit btn pull-right" name="submit_service_directory" type="submit" value="Find" id="submit_service_directory">
            </div>
        <?php echo form_close();?>
    </div>
</div>
<style>
    #topPadding{
        padding-top: 120px;
        width: 100%;
    }
    .sd_home_submit{
        border-radius: 0; 
        background-color: #FFC90E;
        color: red;
        font-size: 16px;
        padding: 5px;
        width: 100px;
    }
    .sd_home_input{
        border: 3px solid #888888;
        padding: 10px;
        width: 100%;
        font-size: 16px;
        line-height: 16px;
    }
</style>
