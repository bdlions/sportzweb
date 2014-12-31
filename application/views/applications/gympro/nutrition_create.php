<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<script>
    var group_counter = 0;
    var row_counter = 0;
    $(function(){
        $("#submit_button").on("click", function() {
            if($("#client_list").val() == 0)
            {
                alert("Please select the person you are assessing from the drop menu.");
                return false;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>applications/gympro/create_nutrition',
                data: $("#form_create_nutrition").serializeArray(),
                success: function(data) {
                    alert(data.message);
                    window.location = '<?php echo base_url(); ?>applications/gympro/nutrition';
                }
            });
        });
        add_meal_group();
    });
    function delete_meal_row(current_row)
    {
        $(current_row).closest('.meal_row').remove();
    }
    function add_meal_row_auto()
    {
        ++row_counter;
        $("#row_counter").val(row_counter);
        var oo = [];
        oo[0] = group_counter;
        oo[1] = row_counter;
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
        add_meal_row_auto();
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
            <?php echo form_open("applications/gympro/create_nutrition/", array('id' => 'form_create_nutrition', 'class' => 'form-horizontal')) ?>
            <div class="pad_title">
                NEW NUTRITION PLAN
                <div class="col-md-3 pull-right">
                    <?php $this->load->view("applications/gympro/template/user_category_dropdown"); ?>
                </div>
            </div>            
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
                <button type="submit" id="submit_button">Save Changes</button> or <a href="<?php echo base_url() ?>applications/gympro/nutrition">Go Back</a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>