<!-- Written by Omar -->
<script type="text/javascript">
    $(function() {
        $("#button_save_news_sub_category_edit").on("click", function() {
            if ($("#input_news_sub_category_name_for_edit").val().length == 0)
            {
               // alert("News sub category name is required.");
               var message = "News sub category name is required.";
               print_common_message(message);
                return;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_news/update_news_sub_category",
                data: {
                    news_sub_category_name: $("#input_news_sub_category_name_for_edit").val(),
                    news_category_id: $("#input_news_category_id").val(),
                    news_sub_category_id: $("#input_news_sub_category_id").val(),
                },
                success: function(data) {
                   // alert(data['message']);
                  var message = data['message'];
                  print_common_message(message);
                    if (data['status'] === 1)
                    {
                        $("#news_title_" + data['news_sub_category_info']['id']).text(data['news_sub_category_info']['title']);
                        $("#modal_edit_news_sub_category").modal('hide');
                    }
                }
            });
        });
    });
</script>
<!-- Written by Omar -->
<script type="text/javascript">
function openModal(val,id) {
    $.ajax({
        dataType: 'json',
        type: "POST",
        url: '<?php echo base_url(); ?>' + "admin/applications_news/get_news_sub_category_data",
        data: {
            news_sub_category_id: id
        },
        success: function(data) {
            $('#input_news_sub_category_id').val(data['id']);
            $('#input_news_category_id').val(data['news_category_id']);
            $('#input_news_sub_category_name_for_edit').val(data['title']);
            $('#modal_edit_news_sub_category').modal('show');
        }
    });
}
</script> 
<div class="modal fade" id="modal_edit_news_sub_category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit News Sub Category</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="row form-group">
                        <div class ="col-sm-2"></div>
                        <label class="col-sm-3 control-label">Sub Category Name:</label>
                        <div class ="col-sm-4">
                            <input id="input_news_sub_category_name_for_edit" name="input_news_sub_category_name_for_edit" value="" type="text" class="form-control"/>
                            <input id="input_news_category_id" name="input_news_category_id" value="<?php echo $news_category_id; ?>" type="hidden" class="form-control"/>
                            <input id="input_news_sub_category_id" name="input_news_sub_category_id" value="" type="hidden" class="form-control"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            <button id="button_save_news_sub_category_edit" name="button_save_news_sub_category_edit" value="" class="form-control btn button-custom pull-right">Update</button>
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
