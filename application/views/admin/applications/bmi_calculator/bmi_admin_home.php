<div class="panel panel-default">
    <div class="panel-heading">All Questions</div>
    <div class="panel-body">
        
        <div class="row form-group col-md-12">
            <div class="col-sm-3">
                <a href="<?php echo base_url();?>admin/bmicalculator/add_question">
                    <button class="btn button-custom pull-right" value="" id="">Create Question</button>  
                </a>
            </div>
            <div class="col-sm-3">
<!--                <a href="javascript:void(0)">
                    <button class="btn button-custom pull-left">Import Questions</button>
                </a>-->
            </div>
            <div class="col-sm-3">
                <!--<button class="btn button-custom" value="" id="button_create_blog_category">another button</button>-->  
            </div>
            <?php if($allow_access): ?>
                <div class="col-sm-3">
                    <a href="<?php echo base_url();?>admin/bmicalculator/manage_homepage">
                        <button class="btn button-custom" value="" id="">Manage Home Page</button>  
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th>Serial</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            
            <tbody id="tbody_business_profiles">
                <?php $i=1;foreach ($questions_list as $question):?>
                <tr>
                    <td><?php echo $i++;?></td>
                    <td><?php echo $question['question'];?></td>
                    <td><?php echo $question['answer'];?></td>
                    <td>
                        <?php if($allow_access): ?>
                            <a href="<?php echo base_url();?>admin/bmicalculator/edit_question/<?php echo $question['id']?>">
                                Edit
                            </a>
                        <?php endif; ?>
                    </td>
                    <?php if($allow_access): ?><td onclick="delete_question(<?php echo $question['id']?>)">Delete</td><?php endif;?>
                </tr>
                <?php endforeach;?>
            </tbody>
            
        </table>
    </div>
</div>

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


<script type="text/javascript">
    function delete_question(id)
    {
        $.ajax({
            dataType : 'json',
            type : "POST",
            url : '<?php echo base_url()?>admin/bmicalculator/delete_question',
            data: {
              question_id : id   
            },
            success: function(data){
                if(data.status === 1) {
                    alert(data.message);
                    window.location = '<?php echo base_url();?>admin/bmicalculator';
                    location.reload(true);
                }
                else if(data.status == 0)
                {
                    alert(data.message);
                    $('#myModal').modal('show');
                    $('#modal_button_confirm').on('click',function(){
                        $.ajax({
                            dataType: 'json',
                            type: "POST",
                            url: '<?php echo base_url();?>admin/bmicalculator/confirmation_for_delete',
                            data: {
                                question_id: id
                            },
                            success: function(data){
                                alert(data.message);
                                
                                window.location = '<?php echo base_url();?>admin/bmicalculator';
                                location.reload(true);
                            }
                        });
                        $('#myModal').modal('hide');
                    });
                }
                
            }
        });
    }
</script>