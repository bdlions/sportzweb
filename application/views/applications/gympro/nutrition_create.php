<!--<script>



////////// these codes can be used as a reference for setting input field names and id



    function jsDelete(pid) {
        if (confirm('Are you sure you want to DELETE this nutrition plan?'))
            document.location = 'index.php?p=nutrition&a=edit&sa=delete&i=' + pid;
    }

    function jsV(f) {
        if (f.__subject.value == '' || f.__message.value == '') {
            alert('Please enter a subject and message before sending.');
            return false;
        }
        return true;
    }

    var qty;
    var cals;
    var pro;
    var fats;
    var carbs;

    $(document).on("focus", ".servinginput", function () {
        qty = $(this).val();
    });
    $(document).on("focus", ".caloriesinput", function () {
        cals = $(this).val();
    });
    $(document).on("focus", ".proteininput", function () {
        pro = $(this).val();
    });
    $(document).on("focus", ".fatsinput", function () {
        fats = $(this).val();
    });
    $(document).on("focus", ".carbsinput", function () {
        carbs = $(this).val();
    });

    $(document).on("change", ".caloriesinput", function () {
        if (isNaN($(this).val())) {
            alert('Please enter numbers or decimals only in the calories field.');
            $(this).val(cals);
        }
    });

    $(document).on("change", ".proteininput", function () {
        if (isNaN($(this).val())) {
            alert('Please enter numbers or decimals only in the protein field.');
            $(this).val(pro);
        }
    });

    $(document).on("change", ".fatsinput", function () {
        if (isNaN($(this).val())) {
            alert('Please enter numbers or decimals only in the fats field.');
            $(this).val(fats);
        }
    });

    $(document).on("change", ".carbsinput", function () {
        if (isNaN($(this).val())) {
            alert('Please enter numbers or decimals only in the carbs field.');
            $(this).val(carbs);
        }
    });

    $(document).on("blur", ".servinginput", function () {

        if (isNaN($(this).val())) {
            alert('Please enter numbers or decimals only in the quantity field.');
            $(this).val(qty);
        } else {

            var hiddenqtyval = $(this).parent().parent().find(".hiddenqty").val();
            $(this).parent().parent().find(".hiddenqty").val($(this).val());

            if (hiddenqtyval != '') {

                var caloriesval = $(this).parent().parent().find(".caloriesinput").val();
                var caloriesvalnew = ($(this).val() / 100) * (caloriesval / hiddenqtyval * 100);
                $(this).parent().parent().find(".caloriesinput").val(caloriesvalnew.toFixed(1));

                var proteinval = $(this).parent().parent().find(".proteininput").val();
                var proteinvalnew = ($(this).val() / 100) * (proteinval / hiddenqtyval * 100);
                $(this).parent().parent().find(".proteininput").val(proteinvalnew.toFixed(1));

                var fatsval = $(this).parent().parent().find(".fatsinput").val();
                var fatsvalnew = ($(this).val() / 100) * (fatsval / hiddenqtyval * 100);
                $(this).parent().parent().find(".fatsinput").val(fatsvalnew.toFixed(1));

                var carbsval = $(this).parent().parent().find(".carbsinput").val();
                var carbsvalnew = ($(this).val() / 100) * (carbsval / hiddenqtyval * 100);
                $(this).parent().parent().find(".carbsinput").val(carbsvalnew.toFixed(1));

            }

        }

    });

    $(document).on("focus", ".foodinputnew", function () {
        $(this).autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "/s/ajax/searchfoods.php?v=1.0",
                    type: "GET",
                    dataType: "json",
                    data: {term: request.term},
                    success: function (data) {

                        response($.map(data.foods, function (item) {

                            return {
                                label: item.name,
                                value: item.name,
                                foodid: item.foodid,
                                calories: item.calories,
                                carbs: item.carbs,
                                protein: item.protein,
                                fats: item.fats,
                                quantity: item.quantity,
                                quantityunit: item.quantityunit
                            }

                        }));
                    }
                });
            },
            minLength: 3,
            select: function (event, ui) {
                //alert(ui.item.calories);
                $(this).parent().parent().find(".servinginput").val(ui.item.quantity);
                $(this).parent().parent().find(".quantityunit").val(ui.item.quantityunit);
                $(this).parent().parent().find(".hiddenqty").val(ui.item.quantity);
                $(this).parent().parent().find(".foodidinput").val(ui.item.foodid);
                $(this).parent().parent().find(".caloriesinput").val(ui.item.calories);
                $(this).parent().parent().find(".proteininput").val(ui.item.protein);
                $(this).parent().parent().find(".fatsinput").val(ui.item.fats);
                $(this).parent().parent().find(".carbsinput").val(ui.item.carbs);
                // "Selected: " + ui.item.value + " aka " + ui.item.id +
                //"Nothing selected, input was " + this.value );
            }
        });
    });

