<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<script>
    var group_counter = 0;
    var row_counter = 0;
    $(function() {
        $("#button_edit_nutrition").on("click", function() {
            if ($("#client_list").val() == 0)
            {
                // alert("Please select the person you are assessing from the drop menu.");
                var message = "Please select the person you are assessing from the drop menu.";
                print_common_message(message);
                return false;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url() . 'applications/gympro/edit_nutrition/' . $nutrition_id; ?>',
                data: $("#form_edit_nutrition").serializeArray(),
                success: function(data) {
                    //alert(data.message);
                    var message = data.message;
                    print_common_message(message);
                    window.location = '<?php echo base_url(); ?>applications/gympro/nutrition';
                }
            });
        });
    });
    function delete_meal_row(current_row)
    {
        $(current_row).closest('.meal_row').remove();
    }
    function add_meal_group_by_loop( )
    {
        ++group_counter;
        $("#group_counter").val(group_counter);
        var oo = [];
        oo[0] = group_counter;
        oo[1] = row_counter;
        $('#meal_group_place').append(tmpl('meal_group_tmpl', oo));
    }
    function add_meal_row_to_latest_group()
    {
        ++row_counter;
        $("#row_counter").val(row_counter);
        var oo = [];
        oo[0] = group_counter;
        oo[1] = row_counter;
//        var rr = $( "input[name='group_is_present_"+group_counter+"_"+(row_counter-1)+"']" ).val(); alert(rr);
        $("input[name='group_is_present_" + group_counter + "']").parent().next().find('.meal_row_place').append(tmpl('meal_row_tmpl', oo));
    }
    function add_meal_row(current_group)
    {
        ++row_counter;
        $("#row_counter").val(row_counter);
        var oo = [];
        oo[0] = $(current_group).siblings('.group_number').val();
        oo[1] = row_counter;

        $(current_group).parent().next().find('.meal_row_place').append(tmpl('meal_row_tmpl', oo));
    }
    function add_meal_group()
    {
        ++group_counter;
        $("#group_counter").val(group_counter);
        var oo = [];
        oo[0] = group_counter;
        oo[1] = row_counter;
        $('#meal_group_place').append(tmpl('meal_group_tmpl', oo));
        add_meal_row_to_latest_group();
    }
    function row_value_set(meal_time, work_out, qq, ww, ee, rr, tt, yy, uu)
    {
        $("select[name='meal_time_" + group_counter + "']").val(meal_time);
        $("select[name='work_out_" + group_counter + "']").val(work_out);
        $("input[name='label_" + group_counter + "_" + row_counter + "']").val(qq);
        $("input[name='quan_" + group_counter + "_" + row_counter + "']").val(ww);
        $("input[name='unit_" + group_counter + "_" + row_counter + "']").val(ee);
        $("input[name='cal_" + group_counter + "_" + row_counter + "']").val(rr);
        $("input[name='prot_" + group_counter + "_" + row_counter + "']").val(tt);
        $("input[name='carb_" + group_counter + "_" + row_counter + "']").val(yy);
        $("input[name='fats_" + group_counter + "_" + row_counter + "']").val(uu);
    }
</script>
<script type="text/x-tmpl" id="meal_group_tmpl">
    <div class="pad_white">
    <select name="meal_time_<?php echo '{%= o[0] %}'; ?>" style="margin-right: 15px; width: 100px;">
    <?php foreach ($meal_time_list as $key => $meal_time): ?>
        <option value="<?php echo $key; ?>"><?php echo $meal_time; ?></option>
    <?php endforeach; ?>
    </select>
    <select name="work_out_<?php echo '{%= o[0] %}'; ?>" style="margin-right: 15px; width: 100px;">
    <?php foreach ($workout_list as $key => $meal_time): ?>
        <option value="<?php echo $key; ?>"><?php echo $meal_time; ?></option>
    <?php endforeach; ?>
    </select>
    <input type="hidden" value="<?php echo '{%=o[0]%}'; ?>" name="group_is_present_<?php echo '{%=o[0]%}'; ?>" class="group_number">
    <img class="pull-right" onclick="add_meal_row(this)" src="<?php echo base_url(); ?>resources/images/add.png" style="margin: 4px">
    </div>
    <div class="pad_white">
    <div class="row">
    <div class="col-md-12">
    <div class="col-md-5" style="padding: 0px; margin: 2px;">
    <div style="font-size: 14px;">Label</div>
    </div>
    <div class="col-md-1" style="padding: 0px; margin: 2px;">
    <div style="font-size: 14px;">Quantity</div>
    </div>
    <div class="col-md-1" style="padding: 0px; margin: 2px;">
    <div style="font-size: 14px;">Qty.Unit</div>
    </div>
    <div class="col-md-1" style="padding: 0px; margin: 2px;">
    <div style="font-size: 14px;">Calories</div>
    </div>
    <div class="col-md-1" style="padding: 0px; margin: 2px;">
    <div style="font-size: 14px;">Protein</div>
    </div>
    <div class="col-md-1" style="padding: 0px; margin: 2px;">
    <div style="font-size: 14px;">Carbs</div>
    </div>
    <div class="col-md-1" style="padding: 0px; margin: 2px;">
    <div style="font-size: 14px;">Fats</div>
    </div>
    </div>
    </div>
    <!--MEALS ARE ADDED HERE-->
    <div class="meal_row_place"> </div>
    </div>
    <div class="form-group"></div>
