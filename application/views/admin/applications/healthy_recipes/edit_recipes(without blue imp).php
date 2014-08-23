<script type="text/javascript" src="<?php echo base_url(); ?>resources/ckeditor/ckeditor.js"></script>

<script type="text/javascript">
window.onload = function()
{
    CKEDITOR.replace('duration', {
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
        }
    );   

    CKEDITOR.replace('preparation_method', {
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
        }
    );   

    CKEDITOR.replace('ingredients', {
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

<script type="text/javascript">
    $(document).ready(function() {
        $("#form_edit_recipe").on("submit", function(){
            $("#duration_editortext").val(jQuery('<div />').text(CKEDITOR.instances.duration.getData()).html());
            $("#ingredients_editortext").val(jQuery('<div />').text(CKEDITOR.instances.ingredients.getData()).html());
            $("#preparation_method_editortext").val(jQuery('<div />').text(CKEDITOR.instances.preparation_method.getData()).html());
            //return false;
        });
    });
</script>
<div class="panel panel-default">
    <div class="panel-heading">Edit Recipes</div>
    <div class="panel-body">
    <div class="row form-horizontal form-background top-bottom-padding">  
        <?php echo form_open_multipart("admin/healthyrecipes/edit_recipe/".$recipes_info['id'], array('id' => 'form_edit_recipe', 'class' => 'form-horizontal')); ?>
        <div class="row">
            <div class ="col-md-10 margin-top-bottom">
                <div class ="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-8"><?php echo $message; ?></div>
                    <div class="col-md-8">
                        <?php
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title" class="col-md-3 control-label requiredField">
                        Recipe Title
                    </label>
                    <div class ="col-md-9">
                        <?php echo form_input($title+array('class'=>'form-control')); ?>
                    </div>
                    <input type="hidden" name="recipe_category_id" value="<?php echo $recipes_info['recipe_category_id'];?>">
                </div>
                <div class="form-group">
                    <label for="first_name" class="col-md-3 control-label requiredField">
                        Recipe Description
                    </label>
                    <div class ="col-md-9">
                        <?php echo form_textarea($description+array('class'=>'form-control')); ?>
                    </div> 
                </div>
                <div class="form-group">
                    <label for="duration" class="col-md-3 control-label requiredField">
                        Recipe Duration
                    </label>
                    <div class ="col-md-9">
                        <?php echo form_textarea($duration+array('class'=>'form-control')); ?>
                        <input type="hidden" name="duration_editortext" id="duration_editortext">
                    </div> 
                </div>
                <div class="form-group">
                    <label for="ingrediantes" class="col-md-3 control-label requiredField">
                        Ingredients
                    </label>
                    <div class ="col-md-9">
                        <?php echo form_textarea($ingredients+array('class'=>'form-control')); ?>
                        <input type="hidden" name="ingredients_editortext" id="ingredients_editortext">
                    </div> 
                </div>
                <div class="form-group">
                    <label for="preparation_method" class="col-md-3 control-label requiredField">
                        Preparation Method
                    </label>
                    <div class ="col-md-9">
                        <?php echo form_textarea($preparation_method+array('class'=>'form-control')); ?>
                        <input type="hidden" name="preparation_method_editortext" id="preparation_method_editortext">
                    </div> 
                </div>
                
                <div class="form-group">
                    <label for="Recommend_esserts" class="col-md-3 control-label requiredField">
                        Recommend Desserts
                    </label>
                    <div class ="col-md-9">
                        <?php echo form_input($recommend_resserts+array('class'=>'form-control', 'data-toggle' => 'modal', 'data-target' => '#modal_recommand_recipe')); ?>
                    </div> 
                </div>
                
                <div class="form-group">
                    <label for="Alternative_recipes" class="col-md-3 control-label requiredField">
                        Alternative Recipes
                    </label>
                    <div class ="col-md-9">
                        <?php echo form_input($alternative_recipes+array('class'=>'form-control', 'data-toggle' => 'modal', 'data-target' => '#modal_alternative_recipe')); ?>
                    </div> 
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 control-label requiredField">Upload file from my computer : </label> &nbsp; &nbsp;
                    <button onclick="sentIDvalue('browse_your_file');" title="Attach files." id="file1" class="btn btn-default dropdown-toggle" type="button">
                        <span class="glyphicon glyphicon-paperclip"></span>
                    </button>
                        <span class="" id ="show_file_name" style=""><?php echo $image; ?></span>
                    <div class="hidden_upload_area">
                        <input id="browse_your_file" type="file" name="fileupload">
                    </div>
                </div>
               
                <div class="form-group">
                    <label for="submit_button" class="col-md-3 control-label requiredField">

                    </label>
                    <div class ="col-md-3 col-md-offset-6">
                        <?php echo form_input($submit_edit_recipe+array('class'=>'form-control button-custom')); ?>
                    </div> 
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>  
    </div>
</div>
<style>
.hidden_upload_area {
    height: 0;
    overflow: hidden;
    visibility: hidden;
    width: 0;
}
</style>
<script type="text/javascript">
//FUNCTION FOR SELECT THE INPUT TYPE FILE FIELD
function sentIDvalue(id_name)
{
    $('#'+id_name).click();
}
document.getElementById('browse_your_file').onchange = function () {
  //alert('Selected file: ' + this.value);
  $('#show_file_name').show().html(this.value);
}; 
</script>

<?php $this->load->view("admin/applications/healthy_recipes/modal_recommand_recipe"); ?>
<?php $this->load->view("admin/applications/healthy_recipes/modal_alternative _recipe"); ?>

