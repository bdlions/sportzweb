<script type="text/javascript">
    $(function() {
        $("#button_update_product_category").on("click", function() {
            if ($("#input_title").val().length == 0)
            {
                alert("Please assign category name");
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_shop/update_size_men",
                data: {
                    title: $("#input_title").val(),
                    category_id: $("#input_id").val()
                },
                success: function(data) {
                    alert(data['message']);
                    $("#modal_product_category_update").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function open_modal_update(id) {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/applications_shop/get_size_info_men",
            data: {
                id: id
            },
            success: function(data) {
                $('#input_id').val(data.size_info['id']);
                $('#input_title').val(data.size_info['title']);
                $('#us_ca').val(data.size_info['us_ca']);
                $('#uk').val(data.size_info['uk']);
                $('#eu').val(data.size_info['eu']);
                $("#modal_product_category_update").modal('show');
            }
        });
    }
</script>
<div class="modal fade" id="modal_create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Create product size for MEN</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    
                    <input id="input_id" name="input_id" value="" type="hidden"/>
                    
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Size title:</label>
                        <div class ="col-sm-4">
                            <input id="input_title" name="input_title" value="" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">US - CA:</label>
                        <div class ="col-sm-4">
                            <input id="us_ca" name="us_ca" value="" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">UK:</label>
                        <div class ="col-sm-4">
                            <input id="uk" name="uk" value="" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">EU:</label>
                        <div class ="col-sm-4">
                            <input id="eu" name="eu" value="" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_create" name="button_create" value="" class="form-control btn button-custom pull-right">Create</button>
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