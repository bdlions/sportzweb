<script type="text/javascript">
    $(function() {
        $("#search_inbox").typeahead([{
                name: "inbox_user",
                //local:[{"username":"Alamgir Kabir","first_name":"Alamgir","last_name":"Kabir","value":"alamgir", "user_id":"2"},{"username":"Nazmul Hasan","first_name":"Nazmul","last_name":"Hasan","value":"nazmul hasan", "user_id":"3"}],
                prefetch:{
                            url: '<?php echo base_url() ?>search/get_users/',
                            ttl: 0
                        },
                template: [
                    '<div class="col-md-3"><img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash3/c5.5.65.65/s56x56/65686_10201374763675922_1110161127_t.jpg"/></div>',
                    '<div class="col-md-9">{{first_name}} {{last_name}}</div>'
                ].join(''),
                engine: Hogan
            }]).on('typeahead:selected', function(obj, datum) {
            window.location = "<?php echo base_url() ?>member_profile/show/" + datum.user_id;
        });

        $("#button_pending_request").on("click", function() {
            window.location = '<?php echo base_url() ?>followers/pending_followers';
        });
        
        $("#buttonPost").on("click", function(){
            $.ajax({
                  type: 'POST',
                  url: '<?php echo base_url() ?>messages/send_message/',
                  data: $("#postMessage").serialize(),
                  dataType: 'json',
                  success: function(data) {console.log(data);
                      if(data == true){
                          window.location.reload();
                      }
                      else{
                          alert("error for following users.");
                      }
                  }
              });
            return false;
        });
                
        $("#new_message").on("click", function(){
            window.location = "<?php echo base_url()?>messages/new_message";
        });
    });
</script>
<div class="col-md-2">
    <h3>Inbox</h3>
    <?php foreach ($followers as $follower) { ?>
        <div class="row">
            <a href="<?php echo base_url() ?>messages/user/<?php echo $follower->user_id ?>">
                <div class="profile-background">
                    <img alt="<?php echo $follower->first_name[0] . $follower->last_name[0]?>" src="<?php echo base_url() ?>resources/uploads/<?php echo $follower->photo?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " /> 
                    <p style="visibility:hidden"><?php echo $follower->first_name[0].$follower->last_name[0] ?></p>
                </div>
                <div><?php echo $follower->first_name . " " . $follower->last_name ?></div>
            </a>
        </div>
    <?php } ?>
</div>
<div class="col-md-7" style="border-left: 1px solid #CCCCCC; border-right: 1px solid #CCCCCC">
    <div class="col-md-12">
        <div class="row" style="padding-bottom: 20px; padding-top: 10px;">
            <div class="col-md-5" style="padding-left: 0px;">
                <div class=" input-group search-box-followers">
                    <input id="search_inbox" class="form-control typeahead" type="text" placeholder="Search inbox" />
                    <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                </div>
            </div>
            <button class="btn button-custom pull-right" id="new_message">New Message</button>
        </div>
        <?php foreach ($messages as $message) { ?>
            <div class="row" style="padding-bottom: 10px; padding-top: 10px; border-bottom: 1px solid #CCCCCC">
                <div class="row col-md-12">
                    <?php $user = $message->from == $me->user_id ? $me : $follower; ?>
                    <div class="col-md-2 profile-background">
                        <img alt="<?php echo $user->first_name[0] . $user->last_name[0]?>" src="<?php echo base_url() ?>resources/uploads/<?php echo $user->photo?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='col-md-2 profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " /> 
                        <p style="visibility:hidden;"><?php echo $user->first_name[0].$user->last_name[0] ?></p>
                    </div>
                    <div class="col-md-9">
                        <?php echo $user->first_name . " " . $user->last_name . ": " . $message->message ?>
                    </div>
                </div>
                <div class="row col-md-12">
                    <div class="pull-right"><?php echo $message->received_date;?></div>
                </div>
            </div>
        <?php } ?>
        <div class="row" style="padding-bottom: 10px; padding-top: 10px;">
            <?php if(isset($to)){ echo form_open("", "id='postMessage'")?>
            <div class="col-md-2" style="padding-left: 0px;">
                <img src="<?php echo base_url() ?>resources/uploads/<?php echo $me->photo ?>" class="img-responsive"/>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <textarea rows="3" name="message" class="form-control"></textarea>
                </div>
                <div class="row" style="padding-top: 10px;">
                    <input type="hidden" value="<?php echo $to?>" name="to"/>
                    <button class="btn button-custom pull-right" id="buttonPost">Post</button>
                </div>
            </div>
            <?php echo form_close(); }?>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="col-md-12">
        <h4>Participants</h4>
        <div class="row">
            <div class="col-md-12">
                <input class="form-control" placeholder="Add name or email..."/>
            </div>
        </div>
        <?php foreach ($followers as $follower) { ?>
            <div class="row">
                <div class="col-md-12">
                    <img src="<?php echo base_url() . 'resources/images/' . ($follower->online_status == TRUE ? 'online.png' : 'offline.png') ?>" />
                    <?php echo $follower->first_name . " " . $follower->last_name ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>