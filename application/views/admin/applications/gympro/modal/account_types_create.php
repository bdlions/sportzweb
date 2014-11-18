<script type="text/javascript">
    $(function() {
        $("#button_create").on("click", function() {
            if ($("#input_title").val().length == 0)
            {
                alert("Please assign Category name");
                return;
            }
            if ($("#input_pricing").val().length == 0)
            {
                alert("Please Enter Price");
                return;
            }
            if ($("#input_total_user").val().length == 0)
            {
                alert("Please Enter Total User");
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_gympro/create_account_types",
                data: {
                    title: $("#input_title").val(),
                    price: $("#input_pricing").val(),
                    total_user: $("#input_total_user").val()
                },
                success: function(data) {
                    alert(data['message']);
                    $("#modal_create").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function open_modal_create() {
        $("#modal_create").modal('show');
    }
</script>
<div class="modal fade" id="modal_create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Create Account Type</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class ="col-sm-2"></div>
                    <label class="col-sm-3 control-label">Account Type Title:</label>
                    <div class ="col-sm-4">
                        <input id="input_title" name="input_title" value="" type="text" class="form-control"/>
                    </div>
                </div>
                <div class="row form-group">
                    <div class ="col-sm-2"></div>
                    <label class="col-sm-3 control-label">Pricing:</label>
                    <div class ="col-sm-4">
                        <input id="input_pricing" name="input_pricing" value="" type="text" class="form-control"/>
                    </div>
                </div>
                <div class="row form-group">
                    <div class ="col-sm-2"></div>
                    <label class="col-sm-3 control-label">Total User:</label>
                    <div class ="col-sm-4">
                        <input id="input_total_user" name="input_total_user" value="" type="text" class="form-control"/>
                    </div>
                </div>

                <div class="row form-group">
                    <div class ="col-sm-6"></div>
                    <div class ="col-sm-3">
                        <button id="button_create" name="button_create" value="" class="form-control btn button-custom pull-right">Create</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->