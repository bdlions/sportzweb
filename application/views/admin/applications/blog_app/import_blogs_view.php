<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="js/vendor/jquery.ui.widget.js"></script>
<script src="js/jquery.iframe-transport.js"></script>
<script src="js/jquery.fileupload.js"></script>
<script>
    $(function() {
        $('#fileupload').fileupload({
            dataType: 'json',
            add: function(e, data) {
                data.context = $('<button/>')
                        .text('Upload')
                        .appendTo(document.body)
                        .click(function() {
                            data.context = $('<p/>').text('Uploading...').replaceAll($(this));
                            data.submit();
                        });
            },
            done: function(e, data) {
                $.each(data.result.files, function(index, file) {
                    $('<p/>').text(file.name).appendTo(document.body);
                });
            }
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .bar').css(
                        'width',progress + '%'
                        );
            }
        });
    });
</script>


<div class="panel panel-default">
    <div class="panel-heading">Upload Blogs xlsx data file:</div>
    <div class="row" style="margin-top: 10px;margin-left: 20px;">
        <div class="col-md-2"></div>
        <div class="col-md-8" style="color: red;"><?php echo $message;?></div>
    </div>
    <div class="panel-body">
        <div>
            <div class="col-md-2"></div>
            <div class="col-md-8" style="border: 2px dotted #999; padding: 32px;">
                <a href="<?php echo base_url();?>resources/import/applications/blogs/blogs_sample.xlsx"><button class="btn btn-info pull-right">Download sample</button></a>
                <div id="progress">
                    <?php echo form_open_multipart('admin/blogapp/page_import_blogs', array('name'=>'file_upload'));?>
                        <div class="form-group">
                            <label for="fileupload">Select the data file for blog:</label>
                            <input id="fileupload" type="file" name="userfile">
                            <p class="help-block">Select ".XLSX" files only.</p>
                            <div class="bar" style="height: 18px; background: green; width: 0%;"></div>
                        </div>
                        <input id="button_submit" name="button_submit" value="Submit" type="submit" class="btn btn-default"/>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>