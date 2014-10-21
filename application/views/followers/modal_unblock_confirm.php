<script type="text/javascript">
    $(function() {
        $("#button_unblock_confirm").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "followers/unblock_follower",
                data: {
                    follower_id: $('#follower_id_confirm_unblock').val()
                },
                success: function(data) {
                    location.reload();
                }
            });
            $('#modal_unblock_confirm').modal('hide');
        });
    });
</script>
<div class="modal fade" id="modal_unblock_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body" style="max-height: 300px; ">
                <div class="row">
                    <div class="col-md-12">
                        Are you sure to unblock?
                    </div>                    
                </div>   
                <input type="hidden" id="follower_id_confirm_unblock" name="follower_id_confirm_unblock" value=""/>
            </div>
            <div class="modal-footer">
                <button id="button_unblock_confirm" name="button_unblock_confirm" value="" class="btn button-custom ">Yes</button>
                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
