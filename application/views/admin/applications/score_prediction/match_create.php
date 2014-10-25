<div class="panel panel-default">
    <div class="panel-heading">Create Match</div>
    <div class="panel-body">
    <div class="form-background top-bottom-padding">  
        <?php // echo form_open_multipart("admin/applications_healthyrecipes/edit_recipe/".$recipes_info['id'], array('id' => 'form_edit_recipe', 'class' => 'form-horizontal', 'onsubmit'=>"return false;")); ?>
        <?php echo form_open_multipart("admin/applications_scoreprediction/create_match/".$tournament_id, array('id' => 'form_edit_recipe', 'class' => 'form-horizontal', 'onsubmit'=>"return false;")); ?>
        <div class="row">
            <div class ="col-md-9 margin-top-bottom">
                <div class="form-group">
                    <label for="title" class="col-md-3 control-label requiredField">
                        Match Title
                    </label>
                    <div class ="col-md-9">
                        <input name="" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="title" class="col-md-3 control-label requiredField">
                        Match Title
                    </label>
                    <div class ="col-md-9">
                        <input name="" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="title" class="col-md-3 control-label requiredField">
                        Match Title
                    </label>
                    <div class ="col-md-9">
                        <input name="" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="pull-right col-md-4">
                        <input id="btnSubmit" type="submit" value="Update" class="btn button-custom pull-right"/>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>