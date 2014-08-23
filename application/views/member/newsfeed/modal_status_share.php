<script type="text/javascript">
    $(function() {
        $("#share_friends").typeahead([{
            name: "share_friends",
            prefetch: {
                url: '<?php echo base_url() ?>search/get_followers/',
                ttl: 0
            },
            template: [
                '<div class="row">'+
                    '<div class="col-md-5">'+
                        '<div>'+
                            '<img alt="{{signature}}" src="<?php echo base_url().PROFILE_PICTURE_DISPLAY_PATH?>{{photo}}" class="img-responsive profile-photo" onError="this.style.display = \'none\'; this.parentNode.className=\'profile-background\'; this.parentNode.getElementsByTagName(\'div\')[0].style.visibility=\'visible\'; "/>'+
                            '<div style="visibility:hidden;height:0px">{{signature}}</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-7">'+
                        '<div class="row col-md-12 profile-name">'+
                            '{{first_name}} {{last_name}}'+
                        '</div>'+
                    '</div>'+
                '</div>'
            ].join(''),
            engine: Hogan
            }]).on('typeahead:selected', function(obj, datum) {
                $("#share_friends").val("");
                $("#status_share_selected_friends").html($("#status_share_selected_friends").html()+'<span class="badge user-token"><input name="participant" type ="hidden" value="' + datum.user_id +'"/>'+ datum.first_name + ' '+ datum.last_name + '<span class="remove" onclick="removeSelectedUser(this)">&times;</span></span>');
                $("input[name=participant]").each(function(){
                    //window.location = "<?php echo base_url()?>" + "messages/new_message/" + $(this).val();
                }); 
        });
        $("#button_post_share").on("click", function(){
            var user_list = new Array();
            var counter = 0;
            $("input", "#status_share_selected_friends").each(function() {
                if ($(this).attr("type") === "hidden")
                {
                    user_list[counter++] = $(this).attr("value");
                }
            });
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>' + "share/share_status",
                dataType: 'json',
                data: {
                    status_category_id: '<?php echo STATUS_CATEGORY_USER_PROFILE?>', 
                    mapping_id: '<?php echo $user_id?>', 
                    description: $("#share_description").val(),
                    shared_type_id: '<?php echo STATUS_SHARE_OTHER_STATUS?>',
                    reference_id: $('#share_status_id').val(),
                    user_id_list:user_list
                },
                success: function(data) {
                    window.location.href = '<?php echo base_url().'member_profile/show/'.$user_id;?>';
                }
            });
        });
    });    
</script>
<div class="modal fade" id="modal_status_share" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Share This Status</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding-top:5px; padding-bottom: 5px;">
                    <div id="status-box-menu" class="status-box-menu">
                        <div class="div1">
                            <div id="status_share_selected_friends"></div>
                        </div>
                        <div class="div2"><input id="share_friends" style="border-color: transparent; box-shadow: none; background: none repeat scroll 0% 0% rgb(255, 255, 255);" class="form-control typeahead" type="text" placeholder="Tell specific people and groups" /></div>
                        <p style="">&nbsp;</p>
                    </div>
                </div>          
                <div class="row" style="padding-top:5px; padding-bottom: 5px; padding-left:15px; padding-right:15px;">
                    <?php echo form_textarea( array("name" => "share_description", "class" =>'form-control', "placeholder" => "Write something...",  "id" => "share_description", "rows" => "2")) ?>
                </div>
                <div class="row" style="padding-top:5px; padding-bottom: 5px;">
                    <div class="col-md-11"></div>
                    <div class="col-md-1">
                        <input id="share_status_id" type="hidden"/>
                        <button class="btn button-custom pull-right" id="button_post_share" name="button_post_share">Share</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->