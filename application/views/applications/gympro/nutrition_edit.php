<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<script>
    var group_counter = 0;
    var row_counter = 0;
    $(function(){
    });
    function delete_meal_row(current_row)
    {
        $(current_row).closest('.meal_row').remove();
    }
    function add_meal_group_by_loop( meal, workout )
    {
        ++group_counter;
        $("#group_counter").val(group_counter);
        var oo = [];
        oo[0] = group_counter;
        oo[1] = row_counter;
        $('#meal_group_place').append(tmpl('meal_group_tmpl', oo));
        $( "input[name='meal_time_" + group_counter + "']" ).val(meal);
        $( "input[name='work_out_" + group_counter + "']" ).val(workout);
    }
    function add_meal_row_to_latest_group()
    {
        ++row_counter;
        $("#row_counter").val(row_counter);
        var oo = [];
        oo[0] = group_counter;
        oo[1] = row_counter;
//        var rr = $( "input[name='group_is_present_"+group_counter+"_"+(row_counter-1)+"']" ).val(); alert(rr);
        $( "input[name='group_is_present_"+group_counter+"']" ).parent().next().find('.meal_row_place').append(tmpl('meal_row_tmpl', oo));
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
    function row_value_set( qq, ww, ee, rr, tt, yy, uu )
    {
        $( "input[name='label_" + group_counter + "_" + row_counter + "']" ).val(qq);
        $( "input[name='quan_" + group_counter + "_" + row_counter + "']" ).val(ww);
        $( "input[name='unit_" + group_counter + "_" + row_counter + "']" ).val(ee);
        $( "input[name='cal_" + group_counter + "_" + row_counter + "']" ).val(rr);
        $( "input[name='prot_" + group_counter + "_" + row_counter + "']" ).val(tt);
        $( "input[name='carb_" + group_counter + "_" + row_counter + "']" ).val(yy);
        $( "input[name='fats_" + group_counter + "_" + row_counter + "']" ).val(uu);
    }
</script>
<script type="text/x-tmpl" id="meal_group_tmpl">
        <div class="pad_white">
            <select name="meal_time_<?php echo '{%= o[0] %}';?>" style="margin-right: 15px; width: 100px;">
                <?php foreach ($meal_time_list as $key => $meal_time): ?>
                    <option value="<?php echo $key; ?>"><?php echo $meal_time; ?></option>
                <?php endforeach; ?>
            </select>
            <select name="work_out_<?php echo '{%= o[0] %}';?>" style="margin-right: 15px; width: 100px;">
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
                        <div style="font-size: 14px;">Protin</div>
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
                    <div><input style="width: 100%" name="label_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>"></div>
                </div>
                <div class="col-md-1" style="padding: 0px; margin: 2px;">
                    <div><input style="width: 100%" name="quan_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>"></div>
                </div>
                <div class="col-md-1" style="padding: 0px; margin: 2px;">
                    <div><input style="width: 100%" name="unit_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>"></div>
                </div>
                <div class="col-md-1" style="padding: 0px; margin: 2px;">
                    <div><input style="width: 100%" name="cal_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>"></div>
                </div>
                <div class="col-md-1" style="padding: 0px; margin: 2px;">
                    <div><input style="width: 100%" name="prot_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>"></div>
                </div>
                <div class="col-md-1" style="padding: 0px; margin: 2px;">
                    <div><input style="width: 100%" name="carb_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>"></div>
                </div>
                <div class="col-md-1" style="padding: 0px; margin: 2px;">
                    <div><input style="width: 100%" name="fats_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>"></div>
                </div>
                <input type="hidden" value="<?php echo '{%=o[1]%}'; ?>" name="row_is_present_<?php echo '{%=o[0]%}'; ?>_<?php echo '{%=o[1]%}'; ?>" class="group_number">
                <img class="pull-right" onclick="delete_meal_row(this)" src="<?php echo base_url(); ?>resources/images/cross.png" style="margin: 4px">
            </div>
        </div>
</script>

<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-10">
            <div class="pad_title">
                NEW NUTRITION PLAN
            </div>
            <?php echo form_open("applications/gympro/create_nutrition/", array('id' => 'form_create_program', 'class' => 'form-horizontal')) ?>            
            <div class="pad_body">
                <input type="hidden" name="group_counter" id="group_counter">
                <input type="hidden" name="row_counter" id="row_counter">
                <!--MEAL BOXES ARE ADDED HERE-->
                <div id="meal_group_place"></div>
                
                <!--ADD MEAL BUTTON-->
                <div>
                    <a class="cursor_pointer" onclick="add_meal_group()" style="font-size: 16px; line-height: 33px;">+Add another meal</a>
                </div>
            </div>
            <div class="pad_footer">
                <button type="submit">Save Changes</button> or <a href="<?php echo base_url() ?>applications/gympro/nutrition">Go Back</a>
            </div>
            <?php echo form_close(); ?>
            <?php ?>
            <?php ?>
            <?php foreach ($nutrition_info as $meal_group) { ?>
            <script> add_meal_group_by_loop();</script>
                <?php foreach ($meal_group as $meal_row) { ?>
                <script> add_meal_row_to_latest_group();</script>
                <script>  row_value_set("<?php echo $meal_row["label"]?>", "<?php echo $meal_row["quan"]?>", "<?php echo $meal_row["unit"]?>", "<?php echo $meal_row["cal"]?>", "<?php echo $meal_row["prot"]?>", "<?php echo $meal_row["carb"]?>", "<?php echo $meal_row["fats"]?>") </script>
                <?php }?>
            <?php }?>
        </div>
    </div>
</div>