</script>
<script type="text/x-tmpl" id="meal_row_tmpl">
    <div class="row meal_row">
    <div class="col-md-12">
    <div class="col-md-5" style="padding: 0px; margin: 2px;">
    <div><input type="text" style="width: 100%" name="label_<?php echo '{%= o[0] %}'; ?>_<?php echo '{%= o[1] %}'; ?>"></div>
    </div>
    <div class="col-md-1" style="padding: 0px; margin: 2px;">
    <div><input type="text" style="width: 100%" name="quan_<?php echo '{%= o[0] %}'; ?>_<?php echo '{%= o[1] %}'; ?>"></div>
    </div>
    <div class="col-md-1" style="padding: 0px; margin: 2px;">
    <div><input type="text" style="width: 100%" name="unit_<?php echo '{%= o[0] %}'; ?>_<?php echo '{%= o[1] %}'; ?>"></div>
    </div>
    <div class="col-md-1" style="padding: 0px; margin: 2px;">
    <div><input type="text" style="width: 100%" name="cal_<?php echo '{%= o[0] %}'; ?>_<?php echo '{%= o[1] %}'; ?>"></div>
    </div>
    <div class="col-md-1" style="padding: 0px; margin: 2px;">
    <div><input type="text" style="width: 100%" name="prot_<?php echo '{%= o[0] %}'; ?>_<?php echo '{%= o[1] %}'; ?>"></div>
    </div>
    <div class="col-md-1" style="padding: 0px; margin: 2px;">
    <div><input type="text" style="width: 100%" name="carb_<?php echo '{%= o[0] %}'; ?>_<?php echo '{%= o[1] %}'; ?>"></div>
    </div>
    <div class="col-md-1" style="padding: 0px; margin: 2px;">
    <div><input type="text" style="width: 100%" name="fats_<?php echo '{%= o[0] %}'; ?>_<?php echo '{%= o[1] %}'; ?>"></div>
    </div>
    <input type="hidden" value="<?php echo '{%=o[1]%}'; ?>" name="row_is_present_<?php echo '{%=o[0]%}'; ?>_<?php echo '{%=o[1]%}'; ?>" class="group_number">
    <img class="pull-right" onclick="delete_meal_row(this)" src="<?php echo base_url(); ?>resources/images/cross.png" style="margin: 4px">
    </div>
    </div>
</script>

<div class="container-fluid">
    <div class="row top_margin">
        <?php
        if ($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT) {
            $this->load->view("applications/gympro/template/sections/client_left_pane");
        } else {
            $this->load->view("applications/gympro/template/sections/pt_left_pane");
        }
        ?>
        <div class="col-md-10">
            <?php echo form_open("applications/gympro/edit_nutrition/" . $nutrition_id, array('id' => 'form_edit_nutrition', 'class' => 'form-horizontal', 'onsubmit' => 'return false;')); ?>
            <div class="pad_title">
                EDIT NUTRITION
                <div class="col-md-3 pull-right">
                    <?php $this->load->view("applications/gympro/template/user_category_dropdown"); ?>
                </div>
            </div>
            <div style="border-top: 2px solid lightgray; margin-left: 20px"></div>
            <div class="pad_body pad_body_custom">
                <input type="hidden" name="group_counter" id="group_counter">
                <input type="hidden" name="row_counter" id="row_counter">
                <!--MEAL BOXES ARE ADDED HERE-->
                <div id="meal_group_place"></div>

                <!--ADD MEAL BUTTON-->
                <div class="add_meal_custom">
                    <a class="cursor_pointer" onclick="add_meal_group()" style="font-size: 16px; line-height: 33px;">+Add another meal</a>
                </div>
            </div>
            <div class="pad_footer">
                <button id="button_edit_nutrition" name="button_edit_nutrition" type="submit">Save</button> or <a href="<?php echo base_url() ?>applications/gympro/nutrition">Previous</a>
            </div>
            <?php echo form_close(); ?>
            <?php ?>
            <?php ?>
            <?php foreach ($nutrition_info as $meal_group) { ?>
                <script> add_meal_group_by_loop();</script>
                <?php foreach ($meal_group as $meal_row) { ?>
                    <script> add_meal_row_to_latest_group();</script>
                    <script>  row_value_set("<?php echo $meal_row["meal_time"] ?>", "<?php echo $meal_row["work_out"] ?>", "<?php echo $meal_row["label"] ?>", "<?php echo $meal_row["quan"] ?>", "<?php echo $meal_row["unit"] ?>", "<?php echo $meal_row["cal"] ?>", "<?php echo $meal_row["prot"] ?>", "<?php echo $meal_row["carb"] ?>", "<?php echo $meal_row["fats"] ?>")</script>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>

