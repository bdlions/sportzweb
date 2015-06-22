<div class="panel panel-default">
    <div class="panel-heading">Blog List</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <?php if($allow_configuration){ ?>
                                <th>Order</th>
                                <?php } ?>
                                <th>Title</th>
                                <th>Comments</th>
                                <?php if($allow_edit): ?>
                                    <th>Edit</th>
                                <?php endif; ?>
                                    
                                <?php if($allow_delete): ?>
                                    <th>Delete</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody id="tbody_blog_list_category">
                            <?php if(!empty($blog_list)): ?>
                                <?php $i=1;foreach($blog_list as $blog):?>
                                    <tr>
                                        <td><a href="<?php echo base_url().'admin/applications_blogs/blog_detail/'.$blog['id'] ?>"><?php echo $i++;?></td>
                                        <?php if($allow_configuration): ?>
                                            <td>
                                                <?php echo form_dropdown('order_list', array('0' => 'Order by date')+$order_list, $blog['order_no'],'id='.$blog['id'].' class=form-control'); ?>                                    
                                                <input type="hidden" id="<?php echo $blog['id'].'_created_on';?>" value="<?php echo $blog['created_on'];?>"/>
                                            </td>
                                        <?php endif; ?>
                                        <td><?php echo html_entity_decode(html_entity_decode($blog['title']));?></td>
                                        <td><a href="<?php echo base_url().'admin/applications_blogs/comment_list/'.$blog['id']; ?>">Comments</a></td>
                                        <?php if($allow_edit): ?>
                                            <td><a href="<?php echo base_url().'admin/applications_blogs/edit_blog/'.$blog['id']; ?>">Edit</a></td>
                                        <?php endif; ?>

                                        <?php if($allow_delete): ?>
                                            <td><a href="javascript:void(0)" onclick="delete_blog(<?php echo $blog['id']?>)">Delete</a></td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach;?>
                            <?php else: ?>
                                    <tr>
                                        <td style="border:none;"></td>
                                        <td style="border:none;"></td>
                                        <td style="font-size: 20px; border:none;text-align: center;">No result is found</td>
                                        <td style="border:none;"></td>
                                        <td style="border:none;"></td>
                                    </tr>  
                            <?php endif;?>
                            
                        </tbody>
                    </table>
                </div>
                <div class="btn-group" style="padding-left: 25px;">
                    <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
                </div>
                <?php if($allow_configuration){ ?>
                <div class="btn-group pull-right" style="padding-left: 25px;">
                    <input type="button" style="width:120px;" value="Save Order" id="button_save_order" class="form-control btn button-custom">
                </div>
                <?php } ?>
            </div>            
        </div>   
        
    </div>
</div>

<!-- Delete confirmation modal -->

<div class="modal fade" id="delete_Confirm_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title" id="myModalLabel">Confirm Message</h2>
      </div>
      <div class="modal-body">
        Do You want to proceed?
      </div>
      <div class="modal-footer">          
        <button type="button" id ="modal_button_confirm" class="btn btn-primary">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<script type="text/javascript">
    $(function() {
        $("#button_save_order").on("click", function() {
            var selected_value_list = Array();
            $("select", "#tbody_blog_list_category").each(function(){
                selected_value_list.push({
                    id: $(this).attr('id'),
                    order: $("select#"+$(this).attr('id')+" option:selected").val(),
                    created_on: $('#'+$(this).attr('id')+'_created_on').val()
                });
//                alert($('#'+$(this).attr('id')+'_created_on').val());
            });
//            $("select", "#tbody_blog_list_category").each(function(){ selected_value_list.push($("select#"+$(this).attr('id')+" option:selected").val()); });
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + 'admin/applications_blogs/update_blog',
                data: { 
                    selected_value_list : selected_value_list
                },
                success: function(data) {
                   // alert(data.message);
                    var message = data.message;
                   print_common_message(message);
                }
            });

        });
    });
</script>

<script>
    function delete_blog(blog_id)
    {
        $('#delete_Confirm_Modal').modal('show');
        $('#modal_button_confirm').on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url();?>admin/applications_blogs/remove_blog_by_admin',
                data: {
                    blog_id : blog_id
                },
                success: function(data) {
                   // alert(data.message);
                    var message = data.message;
                   print_common_message(message);
                    location.reload();
                }
            });
            $('#delete_Confirm_Modal').modal('hide');
        });
    }
</script>