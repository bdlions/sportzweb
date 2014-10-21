<script type="text/javascript">
    $(function() {
        $("#button_accept_confirm").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "followers/accept_follower",
                data: {
                    follower_id: $('#follower_id_confirm_accept').val()
                },
                success: function(data) {
                    location.reload();
                }
            });
            $('#modal_accept_confirm').modal('hide');
        });
    });
</script>
<div class="modal fade" id="modal_accept_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body" style="max-height: 300px; ">
                <div class="row">
                    <div class="col-md-12">
                        Are you sure to accept?
                    </div>                    
                </div>   
                <input type="hidden" id="follower_id_confirm_accept" name="follower_id_confirm_accept" value=""/>
            </div>
            <div class="modal-footer">
                <button id="button_accept_confirm" name="button_accept_confirm" value="" class="btn button-custom ">Yes</button>
                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
