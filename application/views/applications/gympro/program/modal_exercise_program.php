<script type="text/javascript">
    function subcategry_select()
    {
        if ($("#exercise_category_list").val()==0)
        {
            $("#subcategory_view").html("");
            return;
        } 
        var selected_category_id = $("#exercise_category_list").val();
        var selected_category_array = selected_category_id.split("_");
        var exercise_id = $("#hf_numb").val();
        var program_exercise_type_id = $("#program_exercise_type_id_"+exercise_id).val();
        //coming from cardio and now selecting weight type
        if(selected_category_array[1] == '<?php echo GYMPRO_WEIGHT_EXERCISE_TYPE_ID ?>' && program_exercise_type_id == '<?php echo GYMPRO_CARDIO_EXERCISE_TYPE_ID ?>')
        {
            $("#"+exercise_id+"").html(tmpl("tmpl_update_program_weight_exercise", exercise_id));
        }
        //coming from weight and now selecting cardio type
        if(selected_category_array[1] == '<?php echo GYMPRO_CARDIO_EXERCISE_TYPE_ID ?>' && program_exercise_type_id == '<?php echo GYMPRO_WEIGHT_EXERCISE_TYPE_ID ?>')
        {
            $("#"+exercise_id+"").html(tmpl("tmpl_update_program_cardio_exercise", exercise_id));
        }
        
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "applications/gympro/program_subcategory_list",
            data: {
                category_id: selected_category_array[0]
            },
            success: function(data) {
                $("#subcategory_view").html(tmpl("tmpl_subcategory_list", data.subcategory_list));
            }
        });
    }
    function get_exercise_categories()
    {
         $("#subcategory_view").html("");
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "applications/gympro/get_exercise_categories",
            success: function(data) {
                $("#exercise_category_list").html(tmpl("tmpl_exercise_category_list", data.exercise_category_list));
            }
        });
    }
    function open_modal_browse_exercise(number) {
        get_exercise_categories();
        $("#hf_numb").val(number);
        $("#modal_exercise").modal('show');
    }
    function set_subcategory_name(value){
        var position = $("#hf_numb").val();
        $( "input[name='name_" + position + "']" ).val(value);
        $("#modal_exercise").modal('hide');
    }
    
</script>
<img onclick="set_subcategory_name(<?php echo '{%= subcategory_list.title%}'; ?>)">
<script type="text/x-tmpl" id="tmpl_subcategory_list">
    {% var i=0, subcategory_list = ((o instanceof Array) ? o[i++] : o); %}
    {% var count=0;  %}
    <div class="row">
    {% while(subcategory_list){ %}
    {% if( count%3 == 0 ){ %}
    </div>
    <div class="row">
    {% } %}
    <div class="col-md-4">
        <div class="row form-group">
            <div class="col-md-4">
                <img onclick="set_subcategory_name('<?php echo "{%= subcategory_list.title%}"; ?>')" src="<?php echo base_url().PROGRAM_EXERCISE_SUBCATEGORY_PICTURE_PATH_W50_H50.'{%= subcategory_list.picture%}';?>">
            </div>
            <div class="col-md-8">
                <?php echo '{%= subcategory_list.title%}'; ?>
            </div>
        </div>
    </div>
    {%  count++;  %}
    {% subcategory_list = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<script type="text/x-tmpl" id="tmpl_exercise_category_list">
    <option value="0">Select</option>
    <optgroup class="user_category_dropdown_optgroup" label="Weight Exercise">
    {% var i=0, exercise_category_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(exercise_category_info){ %}
        {% if(exercise_category_info.type_id == <?php echo GYMPRO_WEIGHT_EXERCISE_TYPE_ID; ?>){ %}
            <option value="{%= exercise_category_info.exercise_category_id %}_{%= exercise_category_info.type_id %}">{%= exercise_category_info.title %}</option>
        {% } %}
    {% exercise_category_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
    </optgroup>
    <optgroup class="user_category_dropdown_optgroup" label="Cardio Exercise">
    {% var i=0, exercise_category_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(exercise_category_info){ %}
        {% if(exercise_category_info.type_id == <?php echo GYMPRO_CARDIO_EXERCISE_TYPE_ID; ?>){ %}
            <option value="{%= exercise_category_info.exercise_category_id %}_{%= exercise_category_info.type_id %}">{%= exercise_category_info.title %}</option>
        {% } %}
    {% exercise_category_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
    </optgroup>
</script>
<script type="text/x-tmpl" id="tmpl_update_program_weight_exercise">
    {% var weight=0, weight_num = ((o instanceof Array) ? o[weight++] : o); %}
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
</script>
<script type="text/x-tmpl" id="tmpl_update_program_cardio_exercise">
    {% var i=0, cardio_num = ((o instanceof Array) ? o[i++] : o); %}
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
</script>
<div class="modal fade" id="modal_exercise" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Browse Exercise</h4>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-4">
                        <select id="exercise_category_list" class="form-control form_control_custom" onchange=subcategry_select()>
                            
                        </select>
                        <?php //echo form_dropdown('exercise_category_list', $exercise_category_list, '0', 'class=form-control id=exercise_category_list onchange=subcategry_select()'); ?>
                    </div>
                    <div class="col-md-8">
                        <span>Click on an exercise below to add it to the programme</span>
                    </div>
                    <input type=hidden id="hf_numb" >
                </div>
                <div class="form-group">                    
                    <div id="subcategory_view">                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class ="col-md-9">
                </div>
                <div class ="col-md-3">
                    <button style="width:100%" type="button" class="btn button-custom" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->