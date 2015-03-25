<script src="<?php echo base_url()?>jquery.Jcrop.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>jquery.Jcrop.css" type="text/css" />
<script type="text/javascript">
    $(function(){
        $("#button_save").click(function(){
             
        });
    });
    function mediaDisplay(imageSource, photo_id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "user_album/get_photo_details",
            data: {
                photo_id: photo_id
            },
            success: function(data) {
                if(data.status == 1)
                {
                    data.user_info.photo_id = data.photo_id;
                    $("#div_feedback_list").html(tmpl("tmpl_feedback_list",  data.feedbacks));
                    $("#div_post_comment_panel").html(tmpl("tmpl_post_comment_panel",  data.user_info));
                    if(data.is_liked_by_current_user == 1)
                    {
                        $("#span_like_unlike").html('<a onclick="store_unlike_photo('+data.photo_id+'); return false;" href="">Unlike</a>');
                    }
                    else
                    {
                        $("#span_like_unlike").html('<a onclick="store_like_photo('+data.photo_id+'); return false;" href="">Like</a>');
                    }
                    var total_liked_users = data.liked_user_list.length;
                    if(total_liked_users > 0)
                    {
                        $("#liked_user_list").html('<img style="vertical-align: bottom" src="<?php echo base_url();?>resources/images/thumb_up.png" />');
                        $("#liked_user_list").html($("#liked_user_list").html()+tmpl("tmpl_liked_user_list",  data.liked_user_list));
                        if(total_liked_users > 1)
                        {
                            $("#liked_user_list").html($("#liked_user_list").html()+' like this');
                        }
                        else
                        {
                            $("#liked_user_list").html($("#liked_user_list").html()+' likes this');
                        }
                    }
                    else
                    {
                        $("#liked_user_list").html("");
                    }
                }
            }
        });
        $('#share_photo_id').val(photo_id);
        $('#anchor_finish_cropping').hide();
        $("#image_panel").html('<center><img class="img-responsive" id="image-display"></center>');
        $("#image-display").attr("src", imageSource);
        $('#modal-image').modal('show');
    }
    function post_comment_picture()
    {
        $("#text_input_comment").focus();
    }
    
    function share_picture()
    {
        $('#modal_photo_share').modal('show');
    }
    
    function store_feedback(evt, element, photo_id)
    {
        if(evt.keyCode == 13)
        {
            //alert(photo_id);
            var feedback = $(element).val();
            $this = $(element);
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "user_album/post_photo_comment",
                data: {
                    photo_id: photo_id,
                    feedback: feedback
                },
                success: function(data) {
                    $("#div_feedback_list").html($("#div_feedback_list").html()+tmpl("tmpl_feedback_list",  data));
                    $("#text_input_comment").val("");
                }
            });
        }
    }
    
    function store_like_photo(photo_id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "user_album/store_like_photo",
            data: {
                photo_id: photo_id
            },
            success: function(data) {
                $("#span_like_unlike").html('<a onclick="store_unlike_photo('+photo_id+'); return false;" href="">Unlike</a>');
                var total_liked_users = data.liked_user_list.length;
                if(total_liked_users > 0)
                {
                    $("#liked_user_list").html('<img style="vertical-align: bottom" src="<?php echo base_url();?>resources/images/thumb_up.png" />');
                    $("#liked_user_list").html($("#liked_user_list").html()+tmpl("tmpl_liked_user_list",  data.liked_user_list));
                    if(total_liked_users > 1)
                    {
                        $("#liked_user_list").html($("#liked_user_list").html()+' like this');
                    }
                    else
                    {
                        $("#liked_user_list").html($("#liked_user_list").html()+' likes this');
                    }
                }
                else
                {
                    $("#liked_user_list").html("");
                }
            }
        });
        
    }
    function store_unlike_photo(photo_id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "user_album/remove_like_photo",
            data: {
                photo_id: photo_id
            },
            success: function(data) {
                $("#span_like_unlike").html('<a onclick="store_like_photo('+photo_id+'); return false;" href="">Like</a>');
                var total_liked_users = data.liked_user_list.length;
                if(total_liked_users > 0)
                {
                    $("#liked_user_list").html('<img style="vertical-align: bottom" src="<?php echo base_url();?>resources/images/thumb_up.png" />');
                    $("#liked_user_list").html($("#liked_user_list").html()+tmpl("tmpl_liked_user_list",  data.liked_user_list));
                    if(total_liked_users > 1)
                    {
                        $("#liked_user_list").html($("#liked_user_list").html()+' like this');
                    }
                    else
                    {
                        $("#liked_user_list").html($("#liked_user_list").html()+' likes this');
                    }
                }
                else
                {
                    $("#liked_user_list").html("");
                }
            }
        });        
    }
    function crop_picture()
    {
        if (!parseInt($('#w').val()))
        {
            alert('Please select a crop region then press submit.');
            return false;
        }        
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "user_album/crop_picture",
            data: {
                x: $('#x').val(),
                y: $('#y').val(),
                w: $('#w').val(),
                h: $('#h').val(),
                src: $("#image-display").attr("src"),
                src_w: $('#image-display').width(),
                src_h: $('#image-display').height()
            },
            success: function(data) {
                window.location.href = '<?php echo base_url();?>'+'member_profile/show/'+data['user_id'];
            }
        });    
    }
    function make_profile_picture()
    {
        $('#anchor_make_profile_picture').hide();
        $('#anchor_finish_cropping').show();
        $('#image-display').Jcrop({
          aspectRatio: 1,
          onSelect: updateCoords
        });
    }
    function updateCoords(c)
    {
      $('#x').val(c.x);
      $('#y').val(c.y);
      $('#w').val(c.w);
      $('#h').val(c.h);
    };

    function checkCoords()
    {
      if (parseInt($('#w').val())) return true;
      alert('Please select a crop region then press submit.');
      return false;
    };
