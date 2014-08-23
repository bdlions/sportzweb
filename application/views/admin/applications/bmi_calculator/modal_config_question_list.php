<div class="modal fade" id="modal_config_question_list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Question List</h4>
            </div>
            <div class="modal-body" style="max-height: 300px; overflow-y: auto;">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Check box</th>
                                    <th>Question Title</th>
                                    <th>Question Details</th>
                                </tr>
                            </thead>
                            
                            <tbody id="tbody_question_list">
                                <?php $total_question = count($question_list); ?>
                            <?php foreach ($question_list as $key => $question) :?>
                                <tr>
                                    <td><input id="<?php echo $question['id'] ?>" name="checkbox[]" class="" type="checkbox" /></td>
                                    <td id="<?php echo $question['id'] ?>"><?php echo $question['question'] ?></td>
                                    <td id="<?php echo $question['id'] ?>"><?php echo $question['answer'] ?></td>
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
                <button id="button_save_question_list" name="button_save_question_list" value="" class="btn button-custom">Save</button>
               
                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    $(function() {
        $("#button_save_question_list").on("click", function() {
            var selected_array = Array();
            $("#tbody_question_list tr").each(function() {
                $("td:first input:checkbox", $(this)).each(function() {

                    if (this.checked == true)
                    {
                        selected_array.push(this.id);
                    }
                });
            });
            
            
            
            var q_list = get_question_list();
            for (var counter = 0; counter < q_list.length; counter++)
            {
                var question_info = q_list[counter];
                for (var i = 0; i < selected_array.length; i++) {
                    if (selected_array[i] === question_info['id'])
                    {
                        append_selected_question(question_info);
                    }
                }
            }
            $('div[class="clr dropdown open"]').removeClass('open');
            $('#modal_config_question_list').modal('hide');
        });

        
        // clear input of modal when modal close
        $('#modal_config_question_list').on('hidden.bs.modal', function (e) {
            $(this).find("input,textarea,select").val('').end()
              .find("input[type=checkbox], input[type=radio]")
                 .prop("checked", "")
                 .end();
          });
        
    });
</script>
