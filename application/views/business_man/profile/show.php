<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>resources/bootstrap3/css/business_profile.css">
<script type="text/javascript">

$(function(){
    $("#mapLoader").on("click", function(){
        $("#myModal .modal-body").append($("#map_canvas").css("margin-top","0px").get(0));
        $('#myModal').modal('show');
    });
    $("#album").on("click", function(){
        window.location = "<?php echo base_url()?>business_album";
    });

    // Change this to the location of your server-side upload handler:
    var url_cover_photo_upload = '<?php echo base_url()?>business_profile/upload_cover_photo/';                    
    
    $('#fileuploadCoverPhoto').fileupload({
        url: url_cover_photo_upload,
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 5000000, // 5 MB                 // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
        previewCanvas: false,
        previewMaxWidth: $('#cover_photo').width(),
        maxNumberOfFiles: 1,
        previewMaxHeight: 210,
        previewCrop: true
    }).on('fileuploadadd', function(e, data) {
       // $('#cover_photo').empty();
        //$('#cover_photo').append("<div/>");
        data.context = $('#cover_photo');
    }).on('fileuploadprocessalways', function(e, data) {
        var index = data.index,
                file = data.files[index],
                node = $(data.context.children()[index]);
            if (file.preview) {                     
                //node.prepend(file.preview);
            }
        if (file.error) {
           // alert("Uploading error!");
           var message = "Uploading error!";
                print_common_message(message);
        }
    }).on('fileuploadprogressall', function(e, data) {            
    }).on('fileuploaddone', function(e, data) {
        window.location.reload(true);
    });
    var url_logo_upload = "<?php echo base_url()?>business_profile/upload_logo";
    $('#fileuploadLogo').fileupload({
        url: url_logo_upload,
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 5000000, // 5 MB                 // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
        previewCanvas: false,
        previewMaxWidth: $('#logo').width(),
        maxNumberOfFiles: 1,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function(e, data) {
        //$('#logo').empty();
        //$('#logo').append("<div/>");
        //data.context = $('#logo');console.log(e);
    }).on('fileuploadprocessalways', function(e, data) {
        var index = data.index,
                file = data.files[index];
                //node = $(data.context.children()[index]);
          //  if (file.preview) {                     
          //      node.prepend(file.preview);
          //  }
        if (file.error) {
            //alert("Uploading error!");
            var message = "Uploading error!";
                print_common_message(message);
        }
    }).on('fileuploadprogressall', function(e, data) {            
    }).on('fileuploaddone', function(e, data) {
        window.location.reload(true);
    });
});
</script>
<script type="text/javascript">
    function changeConnect()
    {
        var user_id = <?php echo $this->session->userdata('user_id') ?>;
    
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "business_profile/store_business_profile_connection",
            data: {
                business_profile_id : <?php echo $profile->business_profile_id?>,
            },
            success: function(data) {
                //removing throbber
                $("#connection_num").text(data);
                //$("#recipe_comment_list").html(tmpl("tmpl_recipe_comments_list", data['comment_list']));
            }
        });
    }
</script>

<div class="row business-label">
    <div class="col-md-8">
        <div class="cover-photo fileinput-button">
            <div id="cover_photo">
                <?php if($user_id == $profile->user_id){?>
                    <img src="<?php echo base_url().BUSINESS_PROFILE_COVER_PHOTO_PATH.$profile->cover_photo ?>" alt="Click to add cover photo" style="max-height:310px; width:100%"/>
                <?php }else{ ?>
                    <img src="<?php echo base_url().BUSINESS_PROFILE_COVER_PHOTO_PATH.$profile->cover_photo ?>" alt="" style="max-height:310px; width:100%"/>
                <?php } ?>
            </div>
            <?php if($user_id == $profile->user_id){?>
            <input id="fileuploadCoverPhoto" type="file" name="userfile">
            <?php } ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default business-panel">
            <div class="panel-heading">
                <label><?php echo $profile->business_name?></label>
                <?php if($user_id == $myself->user_id){?>
                    <a class="btn button-custom pull-right" href="<?php echo base_url()?>settings?menu=business" >Edit Profile Info</a>
                <?php }?>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9"><?php echo $profile->address ?></div>
                </div>
                <div class="row">
                    <div class="col-md-9"><?php echo $profile->business_city ?></div>
                </div>
                <div class="row">
                    <div class="col-md-9"><?php echo $profile->country_name ?></div>
                </div>
                <div class="row">
                    <div class="col-md-9"><?php echo $profile->post_code ?></div>
                </div>                
                <div class="row" style="padding-top:10px">
                    <div class="col-md-3"><label>Website:</label></div><div class="col-md-9" style="color:blue"><?php echo $profile->website_address ?></div>
                </div>
                <div class="row">
                    <div class="col-md-3"><label>Tel:</label></div>
                    <div class="col-md-9" style="color:cyan"><?php echo $profile->telephone ?></div>
                </div>
                <div class="row">
                    <div class="col-md-3"><label>Email:</label></div>
                    <div class="col-md-9"><?php echo $profile->business_email ?></div>
                </div>
                <div class="row">
                    <div class="col-md-3"><label>Hours:</label></div>
                    <div class="col-md-9"><?php echo $profile->business_hour ?></div>
                </div>
                <div class="row" style="padding-top: 10px">
                    <div class="col-md-3"><label>Business:</label></div>
                    <div class="col-md-9"><?php echo $profile->description ?></div>
                </div>
                <div class="row" style="padding-bottom: 10px"> 
                    <div class="col-md-3"><label>Type:</label></div>
                    <div class="col-md-9"> <?php echo $profile->sub_type->description ?></div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-10" id="updateConnect">
                        <button class="btn connect-button"><div class="row connections-label" id="connection_num"><?php echo $user_connection;?></div><div class="row">Connection</div></button>
                        <button id="button_connect" class="btn connect-button" style="font-size: 20px" onclick="changeConnect()">Connect</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="about-me">
            <?php echo $profile->business_description ?>
        </div>
    </div>
    <div class="col-md-8">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="picture-box fileinput-button">
                            <div id="logo">
                                <img src="<?php echo base_url() . BUSINESS_PROFILE_LOGO_PATH . $profile->logo ?>" alt="Logo" class="img-responsive"/>
                            </div>
                            <?php if($user_id == $profile->user_id){?>
                            <input id="fileuploadLogo" type="file" name="userfile">
                            <?php } ?>
                            
                        </div>
                        <div class="name">Logo</div>
                    </div>
                    <div class="col-md-6">
                        <div class="picture-box"><img src='<?php echo base_url() . "resources/uploads/albums/{$last_uploaded_photo}"?>' class="img-responsive" id="album" /></div>
                        <div class="name">Photos</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="picture-box"><img src='<?php echo base_url() . "resources/images/event.jpg" ?>' class="img-responsive" /></div>
                        <div class="name">Events</div>
                    </div>
                    <div class="col-md-6">
                        <div class="picture-box"><img src='<?php echo base_url() . "resources/images/map.jpg"?>'class="img-responsive" id="mapLoader" /></div>
                        <div class="name">Location</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-7">
        <?php $this->load->view("member/newsfeed/status_bar"); ?>
        <?php $this->load->view("member/newsfeed/feed"); ?>
    </div>
</div>
<?php $this->load->view("business_man/profile/modal_map");?>