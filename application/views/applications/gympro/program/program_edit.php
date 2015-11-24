<script type="text/javascript">
    var id_list = new Array();
    var id_counter = 0;
    var exercise_id = makeid(5);
    $(function() {
        $("#button_program_edit").on("click", function() {
            if($("#client_list").val() == 0)
            {
                //alert("Please select the person you are assessing from the drop menu.");
                var message = "Please select the person you are assessing from the dropdown menu.";
                 print_common_message(message);
                return false;
            }
            if($("#start_date").val() == 0)
            {
                var message = "Please select the mission start date.";
                print_common_message(message);
                return false;
            }
            $('#start_date').val(convert_date_from_user_to_db($('#start_date').val()));
            $('#review').val(convert_date_from_user_to_db($('#review').val()));
            $("#id_list").val(id_list);
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url().'applications/gympro/edit_program/'.$program_id; ?>',
                data: $("#form_edit_program").serializeArray(),
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
    function weight_value_set( qq, ww, ee, rr, tt, yy, uu )
    {
        $( "input[name='name_" + exercise_id + "']" ).val(qq);
//        $( "input[name='description_" + counter + "']" ).val(ww);
        $( "#description_" + exercise_id ).val(ww);
        $( "input[name='sets_" + exercise_id + "']" ).val(ee);
        $( "input[name='reps_" + exercise_id + "']" ).val(rr);
        $( "input[name='weights_" + exercise_id + "']" ).val(tt);
        $( "input[name='reps2_" + exercise_id + "']" ).val(yy);
        $( "input[name='tempo_" + exercise_id + "']" ).val(uu);
    }
    function cardio_value_set( qq, ww, ee, rr, tt, yy )
    {
        $( "input[name='name_" + exercise_id + "']" ).val(qq);
        $( "#description_" + exercise_id ).val(ww);
        $( "input[name='level_" + exercise_id + "']" ).val(ee);
        $( "input[name='speed_" + exercise_id + "']" ).val(rr);
        $( "input[name='time_" + exercise_id + "']" ).val(tt);
        $( "input[name='target_" + exercise_id + "']" ).val(yy);
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
                            <span style="font-weight: bold;">Exercie name: &nbsp;&nbsp;</span>
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
                                <div><textarea style="width: 100%; min-height: 50px;" name="description_<?php echo '{%= weight_num%}'; ?>" id="description_<?php echo '{%= weight_num%}'; ?>"></textarea></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Sets</div>
                                <div><input style="width: 100%" name="sets_<?php echo '{%= weight_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Reps</div>
                                <div><input style="width: 100%" name="reps_<?php echo '{%= weight_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Weights</div>
                                <div><input style="width: 100%" name="weights_<?php echo '{%= weight_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Rest</div>
                                <div><input style="width: 100%" name="reps2_<?php echo '{%= weight_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Tempo</div>
                                <div><input style="width: 100%" name="tempo_<?php echo '{%= weight_num%}'; ?>"></div>
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
            <div class="pad_white"  id="{%= cardio_num%}">
                <input type=hidden id="program_exercise_type_id_{%= cardio_num%}" value="<?php echo GYMPRO_CARDIO_EXERCISE_TYPE_ID; ?>">
                <div class="row">
                    <div class="col-md-12">
                    <div>
                         <input type=hidden class="form-control" name="cardio_is_present_<?php echo '{%= cardio_num%}'; ?>" value="1">
                        </div>
                        <div class="col-md-6" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Description</div>
                            <div><textarea style="width: 100%; min-height: 50px;" name="description_<?php echo '{%= cardio_num%}'; ?>" id="description_<?php echo '{%= cardio_num%}'; ?>"></textarea></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Level</div>
                            <div><input style="width: 100%" name="level_<?php echo '{%= cardio_num%}'; ?>"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Speed</div>
                            <div><input style="width: 100%" name="speed_<?php echo '{%= cardio_num%}'; ?>"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Time</div>
                            <div><input style="width: 100%" name="time_<?php echo '{%= cardio_num%}'; ?>"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Target H.R</div>
                            <div><input style="width: 100%" name="target_<?php echo '{%= cardio_num%}'; ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group"></div>
        </div>
    </div>
    
</script>



<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css"/>
<?php
$this->load->view("applications/gympro/program/modal_exercise_program");
?>
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
            <?php echo form_open("applications/gympro/edit_program/" . $program_id, array('id' => 'form_edit_program', 'class' => 'form-horizontal', 'onsubmit' => 'return false;')) ?>
            <div class="pad_title">
                EDIT PROGRAMME
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
                                <input type="text" class="form-control" name="focus" value="<?php echo $program['focus'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Start date: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="start_date" id="start_date" value="<?php echo convert_date_from_db_to_user($program['program_start_date']);?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Review: </label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="review" id="review" value="<?php echo convert_date_from_db_to_user($program['review']);?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description"><?php echo $program['description'];?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Warm Up: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="warm_up"><?php echo $program['warm_up'];?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cooldown: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="cool_down"><?php echo $program['cool_down'];?></textarea>
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
                <input type="submit" id="button_program_edit" name="button_program_edit" value="Save"> or <a href="<?php echo base_url() ?>applications/gympro/programs">Previous</a>
            </div>
            <?php echo form_close();?>
            
            <?php  ?>
            <?php foreach ($exercise_list as $exercise) { 
                if($exercise['type'] == "weight"){ ?>
                    <script> add_weight_exercise();</script>
                    <script> weight_value_set("<?php echo $exercise["name"]?>", "<?php echo $exercise["description"]?>", "<?php echo $exercise["sets"]?>", "<?php echo $exercise["reps"]?>", "<?php echo $exercise["weights"]?>", "<?php echo $exercise["reps2"]?>", "<?php echo $exercise["tempo"]?>") </script>
                <?php }
                elseif($exercise['type'] == "cardio"){ ?>
                    <script> add_cardio_exercise();</script>
                    <script> cardio_value_set("<?php echo $exercise["name"]?>", "<?php echo $exercise["description"]?>", "<?php echo $exercise["level"]?>", "<?php echo $exercise["speed"]?>", "<?php echo $exercise["time"]?>", "<?php echo $exercise["target"]?>") </script>
                <?php }?>
            <?php }?>
        </div>
    </div>

</div>
