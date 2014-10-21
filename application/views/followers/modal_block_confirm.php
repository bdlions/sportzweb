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
<div class="modal fade" id="modal_block_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body" style="max-height: 300px; ">
                <div class="row">
                    <div class="col-md-12">
                        Are you sure to block?
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
