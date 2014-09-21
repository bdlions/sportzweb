<script type="text/javascript">
    $(function(){
        $("#search_followers_box").typeahead([{
                name:"show_followers",
                prefetch:{
                            url: '<?php echo base_url()?>search/get_followers/',
                            ttl: 0
                        },
                template: [
                    '<div class="col-md-3"><img src="<?php echo base_url()?>resources/uploads/{{photo}}" class="img-responsive"/></div>',
                    '<div class="col-md-9">{{first_name}} {{last_name}}</div>'
                  ].join(''),
                engine: Hogan
        }]).on('typeahead:selected', function (obj, datum) {
                window.location = "<?php echo base_url()?>member_profile/show/" + datum.user_id;
            });
            
        $("#button_pending_request").on("click", function(){
            window.location = '<?php echo base_url()?>followers/pending_followers';
        });
    });
</script>
<div class="col-md-2 column">
    <?php $this->load->view("templates/sections/member_profile_left_pane"); ?>
</div>
<div class="col-md-9 column">
    <?php if($current_user_id == $user_id){?>
    <div class="row" style="padding-bottom: 30px;">
        <div class="col-md-5">
            <div class=" input-group search-box-followers">
                <input id="search_followers_box" class="form-control typeahead" type="text" placeholder="Search for followers" />
                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
            </div>
        </div>
        
        <div class="col-md-7">
            
                <div class="col-md-3">
                    <?php if($follow_permission->value == FOLLOWER_ACCEPTANCE_TYPE_MANUAL){?>
                        <button class="btn button-custom" id="button_pending_request">Pending Requests</button>
                    <?php }?>
                </div>
                <div class="col-md-2">
                    <a href="<?php echo base_url().'followers/invite'?>"><button class="btn button-custom">Invite</button></a>                    
                </div>
                <div class="col-md-3">
                    <a href="<?php echo base_url().'followers/show/'.$user_id?>"><button class="btn button-custom">My Followers</button></a>
                </div>
                <div class="col-md-3">
                    <a href="<?php echo base_url().'followers/blocked_followers/'.$user_id?>"><button class="btn button-custom">Blocked Members</button></a>                    
                </div>
            
        </div>
    </div>
    <?php } ?>
    <?php
    $follower_count = 0;
    foreach ($followers as $follower) {
        if ($follower_count % 2 == 0) {?>
        <div class="row" style="padding-top: 10px;">
        <?php $this->load->view("followers/follower_info", array("follower" => $follower, 'user_id' => $user_id, 'current_user_id' => $current_user_id));
        } 
        else {
            $this->load->view("followers/follower_info", array("follower" => $follower, 'user_id' => $user_id, 'current_user_id' => $current_user_id));?>
        </div>
        <?php } 
        $follower_count++;
    } ?>
</div>
