<script type="text/javascript">
    $(function() {
        $("#status_box").empty();
        $("#status_box").on("focusin", function() {
            $("#status-box-menu").removeClass("hidden");
        });
        $("#button-post").on("click", function() {
            var user_list = new Array();
            var counter = 0;
            $("input", "#status_selected_friends").each(function() {
                if ($(this).attr("type") === "hidden")
                {
                    user_list[counter++] = $(this).attr("value");
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ."feed/post_status/";?>',
                dataType: 'json',
                data: $("#form-status").serialize()+ "&status_category_id=" + <?php echo $status_list_id;?>+ "&user_id=" + <?php echo (isset($user_id) == true ? $user_id:$this->session->userdata('user_id'));?>+ "&mapping_id=" + <?php echo $mapping_id;?>+ "&user_list=" + user_list,
                success: function(data) {
                    if (data == <?php echo STATUS_POST_REFRESH?>) 
                    {
                        $("#status_box").val("");
                        window.location.reload();
                    }
                    else if(data == <?php echo STATUS_POST_EMPTY_ERROR?>)
                    {
                        alert("Empty status can't be posted!");
                    }
                    else if(data == <?php echo STATUS_POST_INSERTION_ERROR?>)
                    {
                        alert("Internal server error. Please try again.");
                    }
                    else 
                    {
                        $("#status_box").val("");
                        //right now we have refreshed the browser, later implement the commented lines
                        window.location.reload();
                        //$("#files").empty();
                        //$("#feeds").prepend(tmpl("tmpl-news-feed", data));
                    }
                }
            });
            return false;
        });
        /*$("#button-post").on("click", function(){
            var user_list = new Array();
            var counter = 0;
            $("input", "#status_selected_friends").each(function() {
                if ($(this).attr("type") === "hidden")
                {
                    user_list[counter++] = $(this).attr("value");
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ."feed/post/". $status_or_comment_in."/".(isset($user_id) == true ? $user_id:"") ?>',
                dataType: 'json',
                data: $("#form-status").serialize()+ "&user_list=" + user_list,
                success: function(data) {
                    if (data == <?php echo STATUS_POST_REFRESH?>) 
                    {
                        $("#status_box").val("");
                        window.location.reload();
                    }
                    else if(data == <?php echo STATUS_POST_EMPTY_ERROR?>)
                    {
                        alert("Empty status can't be posted!");
                    }
                    else if(data == <?php echo STATUS_POST_INSERTION_ERROR?>)
                    {
                        alert("Internal server error. Please try again.");
                    }
                    else 
                    {
                        $("#status_box").val("");
                        //right now we have refreshed the browser, later implement the commented lines
                        window.location.reload();
                        //$("#files").empty();
                        //$("#feeds").prepend(tmpl("tmpl-news-feed", data));
                    }
                }
            });
            return false;
        });*/
        $("#chat_friends").typeahead([{
                name: "chat_friends",
                prefetch: {
                    url: '<?php echo base_url() ?>search/get_followers/',
                    ttl: 0
                },
                template: [
                    '<div class="row">'+
                        '<div class="col-md-5">'+
                            '<div>'+
                                '<img alt="{{signature}}" src="<?php echo base_url().PROFILE_PICTURE_DISPLAY_PATH?>{{photo}}" class="img-responsive profile-photo" onError="this.style.display = \'none\'; this.parentNode.className=\'profile-background\'; this.parentNode.getElementsByTagName(\'div\')[0].style.visibility=\'visible\'; "/>'+
                                '<div style="visibility:hidden;height:0px">{{signature}}</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-7">'+
                            '<div class="row col-md-12 profile-name">'+
                                '{{first_name}} {{last_name}}'+
                            '</div>'+
                        '</div>'+
                    '</div>'
                ].join(''),
                engine: Hogan
            }]).on('typeahead:selected', function(obj, datum) {
                $("#chat_friends").val("");
                $("#status_selected_friends").html($("#status_selected_friends").html()+'<span class="badge user-token"><input name="participant" type ="hidden" value="' + datum.user_id +'"/>'+ datum.first_name + ' '+ datum.last_name + '<span class="remove" onclick="removeSelectedUser(this)">&times;</span></span>');
                $("input[name=participant]").each(function(){
                    //window.location = "<?php echo base_url()?>" + "messages/new_message/" + $(this).val();
                });
        });
    });
    function removeSelectedUser(span){
        span.parentNode.parentNode.removeChild(span.parentNode);
        $("#chat_friends").val("");
    }
</script>
<div class="row">
    <?php echo form_open(base_url()."feed/post/".STATUS_CATEGORY_USER_NEWSFEED, array("id" => "form-status"))?>
    <div class="col-md-12 col-sm-12" style="color:#428BCA">
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <img class="list-icon" src="<?php echo base_url(); ?>resources/images/echo.png"/>
                <a href="#" class="anchor-undecorated">Update Status</a>
            </div>
            <div class="col-md-9 col-sm-9">
<!--                <div class="row">
                    <div class="col-md-offset-6 col-md-4 pull-right">-->
                        <div class="fileinput-button pull-right">
                            <img class="list-icon" src="<?php echo base_url() ?>resources/images/upload-doc.png"/>Add an image
                            <input id="fileupload" type="file" name="userfile">
                        </div>
<!--                    </div>
                    <div class="col-mid-2 dropdown pull-right more-dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            More <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenuMore">
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>">Post An Event</a>
                            </li>
                        </ul>
                    </div>
                </div>-->
            </div>
        </div>
        <div class="row status-box-container">
            <div class="col-md-12">
                <div class="status-arrow"></div>
                <div class="status-box-outer-container">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo form_textarea( array("name" => "description", "class" =>'form-control expanding status-box', "placeholder" => "What are you thinking?",  "id" => "status_box", "rows" => "2")) ?>
                            <!--<div contenteditable="true" name ="description" class='form-control expanding status-box' placeholder = "What are you thinking?"id = "status_box"></div>-->
                            <div id="files" class="list-inline list-unstyled files" style="padding-top: 10px;">
                                
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding-top:5px; padding-bottom: 5px;">
                        <div id="status-box-menu" class="status-box-menu">
                            <div class="div1">
                                <div id="status_selected_friends"></div>
                            </div>
                            <div class="div2"><input id="chat_friends" class="form-control typeahead" type="text" placeholder="Tell specific people and groups" /></div>
                            <div class="div3">
                                <button class="btn button-custom pull-right" id="button-post" style="background-color:skyblue">Post</button>
                            </div>
							<p style="">&nbsp;</p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close();?>
</div>

<script>
    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function() {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url()?>user_album/add_status_photos/';

        $('#form-status').fileupload({
            url: url,
            dataType: 'json',
            autoUpload: true,
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewCanvas: false,
            previewMaxWidth: 100,
            maxNumberOfFiles: 1,
            previewMaxHeight: 100,
            previewCrop: true
        }).on('fileuploadadd', function(e, data) {
            $("#files").empty();
            data.context = $('<li class="col-md-2"/>').appendTo('#files');
            $.each(data.files, function(index, file) {
                if(file.type.toLowerCase().indexOf("video") >= 0){
                    //$("#files li").last().append('<img width="100px" height="100px" src="<?php echo base_url()?>resources/images/video.jpg" class="img-responsive" />');
                }
                else{
                    var node = $('<div />');
                    node.appendTo(data.context);
                }
            });
        }).on('fileuploadprocessalways', function(e, data) {
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);
                if (file.preview) {                     
                    node.prepend(file.preview);
                    node.append('<div id="progress" class="progress" style="margin-bottom:0px;"><div class="progress-bar progress-bar-success"></div></div>');
                }
            if (file.error) {
            }
            if (index + 1 === data.files.length) {
                data.context.find('button').text('Upload').prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function(e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css('width',progress + '%');            
            }).on('fileuploaddone', function(e, data) {
                if($("#files #album_id").length <= 0){
                    $("#files").append("<input name='uploaded_image' value='" + data.result.name + "' type = 'hidden' id='album_id' >");
                }
                $('.progress').removeClass('active');
                }).on('fileuploadfail', function(e, data) {
                        $.each(data.files, function(index, file) {
                        });
                    }).prop('disabled', !$.support.fileInput)
                            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>