<script type="text/x-tmpl" id="tmpl_liked_user_list">
    {% var i=0, user_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(user_info){ %}
    <div class="row" style="padding-top: 10px; padding-bottom:10px;">
        <div class="col-md-3">
            <img src="<?php echo base_url() ?>resources/uploads/{%= user_info.photo%}" class="img-responsive modal_liked_user_list_image"/>
        </div>
        <div class="col-md-6">
            <div class="row"><a href='<?php echo base_url(). "member_profile/show/{%= user_info.id%}"?>' class="profile-name" >{%= user_info.first_name%} {%= user_info.last_name%}</a></div>
            <div class="row">{%= user_info.occupation%}</div>
        </div>
        <div class="col-md-3">
            {% if(user_info.is_follower == '<?php echo STATUS_LIKE_FOLLOWER?>'){ %}
                <a href="<?php echo base_url().'followers/user_unfollow/{%= user_info.id%}'?>"><button class="btn button-custom pull-right">Unfollow</button></a>
            {% }else if(user_info.is_follower == '<?php echo STATUS_LIKE_NON_FOLLOWER?>'){ %}
                <a href="<?php echo base_url().'followers/user_follow/{%= user_info.id%}'?>"><button class="btn button-custom pull-right">Follow</button></a>
            {% } %}
        </div>
    </div>    
    {% user_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<div class="modal fade" id="modal_liked_user_list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">People Who Like This Message</h4>
            </div>
            <div class="modal-body">
                <div class="row" id="liked_user_list">
                                                           
                </div>
            </div>
            <div class="modal-footer">                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->