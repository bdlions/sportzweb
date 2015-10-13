<script type="text/javascript" src="<?php echo base_url(); ?>resources/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    $(function () {
        CKEDITOR.replace('league_table', {
            language: 'en',
            toolbar: [
                {name: 'document', groups: ['mode', 'document', 'doctools'], items: ['Source', '-', 'Preview', '-', 'Templates']},
                {name: 'clipboard', groups: ['clipboard', 'undo'], items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
                {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
                {name: 'colors', items: ['TextColor', 'BGColor']},
                '/',
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']},
                {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
                '/',
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl']},
                {name: 'forms', items: ['ImageButton']},
            ],
            toolbarGroups: [
                {name: 'document', groups: ['mode', 'document']}, // Displays document group with its two subgroups.
                {name: 'clipboard', groups: ['clipboard', 'undo']}, // Group's name will be used to create voice label.
                {name: 'links'},
                {name: 'colors'},
                '/', // Line break - next group will be placed in new line.
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                {name: 'styles'},
                '/',
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
                {name: 'forms'},
            ]
        });
        
        $('#submit_update_tournament').click(function () {
            $("#editortext_league_table").val(jQuery('<div />').text(CKEDITOR.instances.league_table.getData()).html());
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url() . 'admin/applications_scoreprediction/update_tournament/' . $tournament_id; ?>',
                data: $("#form_update_tournament").serializeArray(),
                success: function (data) {
                    print_common_message(data.message);
                    window.location = '<?php echo base_url(); ?>admin/applications_scoreprediction/update_tournament/<?php echo $tournament_id; ?>';
                }
            });
                                    
        });
    });
</script>
<div class="panel panel-default">
    <div class="panel-heading">Update Tournament</div>
    <div class="panel-body">
        <div class="form-background top-bottom-padding">
            <div class="row">
                <div class ="col-md-8 margin-top-bottom">
                    <?php echo form_open("admin/applications_scoreprediction/update_tournament/" . $tournament_id, array('id' => 'form_update_tournament', 'class' => 'form-horizontal', 'onsubmit' => 'return false;')); ?>
                    <div class ="row">
                        <div class="col-md-4"></div>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-md-3 control-label requiredField">
                            Title:
                        </label>
                        <div class ="col-md-9">
                            <?php echo form_input($title + array('class' => 'form-control')); ?>
                        </div> 
                    </div> 
                    <div class="form-group">
                        <label for="season" class="col-md-3 control-label requiredField">
                            Season:
                        </label>
                        <div class ="col-md-9">
                            <?php echo form_input($season + array('class' => 'form-control')); ?>
                        </div> 
                    </div> 
                    <div class="form-group">
                        <label for="table_title" class="col-md-3 control-label requiredField">
                            Table Title:
                        </label>
                        <div class ="col-md-9">
                            <?php echo form_input($table_title + array('class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="league_table" class="col-md-3 control-label requiredField">
                            League Table
                        </label>
                        <div class ="col-md-9">
                            <?php echo form_textarea($league_table + array('class' => 'form-control')); ?>
                            <input type="hidden" name="editortext_league_table" id="editortext_league_table">
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="submit_update_tournament" class="col-md-6 control-label requiredField">

                        </label>
                        <div class ="col-md-3 pull-right">
                            <?php echo form_input($submit_update_tournament + array('class' => 'form-control button-custom')); ?>
                        </div> 
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class="btn-group" style="padding-left: 10px;">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
            </div>
        </div>
    </div>
</div>