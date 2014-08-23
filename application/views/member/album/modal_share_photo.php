<script type="text/javascript">
    $(function() {
        $("#button_post_photo_share").on("click", function(){
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>' + "share/share_photo",
                dataType: 'json',
                data: {
                    status_category_id: '<?php echo STATUS_CATEGORY_USER_PROFILE?>', 
                    mapping_id: '<?php echo $current_user_id?>',
                    description: $("#share_description").val(),
                    shared_type_id: '<?php echo STATUS_SHARE_PHOTO?>',
                    reference_id: $('#share_photo_id').val()
                },
                success: function(data) {
                    window.location.href = '<?php echo base_url().'member_profile/show/'.$current_user_id;?>';
                }
            });
        });
    });    
</script>
<div class="modal fade" id="modal_photo_share" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Share This Photo</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="padding-top:5px; padding-bottom: 5px; padding-left:15px; padding-right:15px;">
                    <?php echo form_textarea( array("name" => "share_description", "class" =>'form-control', "placeholder" => "Write something...",  "id" => "share_description", "rows" => "2")) ?>
                </div>
                <div class="row" style="padding-top:5px; padding-bottom: 5px;">
                    <div class="col-md-11"></div>
                    <div class="col-md-1">
                        <input id="share_photo_id" type="hidden"/>
                        <button class="btn button-custom pull-right" id="button_post_photo_share" name="button_post_photo_share">Share</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">                
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->