<script type="text/javascript">
    $(document).ready(function() {
        var question_data = <?php echo json_encode($question_list_array) ?>;
        set_question_list(question_data);
        
    });
</script>
<script type="text/javascript">
    $(function() {
        $("#question_list_order").on("click", function() {
            $('#modal_config_question_list').modal('show');
        });
    });
    
    function append_selected_question(question_info)
    {
        //console.log(question_info);
        var is_product_previously_selected = false;
        $("input", "#tbody_selected_question_list").each(function() {
                if ($(this).attr("id") === question_info['id'])
                {
                    is_product_previously_selected = true;
                }
        });
        if (is_product_previously_selected === true)
        {
            alert('The question is already selected.');
            return;
        }
        $("#tbody_selected_question_list").html($("#tbody_selected_question_list").html()+tmpl("tmpl_selected_question_info",  question_info)); 
    }
</script>
<!--Written By Omar for remove selected product -->
<script type="text/javascript">
    $(function () {
        $("#tbody_selected_question_list").on("click", "button", function(e) {
            //console.log(this.id);
            var target = e.target;
            //console.log(target);
            $(target).closest('tr').remove();
        });
    });
</script>

<div class="panel panel-default">
    <div class="panel-heading">Manage Homepage
    <div class="pull-right">
            <form action="">
                <select name="cars" onchange="panel_change()" id="panel_dd">
                    <option value="1">Show Question</option>
                    <option value="2">Show Advertise</option> 
                </select>
            </form>
        </div>
    </div>
    <div class="panel-body">
        <div id="question_panel">
        <div class="row">
            <div class ="col-sm-2" style="padding-left: 0px;">
                <button class="btn button-custom pull-right" id="question_list_order">
                   Set Your Question List
                </button>
            </div>.
            <div class ="col-sm-4">
                
            </div>
        </div>
        <div class="row" style="padding-top: 10px;">
            
        </div>
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th>Serial</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody id="tbody_selected_question_list">
                <?php //foreach ($homepage_question_list as $question):?>
<!--                    <tr>
                        <td id="<?php echo $question['id']; ?>"><input name="set_question_order" type="text" value=""/><input name="question_id" type="hidden" value="<?php echo $question['id']; ?>"/></td>
                        <td><textarea class="input-width-table" readonly id="question_<?php echo $question['id']; ?>" name="question" ><?php echo $question['question']; ?></textarea></td>
                        <td><textarea class="input-width-table" readonly id="answare_<?php echo $question['id']; ?>" name="answer" ><?php echo $question['answer']; ?></textarea></td>
                        <td id=""><button id="<?php echo $question['id']; ?>" class="glyphicon glyphicon-trash"></button></td>
                    </tr>-->
                <?php //endforeach;?>
            </tbody>
            
        </table>
        </div>
        <div class="row col-md-12">
            <div class ="col-sm-3">
                <input type="text" class="form-control" id="date_for_show_item" name="date_for_show_item" value=""/>
            </div>
            <div class="col-sm-2">
                <button id="question_list_for_home_page" value="" class="form-control btn button-custom">
                    Submit
                </button>
            </div>
            <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
        </div>
    </div>
</div>
<?php $this->load->view("admin/applications/bmi_calculator/modal_config_question_list"); ?>
<script type="text/javascript">
    $(function() {  
        $('#date_for_show_item').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#date_for_show_item').text($('#date_for_show_item').data('date'));
            $('#date_for_show_item').datepicker('hide');
        });
    });
</script>
<script type="text/javascript">
    
    var adv = <?php echo $show_advertise;?>;
    if(adv == 1){
        $('#question_panel').hide();
        $('select option[value="2"]').attr("selected",true);
    }
    $(function() {
        $("#question_list_for_home_page").on("click", function() {
            
            var advertise = $('#panel_dd').val();
            var show_advertise = 0;
            if(advertise == 2){ show_advertise = 1;}
            
            var selected_date_for_item = $('#date_for_show_item').val();
            if (selected_date_for_item.length == 0)
            {
                alert('please select a date first');
            }
            var global_check = true;
            var selected_question_array = Array();
            var selected_questions_order_array = Array();
            var selected_recipe_item = Array();
            $("#tbody_selected_question_list tr").each(function() {
                var firstColumn = $(this).find('td:first');
                
                var questionId = $(firstColumn).find('input[name=question_id]').val();
                var questionOrder = $(firstColumn).find('input[name=set_question_order]').val();
                
                if(questionOrder !== '') {
                    selected_questions_order_array.push(questionOrder);
                } else {
                    global_check = false;
                    alert('you did not give order of a question');
                    return false;
                }
                
                if(questionId !== '') {
                    selected_question_array.push(questionId);
                } else {
                    alert('your selected question have no id');
                    return false;
                }
                
            });
            
            if(global_check != false) {
               $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "admin/applications_bmicalculator/question_list_for_home_page",
                    data: {
                        selected_questions_list: JSON.stringify(selected_question_array),
                        selected_questions_order_list: JSON.stringify(selected_questions_order_array),
                        selected_date_for_item: selected_date_for_item,
                        show_advertise: show_advertise
                    },
                    success: function(data) {
                        alert(data['message']);
                        if (data['status'] === 1)
                        {
                            location.reload();
                        }
                    }
                }); 
            }
        });
    });
    
    function panel_change()
    {
       var id = $('#panel_dd').val();
       if(id == 2) $('#question_panel').hide();
       if(id == 1) $('#question_panel').show();
    }
    
    
</script> 
<script type="text/x-tmpl" id="tmpl_selected_question_info">
    {% var i=0, product_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(product_info){ %}
    <tr>
    <td id="<?php echo '{%= product_info.id%}'; ?>"><input name="set_question_order" type="text" value=""/><input name="question_id" type="hidden" value="<?php echo '{%= product_info.id%}'; ?>"/></td>
    <td><textarea class="input-width-table" readonly id="question_<?php echo '{%= product_info.id%}'; ?>" name="question" ><?php echo '{%= product_info.question%}'; ?></textarea></td>
    <td><textarea class="input-width-table" readonly id="answare_<?php echo '{%= product_info.id%}'; ?>" name="answer" ><?php echo '{%= product_info.answer%}'; ?></textarea></td>
    <td id=""><button id="<?php echo '{%= product_info.id%}'; ?>" class="glyphicon glyphicon-trash"></button></td>
    </tr>
    {% product_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>