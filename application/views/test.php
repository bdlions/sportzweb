<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/blog_app.css" />
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <input id="input_area" class="form-control">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <input id="regex" class="form-control">
        </div>
        <div class="col-md-1"><button onclick="firett()">Filter</button></div>
    </div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <input id="output_area" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <?php var_dump($arrFULL);?>
            <?php foreach ($arrFULL as $value) {
                var_dump($value);
            };?>
            <?php var_dump('----------break-----------');?>
            <?php var_dump($arrEMPTY);?>
            <?php foreach ($arrEMPTY as $value) {
                var_dump($value);
                var_dump('---entered----');
            };?>
        </div>
    </div>
</div>


image upload
<form id="formsubmit" method="post" action="<?php echo base_url();?>test/fileimageupload" onsubmit="return false;">
     <div class="col-md-6">
        <div class="row fileinput-button">
            <button class="btn button-custom">Upload a photo</button>
            <input id="fileupload" type="file" name="userfile">
        </div>
        <div id="progress" class="row progress" style="margin-top: 8px;">
            <div class="progress-bar progress-bar-success"></div>
        </div>
    </div>
    <div class=" col-md-4">
        <div class="profile-picture-box" style="border: 1px solid salmon">
            <div id="files" class="files">
            </div>
        </div>
    </div>

    <div class="col-md-4" id="upload">
        <input id="btnSubmit" type="submit" value="Save" class="btn button-custom pull-right"/>
    </div>
</form>
<script>
$(function () {
    $("#btnSubmit").on("click", function(){
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url();?>test/fileimageupload',
            data: $("#formsubmit").serializeArray(),
            success: function(data) {
               // alert(data.message);
                var message = data.message;
                print_common_message(message);
            }
        });
    });
    
    // Change this to the location of your server-side upload handler:
    var url = "<?php echo base_url();?>test/fileimageupload",
                    uploadButton = $('<input type="submit" value="Save"/>').addClass('btn button-custom pull-right').text('Confirm').
                    on('click', function() {
                        var $this = $(this),data = $this.data();
                        $this.off('click').text('Abort').on('click', function() {
                            $this.remove();
                            data.abort();
                        });
                        data.submit().always(function() {
                            $this.remove();
                        });
                    });
        
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: $("form").serializeArray(),
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 5000000, // 5 MB
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewMaxWidth: 120,
            maxNumberOfFiles: 1,
            previewMaxHeight: 120,
            previewCrop: true
        }).on('fileuploadadd', function(e, data) {
            $("#files").empty();
            data.context = $('<div/>').appendTo('#files');
            $("div#upload").empty();
            $("div#upload").append('<br>').append(uploadButton.clone(true).data(data));
            $.each(data.files, function(index, file) {
                var node = $('<p/>');
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function(e, data) {
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);
            if (file.preview) {
                node.prepend('<br>').prepend(file.preview);
            }
            if (file.error) {
                $("div#header").append('<br>').append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button').text('Upload').prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function(e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css('width',progress + '%');
        }).on('fileuploaddone', function(e, data) {
            //alert(data.result.message);
            var message = data.result.message;
            print_common_message(message);
            //alert('down alert');
            var message = "down alert";
            print_common_message(message);
            window.location = '<?php echo base_url();?>applications/blog_app/create_blog_by_user';
        }).on('fileuploadsubmit', function(e, data){
            data.formData = $('form').serializeArray();
        }).on('fileuploadfail', function(e, data) {
            //alert(data.message);
             var message = data.message;
            print_common_message(message);
            $.each(data.files, function(index, file) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index]).append('<br>').append(error);
            });
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');

    });
</script>
<!-- modal -->
<div class="modal fade" id="confirmModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Confirm Vote...</h4>
            </div>
            <div class="modal-body">
                <h3>Are you sure you want to vote?</h3>
            </div>
            <div class="modal-footer">
                <button onclick="post_vote()" type="button" class="btn btn-primary">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <input id="league_id" name="league_id" type="hidden" value="">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>

function firett(){
    var regex = null;
    var intext = $('#input_area').val();
    regex = $('#regex').val();
//    regex = '<(?!\/?(p)|(img)|(a)(?=>|\s.*>))\/?.*?>';
    regex = new RegExp(regex, 'gi');
    $('#output_area').val( null );
    $('#output_area').val( intext.replace( regex, '_' ) );
}



</script>
<script>
    function confirmation_vote(league_id)
    {
        $("#league_id").val(league_id);
        $("#confirmModal").modal("show");
    }
    function post_vote()
    {
        var league_id = $("#league_id").val();
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>' + "asdasd/application/xstreambanter/post_vote",
                dataType: 'json',
                data: {
                    league_id: league_id
                },
                success: function(data) {
                    location.reload();
                }
            });
    }
</script>
<style>
    .blue_banner
    {
        color: white;
        background-color:#3F48CC;
    }
    .title{
        font-size: 20px;
        text-align: center;
    }
    .heading{
        padding: 15px;
        font-size: 25px;
        text-align: center;
    }
    .lr_image
    {
        height: 18px;
        padding: 4px 0px 0px;
    }
</style>



<!--<div class="col-md-6">
    <?php echo 'echo error: ';?>
    <?php echo $error;?>
    <?php var_dump($error);?>

    <?php echo form_open_multipart('test/upload_crop');?>

        <input type="file" name="userfile" size="20" />
        <br /><br />
        <input type="submit" value="upload" />

    <?php echo form_close();?>
        
        
        
</div>-->