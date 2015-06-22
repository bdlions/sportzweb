<script type="text/javascript">
    $(function() {
        $("#button_create_product_category").on("click", function() {
            if ($("#input_product_category_create_title").val().length == 0)
            {
                //alert("Please assign Category name");
                 var message = "Please assign Category name";
                print_common_message(message);
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_shop/create_product_category",
                data: {
                    title: $("#input_product_category_create_title").val()
                },
                success: function(data) {
                    //alert(data['message']);
                    var message = data['message'];
                    print_common_message(message);
                    $("#modal_product_category_create").modal('hide');
                    window.location.reload();
                }
            });
        });
    });
    function open_modal_product_category_create() {
        $("#modal_product_category_create").modal('show');
    }
</script>
<div class="modal fade" id="modal_product_category_create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Create Product Category</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Product Name:</label>
                        <div class ="col-sm-4">
                            <input id="input_product_category_create_title" name="input_product_category_create_title" value="" type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_create_product_category" name="button_create_product_category" value="" class="form-control btn button-custom pull-right">Create</button>
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