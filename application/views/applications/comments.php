<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />
<script type="text/javascript">
    $(function() {
        $("#save_comment").on("click", function() {
            if ($("#comment").val().length == 0)
            {
                alert("please type your comment");
                return false;
            }
            var radios = $('input:radio[name=comment_nature]');
            if (radios.is(':checked') === false) {
                var comment_nature = "Neutral";
            } else {
                var comment_nature = $('input[name$="comment_nature"]:checked').val();
            }
            
            var application_id = <?php echo $application_id?>;
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "applications/comments/post_comment",
                data: {
                    application_id:'<?php echo $application_id?>',
                    comment: $("#comment").val(),
                    comment_nature: comment_nature,
                    item_id: '<?php echo $item_id?>'
                },
                success: function(data) {
                    if (data['status'] === 1)
                    {
                        $("#div_comment_list").html(tmpl("tmpl_recipe_comments_list", data['comment_info'])+$("#div_comment_list").html());                        
                        $("#comment").val('');
                    }
                    
                    if(application_id == <?php echo APPLICATION_BLOG_APP_ID?>)
                    {
                        var comments_counter = parseInt($("#comment_counter").text())+1;
                        if(comments_counter<=1){
                            $("#comment_counter").text(comments_counter + ' comment');
                        }
                        else
                        {
                            $("#comment_counter").text(comments_counter + ' comments');
                        }
                    }
                }
            });
        });
        $("#div_comment_list").on("click", "img", function() {
            var comment_id = $(this).attr('value');
            if($(this).attr('id') == 'unliked_image')
            {
                $(this).attr("id","liked_image");
                $(this).attr("src",'<?php echo base_url(); ?>'+"resources/images/vote_star_active_32.png");
                $("#like_counter_"+comment_id+"").text((+$("#like_counter_"+comment_id+"").text().trim() + +1));
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "applications/comments/like_comment",
                    data: {
                        application_id:'<?php echo $application_id?>',
                        comment_id: comment_id
                    },
                    success: function(data) {
                                            
                    }
                });
            }
            else if($(this).attr('id') == 'liked_image')
            {
                $(this).attr("id","unliked_image");
                $(this).attr("src",'<?php echo base_url(); ?>'+"resources/images/vote_star_gray_32.png");
                $("#like_counter_"+comment_id+"").text((+$("#like_counter_"+comment_id+"").text().trim() - +1));
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "applications/comments/unlike_comment",
                    data: {
                        application_id:'<?php echo $application_id?>',
                        comment_id: comment_id
                    },
                    success: function(data) {
                                            
                    }
                });
            }
        });
        
    });
    function slidin(id) {
        $("#effect_" + id).show("clip", {}, 400);
        //console.log('input[name=comment_nature'+id+']');
        $('input[name=comment_nature'+id+']').on("click",function(){
            //console.log($('input[name=comment_nature'+id+']:checked').val());
        });
    }
    
    function edit_your_comment(comment_id)
    {
        if ($("#comment_for_edit_" + comment_id).val().length == 0)
        {
            alert("please type your comment");
            return false;
        }
        //var radios = $('#comment_nature_for_edit_' + comment_id + ' input:radio[name=comment_nature'+comment_id+']');
        var radios = $('#comment_nature_for_edit_' + comment_id + ' input:radio[name=comment_nature'+comment_id+']');
        var comment_nature;
        if (radios.is(':checked') == false) {
            comment_nature = "Neutral";
        } else {
            //comment_nature = $('input[name=comment_nature'+comment_id+']:checked').val(); 
            comment_nature = $('input[name=comment_nature'+comment_id+']:checked').val();
        }
        
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "applications/comments/edit_comment",
            data: {
                application_id:'<?php echo $application_id?>',
                comment_id: comment_id,
                comment: $("#comment_for_edit_" + comment_id).val(),
                comment_nature: comment_nature,
                item_id: '<?php echo $item_id?>'
            },
            success: function(data) {
                if (data['status'] === 1)
                {
                    var generated_html = tmpl("tmpl_recipe_comments_list", data['comment_info']);
                    $("#div_comment_"+comment_id+"").html($(generated_html).html());
                }
            }
        });

        $("#effect_" + comment_id).hide("clip", {}, 400);
    }
    function remove_comment(id)
    {
        var application_id = <?php echo $application_id?>;
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "applications/comments/remove_comment",
            data: {
                application_id:'<?php echo $application_id?>',
                comment_id: id,
            },
            success: function(data) {
                if (data['status'] === 1)
                {
                    $("#div_comment_"+id+"").remove();
                }
                if(application_id  == <?php echo APPLICATION_BLOG_APP_ID?>)
                {
                    var comments_counter = parseInt($("#comment_counter").text())-1;
                        if(comments_counter<=1){
                            $("#comment_counter").text(comments_counter + ' comment');
                        }
                        else
                        {
                            $("#comment_counter").text(comments_counter + ' comments');
                        }
                }
            }
        });
    }
    function changeView()
    {
        //adding throbber
        $("#div_comment_list").html('<img style="padding-top: 16px; padding-left: 500px;" src="<?php echo base_url();?>resources/images/Ajax-loader.gif"/>');
        var value = document.getElementById("comment_view").value;
        var list = document.getElementById("no_of_comment_show").value;
        var expand;
        if ($("#expand_all").prop('checked') == true) {
            expand = 1;
            list = 0;
        }
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "applications/comments/search_comment_list",
            data: {
                application_id:'<?php echo $application_id?>',
                value: value,
                list: list,
                item_id: '<?php echo $item_id?>'
            },
            success: function(data) {
                //removing throbber
                $("#div_comment_list").html('');
                $.each(data['comment_list'], function(i, item){
                    $("#div_comment_list").html($("#div_comment_list").html()+tmpl("tmpl_recipe_comments_list", item));
                });
            }
        });
    }
    function is_liked_by_current_user(user_id_list)
    {
        var current_user_id = '<?php echo $user_info['user_id'];?>';
        for(var counter = 0; counter < user_id_list.length; counter++)
        {
            if(current_user_id == user_id_list[counter])
            {
                return true;
            }
        }
        return false;
    }
