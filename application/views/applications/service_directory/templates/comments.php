<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />

<script>
    function slidin(id) {
        $("#effect_"+id).show("clip", {}, 400);
    }
    
    function edit_your_comment(comment_id)
    {
        if ($("#comment_for_edit_"+comment_id).val().length == 0)
        {
            //alert("please type your comment");
             var message = "please type your comment";
                print_common_message(message);
            return false;
        }
        var radios = $('#comment_nature_for_edit_'+comment_id+' input:radio[name=comment_nature]');
        var comment_nature;
        if(radios.is(':checked') === false) {
           comment_nature = "Neutral";
        } else {
           comment_nature = $('#comment_nature_for_edit_'+comment_id+' input[name$="comment_nature"]:checked').val();
        }

        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "applications/service_directory/edit_comment",
            data: {
                comment_id : comment_id,
                comment: $("#comment_for_edit_"+comment_id).val(),
                comment_nature : comment_nature,
                service_id : $("#service_id").val()
            },
            success: function(data) {
                //alert(data['message']);
                var message = data['message'];
                print_common_message(message);
                if (data['status'] === 1)
                {                       
                    window.location.reload();
                }
            }
        });
        
        $("#effect_"+comment_id).hide("clip", {}, 400);
    }
    
    function remove_comment(id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "applications/service_directory/remove_comment",
            data: {
                comment_id : id,
            },
            success: function(data) {
               // alert(data['message']);
               var message = data['message'];
                print_common_message(message);
                if (data['status'] === 1)
                {                       
                    window.location.reload();
                }
            }
        });
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
                <select>
                    <option value="newest">Newest first</option> 
                    <option value="oldest">Oldest first</option> 
                    <option onclick="history.go(0)">function here</option> 
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" onclick="history.go(0)"> Expand all
                <div style="float: right;">
                    Comments per page: 
                    <select>
                        <option value="4">4</option>
                        <option value="8">8</option>
                        <option value="12">12</option>
                        <option value="16">16</option>
                    </select>

                </div>
            </div>
            <?php foreach ($comments as $comment) : ?>
            
            
            <?php if($comment['rate_id'] == 0) : ?><!--neutral comments-->
                <div class="row" style="margin-bottom: 8px"><!--comments-->
                    <div class="col-md-12">
                        <table style="margin-left: 16px">
                            <tbody id="tbody_service_comments_list">
                            <tr>
                                <td style="vertical-align: top">
                                    <img src="<?php echo base_url() . "resources/uploads/" .$comment['photo'];?>" height="auto" width="32px"/>
                                </td>
                                <td align="right" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-bln-ml.png" ?>');background-repeat:repeat-y; background-position: right;">
                                    <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-bln-tl.png" ?>"/>
                                </td>
                                <td class="cus_comment_field" style="width: 100%;" >
                                    <table>
                                        <tr>
                                            <td style="width: 100%;"><!--actual comment-->
                                                <span id="commentfield" class="cus_comment_field_commenter"><?php echo$comment['username']; ?></span>
                                                <br><?php echo $comment['comment']; ?><br><!-- edit, truncate text here-->
                                                <div>
                                                    <?php if($comment['rate_id'] == 0): ?>
                                                        <?php echo 'Neutral'; ?>
                                                    <?php elseif($comment['rate_id'] == 1) : ?>
                                                        <?php echo 'Positive'; ?>
                                                    <?php else: ?>
                                                        <?php echo 'Negative'; ?>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    Posted: <?php echo unix_to_human($comment['created_on']); ?>
                                                </div>
                                                <div id="effect_<?php echo $comment['id']; ?>" style="display: none;">
                                                    <br><textarea style="width: 100%;" name="comment_for_edit" id="comment_for_edit_<?php echo $comment['id']; ?>"><?php echo $comment['comment']; ?></textarea>
                                                    <input type="hidden" name="comment_id_for_edit" id="comment_id_for_edit_<?php echo $comment['id']; ?>" value="<?php echo $comment['id']; ?>">
                                                    <!--<br><br><button  onclick="slidout();">Post</button>-->
                                                    <br><br><button  onclick="edit_your_comment('<?php echo $comment['id']; ?>');">Post</button>
                                                    <div style="float: right;" id="comment_nature_for_edit_<?php echo $comment['id']; ?>">
                                                        <b>
                                                            <?php if($comment['rate_id'] == 1): ?>
                                                                <input type="radio" name="comment_nature" checked value="Positive" style="margin-left: 8px;"> Positive
                                                            <?php else: ?>
                                                                <input type="radio" name="comment_nature" value="Positive" style="margin-left: 8px;"> Positive
                                                            <?php endif; ?>
                                                                
                                                            <?php if($comment['rate_id'] == 2): ?>
                                                                <input type="radio" name="comment_nature" value="Negative" checked style="margin-left: 8px;"> Negative
                                                            <?php else: ?>
                                                                <input type="radio" name="comment_nature" value="Negative" style="margin-left: 8px;"> Negative
                                                            <?php endif; ?>
                                                                
                                                            <?php if($comment['rate_id'] == 0): ?>
                                                                <input type="radio" name="comment_nature" checked value="Neutral" style="margin-left: 8px;"> Neutral
                                                            <?php else: ?>
                                                                <input type="radio" name="comment_nature" value="Neutral" style="margin-left: 8px;"> Neutral
                                                            <?php endif; ?>
                                                        </b>
                                                    </div>
                                                </div>
                                                <br>
                                            </td>
                                            
                                            <td align="right" style="width: 16px; vertical-align:top;">
                                                <div class="btn-group">
                                                    <img class="dropdown-toggle" data-toggle="dropdown" src="<?php echo base_url() . "resources/images/comment_bubble/cross.png" ?>"/>
                                                    <ul class="dropdown-menu" style="text-align: left; background-color: #00A2E8">
                                                        <li role="presentation"><a onclick="remove_comment('<?php echo $comment['id']; ?>');"> <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-delete.png" ?>"/> Remove </a></li>
                                                        <li role="presentation"><a  onclick="slidin('<?php echo $comment['id']; ?>');"><img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-edit.png" ?>"/> Edit</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td align="left" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-bln-mr.png" ?>');background-repeat:repeat-y;">
                                    <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-bln-mr.png" ?>"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif;?>
            
            <?php if($comment['rate_id'] == 1) : ?><!--positive comments-->
                <div class="row" style="margin-bottom: 8px"><!--comments-->
                    <div class="col-md-12">
                        <table style="margin-left: 16px">
                            <tbody id="tbody_service_comments_list">
                            <tr>
                                <td style="vertical-align: top">
                                    <img src="<?php echo base_url() . "resources/uploads/" .$comment['photo'];?>" height="auto" width="32px"/>
                                </td>
                                <td align="right" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-gre-ml.png" ?>');background-repeat:repeat-y; background-position: right;">
                                    <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-gre-tl.png" ?>"/>
                                </td>
                                <td class="cus_comment_field_pos" style="width: 100%;" >
                                    <table>
                                        <tr>
                                            <td style="width: 100%;"><!--actual comment-->
                                                <span id="commentfield" class="cus_comment_field_commenter"><?php echo$comment['username']; ?></span>
                                                <br><?php echo $comment['comment']; ?><br>
                                                <div>
                                                    <?php if($comment['rate_id'] == 0): ?>
                                                        <?php echo 'Neutral'; ?>
                                                    <?php elseif($comment['rate_id'] == 1) : ?>
                                                        <?php echo 'Positive'; ?>
                                                    <?php else: ?>
                                                        <?php echo 'Negative'; ?>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    Posted: <?php echo unix_to_human($comment['created_on']); ?>
                                                </div>
                                                <div id="effect_<?php echo $comment['id']; ?>" style="display: none;">
                                                    <br><textarea style="width: 100%;" name="comment_for_edit" id="comment_for_edit_<?php echo $comment['id']; ?>"><?php echo $comment['comment']; ?></textarea>
                                                    <input type="hidden" name="comment_id_for_edit" id="comment_id_for_edit_<?php echo $comment['id']; ?>" value="<?php echo $comment['id']; ?>">
                                                    <!--<br><br><button  onclick="slidout();">Post</button>-->
                                                    <br><br><button  onclick="edit_your_comment('<?php echo $comment['id']; ?>');">Post</button>
                                                    <div style="float: right;" id="comment_nature_for_edit_<?php echo $comment['id']; ?>">
                                                        <b>
                                                            <?php if($comment['rate_id'] == 1): ?>
                                                                <input type="radio" name="comment_nature" checked value="Positive" style="margin-left: 8px;"> Positive
                                                            <?php else: ?>
                                                                <input type="radio" name="comment_nature" value="Positive" style="margin-left: 8px;"> Positive
                                                            <?php endif; ?>
                                                                
                                                            <?php if($comment['rate_id'] == 2): ?>
                                                                <input type="radio" name="comment_nature" value="Negative" checked style="margin-left: 8px;"> Negative
                                                            <?php else: ?>
                                                                <input type="radio" name="comment_nature" value="Negative" style="margin-left: 8px;"> Negative
                                                            <?php endif; ?>
                                                                
                                                            <?php if($comment['rate_id'] == 0): ?>
                                                                <input type="radio" name="comment_nature" checked value="Neutral" style="margin-left: 8px;"> Neutral
                                                            <?php else: ?>
                                                                <input type="radio" name="comment_nature" value="Neutral" style="margin-left: 8px;"> Neutral
                                                            <?php endif; ?>
                                                        </b>
                                                    </div>
                                                </div>
                                                <br>
                                            </td>
                                            
                                            <td align="right" style="width: 16px; vertical-align:top;">
                                                <div class="btn-group">
                                                    <img class="dropdown-toggle" data-toggle="dropdown" src="<?php echo base_url() . "resources/images/comment_bubble/cross.png" ?>"/>
                                                    <ul class="dropdown-menu" style="text-align: left; background-color: #00A2E8">
                                                        <li role="presentation"><a onclick="remove_comment('<?php echo $comment['id']; ?>');"> <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-delete.png" ?>"/> Remove </a></li>
                                                        <li role="presentation"><a  onclick="slidin('<?php echo $comment['id']; ?>');"><img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-edit.png" ?>"/> Edit</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td align="left" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-gre-mr.png" ?>');background-repeat:repeat-y;">
                                    <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-gre-mr.png" ?>"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif;?>
            
            <?php if($comment['rate_id'] == 2) : ?><!--negetive comments-->
                <div class="row" style="margin-bottom: 8px"><!--comments-->
                    <div class="col-md-12">
                        <table style="margin-left: 16px">
                            <tbody id="tbody_service_comments_list">
                            <tr>
                                <td style="vertical-align: top">
                                    <img src="<?php echo base_url() . "resources/uploads/" .$comment['photo'];?>" height="auto" width="32px"/>
                                </td>
                                <td align="right" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-red-ml.png" ?>');background-repeat:repeat-y; background-position: right;">
                                    <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-red-tl.png" ?>"/>
                                </td>
                                <td class="cus_comment_field_neg" style="width: 100%;" >
                                    <table>
                                        <tr>
                                            <td style="width: 100%;"><!--actual comment-->
                                                <span id="commentfield" class="cus_comment_field_commenter"><?php echo$comment['username']; ?></span>
                                                <br><?php echo $comment['comment']; ?><br>
                                                <div>
                                                    <?php if($comment['rate_id'] == 0): ?>
                                                        <?php echo 'Neutral'; ?>
                                                    <?php elseif($comment['rate_id'] == 1) : ?>
                                                        <?php echo 'Positive'; ?>
                                                    <?php else: ?>
                                                        <?php echo 'Negative'; ?>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    Posted: <?php echo unix_to_human($comment['created_on']); ?>
                                                </div>
                                                <div id="effect_<?php echo $comment['id']; ?>" style="display: none;">
                                                    <br><textarea style="width: 100%;" name="comment_for_edit" id="comment_for_edit_<?php echo $comment['id']; ?>"><?php echo $comment['comment']; ?></textarea>
                                                    <input type="hidden" name="comment_id_for_edit" id="comment_id_for_edit_<?php echo $comment['id']; ?>" value="<?php echo $comment['id']; ?>">
                                                    <!--<br><br><button  onclick="slidout();">Post</button>-->
                                                    <br><br><button  onclick="edit_your_comment('<?php echo $comment['id']; ?>');">Post</button>
                                                    <div style="float: right;" id="comment_nature_for_edit_<?php echo $comment['id']; ?>">
                                                        <b>
                                                            <?php if($comment['rate_id'] == 1): ?>
                                                                <input type="radio" name="comment_nature" checked value="Positive" style="margin-left: 8px;"> Positive
                                                            <?php else: ?>
                                                                <input type="radio" name="comment_nature" value="Positive" style="margin-left: 8px;"> Positive
                                                            <?php endif; ?>
                                                                
                                                            <?php if($comment['rate_id'] == 2): ?>
                                                                <input type="radio" name="comment_nature" value="Negative" checked style="margin-left: 8px;"> Negative
                                                            <?php else: ?>
                                                                <input type="radio" name="comment_nature" value="Negative" style="margin-left: 8px;"> Negative
                                                            <?php endif; ?>
                                                                
                                                            <?php if($comment['rate_id'] == 0): ?>
                                                                <input type="radio" name="comment_nature" checked value="Neutral" style="margin-left: 8px;"> Neutral
                                                            <?php else: ?>
                                                                <input type="radio" name="comment_nature" value="Neutral" style="margin-left: 8px;"> Neutral
                                                            <?php endif; ?>
                                                        </b>
                                                    </div>
                                                </div>
                                                <br>
                                            </td>
                                            
                                            <td align="right" style="width: 16px; vertical-align:top;">
                                                <div class="btn-group">
                                                    <img class="dropdown-toggle" data-toggle="dropdown" src="<?php echo base_url() . "resources/images/comment_bubble/cross.png" ?>"/>
                                                    <ul class="dropdown-menu" style="text-align: left; background-color: #00A2E8">
                                                        <li role="presentation"><a onclick="remove_comment('<?php echo $comment['id']; ?>');"> <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-delete.png" ?>"/> Remove </a></li>
                                                        <li role="presentation"><a  onclick="slidin('<?php echo $comment['id']; ?>');"><img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-edit.png" ?>"/> Edit</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td align="left" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-red-mr.png" ?>');background-repeat:repeat-y;">
                                    <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-red-mr.png" ?>"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif;?>
            
            
            <?php endforeach; ?>
            

            <div class="row" style="margin-bottom: 8px"><!--comments-->
                <div class="col-md-12">
                    <table style="margin-left: 16px">
                        <tr>
                            <td style="vertical-align: top">
                                <?php if(isset($comment['photo'])): ?>
                                    <img src="<?php echo base_url() . "resources/uploads/" . $comment['photo']; ?>" height="auto" width="32px"/>
                                <?php endif;?>
                            </td>
                            <td align="right" style="width: auto; vertical-align:top; background-image:url('<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-bln-ml.png" ?>');background-repeat:repeat-y; background-position: right;">
                                <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-frm-bln-tl.png" ?>"/>
                            </td>
                            <td class="cus_comment_reply_field" style="width: 100%;" >
                                <table>
                                    <tr>
                                        <td style="width: 100%;"><!--actual comment-->
                                            <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-reply-write.png" ?>"/>
                                            <span class="cus_comment_field_commenter" style="color: #666666; font-weight: normal;">Comment</span>
                                                <br><textarea name="comment" id="comment" style="width: 100%;"></textarea>
                                                <input type="hidden" name="service_id" id="service_id" value="<?php echo $service_info['id'];?>" >
                                                <!--<input type="hidden" name="user_id" id="user_id" value="<?php //echo $service_info['id'];?>" >-->
                                                <br><br><button class="btn btn-default blog_app_cnt_post_btn" id="save_comment" name="save_comment">Post</button>
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
        <!--content-->
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $("#save_comment").on("click", function() {
            if ($("#comment").val().length == 0)
            {
               // alert("please type your comment");
               var message = "please type your comment";
                print_common_message(message);
                return false;
            }
            var radios = $('input:radio[name=comment_nature]');
            if(radios.is(':checked') === false) {
                var comment_nature = "Neutral";
            } else {
               var comment_nature = $('input[name$="comment_nature"]:checked').val();
            }
  
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "applications/service_directory/post_comment",
                data: {
                    comment: $("#comment").val(),
                    comment_nature : comment_nature,
                    service_id : $("#service_id").val()
                },
                success: function(data) {
                    //alert(data['message']);
                    var message = data['message'];
                print_common_message(message);
                    if (data['status'] === 1)
                    {                    
                        //$("#tbody_service_comments_list").html($("#tbody_service_comments_list").html()+tmpl("tmpl_service_comments_list",  data['service_comment_info']));
                        window.location.reload();
                    }
                }
            });
        });
    });
</script>

<script type="text/x-tmpl" id="tmpl_service_comments_list">
    {% var i=0, service_comment_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(service_comment_info){ %}
    <tr>
       
    </tr>
    {% service_comment_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>

<script type="text/javascript">
   $(function() {
    //var $radios = $('input:radio[name=comment_nature]');
    //$radios.filter('[value=Neutral]').prop('checked', true);
//    if($radios.is(':checked') === false) {
//        $radios.filter('[value=Male]').prop('checked', true);
//    }
});
</script>