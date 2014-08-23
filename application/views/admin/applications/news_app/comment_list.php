<script type="text/javascript">
    function delete_news_comment(id) {
        //alert(id);
            $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/applications_news/remove_comment",
            data: {
                comment_id: id
            },
            success: function(data) {
                alert(data['message']);
                    if (data['status'] === 1)
                    {
                       window.location = '<?php echo base_url();?>admin/applications_news/all_comments/<?php echo $news_id;?>';
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
                                <th>Delete</th>
                                
                            </tr>
                        </thead>
                        <tbody id="tbody_recipes_category_list">
                            <?php $counter=1;?>
                            <?php if(count($comment_list)>0) :?>
                                <?php foreach($comment_list as $comment):?>
                                    <tr>
                                        <td><a href="<?php echo base_url().'admin/applications_news/comment_details/'.$comment['id']?>"><?php echo $counter++;?></a></td>
                                        <td><?php echo $comment['comment'];?></td>
                                        <td><?php echo $comment['username'];?></td>
                                        <td><a href="javascript:void(o)" onclick="delete_news_comment('<?php echo $comment['id'];?>')" id="">Delete</a></td>
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