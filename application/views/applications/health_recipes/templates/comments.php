<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />

<script>
    function slidin(id) {
        $("#effect_" + id).show("clip", {}, 400);
    }

    function edit_your_comment(comment_id)
    {
        //alert(comment_id);
        if ($("#comment_for_edit_" + comment_id).val().length == 0)
        {
           // alert("please type your comment");
           var message = please type your comment;
           print_common_message(message);
            return false;
        }
        var radios = $('#comment_nature_for_edit_' + comment_id + ' input:radio[name=comment_nature'+comment_id+']');
        var comment_nature;
        if (radios.is(':checked') === false) {
            comment_nature = "Neutral";
        } else {
            comment_nature = $('input[name=comment_nature'+comment_id+']:checked').val();            
        }

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "applications/healthy_recipes/edit_comment",
            data: {
                comment_id: comment_id,
                comment: $("#comment_for_edit_" + comment_id).val(),
                comment_nature: comment_nature,
                recipe_id: $("#recipe_id").val()
            },
            success: function(data) {
                if (data['status'] === 1)
                {
                    var generated_html = tmpl("tmpl_recipe_comments_list", data['comment_info']);
                    $("#div_comment_"+comment_id+"").html($(generated_html).html());
                }
                //alert(data['message']); 
                var message = data['message'];
                 print_common_message(message);
            }
        });

        $("#effect_" + comment_id).hide("clip", {}, 400);
    }

    function remove_comment(id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "applications/healthy_recipes/remove_comment",
            data: {
                comment_id: id,
            },
            success: function(data) {
               // alert(data['message']);
               var message = data['message'];
                 print_common_message(message);
                if (data['status'] === 1)
                {
                    $("#div_comment_"+id+"").remove();
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
        var recipe_id = <?php echo $recipe_item['id'] ?>;
        //alert(recipe_id+' '+list+' '+value);


        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "applications/healthy_recipes/sorted_comment_list",
            data: {
                value: value,
                recipe_id: recipe_id,
                list: list
            },
            success: function(data) {
                //removing throbber
                $("#div_comment_list").html('');
                $.each(data['comment_list'], function(i, item){
                    $("#div_comment_list").html($("#div_comment_list").html()+tmpl("tmpl_recipe_comments_list", item));
                });
                //$("#recipe_comment_list").html(tmpl("tmpl_recipe_comments_list", data['comment_list']));
            }
        });
    }

</script>
<script type="text/javascript">
    function expandAll() {
        if ($("#expand_all").prop('checked') == true) {
            $("#comment_list").show();
        } else {
            $("#comment_list").hide();
        }
    }
</script>