</script>
<script type="text/javascript">
    function jsaddmeal2() {

        var mealarray = $('input[name="__meal[]"]');
        var mealarraylength = parseInt($('input[name="__meal[]"]').length);
        var latestmealid = mealarray[mealarraylength - 1].value;

        var newmeal = $('#mealtemplate').clone();
        newmeal.attr('class', 'mealboxnew');
        $(newmeal).find("input[type='hidden']:first").val(parseInt(latestmealid) + 1);
        newmeal.appendTo('#meals');

    }
    function jsnewfooditem(f) {

        var foods = $(f).parent().next().find(".foods");
        var newfooditem = $(".fooditemline-template").clone();
        $(newfooditem).attr('class', 'fooditemline');
        $(newfooditem).appendTo(foods);

        var mealid = $(newfooditem).prev().find("input[type='hidden']:first").val();
        $(newfooditem).children("input[type='hidden']:first").val(mealid);

    }
</script>
<script>(function () {
        var uv = document.createElement('script');
        uv.type = 'text/javascript';
        uv.async = true;
        uv.src = '//widget.uservoice.com/XnFn1yjpDeWrTh8QMzqHNw.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(uv, s)
    })()
</script>

<script>
    window.intercomSettings = {
// TODO: The current logged in user's full name
        name: "Nazmul Hasan",
// TODO: The current logged in user's email address.
        email: "bdlions@gmail.com",
// TODO: The current logged in user's sign-up date as a Unix timestamp.
        created_at: 1408398417,
        app_id: "nn2sqohu"
    };
</script>
<script>
(
    function () 
    {
        var w = window;
        var ic = w.Intercom;
        if (typeof ic === "function") {
            ic('reattach_activator');
            ic('update', intercomSettings);
        } else {
            var d = document;
            var i = function () {
                i.c(arguments)
            };
            i.q = [];
            i.c = function (args) {
                i.q.push(args)
            };
            w.Intercom = i;
            function l() {
                var s = d.createElement('script');
                s.type = 'text/javascript';
                s.async = true;
                s.src = 'https://widget.intercom.io/widget/nn2sqohu';
                var x = d.getElementsByTagName('script')[0];
                x.parentNode.insertBefore(s, x);
            }
            if (w.attachEvent) {
                w.attachEvent('onload', l);
            } else {
                w.addEventListener('load', l, false);
            }
        }
    }
)
</script>-->

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<script>
    var group_counter = 0;
    var row_counter = 0;
    $(function(){
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
        add_meal_row_auto();
    }
//    function delete_meal_group()
//    {
//        ;
//    }

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
<script type="text/x-tmpl" id="meal_group_tmpl">
        <div class="pad_white">
            <select name="meal_time_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>" style="margin-right: 15px; width: 100px;">
                <?php foreach ($meal_time_list as $key => $meal_time): ?>
                    <option value="<?php echo $key; ?>"><?php echo $meal_time; ?></option>
                <?php endforeach; ?>
            </select>
            <select name="work_out_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>" style="margin-right: 15px; width: 100px;">
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




<!--
<div class="pad_white">
            <select name="meal_time_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>" style="margin-right: 15px; width: 100px;">
                <?php foreach ($meal_time_list as $key => $meal_time): ?>
                    <option value="<?php echo $key; ?>"><?php echo $meal_time; ?></option>
                <?php endforeach; ?>
            </select>
            <select name="work_out_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>" style="margin-right: 15px; width: 100px;">
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
                        <div><input style="width: 100%" name="label_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>"></div>
                    </div>
                    <div class="col-md-1" style="padding: 0px; margin: 2px;">
                        <div style="font-size: 14px;">Quantity</div>
                        <div><input style="width: 100%"  name="quan_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>"></div>
                    </div>
                    <div class="col-md-1" style="padding: 0px; margin: 2px;">
                        <div style="font-size: 14px;">Qty.Unit</div>
                        <div><input style="width: 100%" name="unit_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>"></div>
                    </div>
                    <div class="col-md-1" style="padding: 0px; margin: 2px;">
                        <div style="font-size: 14px;">Calories</div>
                        <div><input style="width: 100%" name="cal_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>"></div>
                    </div>
                    <div class="col-md-1" style="padding: 0px; margin: 2px;">
                        <div style="font-size: 14px;">Protin</div>
                        <div><input style="width: 100%" name="prot_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>"></div>
                    </div>
                    <div class="col-md-1" style="padding: 0px; margin: 2px;">
                        <div style="font-size: 14px;">Carbs</div>
                        <div><input style="width: 100%" name="carb_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>"></div>
                    </div>
                    <div class="col-md-1" style="padding: 0px; margin: 2px;">
                        <div style="font-size: 14px;">Fats</div>
                        <div><input style="width: 100%" name="fats_<?php echo '{%= o[0] %}';?>_<?php echo '{%= o[1] %}';?>"></div>
                    </div>
                </div>
            </div>
            MEALS ARE ADDED HERE
            <div class="meal_row_place"> </div>
        </div>
        <div class="form-group"></div>-->





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
        </div>
    </div>
</div>