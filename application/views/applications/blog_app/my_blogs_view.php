<?php $this->load->view("applications/blog_app/templates/header_menu"); ?>

<div class="col-md-9" style="background-color: #F5F5F5">
    <div class="top-bottom-padding">
        <h3 class="heading_medium_thin">My Blogs</h3>
        <table class="table table-bordered table-responsive table-condensed">
            <tbody style="background-color: white">
    <!--            <tr style="background-color: lightblue">
                    <th>No.</th>
                    <th>Blog Title</th>
                    <th>Status</th>
                    <th>Edit Blog</th>
                    <th>Delete Blog</th>
                </tr>-->

                <?php $i=1; foreach($blog_list as $blog): ?>
                <tr>    
                    <td><?php echo $i++;?></td>
                    <td><?php echo html_entity_decode(html_entity_decode($blog['title']));?></td>
                    <td><?php echo $blog['status_title'];?></td>
                    <td><a href="<?php echo base_url().'applications/blog_app/edit_blog/'.$blog['id']?>">Edit</td>
                    <?php if($blog['blog_status_id']!=DELETION_PENDING){?><td><a href="javascript:void(0)" onclick="dlt_blog(<?php echo $blog['id']?>)">Delete</a></td><?php } ?>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-3">
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
<script>
    function dlt_blog(blog_id)
    {
        $('#myModal').modal('show');
        $('#modal_button_confirm').on("click", function() {
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url();?>applications/blog_app/request_to_remove_blog',
                data: {
                    blog_id : blog_id
                },
                success: function(data) {
                    //alert(data.message);
                    var message = data.message;
                    print_common_message(message);
                    location.reload();

                }
            });
            $('#myModal').modal('hide');
        });
    }
</script>
<style>
    .table td {
        text-align: center;
    }
    .table th {
        text-align: center;
        font-size: larger;
    }
</style>