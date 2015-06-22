<script type="text/javascript">
    $(function() {
        $("#button_update_product_category").on("click", function() {
            if ($("#input_product_category_update_title").val().length == 0)
            {
               // alert("Please assign category name");
               var message = "Please assign category name";
               print_common_message(message);
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_shop/update_product_category",
                data: {
                    title: $("#input_product_category_update_title").val(),
                    category_id: $("#input_product_category_id").val()
                },
                success: function(data) {
                  //  alert(data['message']);
                  var message = data['message'];
                    print_common_message(message);
                    $("#modal_product_category_update").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function open_modal_product_category_update(category_id) {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/applications_shop/get_product_category_info",
            data: {
                category_id: category_id
            },
            success: function(data) {
                $('#input_product_category_update_title').val(data.product_category_info['title']);
                $('#input_product_category_id').val(data.product_category_info['category_id']);
                $("#modal_product_category_update").modal('show');
            }
        });
    }
</script>
<div class="modal fade" id="modal_product_category_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update Product Category</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Category Name:</label>
                        <div class ="col-sm-4">
                            <input id="input_product_category_update_title" name="input_product_category_update_title" value="" type="text" class="form-control"/>
                            <input id="input_product_category_id" name="input_product_category_id" value="" type="hidden" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_update_product_category" name="button_update_product_category" value="" class="form-control btn button-custom pull-right">Update</button>
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