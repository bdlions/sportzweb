<div class="row feed" id="status_id_<?php echo $newsfeed['status_id']?>">
    <div class="pull-right">
        <?php if($newsfeed['allow_to_delete'] == TRUE){?>
        <div class="btn-group" style="padding-right: 32px">
            <img class="dropdown-toggle" data-toggle="dropdown" src="<?php echo base_url() . "resources/images/close.png" ?>"/>
            <ul class="dropdown-menu" style="text-align: left; background-color: #00A2E8; right: 0; left: auto;">
                <li role="presentation"><a onclick="remove_status('<?php echo $newsfeed['status_id']?>')"> <img src="<?php echo base_url() . "resources/images/comment_bubble/cmt-delete.png" ?>"/> Remove </a></li>
            </ul>
        </div>
        <?php } ?>
    </div>
    <div class="col-md-2 feed-profile-picture">
        <a href='<?php echo base_url(). "member_profile/show/{$newsfeed['user_id']}"?>'>
            <div>
                <img alt="<?php echo $newsfeed['first_name'][0] . $newsfeed['last_name'][0]?>" src="<?php echo base_url().PROFILE_PICTURE_DISPLAY_PATH.$newsfeed['photo'] ?>?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " />                     
                <p style="visibility:hidden"><?php echo $newsfeed['first_name'][0].$newsfeed['last_name'][0] ?></p>
            </div>
        </a>             
    </div>
    <div class="row col-md-10">
        <div class="row">
            <div class="col-md-12">
                <div class="row col-md-12">
                    <?php 
                        $this->data['newsfeed'] = $newsfeed;  
                        $this->load->view("member/newsfeed/feed_header", $this->data); 
                    ?>
                </div>
                <div class="row col-md-12">
                    <?php //echo convert_time($newsfeed['status_created_on'])?> 
                    <span class="small_text_pale"><?php echo $newsfeed['status_created_on']?> </span>
                </div>
                <?php if(!empty($newsfeed['reference_list']) && !empty($newsfeed['reference_list']['user_list'])) {?>
                <div class="row col-md-12 content_text">
                    <?php
                        $reference_size = count($newsfeed['reference_list']['user_list']);
                        $reference_counter = 1;
                        echo 'To ';
                        foreach($newsfeed['reference_list']['user_list'] as $reference_user_info){ ?>
                            <a href='<?php echo base_url(). "member_profile/show/{$reference_user_info['user_id']}"?>' class="profile-name" >
                                <span class="content_text"><?php echo $reference_user_info['first_name'] . " ". $reference_user_info['last_name'].' ' ?></span>
                            </a>
                    <?php 
                            if($reference_counter < $reference_size)
                            {
                                echo ', ';
                            }
                            $reference_counter++;
                        }
                    ?>
                </div>
                <?php }?>                    
            </div>
        </div>
        <div class="row feed-description">

            <div class="col-md-12">
                <?php if( !empty($newsfeed['description']) && isset($newsfeed['description']) ){?>
                <div class="row col-md-12" style="padding-bottom:10px;font-size:15px;">
                    <span class="content_text"><?php echo $newsfeed['description'] ?></span><br/>
                </div>
                <?php } ?>
                <?php if(!empty($newsfeed['attachments'])) {?>
                <div class="row col-md-12" style="padding-top: 10px; padding-bottom:10px;">               
                    <div class="list-inline list-unstyled row col-md-12">
                        <?php foreach ($newsfeed['attachments'] as $attachments){?>
                            <li class="col-md-12">
                                <img src="<?php echo base_url().STATUS_IMAGE_UPLOAD_PATH.$attachments['name'] ?>" class="img-responsive"/> 
                           </li>
                        <?php }?>
                    </div>
                </div>
                <?php } ?>
                <?php if($newsfeed['status_type_id'] == STATUS_TYPE_PROFILE_PIC_CHANGE || $newsfeed['status_type_id'] == STATUS_TYPE_IMAGE_ATTACHMENT) {?>
                <div class="row col-md-12" style="padding-top: 10px; padding-bottom:10px;">               
                    <div class="list-inline list-unstyled row col-md-12">
                        <li class="col-md-12">
                            <img src="<?php echo base_url().ALBUM_IMAGE_PATH.$newsfeed['reference_info']['img'] ?>" class="img-responsive" onclick="mediaDisplay('<?php echo base_url().ALBUM_IMAGE_PATH.$newsfeed['reference_info']['img'] ?>', <?php echo $newsfeed['reference_info']['photo_id']?>)"/> 
                       </li>
                    </div>
                </div>
                <?php } ?>
                <?php 
                    $this->data['newsfeed'] = $newsfeed;  
                    $this->load->view("member/newsfeed/shared_status_content", $this->data); 
                ?>
                <div class="row col-md-12 small_text_dark" id="newsfeed" style="padding-top: 10px; padding-bottom:10px;">
                    <?php 
                        if(is_like_label($newsfeed['liked_user_list']))
                        { ?>
                            <a onclick="click_unlike_feed_post(<?php echo $newsfeed['status_id'];?>); return false;" href="">Unlike</a> 

                        <?php }
                        else
                        { ?>
                            <a onclick="click_like_feed_post(<?php echo $newsfeed['status_id'];?>); return false;" href="">Like</a>
                        <?php }
                    ?>
                    <a onclick="click_comment(<?php echo $newsfeed['status_id'];?>)" href="javascript: void(0)">&nbsp;Comment&nbsp;</a>
                    <a onclick="click_share_feed_post(<?php echo $newsfeed['status_id'];?>)" href="#">Share</a>
                    <?php //echo convert_time($newsfeed['status_created_on'])?>                        
                </div>
                <div class="row col-md-12" id="liked_message" style="padding-bottom:10px;">
                <?php 
                    $total_liked_users = count($newsfeed['liked_user_list']);
                    if($total_liked_users > 0){?>                        
                        <img style="vertical-align: bottom" src="<?php echo base_url();?>resources/images/thumb_up.png" />
                    <?php }
                    $counter = 1;
                    foreach($newsfeed['liked_user_list'] as $liked_user_info)
                    { 
                       if($counter > 1)
                       {
                           if( $counter == 3 && $counter <= $total_liked_users)
                           {
                               echo ' and ';
                           }
                           else if( $counter == $total_liked_users)
                           {
                               echo ' and ';
                           }
                           else
                           {
                               echo ' , ';
                           }
                       } 
                       if($counter == 3 && $total_liked_users > 3)
                       {?>
                           <a onclick="show_liked_user_list(<?php echo $newsfeed['status_id'];?>)" href="#">
                               <?php 
                                echo ($total_liked_users - $counter +1).' others';                                        
                               ?> 
                           </a> 
                       <?php 
                            break;
                       }
                       ?>
                       <a href='<?php echo base_url(). "member_profile/show/{$liked_user_info['user_id']}"?>' class="profile-name" ><?php echo $liked_user_info['first_name'] . " ". $liked_user_info['last_name']; ?></a>                            
                    <?php 
                        $counter++;                            
                    }
                    if($total_liked_users == 1)
                    {
                        echo ' likes this.';
                    }
                    else if($total_liked_users > 1)
                    {
                        echo ' like this.';
                    }

                ?>
                </div>
                <div class="row col-md-10">
                    <div class="row col-md-12">
                        <div class="row col-md-12" id="<?php echo 'feedback_list_'.$newsfeed['status_id']?>">
                        <?php foreach ($newsfeed['feedbacks'] as $feedback){?>
                            <div class="row form-group">
                                <div class="col-md-2 feed-profile-picture">
                                    <a
                                        class="content_text"
                                        href='<?php echo base_url(). "member_profile/show/{$feedback['user_info']['user_id']}"?>'>
                                        <div class="profile-background-comment">
                                            <img
                                                alt="<?php echo $feedback['user_info']['first_name'][0] . $feedback['user_info']['last_name'][0]?>"
                                                src="<?php echo base_url().PROFILE_PICTURE_DISPLAY_PATH.$feedback['user_info']['photo'] ?>?>"
                                                class="img-responsive profile-photo"
                                                onError="this.style.display = 'none'; this.parentNode.className='profile-background-comment'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; "
                                                />                     
                                            <p style="visibility:hidden">
                                                <?php echo $feedback['user_info']['first_name'][0].$feedback['user_info']['last_name'][0] ?>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <div class="row col-md-10">
                                    <a href='<?php echo base_url(). "member_profile/show/{$feedback['user_info']['user_id'] }"?>' class="profile-name" >
                                        <?php echo $feedback['user_info']['first_name'] . " ". $feedback['user_info']['last_name']?>
                                    </a>
                                    <?php echo $feedback['description']?>
                                </div>
                                <div class="row col-md-10" id="feedback_created_date">
                                    <?php echo convert_time($feedback['created_on']) ?>
                                </div>
                            </div>
                        <?php }?>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 feed-profile-picture">
                                <a href='<?php echo base_url(). "member_profile/show/{$user_info['user_id']}"?>'>
                                    <div class="profile-background-comment">
                                        <img alt="<?php echo $user_info['first_name'][0] . $user_info['last_name'][0]?>" src="<?php echo base_url().PROFILE_PICTURE_DISPLAY_PATH.$user_info['photo'] ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background-comment'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " /> 
                                        <p style="visibility:hidden"><?php echo $user_info['first_name'][0].$user_info['last_name'][0] ?></p>
                                    </div>
                                </a>
                            </div>
                            <div class="row col-md-10">
                                <input id="text_input_comment_<?php echo $newsfeed['status_id']?>" type="text" onkeyup="store_status_feedback(event, this, <?php echo $newsfeed['status_id']?>)" class="form-control small_text_pale" placeholder="Write a comment..."  name ="feedback" style="background-color: #EFE4B0"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>