</script>
<script type="text/x-tmpl" id="tmpl_liked_user_list">
    {% var i=0, user_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(user_info){ %}       
        <a href='<?php echo base_url(). "member_profile/show/{%= user_info.user_id%}"?>' class="profile-name" >{%= user_info.first_name%} {%= user_info.last_name%}</a>                            
    {% user_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<script type="text/x-tmpl" id="tmpl_feedback_list">
    {% var i=0, feedback_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(feedback_info){ %}       
        <div class="row form-group">
            <div class="col-md-2 feed-profile-picture">
                <a href='<?php echo base_url(). "member_profile/show/{%= feedback_info.user_info.user_id%}"?>'>
                    <div class="profile-background-comment">
                        <img alt="{%= feedback_info.user_info.first_name[0] %}{%= feedback_info.user_info.last_name[0] %}" src="<?php echo base_url().PROFILE_PICTURE_DISPLAY_PATH.'{%= feedback_info.user_info.photo%}' ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background-comment'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " />                     
                        <p style="visibility:hidden">{%= feedback_info.user_info.first_name[0] %}{%= feedback_info.user_info.last_name[0] %}</p>
                    </div>
                </a>
            </div>
            <div class="row col-md-10">
                <a href='<?php echo base_url(). "member_profile/show/{%= feedback_info.user_info.user_id%}"?>' class="profile-name" >{%= feedback_info.user_info.first_name %} {%= feedback_info.user_info.last_name %}</a> {%= feedback_info.description %}
            </div>
            <div class="row col-md-10" id="feedback_created_date">
                {%= feedback_info.created_on %}
            </div>
        </div>
    {% feedback_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<script type="text/x-tmpl" id="tmpl_post_comment_panel">
    {% var i=0, user_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(user_info){ %}
        <div class="col-md-2 feed-profile-picture">
            <a href='<?php echo base_url(). "member_profile/show/{%= user_info.user_id%}"; ?>'>
                <div class="profile-background-comment">
                    <img alt="{%= user_info.first_name[0] %}{%= user_info.last_name[0] %}" src="<?php echo base_url().PROFILE_PICTURE_DISPLAY_PATH.'{%= user_info.photo%}' ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background-comment'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " /> 
                    <p style="visibility:hidden">{%= user_info.first_name[0] %}{%= user_info.last_name[0] %}</p>
                </div>
            </a>
        </div>
        <div class="row col-md-10">
            <input id="text_input_comment" type="text" onkeyup="store_feedback(event, this, {%= user_info.photo_id%})" class="form-control" placeholder="Write a comment..."  name ="feedback" style="background-color: #EFE4B0"/>
        </div>
    {% user_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<!--/modal for image display-->
<div class="modal fade"id="modal-image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog image-display-modal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Image</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row col-md-12">
                            <div class="row form-group" id="image_panel">
                                <center><img class="img-responsive" id="image-display"></center>
                            </div>
                            <div class="row">
                                <input type="hidden" id="x" name="x" />
                                <input type="hidden" id="y" name="y" />
                                <input type="hidden" id="w" name="w" />
                                <input type="hidden" id="h" name="h" />
                                <a id="anchor_make_profile_picture" class=pull-left" onclick="make_profile_picture()" href="javascript: void(0)">&nbsp;Make profile picture&nbsp;</a>
                                <a id="anchor_finish_cropping" class="pull-right" onclick="crop_picture()" href="javascript: void(0)">&nbsp;Finished Cropping&nbsp;</a>                                
                            </div>
                        </div>                        
                    </div>
                    <div class="col-md-6" id="div_feedback_details">
                        <div class="row col-md-12" id="newsfeed" style="padding-top: 10px; padding-bottom:10px;">
                            <span id="span_like_unlike">
                            
                            </span>
                            <a onclick="post_comment_picture()" href="javascript: void(0)">&nbsp;Comment&nbsp;</a>
                            <a onclick="share_picture()" href="javascript: void(0)">&nbsp;Share&nbsp;</a>
                        </div>
                        <div class="row col-md-12" id="liked_user_list" style="padding-bottom:10px;">
                            
                        </div>
                        <div class="row col-md-12">
                            <div class="row col-md-12" id="div_feedback_list">                            
                            </div>
                            <div class="row form-group" id="div_post_comment_panel">                                
                            </div>
                        </div>                       
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('member/album/modal_share_photo');?>