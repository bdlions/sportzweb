<script type="text/javascript">
    $(function(){
        $("#search_followers_box").typeahead([{
                name:"show_followers",
                prefetch:{
                            url: '<?php echo base_url()?>search/get_followers/',
                            ttl: 0
                        },
                template: [
                    '<div class="row">'+
                        '<div class="col-md-3">'+
                            '<div>'+
                                '<img alt="{{signature}}" src="<?php echo base_url().PROFILE_PICTURE_DISPLAY_PATH?>{{photo}}" class="img-responsive profile-photo" onError="this.style.display = \'none\'; this.parentNode.className=\'profile-background\'; this.parentNode.getElementsByTagName(\'div\')[0].style.visibility=\'visible\'; "/>'+
                                '<div style="visibility:hidden;height:0px">{{signature}}</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-9">'+
                            '<div class="row col-md-12 profile-name">'+
                                '{{first_name}} {{last_name}}'+
                            '</div>'+
                        '</div>'+
                    '</div>'
                  ].join(''),
                engine: Hogan
        }]).on('typeahead:selected', function (obj, datum) {
                window.location = "<?php echo base_url()?>member_profile/show/" + datum.user_id;
            });
    });
    function open_report_modal(follower_id){
        $('#follower_id').val(follower_id);
        $('#<?php echo FOLLOWER_REPORT_TYPE_SHARED_CONTENT_ID?>').attr('checked', false);
        $('#<?php echo FOLLOWER_REPORT_TYPE_ACCOUNT_ID?>').attr('checked', false);
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "followers/get_follower_info",
            data: {
                follower_id: follower_id
            },
            success: function(data) {
                $("#div_follower_info").html(tmpl("tmpl_user_info", data.user_info)); 
                $('#span_shared_content').text('Report content shared by '+data.user_info.first_name+' '+data.user_info.last_name);
                $('#modal_report_content').modal('show');
            }
        });

    }
</script>
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
                <a href="<?php echo base_url().'followers/pending_followers'?>"><button class="btn button-custom" id="button_pending_request">Pending Requests</button></a>
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