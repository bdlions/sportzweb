<script type="text/javascript">
    $(function(){
        $("#search_pending_followers_box").typeahead([{
                name:"pending_user",
                //local:[{"username":"Alamgir Kabir","first_name":"Alamgir","last_name":"Kabir","value":"alamgir", "user_id":"2"},{"username":"Nazmul Hasan","first_name":"Nazmul","last_name":"Hasan","value":"nazmul hasan", "user_id":"3"}],
                prefetch:
                        { 
                            url: '<?php echo base_url()?>search/get_followers/', 
                            ttl:0
                        },
                template: [
                    '<div class="col-md-3"><img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash3/c5.5.65.65/s56x56/65686_10201374763675922_1110161127_t.jpg"/></div>',
                    '<div class="col-md-9">{{first_name}} {{last_name}}</div>'
                  ].join(''),
                engine: Hogan
        }]).on('typeahead:selected', function (obj, datum) {
                window.location = "<?php echo base_url()?>member_profile/show/" + datum.user_id;
            });
    });
</script>
<div class="col-md-2 column">
    <?php $this->load->view("templates/sections/member_profile_left_pane"); ?>
</div>
<div class="col-md-8 column">
    <div class="row" style="padding-bottom: 30px;">
        <div class="col-md-7">
            <div class=" input-group search-box-followers">
                <input id="search_pending_followers_box" class="form-control typeahead" type="text" placeholder="Search for followers" />
                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
            </div>
        </div>
    </div>
    <?php 
        $follower_count = 0;
        foreach ($followers as $follower){
            if($follower_count % 2 == 0){
        ?>
    <div class="row" style="padding-bottom: 20px;">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">
                    <img src='<?php echo base_url() . "resources/uploads/".$follower->photo ?>' class="img-responsive" />
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12"><?php echo $follower->first_name. " ". $follower->last_name?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><?php $follower_count = count(json_decode($follower->relations)); echo $follower_count == 1? "{$follower_count} Follower": "{$follower_count} Followers"?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><?php echo $follower->about_me?></div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="dropdown friends-satus-dropdown">
                        <a id="friends_status" data-toggle="dropdown" href="#" >
                            <img src="<?php echo base_url()?>resources/images/friends_status.png" alt=""/>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="friends_status">
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>followers/accept_request/<?php echo $follower->user_id?>">Accept Request</a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>register/business_profile">Block</a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>register/business_profile">Report</a>
                            </li>
                        </ul>
                    </div>
               </div>
            </div>
        </div>
        <?php  }else{?>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">
                    <img src='<?php echo base_url() . "resources/uploads/".$follower->photo ?>' class="img-responsive" />
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12"><?php echo $follower->first_name. " ". $follower->last_name?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><?php $follower_count = count(json_decode($follower->relations)); echo $follower_count == 1? "{$follower_count} Follower": "{$follower_count} Followers"?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12"><?php echo $follower->about_me?></div>
                    </div>
                </div>
                <div class="col-md-2">
                     <div class="dropdown friends-satus-dropdown">
                        <a id="friends_status" data-toggle="dropdown" href="#" >
                            <img src="<?php echo base_url()?>resources/images/friends_status.png" alt=""/>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="friends_status">
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>register/business_profile">Unfollow</a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>register/business_profile">Block</a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>register/business_profile">Report</a>
                            </li>
                        </ul>
                    </div>
               </div>
            </div>
        </div>
    </div>
    <?php
        }
        $follower_count ++;     
       }?>
</div>
