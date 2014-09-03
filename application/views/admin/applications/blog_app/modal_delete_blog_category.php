<!-- Written by Omar -->
<script type="text/javascript">
    $(function() {
        $("#button_delete_blog_category").on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_blogs/delete_blog_category",
                data: {
                    blog_category_name: $("#input_blog_category_name_for_edit").val(),
                    blog_category_id: $("#input_blog_category_id").val()
                },
                success: function(data) {
                    alert(data['message']);
                    if (data['status'] === 1)
                    {
                        $("#modal_delete_blog_category").modal('hide');
                        window.location.reload();
                    }
                }
            });
        });
    });
</script>
<!-- Written by Omar -->
<script type="text/javascript">
function openDeleteModal(val,id) {
    
    $.ajax({
        dataType: 'json',
        type: "POST",
        url: '<?php echo base_url(); ?>' + "admin/applications_blogs/get_blog_data",
        data: {
            blog_category_id: id
        },
        success: function(data) {
            $('#input_blog_category_id').val(data['id']);
            $('#modal_delete_blog_category').modal('show');
        }
    });
}
</script> 
<div class="modal fade" id="modal_delete_blog_category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Blog Category</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <h3>Are you sure about deleting this blog category?</h3> 
                    <br><span style="padding-left: 10px;">If you delete this category then all the blog under this category will be deleted.</span>
                    <input id="input_blog_category_id" name="input_blog_category_id" value="" type="hidden" class="form-control"/>
                    <div class="row form-group">
                        <div class ="col-sm-6"></div>
                        <div class ="col-sm-3">
                            
                        </div>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button style="padding-right: 10px;" id="button_delete_blog_category" name="button_delete_blog_category" value="" class=" btn button-custom">
                    Yes
                </button>
                <button type="button" class="btn button-custom" data-dismiss="modal">No</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
