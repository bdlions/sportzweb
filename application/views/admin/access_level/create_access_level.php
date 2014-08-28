<style type="text/css">
    .td_text_color {color: #428bca;}
</style>
<div class="col-md-12">    
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo $current_user_info['first_name'] . ' ' . $current_user_info['last_name'] . ' - ' . $current_user_info['description']; ?>
        </div>

        <div class="panel-body">
            <?php echo form_open("admin/access_level/create_access_level", array('id' => 'form_create_user', 'class' => 'form-horizontal')); ?>
            <div class="col-md-8">
                <div class="form-group">
                    <label for="name" class="col-md-4 control-label requiredField">
                        Access Level Name:
                    </label>
                    <div class ="col-md-5">
                        <?php echo form_input($access_level + array('class' => 'form-control')); ?>
                    </div> 
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                <label for="create_access_level" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-0">
                    <?php echo form_input($create_access_level + array('class' => 'form-control btn button-custom')); ?>
                </div> 
            </div>
            </div>
            
            <?php echo form_close(); ?>
        </div>
    </div>
</div>