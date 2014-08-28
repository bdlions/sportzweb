<script type="text/javascript">
    $(function() {
        $("#button_save_text").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/footer/update_about_us",
                data: {
                    region_id: $('#region_id').val(),
                    text: $('#input_text').val(),
                },
                success: function(data) {
                    window.location.reload();
                }
            });
            $('#modal_chnage_content').modal('hide');
        });
    });
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
                    <div class="col-md-12">
                        <div class="col-md-4">
                            <img src="<?php echo base_url() . "resources/uploads/profile_picture/100x100/4_1407803389.jpg" ?>" alt="" class="img-responsive profile-photo"  />
                        </div>
                        <div class="col-md-3">
                             Nazmul Hasan <br>
                             1 follower
                        </div>
                       
                    </div>
                    <div class="col-md-12">
                        <div class ="col-sm-8">
                            <input type="hidden" id="follwers_id" name="follwers_id" value=""/>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Report content shared by Nazmul Hasan
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class ="col-sm-8">
                            <div class="checkbox">
                            <label>
                                <input type="checkbox"> Report this account
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
                <button id="button_save_text" name="button_save_text" value="" class="btn button-custom ">Save</button>
                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
