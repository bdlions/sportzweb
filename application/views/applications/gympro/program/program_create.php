<?php
$this->load->view("applications/gympro/program/modal_exercise_program");
?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css"/>
<script type="text/javascript">
    var id_list = new Array();
    var id_counter = 0;
    var exercise_id = makeid(5);
    $(function() {
         $("#button_create_program").on("click", function() {
            if($("#client_list").val() == 0)
            {
              //  alert("Please select the person you are assessing from the drop menu.");
              var message = "Please select the person you are assessing from the dropdown menu.";
                 print_common_message(message);
                return false;
            }
            if($("#start_date").val() == 0)
            {
                var message = "Please select the start date.";
                print_common_message(message);
                return false;
            }
            $('#start_date').val(convert_date_from_user_to_db($('#start_date').val()));
            $('#review').val(convert_date_from_user_to_db($('#review').val()));
            $("#id_list").val(id_list);
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>applications/gympro/create_program',
                data: $("#form_create_program").serializeArray(),
                success: function(data) {
                    var message = data.message;
                    print_common_message(message);
                    window.location = '<?php echo base_url(); ?>applications/gympro/programs';
                }
            });
        });
        $('#start_date').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#start_date').text($('#start_date').data('date'));
            $('#start_date').datepicker('hide');
        });
        $('#review').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#review').text($('#review').data('date'));
            $('#review').datepicker('hide');
        });
        id_list[id_counter++] = exercise_id;
        $("#exercise_box").append(tmpl("tmpl_weight_exercise",exercise_id));
        
            
    });
    
    function add_weight_exercise()
    {
        exercise_id = makeid(5);
        id_list[id_counter++] = exercise_id;
        $("#exercise_box").append(tmpl("tmpl_weight_exercise",exercise_id));
    }
    function add_cardio_exercise()
    {
        exercise_id = makeid(5);
        id_list[id_counter++] = exercise_id;
        $("#exercise_box").append(tmpl("tmpl_cardio_exercise",exercise_id));
    }
    function makeid(length)
    {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for( var i=0; i < length; i++ )
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }

</script>
<script type="text/x-tmpl" id="tmpl_weight_exercise">
    {% var weight=0, weight_num = ((o instanceof Array) ? o[weight++] : o); %}
    <div id="">
            <div class="deletable_box">
                <div class="pad_white">
                    <div class="row">
                        <div class="col-md-12">
                            <span style="font-weight: bold;">Exercise name: &nbsp;&nbsp;</span>
                            <input style="width: 40%; min-width: 150px;" name="name_<?php echo '{%= weight_num%}'; ?>">
                            <img onclick="open_modal_browse_exercise('<?php echo '{%= weight_num%}'; ?>')" src="<?php echo base_url(); ?>resources/images/browse.png" style="margin: 4px">
                            <img class="pull-right" onclick="$(this).closest('.deletable_box').remove()" src="<?php echo base_url(); ?>resources/images/cross.png" style="margin: 4px">
                        </div>
                    </div>
                </div>
                <div class="pad_white" id="{%= weight_num%}">
                    <input type=hidden id="program_exercise_type_id_{%= weight_num%}" value="<?php echo GYMPRO_WEIGHT_EXERCISE_TYPE_ID; ?>">
                    <div class="row">
                        <div class="col-md-12">
                             <div>
                             <input type=hidden class="form-control" name="weight_is_present_<?php echo '{%= weight_num%}'; ?>" value="1">
                            </div>
                            <div class="col-md-6" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Description</div>
                                <div><textarea style="width: 100%; min-height: 50px;" name="description_<?php echo '{%= weight_num%}'; ?>"></textarea></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Sets</div>
                                <div><input type="text" style="width: 100%" name="sets_<?php echo '{%= weight_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Reps</div>
                                <div><input type="text" style="width: 100%" name="reps_<?php echo '{%= weight_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Weights</div>
                                <div><input type="text" style="width: 100%" name="weights_<?php echo '{%= weight_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Rest</div>
                                <div><input type="text" style="width: 100%" name="reps2_<?php echo '{%= weight_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Tempo</div>
                                <div><input type="text" style="width: 100%" name="tempo_<?php echo '{%= weight_num%}'; ?>"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group"></div>
            </div>
        </div>
    
