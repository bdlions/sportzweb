<script type="text/javascript">
    $(function() {
        $("#button_block_confirm").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "followers/block_follower",
                data: {
                    follower_id: $('#follower_id_confirm_block').val()
                },
                success: function(data) {
                    location.reload();
                }
            });
            $('#modal_block_confirm').modal('hide');
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_user_info">
    {% var i=0, user_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(user_info){ %}
        <div class="col-md-4">
            <a href='<?php echo base_url() . "member_profile/show/".'{%= user_info.user_id%}' ?>' class="profile-name"> 
                <div>
                    <img alt="{%= user_info.first_name%} {%= user_info.last_name%}" src="<?php echo base_url() . PROFILE_PICTURE_DISPLAY_PATH.'{%= user_info.photo%}' ?>" class="img-responsive profile-photo" onError="this.style.display = 'none'; this.parentNode.className='profile-background'; this.parentNode.getElementsByTagName('p')[0].style.visibility='visible'; " /> 
                    <p style="visibility:hidden">{%= user_info.first_name[0]%} {%= user_info.last_name[0]%}</p>
                </div>
            </a>
        </div>
        <div class="col-md-3">
             {%= user_info.first_name%} {%= user_info.last_name%}
        </div>
    {% user_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<div class="modal fade" id="modal_block_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body" style="max-height: 300px; ">
                <div class="row">
                    <div class="col-md-12" id="div_block_confirm_follower_info">                        
                    </div>
                    <div class="col-md-12" style="padding-left: 30px;padding-top:20px;">
                        <span id="span_block_confirm_message"></span>
                    </div>                    
                </div> 
                <input type="hidden" id="follower_id_confirm_block" name="follower_id_confirm_block" value=""/>
            </div>
            <div class="modal-footer">
                <button id="button_block_confirm" name="button_block_confirm" value="" class="btn button-custom ">Yes</button>
                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
