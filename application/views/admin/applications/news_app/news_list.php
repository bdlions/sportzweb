<div class="panel panel-default">
    <div class="panel-heading">News List</div>
    <div class="panel-body">
        <div class="row col-md-12">
            
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Edit</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_blog_list_category">
                            <?php if(!empty($news_lists)): ?>
                                <?php $i=1;foreach($news_lists as $news):?>
                                    <tr>
                                        <td><?php echo html_entity_decode(html_entity_decode($news['headline']));?></td>
                                        <td><?php echo substr(html_entity_decode(html_entity_decode($news['summary'])),0,100)." ....."; ?></td>
                                        <td><a href="<?php echo base_url().'admin/applications_news/edit_news/'.$news['id']; ?>">Edit</a></td>
                                        <td><a href="<?php echo base_url().'admin/applications_news/news_details/'.$news['id']; ?>">View</a></td>
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



