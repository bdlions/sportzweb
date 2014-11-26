<style type="text/css">
.hashtag{  
    color:blue;
}
</style>
<script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/twitter-text.js"></script>
<script type="text/javascript">
    $(function() {
        $("#status_box").empty();
        $("#status_box").on("focusin", function() {
            $("#status-box-menu").removeClass("hidden");
        });
        $("#button-post").on("click", function() {
            var status_text = $("#description").html().trim();
            var content = $('<div>' + $("#description").html().trim() + '</div>');
            content.find('a').replaceWith(function() { return ''; });
            content.find('div').replaceWith(function() { return $(this).text(); });
            var myRegexp = new RegExp('#([^\\s]*)','g');
            var match = myRegexp.exec(content.text());
            if(match != null){
                //console.log(match);
                if(match[1] != '')
                {
                    //var status_text = $("#appendedInputButton").html();
                    status_text = status_text.replace(match[0], process_hashtag(match[1]));
                    $("#description").html(status_text);
                }                
            }
            
            var hashtag_list = new Array();
            var counter = 0;
            $("#description a").each(function () {
                var text = $(this).text();
                if(text.indexOf("#") > -1)
                {
                    text = text.replace("#", ""); 
                    hashtag_list[counter++] = text;
                }                
            });
            
            var user_list = new Array();
            counter = 0;
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
                data: $("#form-status").serialize()+ "&status_category_id=" + <?php echo $status_list_id;?>+ "&user_id=" + <?php echo (isset($user_id) == true ? $user_id:$this->session->userdata('user_id'));?>+ "&mapping_id=" + <?php echo $mapping_id;?>+ "&user_list=" + user_list+ "&hashtag_list=" + hashtag_list+"&description=" + status_text,
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
        $("#description").on("keyup", function(){
            //check @ functionality
            var status_text = $("#description").text();
            var myRegexp = new RegExp('@([^\\s]*)','g');
            var match = myRegexp.exec(status_text);
            if(match != null){
                if(match[1] != '')
                {                    
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() ."trending_feature/get_at";?>',
                        dataType: 'json',
                        data: {
                            at: match[1]
                        },
                        success: function(data) {
                            $('.dropdown-menu').empty();
                            for(var i = 0; i < data.length; i ++){
                                    $('.dropdown-menu').append('<li><a href="#" onclick="get_selected_at('+data[i].type_id+','+data[i].id+')"><i class="icon-pencil"></i>'+ data[i].name +'</a></li>');
                            }
                            $('.input-append').addClass("open");                            
                        }
                    });
                }
                
            }
            
            //check # functionality
            status_text = $("#description").text();
            myRegexp = new RegExp('#([^\\s]*)','g');
            match = myRegexp.exec(status_text);
            if(match != null){
                if(match[1] != '')
                {                    
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url() ."trending_feature/get_hash_tags";?>',
                        dataType: 'json',
                        data: {
                            hash_tag: match[1]
                        },
                        success: function(data) {
                            if(data.length > 0)
                            {
                                $('.dropdown-menu').empty();
                                for(var i = 0; i < data.length; i ++){
                                    $('.dropdown-menu').append('<li><a onclick="get_selected_ht(\''+data[i].name+'\')" href="#" ><i class="icon-pencil"></i>'+ data[i].name +'</a></li>');
                                }
                                $('.input-append').addClass("open"); 
                            }
                            else
                            {
                                $('.dropdown-menu').empty();
                                $('.dropdown-menu').hide();
                            }
                        }
                    });
                }
                
            }
            /*var status_text = $("#appendedInputButton").html();
            var status_text_array = status_text.trim().split(" ");
            for(var counter = 0; counter < status_text_array.length; counter++)
            {
                var text = status_text_array[counter];
                var myRegexp = /#(.*)/;
                var match = myRegexp.exec(text);
                if(match != null){
                    if(match[1] != '')
                    {
                        var hashtag = '#'+match[1];
                        status_text = status_text.replace(hashtag, addHashTag(hashtag));
                        $("#appendedInputButton").html(status_text);
                        //addHashTag(hashtag);
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url() ."trending_feature/get_hash_tags";?>',
                            dataType: 'json',
                            data: {
                                hashtag: hashtag
                            },
                            success: function(data) {
                                //$('.dropdown-menu').empty();
                                //for(var i = 0; i < data.length; i ++){
                                //        $('.dropdown-menu').append('<li><a href="#"><i class="icon-pencil"></i>'+ $("#appendedInputButton").val() + data[i].name +'</a></li>');
                                //}
                                //$('.input-append').addClass("open");                            
                            }
                        });
                    }
                    
                }    
            }*/
            //var myRegexp = /#([^\\s]*)/;
//            var el = document.getElementById("appendedInputButton");
//var range = document.createRange();
//var sel = window.getSelection();
//console.log(el.childNodes[0]);
//range.setStart(el.childNodes[0], 2);
//range.setEnd(el.childNodes[0], 2);
            //alert("Current position: " + $(this).caret().start);
            
            /*var content = $('<div>' + $("#appendedInputButton").html().trim() + '</div>');
            content.find('a').replaceWith(function() { return ''; });
            var newHtml = content.html().trim();
            
            var myRegexp = new RegExp('#([^\\s]*)','g');
            var match = myRegexp.exec(newHtml);
            if(match != null){
                console.log(match);
                if(match[1] != '')
                {
                    var status_text = $("#appendedInputButton").html();
                    var status_text = status_text.replace(match[0], addHashTag(match[0]));
                    $("#appendedInputButton").html(status_text);
                    //$("#appendedInputButton").focus();
                    placeCaretAtEnd( $("#appendedInputButton").get(0) );
                }
                
            }  */  
            /*$('.dropdown-menu').empty();
            for(var i = 1; i < 2; i ++){
                    $('.dropdown-menu').append('<li><a href="#"><i class="icon-pencil"></i>'+ $("#appendedInputButton").val() + i +'</a></li>');
            }
            $('.input-append').addClass("open");*/

        });
    });
    
    function placeCaretAtEnd(ele) {
        var range = document.createRange();
        var sel = window.getSelection();
        range.setStart(ele, 1);
        range.collapse(true);
        sel.removeAllRanges();
        sel.addRange(range);
        ele.focus();
        /*el.focus();
        if (typeof window.getSelection != "undefined"
                && typeof document.createRange != "undefined") {
            var range = document.createRange();
            range.selectNodeContents(el);
            range.collapse(false);
            var sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(range);
        } else if (typeof document.body.createTextRange != "undefined") {
            var textRange = document.body.createTextRange();
            textRange.moveToElementText(el);
            textRange.collapse(false);
            textRange.select();
        }*/
    }
    
    function get_selected_at(type_id, id)
    {
        $('.dropdown-menu').empty();
        $('.dropdown-menu').hide();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ."trending_feature/get_selected_at";?>',
            dataType: 'json',
            data: {
                type_id: type_id,
                id: id
            },
            success: function(data) {
                var status_text = $("#description").text();
                var myRegexp = new RegExp('@([^\\s]*)','g');
                var match = myRegexp.exec(status_text);
                if(match != null){
                    if(match[1] != '')
                    {
                        var status_text = $("#description").html();
                        var anchor = '<a rel="nofollow" data-screen-name="" href="'+data.url+'" class="tweet-url username">'+data.name+'</a>&nbsp;';
                        var status_text = status_text.replace(match[0], anchor);
                        $("#description").html(status_text);
                        placeCaretAtEnd( $("#description").get(0) );
                    }

                }
            }
        });
    }
    
    function get_selected_ht(name)
    {
        $('.dropdown-menu').empty();
        $('.dropdown-menu').hide();
        var status_text = $("#description").text();
        var myRegexp = new RegExp('#([^\\s]*)','g');
        var match = myRegexp.exec(status_text);
        if(match != null){
            if(match[1] != '')
            {
                var status_text = $("#description").html();
                var anchor = generate_hashtag(name);
                var status_text = status_text.replace(match[0], anchor);
                $("#description").html(status_text);
                placeCaretAtEnd( $("#description").get(0) );
            }

        }
    }
    
    function generate_hashtag(hashtag)
    {
        var url = '<?php echo base_url()?>'+'trending_feature/hashtag/'+hashtag;
        return '<a rel="nofollow" data-screen-name="" href="'+url+'" class="tweet-url username">#'+hashtag+'</a>&nbsp;';
    }
    
    function process_hashtag(hashtag)
    {
        var url = '<?php echo base_url()?>'+'trending_feature/hashtag/'+hashtag;
        return '<a rel="nofollow" data-screen-name="" href="'+url+'" class="tweet-url username">#'+hashtag+'</a>';
    }
    
    function removeSelectedUser(span){
        span.parentNode.parentNode.removeChild(span.parentNode);
        $("#chat_friends").val("");
    }
    
    function addHashTag(name)
    {
        twttr.sourceUrl = '<?php echo base_url()?>'+'trending_feature/hashtag/';
        //$("#test1").html(twttr.txt.autoLink(twttr.txt.htmlEscape(name)));
        //alert(twttr.txt.autoLink(twttr.txt.htmlEscape(name)));
        //alert(user_id);
        //alert(name);
        return twttr.txt.autoLink(twttr.txt.htmlEscape(name));
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
                    <div class="row col-md-12">
                        <div contenteditable="true" id="test1">
                                
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 input-append">
                            <div class="expanding status-box" contenteditable="true" id="description" style="min-height: 40px; padding: 10px;">                            
                            </div>                            
                            <ul class="dropdown-menu" style="left:15px;width:95%">
                            </ul>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php //echo form_textarea( array("name" => "description2", "class" =>'form-control expanding status-box', "placeholder" => "What are you thinking?",  "id" => "status_box", "rows" => "2")) ?>
                            <!--<div contenteditable="true" name ="description" class='form-control expanding status-box' placeholder = "What are you thinking?"id = "status_box"></div>-->
                            <div id="files" class="list-inline list-unstyled files">
                                
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