<script type="text/javascript" src="<?php echo base_url(); ?>resources/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
window.onload = function()
{   
    CKEDITOR.replace('summary', {
        language: 'en',
        toolbar: [
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Preview', '-', 'Templates' ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
        { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
        '/',
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },

        { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
        '/',
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
        { name: 'forms', items: ['ImageButton'] },
        ],
        toolbarGroups: [
                { name: 'document',	   groups: [ 'mode', 'document' ] },			// Displays document group with its two subgroups.
                { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },			// Group's name will be used to create voice label.
        { name: 'links' },
        { name: 'colors' },
                '/',																// Line break - next group will be placed in new line.
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'styles' },
        '/',
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
        { name: 'forms' },
        ]
    });
}
</script>

<div class="panel panel-default">
    <div class="panel-heading">Create Application</div>
    <div class="panel-body">
        <div class="row form-horizontal form-background top-bottom-padding">  
            <form id="formsubmit" method="post" action="<?php echo base_url();?>admin/applications_directory/create_application" onsubmit="return false;">
            <div class="row">
                <div class ="col-md-10 margin-top-bottom">
                    <div class ="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-9"><?php echo $message; ?></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label requiredField">
                            Application Title
                        </label>
                        <div class ="col-md-9">
                            <?php echo form_input($title + array('class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label requiredField">
                            Application Order
                        </label>
                        <div class ="col-md-9">
                            <?php echo form_input($app_order + array('class' => 'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-md-3 control-label requiredField">
                            Description
                        </label>
                        <div class ="col-md-9">
                            <?php echo form_textarea($description + array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="summary" class="col-md-3 control-label requiredField">
                            Summary
                        </label>
                        <div class ="col-md-9">
                            <?php echo form_textarea($summary+array('class'=>'form-control')); ?>
                        </div> 
                        <input type="hidden" name="summary_editortext" id="summary_editortext">
                    </div>
                    <div class="form-group">
                        <div class ="col-md-12">
                            <input id="button_create_application_directory" type="submit" value="Save" class="btn button-custom pull-right"/>
                        </div>
                    </div>                    
                </div>
            </div>
        </form>
        </div>
        <div class="btn-group" style="padding-left: 10px;">
            <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
        </div>
    </div>
</div>

<script>
$(function () {
    $("#button_create_application_directory").on("click", function(){
        $("#summary_editortext").val(jQuery('<div />').text(CKEDITOR.instances.summary.getData()).html());
        if (CKEDITOR.instances.summary.getData() === "")
        {
            //alert("Application summary is required .");
            var message = "Application summary is required .";
            print_common_message(message);
            return;
        }        
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url();?>admin/applications_directory/create_application',
            data: $("#formsubmit").serializeArray(),
            success: function(data) {
                //alert(data.message);
                var message = data.message;
                print_common_message(message);
                window.location = '<?php echo base_url();?>admin/applications_directory';
            }
        });
    });
});
</script>