</script>
<div class="row" style="margin-top: 8px;">
    <div class="col-md-12 cus_comment_box"><!--main box-->
        <div class="row cus_comment_box_header">
            <h3 class="col-md-12 heading_medium_thin" style="padding-left: 16px"> Comments</h3>
        </div>
        <div class="col-md-12" ><!--content-->
            <div class="col-md-12" style="border: 1px solid #cccccc; background-color: #EDEDED; padding: 8px; margin-bottom: 16px;"><!--order-->
                <span class="content_text">Order by: <!--ajax reload 'comments'--></span>
                <select id="comment_view" onchange="changeView()">
                    <option value="1">Newest first</option> 
                    <option value="2">Oldest first</option>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="show_or_not_show" onchange="changeView()" id="expand_all" >
                <span class="small_text_dark">Expand all</span>
                <div style="float: right;">
                    <span class="content_text">Comments per page: </span>
                    <select id="no_of_comment_show" onchange="changeView()">
                        <option value="4">4</option>
                        <option value="8">8</option>
                        <option value="12">12</option>
                        <option value="16">16</option>
                    </select>

                </div>
            </div>
            <div class="row" id="div_comment_list">
            <?php foreach ($comments as $comment) { ?>
                <div id="div_comment_<?php echo $comment['comment_id'] ?>" class="row" style="margin-bottom: 8px;"><!--comments-->
                    <div class="col-md-12">
                        <table style="margin-right: 16px">
                            <tbody id="tbody_recipe_comments_list">
                                <tr>
                                    <td style="vertical-align: top">
                                        <div class="col-md-2 feed-profile-picture">
                                            <a href='<?php echo base_url() . "member_profile/show/{$comment['user_id']}" ?>'>
                                                <div>
                                                    <img style="max-width:50px;" alt="<?php echo $comment['first_name'][0] . $comment['last_name'][0] ?>" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $comment['photo'] ?>?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " />                     
                                                    <p style="visibility:hidden"><?php echo $comment['first_name'][0] . $comment['last_name'][0] ?></p>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <?php if ($comment['rate_id'] == 0) { ?>
                                        <td align="right" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-bln-ml.png" ?>');background-repeat:repeat-y; background-position: right;">
                                            <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-bln-tl.png" ?>"/>
                                        </td>
                                        <td class="cus_comment_field" style="width: 100%;" >
                                        <?php } else if ($comment['rate_id'] == 1) { ?>
                                        <td align="right" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-gre-ml.png" ?>');background-repeat:repeat-y; background-position: right;">
                                            <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-gre-tl.png" ?>"/>
                                        </td>
                                        <td class="cus_comment_field_pos" style="width: 100%;" >  
                                        <?php } else if ($comment['rate_id'] == 2) { ?>
                                        <td align="right" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-red-ml.png" ?>');background-repeat:repeat-y; background-position: right;">
                                            <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-red-tl.png" ?>"/>
                                        </td>
                                        <td class="cus_comment_field_neg" style="width: 100%;" >
                                        <?php } ?>                                
                                        <table style="width: 100%;">
                                            <tr>
                                                <td style="width: 100%;"><!--actual comment-->
                                                    <span id="commentfield" class="cus_comment_field_commenter">
                                                        <span class="content_text"><?php echo $comment['first_name'] . ' ' . $comment['last_name']; ?></span>
                                                    </span>
                                                    <div style="padding: 10px;" class="small_text_pale">
                                                        <?php echo $comment['comment']; ?><br>
                                                        <!--<div class="row form-group"></div>-->
                                                        <?php echo$comment['comment_created_on']?>
                                                    </div>
                                                    <div id="effect_<?php echo $comment['comment_id']; ?>" style="display:none">
                                                        <br><textarea style="width: 100%;" name="comment_for_edit" id="comment_for_edit_<?php echo $comment['comment_id']; ?>"><?php echo $comment['comment']; ?></textarea>
                                                        <input type="hidden" name="comment_id_for_edit" id="comment_id_for_edit_<?php echo $comment['comment_id']; ?>" value="<?php echo $comment['comment_id']; ?>">
                                                        <!--<br><br><button  onclick="slidout();">Post</button>-->
                                                        <br><br><button class="btn btn-default" onclick="edit_your_comment('<?php echo $comment['comment_id']; ?>');">Post</button>
                                                        <div style="float: right;" id="comment_nature_for_edit_<?php echo $comment['comment_id']; ?>">
                                                            <b>
                                                                <input type="radio" name="comment_nature<?php echo $comment['comment_id']?>" <?php if($comment['rate_id'] == 1) echo "checked";?> value="Positive" style="margin-left: 8px;"> Positive
                                                                <input type="radio" name="comment_nature<?php echo $comment['comment_id']?>" <?php if($comment['rate_id'] == 2) echo "checked";?> value="Negative" style="margin-left: 8px;"> Negative
                                                                <input type="radio" name="comment_nature<?php echo $comment['comment_id']?>" <?php if($comment['rate_id'] == 0) echo "checked";?> value="Neutral" style="margin-left: 8px;"> Neutral
                                                            </b>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td align="right" style="vertical-align: top">
                                                    <?php if ($comment['user_id'] == $user_info['user_id']) { ?>
                                                        <div class="btn-group">
                                                            <img class="dropdown-toggle" data-toggle="dropdown" src="<?php echo base_url() . "resources/images/comment_bubble/cross.png" ?>"/>
                                                            <ul class="dropdown-menu" style="text-align: left; background-color: #00A2E8">
                                                                <li role="presentation"><a onclick="remove_comment('<?php echo $comment['comment_id']; ?>');"> <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-delete.png" ?>"/> Remove </a></li>
                                                                <li role="presentation"><a  onclick="slidin('<?php echo $comment['comment_id']; ?>');"><img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-edit.png" ?>"/> Edit</a></li>
                                                            </ul>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div id="like_star_<?php echo $comment['comment_id'] ?>" align="right">
                                                        <?php 
                                                        if(is_application_comment_like_label($comment['liked_user_list'])){ ?>
                                                            <img id="liked_image" value="<?php echo $comment['comment_id'] ?>" style="padding-bottom: 4px;"src="<?php echo base_url(); ?>resources/images/vote_star_active_32.png" />
                                                        <?php } else{ ?>
                                                            <img id="unliked_image" value="<?php echo $comment['comment_id'] ?>" style="padding-bottom: 4px;"src="<?php echo base_url(); ?>resources/images/vote_star_gray_32.png" />
                                                        <?php }?>                                                        
                                                    </div>
                                                </td>
                                                <td>
                                                    <div id="like_counter_<?php echo $comment['comment_id'] ?>" value="<?php echo count($comment['liked_user_list']);?>" class="small_text_pale">
                                                        <?php echo count($comment['liked_user_list']);?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <?php if ($comment['rate_id'] == 0) { ?>
                                        <td align="left" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-bln-mr.png" ?>');background-repeat:repeat-y;">
                                            <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-bln-mr.png" ?>"/>
                                        </td>
                                    <?php } else if ($comment['rate_id'] == 1) { ?>
                                        <td align="left" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-gre-mr.png" ?>');background-repeat:repeat-y;">
                                            <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-gre-mr.png" ?>"/>
                                        </td>  
                                    <?php } else if ($comment['rate_id'] == 2) { ?>
                                        <td align="left" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-red-mr.png" ?>');background-repeat:repeat-y;">
                                            <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-red-mr.png" ?>"/>
                                        </td>
                                    <?php } ?>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } ?>
            </div>
        </div>
        <div id="" class="row" style="margin-bottom: 8px"><!--comments-->
            <div id="comment_list" class="col-md-12">
                <table style="margin-right: 16px">
                    <tr>
                        <td style="vertical-align: top">
                            <div class="col-md-2 feed-profile-picture">
                                <a href='<?php echo base_url() . "member_profile/show/{$user_info['user_id']}" ?>'>
                                    <div>
                                        <img style="max-width:50px;" alt="<?php echo $user_info['first_name'][0] . $user_info['last_name'][0] ?>" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $user_info['photo'] ?>?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " />                     
                                        <p style="visibility:hidden"><?php echo $user_info['first_name'][0] . $user_info['last_name'][0] ?></p>
                                    </div>
                                </a>
                            </div>
                        </td>
                        <td align="right" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-bln-ml.png" ?>');background-repeat:repeat-y; background-position: right;">
                            <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-bln-tl.png" ?>"/>
                        </td>
                        <td class="cus_comment_reply_field" style="width: 100%;" >
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 100%;"><!--actual comment-->
                                        <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-reply-write.png" ?>"/>
                                        <span class="cus_comment_field_commenter" style="color: #666666; font-weight: normal;">Comment</span>
                                        <br><textarea name="comment" id="comment" style="width: 100%;margin: 5px 0px;"></textarea>
                                        <br><button class="btn btn-default" id="save_comment" name="save_comment">Post</button>
                                        <div style="float: right;" class="small_text_pale">
                                            <b>
                                                <input type="radio" name="comment_nature" value="Positive" style="margin-left: 8px;"> Positive
                                                <input type="radio" name="comment_nature" value="Negative" style="margin-left: 8px;"> Negative
                                                <input type="radio" name="comment_nature" value="Neutral" style="margin-left: 8px;" checked> Neutral
                                            </b>
                                        </div>
                                        <br>
                                    </td>
                                    <td align="right" style="width: 16px; vertical-align:top;">

                                    </td>

                                </tr>
                            </table>
                        </td>
                        <td align="left" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-bln-mr.png" ?>');background-repeat:repeat-y;">
                            <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-bln-mr.png" ?>"/>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/x-tmpl" id="tmpl_recipe_comments_list">
    {% var i=0, application_comment_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(application_comment_info){ %}
        <div id="div_comment_{%=application_comment_info.comment_id %}" class="row" style="margin-bottom: 8px"><!--comments-->
            <div class="col-md-12">
                <table style="margin-right: 16px">
                    <tbody id="tbody_recipe_comments_list">
                    <tr>
                        <td style="vertical-align: top">
                            <div class="col-md-2 feed-profile-picture">
                                <a href='<?php echo base_url() . "member_profile/show/{%=application_comment_info.user_id %}" ?>'>
                                    <div>
                                        <img style="max-width:50px;" alt="{%=application_comment_info.signature %}" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . "{%=application_comment_info.photo %}" ?>?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " />                     
                                        <p style="visibility:hidden">{%=application_comment_info.signature %}</p>
                                    </div>
                                </a>
                            </div>
                        </td>
                        {% if(application_comment_info.rate_id  == 0){ %}
                        <td align="right" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-bln-ml.png" ?>');background-repeat:repeat-y; background-position: right;">
                            <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-bln-tl.png" ?>"/>
                        </td>
                        <td class="cus_comment_field" style="width: 100%;" >
                        {% }else if(application_comment_info.rate_id  == 1){ %}
                        <td align="right" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-gre-ml.png" ?>');background-repeat:repeat-y; background-position: right;">
                            <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-gre-tl.png" ?>"/>
                        </td>
                        <td class="cus_comment_field_pos" style="width: 100%;" >    
                        {% }else if(application_comment_info.rate_id  == 2){ %}
                        <td align="right" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-red-ml.png" ?>');background-repeat:repeat-y; background-position: right;">
                            <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-red-tl.png" ?>"/>
                        </td>
                        <td class="cus_comment_field_neg" style="width: 100%;" >
                        {% } %}
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 100%;"><!--actual comment-->
                                        <span id="commentfield" class="cus_comment_field_commenter">{%=application_comment_info.first_name%} {%=application_comment_info.last_name%}</span>
                                        <br>{%=application_comment_info.comment %}<br>
                                        <div>
                                            {%= application_comment_info.comment_created_on %}
                                        </div>
                                        <div id="effect_{%=application_comment_info.comment_id %}" style="display: none;">
                                            <br><textarea style="width: 100%;" name="comment_for_edit" id="comment_for_edit_{%=application_comment_info.comment_id %}">{%=application_comment_info.comment %}</textarea>
                                            <input type="hidden" name="comment_id_for_edit" id="comment_id_for_edit_{%=application_comment_info.comment_id %}" value="{%=application_comment_info.comment_id %}">
                                            <!--<br><br><button  onclick="slidout();">Post</button>-->
                                            <br><br><button class="btn btn-default" onclick="edit_your_comment('{%=application_comment_info.comment_id %}');">Post</button>
                                            <div style="float: right;" id="comment_nature_for_edit_{%=application_comment_info.comment_id %}">
                                                <b>
                                                    {% if(application_comment_info.rate_id  == 1){ %}
                                                        <input type="radio" name="comment_nature{%=application_comment_info.comment_id%}" checked value="Positive" style="margin-left: 8px;"> Positive
                                                    {% }else{ %}
                                                        <input type="radio" name="comment_nature{%=application_comment_info.comment_id%}" value="Positive" style="margin-left: 8px;"> Positive
                                                    {% } %}
                                                    {% if(application_comment_info.rate_id  == 2){ %}
                                                        <input type="radio" name="comment_nature{%=application_comment_info.comment_id%}" value="Negative" checked style="margin-left: 8px;"> Negative
                                                    {% }else{ %}
                                                        <input type="radio" name="comment_nature{%=application_comment_info.comment_id%}" value="Negative" style="margin-left: 8px;"> Negative
                                                    {% } %}
                                                    {% if(application_comment_info.rate_id  == 0){ %}
                                                        <input type="radio" name="comment_nature{%=application_comment_info.comment_id%}" checked value="Neutral" style="margin-left: 8px;"> Neutral
                                                    {% }else{ %}
                                                        <input type="radio" name="comment_nature{%=application_comment_info.comment_id%}" value="Neutral" style="margin-left: 8px;"> Neutral
                                                    {% } %}
                                                </b>
                                            </div>
                                        </div>
                                        <br>
                                    </td>

                                    <td align="right" style="vertical-align: top">
                                        {% if(application_comment_info.user_id  == '<?php echo $user_info['user_id'] ?>'){ %}
                                        <div class="btn-group">
                                            <img class="dropdown-toggle" data-toggle="dropdown" src="<?php echo base_url() . "resources/images/comment_bubble/cross.png" ?>"/>
                                            <ul class="dropdown-menu" style="text-align: left; background-color: #00A2E8">
                                                <li role="presentation"><a onclick="remove_comment('{%=application_comment_info.comment_id %}');"> <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-delete.png" ?>"/> Remove </a></li>
                                                <li role="presentation"><a  onclick="slidin('{%=application_comment_info.comment_id %}');"><img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-edit.png" ?>"/> Edit</a></li>
                                            </ul>
                                        </div>
                                        {% } %}  
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div id="like_star_{%= application_comment_info.comment_id %}" align="right">
                                            {% if(is_liked_by_current_user(application_comment_info.liked_user_list)){ %}
                                                <img id="liked_image" value="{%= application_comment_info.comment_id %}" style="padding-bottom: 4px;"src="<?php echo base_url(); ?>resources/images/vote_star_active_32.png" />
                                            {% } else{ %}
                                                <img id="unliked_image" value="{%= application_comment_info.comment_id %}" style="padding-bottom: 4px;"src="<?php echo base_url(); ?>resources/images/vote_star_gray_32.png" />
                                            {% } %}                                                     
                                        </div>
                                    </td>
                                    <td>
                                        <div id="like_counter_{%= application_comment_info.comment_id %}" value="{%= application_comment_info.liked_user_list.length %}">
                                            {%= application_comment_info.liked_user_list.length %}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        {% if(application_comment_info.rate_id  == 0){ %}
                            <td align="left" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-bln-mr.png" ?>');background-repeat:repeat-y;">
                                <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-bln-mr.png" ?>"/>
                            </td>
                        {% }else if(application_comment_info.rate_id  == 1){ %}
                            <td align="left" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-gre-mr.png" ?>');background-repeat:repeat-y;">
                                <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-gre-mr.png" ?>"/>
                            </td> 
                        {% }else if(application_comment_info.rate_id  == 2){ %}
                            <td align="left" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-red-mr.png" ?>');background-repeat:repeat-y;">
                                <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-red-mr.png" ?>"/>
                            </td>
                        {% } %}                        
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    {% application_comment_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
