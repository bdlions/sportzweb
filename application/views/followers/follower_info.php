<div class="col-md-5">
    <div class="row">
        <div class="col-md-4">
            <a href='<?php echo base_url() . "member_profile/show/{$follower->user_id}" ?>' class="profile-name"> 
                <div>
                    <img alt="<?php echo $follower->first_name[0] . $follower->last_name[0] ?>" src="<?php echo base_url() . "resources/uploads/" . $follower->photo ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " /> 
                    <p style="visibility:hidden"><?php echo $follower->first_name[0].$follower->last_name[0] ?></p>
                </div>
            </a>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12"><?php echo $follower->first_name . " " . $follower->last_name ?></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php $follower_count = count(json_decode($follower->relations)); echo $follower_count == 1 ? "{$follower_count} Follower" : "{$follower_count} Followers";?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12"><?php echo $follower->about_me ?></div>
            </div>
        </div>
        <?php if($current_user_id == $user_id){ ?>
        <div class="col-md-2">
            <div class="dropdown friends-satus-dropdown">
                <a id="friends_status" data-toggle="dropdown" href="#" >
                    <img src="<?php echo base_url() ?>resources/images/friends_status.png" alt=""/>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="friends_status">
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>followers/remove_follower/<?php echo $follower->follower_id ?>">Unfollow</a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>followers/block_follower/<?php echo $follower->follower_id ?>">Block</a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="open_report_modal('<?php echo $follower->id; ?>')">Report</a>
                    </li>
                </ul>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<div class="col-md-1">
    
</div>
<?php $this->load->view("followers/modal_report"); ?>
<script type="text/javascript">
    function open_report_modal(followers_id){
        $('#follwers_id').val(followers_id);
        $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "followers/get_followers_infor",
                    data: {
                        follwers_id: $('#follwers_id').val(),
                    },
                    success: function(data) {
                        //window.location.reload();
                    }
                });
        $('#modal_report_content').modal('show');
    }
//    $(function(){
//        
//    });
</script>