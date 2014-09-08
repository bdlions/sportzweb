<style>
    .table td {
        text-align: center;
    }
    .table th {
        text-align: center;
        font-size: larger;
    }
</style>

<div class="panel panel-default">
    <div class="panel-heading">
        Blog Pending List
        <div class="pull-right">
            <select id="blog_status_list">
                <option value="1">All</option>
                <option value="2">Pending</option>
                <option value="3">Re approval</option>
                <option value="4">Deletion Pending</option>
            </select>
        </div>
    </div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row form-group">
                <div class ="col-sm-12"></div>
            </div>
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Title</th>
                                <th>View Blog</th>
                                <th>Edit Blog</th>
                                <th>Status</th>
                                <th>Confirmation</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_blog_aprrove_list">
                            <?php $i=1;foreach($pending_list as $blog):?>
                            <tr>
                                <td><?php echo $blog['username'];?></td>
                                <td><a href="<?php echo base_url().'admin/applications_blogs/blog_detail/'.$blog['id'] ?>"><?php echo html_entity_decode(html_entity_decode($blog['title']));?></a></td>
                                <td><a href="<?php echo base_url().'admin/applications_blogs/blog_detail/'.$blog['id'] ?>">View</a></td>
                                <td><a href="<?php echo base_url().'admin/applications_blogs/edit_blog/'.$blog['id'] ?>">Edit</a></td>
                                <td><?php echo $blog['blog_status_title']?></td>
                                <td onclick="delete_pending(<?php echo $blog['id']?>)" >Confirm</td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <div class="btn-group" style="padding-left: 25px;">
                    <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
                </div>
            </div>            
        </div>        
    </div>
</div>

<script>
    
    function delete_pending(blog_id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url();?>admin/applications_blogs/blog_confirmation',
            data: {
                blog_id : blog_id
            },
            success: function(data){
                
                if(data.status === 1) {
                    alert(data.message);
                    window.location = '<?php echo base_url();?>admin/applications_blogs/approve_blog';
                    location.reload(true);
                }
                else if(data.status==0)
                {
                    //alert(data.message);
                    $("#deletion_msg").text(data.message);
                    $('#myModal').modal('show');
                    $('#modal_button_confirm').on('click',function(){
                        $.ajax({
                            dataType: 'json',
                            type: "POST",
                            url: '<?php echo base_url();?>admin/applications_blogs/blog_confirmation_for_delete',
                            data: {
                                blog_id: blog_id
                            },
                            success: function(data){
                                alert(data.message);
                                
                                window.location = '<?php echo base_url();?>admin/applications_blogs/approve_blog';
                                location.reload(true);
                            }
                        });
                        $('#myModal').modal('hide');
                    });
                   
                }
            }
        });
    }
    
    $(function (){
        $('#blog_status_list').on('change',function(){
            var id = $('#blog_status_list').val();
            
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url();?>admin/applications_blogs/get_blog_by_status_id',
                data: {
                  status_id: id  
                },
                success: function(data){
                    //alert(data.message);
                    $('#tbody_blog_aprrove_list').html('');
                    $("#tbody_blog_aprrove_list").html($("#tbody_blog_aprrove_list").html()+tmpl("tmpl_blog_aprrove_list",  data['blog_list']));
                }
            });
        });
    });
    
    
</script>

<script type="text/x-tmpl" id="tmpl_blog_aprrove_list">
    {% var i=0, blog_list = ((o instanceof Array) ? o[i++] : o); %}
    {% while(blog_list){ %}
        <tr>
            <td>{%= blog_list.username %}</td>
           <td><a href="<?php echo base_url().'admin/applications_blogs/blog_detail/{%= blog_list.id %}' ?>">{%=blog_list.title%}</a></td>
            <td><a href="<?php echo base_url().'admin/applications_blogs/blog_detail/{%= blog_list.id %}' ?>">View</a></td>
            <td><a href="<?php echo base_url().'admin/applications_blogs/edit_blog/{%= blog_list.id %}' ?>">Edit</a></td>
            <td>{%= blog_list.blog_status_title %}</td>
            <td onclick="delete_pending({%=blog_list.id%})" >Confirm</td>
        </tr>
    {% blog_list = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>

<!--<div class="modal fade" id="change_delete_request_blog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Blog List</h4>
            </div>
            <div class="modal-body" style="max-height: 300px; overflow-y: auto;">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Check box</th>
                                    <th>Blog Category</th>
                                    <th>Blog Title</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            
                            <tbody id="tbody_blog_list">
                            <?php foreach ($blog_list as $key => $blog) :?>
                                <tr>
                                    <td><input id="<?php echo $blog['id'] ?>" name="checkbox[]" class="" type="checkbox" /></td>
                                    <td id="<?php echo $blog['id'] ?>"><?php echo html_entity_decode(html_entity_decode($blog['blog_category_name'])) ?></td>
                                    <td id="<?php echo $blog['id'] ?>"><?php echo html_entity_decode(html_entity_decode($blog['title'])) ?></td>
                                    <td id="<?php echo $blog['id'] ?>"><?php echo html_entity_decode(html_entity_decode($blog['description'])); ?></td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row form-group">
                        
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button id="button_save_blog" name="button_save_blog" value="" class="btn button-custom">Save</button>
               
                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div> /.modal-content 
    </div> /.modal-dialog 
</div> /.modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 400px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 class="modal-title" id="myModalLabel">Confirm Message</h2>
      </div>
      <div class="modal-body">
          <div id="deletion_msg">
              
          </div>
       Do You want to delete it right now?
      </div>
      <div class="modal-footer">          
        <button type="button" id ="modal_button_confirm" class="btn btn-primary">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
      </div>
    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>