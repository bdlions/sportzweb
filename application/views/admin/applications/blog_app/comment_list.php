<script type="text/javascript">
    function delete_blog_comment(id) {
       // alert(id);
         var message = id;
         print_common_message(message);
            $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/applications_blogs/remove_comment",
            data: {
                comment_id: id
            },
            success: function(data) {
               // alert(data['message']);
                 var message = data.message;
                 print_common_message(message);
                    if (data['status'] === 1)
                    {
                       window.location = '<?php echo base_url();?>admin/applications_blogs/comment_list/<?php echo $blog_id;?>';
                    }
            }
        });
    }
</script>
<div class="panel panel-default">
    <div class="panel-heading">Comment List</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Comment</th>
                                <th>User</th>
                                <th>Counted Like</th>
                                <?php if($allow_access){ ?>
                                <th>Delete</th>
                                <?php } ?>
                                
                            </tr>
                        </thead>
                        <tbody id="tbody_recipes_category_list">
                            <?php $counter=1;?>
                            <?php if(count($comment_list)>0) :?>
                                <?php foreach($comment_list as $comment):?>
                                    <tr>
                                        <td><?php echo $counter++;?></td>
                                        <td><?php echo $comment['comment'];?></td>
                                        <td><?php echo $comment['username'];?></td>
                                        <td><?php echo $comment['user_liked_list'];?></td>
                                        <?php if($allow_access){ ?>
                                        <td><a href="javascript:void(o)" onclick="delete_blog_comment('<?php echo $comment['id'];?>')" id="">Delete</a></td>
                                        <?php } ?>
                                    </tr>
                                <?php endforeach;?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
        <div class="btn-group" style="padding-left: 10px;">
            <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
        </div>
    </div>
    
</div>

