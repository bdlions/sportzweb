<script type="text/javascript">
    $(function() {
        $("#button_send_report").on("click", function() {
            var reported_id_list = Array();
            var counter = 0;
            if($('#<?php echo FOLLOWER_REPORT_TYPE_SHARED_CONTENT_ID?>').prop('checked'))
            {
                reported_id_list[counter++] = <?php echo FOLLOWER_REPORT_TYPE_SHARED_CONTENT_ID?>;
            }
            if($('#<?php echo FOLLOWER_REPORT_TYPE_ACCOUNT_ID?>').prop('checked'))
            {
                reported_id_list[counter++] = <?php echo FOLLOWER_REPORT_TYPE_ACCOUNT_ID?>;
            }
            //console.log($('#<?php echo FOLLOWER_REPORT_TYPE_SHARED_CONTENT_ID?>').prop('checked') == true);
            //console.log($('#<?php echo FOLLOWER_REPORT_TYPE_ACCOUNT_ID?>').prop('checked') == true);
            //console.log(reported_id_list);
            if(reported_id_list.length == 0)
            {
                //alert('Please select at least one option to report a user.');
                var message = "Please select at least one option to report a user.";
                print_common_message(message);
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "followers/store_report",
                data: {
                    follower_id: $('#follower_id').val(),
                    reported_id_list:reported_id_list
                },
                success: function(data) {
                    
                }
            });
            $('#modal_report_content').modal('hide');
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
<div class="modal fade" id="modal_report_content" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Report </h4>
            </div>
            <div class="modal-body" style="max-height: 300px; ">
                <div class="row">
                    <!-- <div class="col-md-12">
                        <div class="col-md-4">
                            <img src="<?php echo base_url() . "resources/uploads/profile_picture/100x100/4_1407803389.jpg" ?>" alt="" class="img-responsive profile-photo"  />
                        </div>
                        <div class="col-md-3">
                             Nazmul Hasan <br>
                             1 follower
                        </div>
                       
                    </div> -->
                    <div class="col-md-12" id="div_follower_info">
                        
                    </div>
                    <input type="hidden" id="follower_id" name="follower_id" value=""/>
                    <div class="col-md-12">
                        <div class ="col-sm-8">
                            <input type="hidden" id="follwers_id" name="follwers_id" value=""/>
                            <div class="checkbox">
                                <label>
                                    <input id="<?php echo FOLLOWER_REPORT_TYPE_SHARED_CONTENT_ID?>" name="<?php echo FOLLOWER_REPORT_TYPE_SHARED_CONTENT_ID?>" type="checkbox"> <span id="span_shared_content"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class ="col-sm-8">
                            <div class="checkbox">
                            <label>
                                <input id="<?php echo FOLLOWER_REPORT_TYPE_ACCOUNT_ID?>" name="<?php echo FOLLOWER_REPORT_TYPE_ACCOUNT_ID?>" type="checkbox"> Report this account
                            </label>
                        </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-3 pull-right">

                        </div>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button id="button_send_report" name="button_send_report" value="" class="btn button-custom ">Save</button>
                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
