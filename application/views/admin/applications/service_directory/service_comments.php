<script type="text/javascript">
    function delete_service_comment(id) {
        
            $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/applications_servicedirectory/remove_comment",
            data: {
                comment_id: id
            },
            success: function(data) {
                alert(data['message']);
                    if (data['status'] === 1)
                    {
                       window.location = '<?php echo base_url();?>admin/applications_servicedirectory/service_comments/<?php echo $service_id;?>';
                    }
            }
        });
    }
</script>
<div class="panel panel-default">
    <div class="panel-heading">Comments</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Comment</th>
                                <th>Rating</th>
                                <th>Date</th>
                                <th>Liked list</th> 
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_recipe_list">
                            <?php if(count($service_comments) > 0): ?>
                                <?php foreach($service_comments as $comment): ?>
                                    <tr>
                                        <td><?php echo $comment['username'];?></td>
                                        <td><?php echo $comment['comment'];?></td>
                                        <td><?php echo $comment['created_on'];?></td>
                                        <td><?php echo $comment['rate_id'];?></td>
                                        <td><?php echo $comment['liked_user_list'];?></td>
                                        <td><a href="javascript:void(o)" onclick="delete_service_comment('<?php echo $comment['id'];?>')" id="">Delete</a></td>
                                    </tr>
                                <?php endforeach;?>
                            <?php else: ?>
                                    <tr>
                                        <td style="border: none!important;text-align: center;">No comments found for this service</td>
                                    </tr>  
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
