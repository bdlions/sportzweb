<script type="text/javascript">
    $(function() {
        $("#button_update").on("click", function() {
            if ($("#upd_title").val().length == 0)
            {
                alert("Please assign category name");
                return;
            }
            if ($("#upd_us_ca").val().length == 0)
            {
                alert("Please assign US - CA");
                return;
            }
            if ($("#upd_uk").val().length == 0)
            {
                alert("Please assign UK");
                return;
            }
            if ($("#upd_eu").val().length == 0)
            {
                alert("Please assign EU");
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_shop/update_size_tinytoms",
                data: {
                    id: $("#upd_id").val(),
                    title: $("#upd_title").val(),
                    us_ca: $("#upd_us_ca").val(),
                    uk: $("#upd_uk").val(),
                    eu: $("#upd_eu").val()
                },
                success: function(data) {
                    alert(data['message']);
                    $("#modal_update").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function open_modal_update(id) {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/applications_shop/get_size_info_tinytoms",
            data: {
                id: id
            },
            success: function(data) {
                $('#upd_id').val(data.size_info['id']);
                $('#upd_title').val(data.size_info['title']);
                $('#upd_us_ca').val(data.size_info['us_ca']);
                $('#upd_uk').val(data.size_info['uk']);
                $('#upd_eu').val(data.size_info['eu']);
                $("#modal_update").modal('show');
            }
        });
    }
</script>
<div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update product size for TINY TOMS</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    
                    <input id="upd_id" name="upd_id" value="" type="hidden"/>
                    
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Size title:</label>
                        <div class ="col-sm-4">
                            <input id="upd_title" name="upd_title" value="" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">US - CA:</label>
                        <div class ="col-sm-4">
                            <input id="upd_us_ca" name="upd_us_ca" value="" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">UK:</label>
                        <div class ="col-sm-4">
                            <input id="upd_uk" name="upd_uk" value="" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">EU:</label>
                        <div class ="col-sm-4">
                            <input id="upd_eu" name="upd_eu" value="" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_update" name="button_update" value="" class="form-control btn button-custom pull-right">Update</button>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->