</script>
<script type="text/x-tmpl" id="tmpl_cardio_exercise" >
    {% var i=0, cardio_num = ((o instanceof Array) ? o[i++] : o); %}
    <div id="">
            <div class="deletable_box">
                <div class="pad_white">
                    <div class="row">
                        <div class="col-md-12">
                            <span style="font-weight: bold;">Exercie name: &nbsp;&nbsp;</span>
                            <input style="width: 40%; min-width: 150px;" name="name_<?php echo '{%= cardio_num%}'; ?>">
                            <img onclick="open_modal_browse_exercise('<?php echo '{%= cardio_num%}'; ?>')" src="<?php echo base_url(); ?>resources/images/browse.png" style="margin: 4px">
                            <img class="pull-right" onclick="$(this).closest('.deletable_box').remove()" src="<?php echo base_url(); ?>resources/images/cross.png" style="margin: 4px">
                        </div>
                    </div>
                </div>
                <div class="pad_white" id="{%= cardio_num%}">
                    <input type=hidden id="program_exercise_type_id_{%= cardio_num%}" value="<?php echo GYMPRO_CARDIO_EXERCISE_TYPE_ID; ?>">
                    <div class="row">
                        <div class="col-md-12">
                        <div>
                             <input type=hidden class="form-control" name="cardio_is_present_<?php echo '{%= cardio_num%}'; ?>" value="1">
                            </div>
                            <div class="col-md-6" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Description</div>
                                <div><textarea style="width: 100%; min-height: 50px;" name="description_<?php echo '{%= cardio_num%}'; ?>"></textarea></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Level</div>
                                <div><input type="text" style="width: 100%" name="level_<?php echo '{%= cardio_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Speed</div>
                                <div><input type="text" style="width: 100%" name="speed_<?php echo '{%= cardio_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Time</div>
                                <div><input type="text" style="width: 100%" name="time_<?php echo '{%= cardio_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Target H.R</div>
                                <div><input type="text" style="width: 100%" name="target_<?php echo '{%= cardio_num%}'; ?>"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group"></div>
            </div>
    </div>
    
</script>
<div class="container-fluid">
    <div class="row top_margin">
        <?php 
        if($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT)
        {
            $this->load->view("applications/gympro/template/sections/client_left_pane"); 
        }
        else
        {
            $this->load->view("applications/gympro/template/sections/pt_left_pane"); 
        }            
        ?>
        <div class="col-md-10">
            <?php echo form_open("applications/gympro/create_program", array('id' => 'form_create_program', 'class' => 'form-horizontal', 'onsubmit' => 'return false;')) ?>
            <div class="pad_title">
                CREATE PROGRAMME
                <div class="col-md-3 pull-right">
                    <?php $this->load->view("applications/gympro/template/user_category_dropdown"); ?>
                </div>
            </div>
            <div style="border-top: 2px solid lightgray; margin-left: 20px"></div>
            <div class="pad_body">
                <div>
                    <input type=hidden class="form-control" name="id_list" id="id_list">
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Programme Title: </label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="focus" id="focus">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Start date: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="start_date" id="start_date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Review: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="review" id="review">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Warm Up: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="warm_up"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cooldown: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="cool_down"></textarea>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <!--EXERCISE BOXES ARE ADDED HERE-->
                <div id="exercise_box">
                </div>
                
                <div style="width: 100%; display: inline-block;">
                    <div style="font-size: 16px; line-height: 33px; float: right">
                        Add another: <a class="cursor_pointer" onclick="add_weight_exercise()">Weight exercise</a>&nbsp; or &nbsp;<a class="cursor_pointer" onclick="add_cardio_exercise()">Cardio Exercise</a>
                    </div>
                </div>
            </div>
            <div class="pad_footer">
                <input type="submit" id="button_create_program" name="button_create_program" value="Save"> or <a href="<?php echo base_url() ?>applications/gympro/programs">Previous</a>
            </div>
            <?php echo form_close();?>
        </div>
    </div>

    <div class="pad_white">
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
    </div>
    
</div>