<div class="row" style="margin-top: 8px;">
    <div class="col-md-12 cus_comment_box"><!--main box-->

        <div class="row cus_comment_box_header">
            <h3 class="col-md-12" style="padding-left: 16px"> Comments</h3>
        </div>

        <div class="col-md-12" ><!--content-->
            <div class="col-md-12" style="border: 1px solid #cccccc; background-color: #EDEDED; padding: 8px; margin-bottom: 16px;"><!--order-->
                Order by: <!--ajax reload 'comments'-->
                <select id="comment_view" onchange="changeView()">
                    <option value="1">Newest first</option> 
                    <option value="2">Oldest first</option>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="show_or_not_show" onchange="changeView()" id="expand_all" > Expand all
                <div style="float: right;">
                    Comments per page: 
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
                <div id="div_comment_<?php echo $comment['comment_id'] ?>" class="row" style="margin-bottom: 8px"><!--comments-->
                    <div class="col-md-12">
                        <table style="margin-left: 16px">
                            <tbody id="tbody_recipe_comments_list">
                                <tr>
                                    <td style="vertical-align: top">
                                        <div class="col-md-2 feed-profile-picture">
                                            <a href='<?php echo base_url() . "member_profile/show/{$comment['user_id']}" ?>'>
                                                <div>
                                                    <img style="max-width:50px;" alt="<?php echo $comment['first_name'][0] . $comment['last_name'][0] ?>" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $comment['photo'] ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " />                     
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
                                                    <span id="commentfield" class="cus_comment_field_commenter"><?php echo $comment['first_name'] . ' ' . $comment['last_name']; ?></span>
                                                    <br><?php echo $comment['comment']; ?><br>
                                                    <div>
                                                        <?php echo convert_time($comment['comment_created_on'])?>
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
                                                    <br>
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
                                                    <div id="like_star" align="right">
                                                        <img style="padding-bottom: 4px;"src="<?php echo base_url(); ?>resources/images/vote_star_active_32.png" />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div id="like_count">
                                                        1
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
            <table style="margin-left: 16px">
                <tr>
                    <td style="vertical-align: top">
                        <div class="col-md-2 feed-profile-picture">
                            <a href='<?php echo base_url() . "member_profile/show/{$user_info['user_id']}" ?>'>
                                <div>
                                    <img style="max-width:50px;" alt="<?php echo $user_info['first_name'][0] . $user_info['last_name'][0] ?>" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . $user_info['photo'] ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " />                     
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
                                    <br><textarea name="comment" id="comment" style="width: 100%;"></textarea>
                                    <input type="hidden" name="recipe_id" id="recipe_id" value="<?php echo isset($recipe_item['id']) ? $recipe_item['id'] : ''; ?>" >
                                    <!--<input type="hidden" name="user_id" id="user_id" value="<?php //echo $recipe['id']; ?>" >-->
                                    <br><br><button class="btn btn-default" id="save_comment" name="save_comment">Post</button>
                                    <div style="float: right;">
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
<script type="text/javascript">
    $(function() {
        $("#save_comment").on("click", function() {
            if ($("#comment").val().length == 0)
            {
                //alert("please type your comment");
                var message = "please type your comment";
                 print_common_message(message);
                return false;
            }
            var radios = $('input:radio[name=comment_nature]');
            if (radios.is(':checked') === false) {
                var comment_nature = "Neutral";
            } else {
                var comment_nature = $('input[name$="comment_nature"]:checked').val();
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "applications/healthy_recipes/post_comment",
                data: {
                    comment: $("#comment").val(),
                    comment_nature: comment_nature,
                    recipe_id: $("#recipe_id").val()
                },
                success: function(data) {
                   // alert(data['message']);
                   var message = data['message'];
                 print_common_message(message);
                    if (data['status'] === 1)
                    {
                        $("#div_comment_list").html(tmpl("tmpl_recipe_comments_list", data['comment_info'])+$("#div_comment_list").html());                        
                    }
                }
            });
        });
    });
</script>

<script type="text/x-tmpl" id="tmpl_recipe_comments_list">
    {% var i=0, recipe_comment_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(recipe_comment_info){ %}
        <div id="div_comment_{%=recipe_comment_info.comment_id %}" class="row" style="margin-bottom: 8px"><!--comments-->
            <div class="col-md-12">
                <table style="margin-left: 16px">
                    <tbody id="tbody_recipe_comments_list">
                    <tr>
                        <td style="vertical-align: top">
                            <div class="col-md-2 feed-profile-picture">
                                <a href='<?php echo base_url() . "member_profile/show/{%=recipe_comment_info.user_id %}" ?>'>
                                    <div>
                                        <img style="max-width:50px;" alt="{%=recipe_comment_info.signature %}" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH . "{%=recipe_comment_info.photo %}" ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " />                     
                                        <p style="visibility:hidden">{%=recipe_comment_info.signature %}</p>
                                    </div>
                                </a>
                            </div>
                        </td>
                        {% if(recipe_comment_info.rate_id  == 0){ %}
                        <td align="right" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-bln-ml.png" ?>');background-repeat:repeat-y; background-position: right;">
                            <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-bln-tl.png" ?>"/>
                        </td>
                        <td class="cus_comment_field" style="width: 100%;" >
                        {% }else if(recipe_comment_info.rate_id  == 1){ %}
                        <td align="right" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-gre-ml.png" ?>');background-repeat:repeat-y; background-position: right;">
                            <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-gre-tl.png" ?>"/>
                        </td>
                        <td class="cus_comment_field_pos" style="width: 100%;" >    
                        {% }else if(recipe_comment_info.rate_id  == 2){ %}
                        <td align="right" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-red-ml.png" ?>');background-repeat:repeat-y; background-position: right;">
                            <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-red-tl.png" ?>"/>
                        </td>
                        <td class="cus_comment_field_neg" style="width: 100%;" >
                        {% } %}
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 100%;"><!--actual comment-->
                                        <span id="commentfield" class="cus_comment_field_commenter">{%=recipe_comment_info.first_name%} {%=recipe_comment_info.last_name%}</span>
                                        <br>{%=recipe_comment_info.comment %}<br>
                                        <div>
                                            {%= getDateDescription(recipe_comment_info.comment_created_on,'<?php echo now()?>') %}
                                        </div>
                                        <div id="effect_{%=recipe_comment_info.comment_id %}" style="display: none;">
                                            <br><textarea style="width: 100%;" name="comment_for_edit" id="comment_for_edit_{%=recipe_comment_info.comment_id %}">{%=recipe_comment_info.comment %}</textarea>
                                            <input type="hidden" name="comment_id_for_edit" id="comment_id_for_edit_{%=recipe_comment_info.comment_id %}" value="{%=recipe_comment_info.comment_id %}">
                                            <!--<br><br><button  onclick="slidout();">Post</button>-->
                                            <br><br><button class="btn btn-default" onclick="edit_your_comment('{%=recipe_comment_info.comment_id %}');">Post</button>
                                            <div style="float: right;" id="comment_nature_for_edit_{%=recipe_comment_info.comment_id %}">
                                                <b>
                                                    {% if(recipe_comment_info.rate_id  == 1){ %}
                                                        <input type="radio" name="comment_nature" checked value="Positive" style="margin-left: 8px;"> Positive
                                                    {% }else{ %}
                                                        <input type="radio" name="comment_nature" value="Positive" style="margin-left: 8px;"> Positive
                                                    {% } %}
                                                    {% if(recipe_comment_info.rate_id  == 2){ %}
                                                        <input type="radio" name="comment_nature" value="Negative" checked style="margin-left: 8px;"> Negative
                                                    {% }else{ %}
                                                        <input type="radio" name="comment_nature" value="Negative" style="margin-left: 8px;"> Negative
                                                    {% } %}
                                                    {% if(recipe_comment_info.rate_id  == 0){ %}
                                                        <input type="radio" name="comment_nature" checked value="Neutral" style="margin-left: 8px;"> Neutral
                                                    {% }else{ %}
                                                        <input type="radio" name="comment_nature" value="Neutral" style="margin-left: 8px;"> Neutral
                                                    {% } %}                                                    
                                                </b>
                                            </div>
                                        </div>
                                        <br>
                                    </td>

                                    <td align="right" style="vertical-align: top">
                                        {% if(recipe_comment_info.user_id  == '<?php echo $user_info['user_id'] ?>'){ %}
                                        <div class="btn-group">
                                            <img class="dropdown-toggle" data-toggle="dropdown" src="<?php echo base_url() . "resources/images/comment_bubble/cross.png" ?>"/>
                                            <ul class="dropdown-menu" style="text-align: left; background-color: #00A2E8">
                                                <li role="presentation"><a onclick="remove_comment('{%=recipe_comment_info.comment_id %}');"> <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-delete.png" ?>"/> Remove </a></li>
                                                <li role="presentation"><a  onclick="slidin('{%=recipe_comment_info.comment_id %}');"><img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-edit.png" ?>"/> Edit</a></li>
                                            </ul>
                                        </div>
                                        {% } %}  
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div id="like_star" align="right">
                                            <img style="padding-bottom: 4px;"src="<?php echo base_url(); ?>resources/images/vote_star_active_32.png" />
                                        </div>
                                    </td>
                                    <td>
                                        <div id="like_count">
                                           1
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        {% if(recipe_comment_info.rate_id  == 0){ %}
                            <td align="left" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-bln-mr.png" ?>');background-repeat:repeat-y;">
                                <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-bln-mr.png" ?>"/>
                            </td>
                        {% }else if(recipe_comment_info.rate_id  == 1){ %}
                            <td align="left" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-gre-mr.png" ?>');background-repeat:repeat-y;">
                                <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-gre-mr.png" ?>"/>
                            </td> 
                        {% }else if(recipe_comment_info.rate_id  == 2){ %}
                            <td align="left" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-red-mr.png" ?>');background-repeat:repeat-y;">
                                <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-red-mr.png" ?>"/>
                            </td>
                        {% } %}                        
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    {% recipe_comment_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
