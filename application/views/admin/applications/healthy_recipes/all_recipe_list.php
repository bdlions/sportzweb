<?php
    $data = array();
    
    for($i=0;$i<count($recipe_list_item);$i++){
        array_push($data,$recipe_list_item[$i]['id']);
    }
    $data = json_encode($data);
?>

<script type="text/javascript">
    $(function() {
        
        
        var selected_array = Array();
        selected_array = <?php echo $data;?>;
        //alert(selected_array);
        $('#recipes_list_after_select').val(JSON.stringify(selected_array));
        
        $("#recipe_list_for_home_page").on("click", function() {
            var selected_date_for_item = $('#date_for_show_item').val();
            if (selected_date_for_item.length == 0)
            {
                alert('please select a date first for your item');
            }
            var selected_recipe_array = Array();
            var selected_recipe_item = Array();
            $("#tbody_recipe_list_for_home_page tr").each(function() {
                var lastColumn = $(this).find('td:last');
                var lastPrevColumn = $(this).find('td:last').prev("td");

                var recipeSelectionCheckBox = $(lastPrevColumn).find("input:checkbox");
                if ($(recipeSelectionCheckBox).prop('checked') == true) {
                    selected_recipe_item.push(recipeSelectionCheckBox.attr('id'));
                }

                var recipeListCheckBox = $(lastColumn).find("input:checkbox");
                if ($(recipeListCheckBox).prop('checked') == true) {
                    selected_recipe_array.push(recipeListCheckBox.attr('id'));
                }
            });

            if (selected_recipe_array.length == 7)
            {
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "admin/applications_healthyrecipes/recipe_list_for_home_page",
                    data: {
                        selected_recipe_array_list: JSON.stringify(selected_recipe_array),
                        selected_recipe_item: JSON.stringify(selected_recipe_item),
                        selected_date_for_item: selected_date_for_item
                    },
                    success: function(data) {
                        alert(data['message']);
                        if (data['status'] === 1)
                        {
                            location.reload();
                        }
                    }
                });
            } else if (selected_recipe_array.length > 7)
            {
                alert('Please select only 6 recipe item for your home page');
            } else
            {
                alert('Please select only 6 recipe item for your home page');
            }
        });
    });
</script> 
<script type="text/javascript">
    $(function() {
        var a = <?php echo $show_advertise;?>;
        if(a==1){
            $('select option[value="3"]').attr("selected",true);
        }   
        $('#date_for_show_item').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#date_for_show_item').text($('#date_for_show_item').data('date'));
            $('#date_for_show_item').datepicker('hide');
        });
    });
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/healthy_recipe.css">
<div class="panel panel-default">
    <div class="panel-heading">
        Recipes List
        <div class="pull-right">
            <form action="">
                <select name="cars" onchange="panel_change()" id="panel">
                    <option value="1">Show all</option>
                    <option value="2">Show Advertise</option>
                    <option value="3">Hide</option>
                </select>
            </form>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <div class="col-md-12 grayborderbottom"style="border-left: 2px solid #E7E7E7; border-right: 2px solid #E7E7E7; ">
                <div class="col-md-9">
                    <div class="row">
                        <?php if (count($recipe_view_list_item) > 1): ?>
                            <div class="col-md-8 grayborderbottom grayborderright">
                                <?php if (array_key_exists(0, $recipe_view_list_item)) : ?>
                                    <?php if (!empty($recipe_view_list_item[0]['main_picture'])): ?>
                                        <button style="z-index: 500; position: relative;" id="button_edit_recipe_<?php echo $recipe_view_list_item[0]["id"]; ?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_recipe_<?php echo $recipe_view_list_item[0]["id"]; ?>', '1')">
                                            Edit
                                        </button>
                                        <input type="hidden" name="top_left" id="position_of_recipe_1" value="<?php echo $recipe_view_list_item[0]["id"]; ?>">
                                        <input type="hidden" name="get_selected_id" id="get_selected_id" value="">
                                        <a href="<?php echo base_url() . 'admin/applications_healthyrecipes/recipes/' . $recipe_view_list_item[0]['id']; ?>">
                                            <img id="image_position_1" style="width: 480px;height: 200px;" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_view_list_item[0]['main_picture']; ?>" class="img-responsive" alt="<?php echo $recipe_view_list_item[0]['title']; ?>"/>
                                        </a>
                                    <?php endif; ?>
                                    <span id="title_1" class="image-caption reciepe_title" style="color: #7092BE"><?php echo (!empty($recipe_view_list_item[0]['title'])) ? $recipe_view_list_item[0]['title'] : ''; ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-4" style="padding-right: 0px">
                                <?php if (array_key_exists(1, $recipe_view_list_item)) : ?>
                                    <button style="z-index: 500;" id="button_edit_recipe_<?php echo $recipe_view_list_item[1]["id"]; ?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_recipe_<?php echo $recipe_view_list_item[1]["id"]; ?>', '2')">
                                        Edit
                                    </button>
                                    <input type="hidden" name="top_right" id="position_of_recipe_2" value="<?php echo $recipe_view_list_item[1]["id"]; ?>">
                                    <img src="<?php echo base_url(); ?>resources/images/quote.png" class="img-responsive" alt=""/>
                                    <a style="color: red" href="<?php echo base_url() . 'admin/applications_healthyrecipes/recipes/' . $recipe_view_list_item[1]['id']; ?>">
                                        <h2 id="title_2" class="reciepe_title"><?php echo (!empty($recipe_view_list_item[1]['title'])) ? $recipe_view_list_item[1]['title'] : ''; ?></h2>
                                    </a>
                                    <span id="description_2" class="recipe_description">
                                        <?php echo $recipe_view_list_item[1]['description']; ?>
                                    </span>

                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <?php if (count($recipe_view_list_item) >= 3): ?>
                            <div class="col-md-3" style="padding-right: 2px">
                                <?php if (array_key_exists(2, $recipe_view_list_item)) : ?>
                                    <button style="z-index: 500;" id="button_edit_recipe_<?php echo $recipe_view_list_item[2]["id"]; ?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_recipe_<?php echo $recipe_view_list_item[2]["id"]; ?>', '3')">
                                        Edit
                                    </button>
                                    <input type="hidden" name="bottom_left" id="position_of_recipe_3" value="<?php echo $recipe_view_list_item[2]["id"]; ?>">
                                    <img src="<?php echo base_url(); ?>resources/images/quote.png" class="img-responsive" alt=""/>
                                    <a style="color: red" href="<?php echo base_url() . 'admin/applications_healthyrecipes/recipes/' . $recipe_view_list_item[2]['id']; ?>">
                                        <h4 id="title_3" class="reciepe_title"><?php echo (!empty($recipe_view_list_item[2]['title'])) ? $recipe_view_list_item[2]['title'] : ''; ?></h4>
                                    </a>
                                    <div id="description_3" class="recipe_description"><?php echo $recipe_view_list_item[2]['description']; ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-4 grayborderright grayborderleft">
                            <div class="col-md-12 purp_style" style="padding-right: 0px;">
                                Recipes
                                <button style="z-index: 500" id="button_edit_recipes" value="" class="btn button-custom pull-right">
                                    Edit
                                </button>
                            </div>


                            <input type="hidden" name="recipes_list_after_select" id="recipes_list_after_select" value="">
                            <div id="show_recipes_after_select">
                                <?php if (count($recipe_list_item) > 0): ?>
                                    <?php foreach ($recipe_list_item as $key => $value): ?>
                                        <a class="recipe_a_list" href="<?php echo base_url() . 'admin/applications_healthyrecipes/recipes/' . $value['id']; ?>">
                                            <?php echo $value['title']; ?>
                                        </a>
                                        <br>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-5" style="padding-right: 0px">
                            <?php if (array_key_exists(3, $recipe_view_list_item)) : ?>
                                <?php if (!empty($recipe_view_list_item[3]['main_picture'])): ?>
                                    <button style="z-index: 500; position: relative" id="button_edit_recipe_<?php echo $recipe_view_list_item[3]["id"]; ?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_recipe_<?php echo $recipe_view_list_item[3]["id"]; ?>', '4')">
                                        Edit
                                    </button>
                                    <input type="hidden" name="bottom_right" id="position_of_recipe_4" value="<?php echo $recipe_view_list_item[3]["id"]; ?>">
                                    <a href="<?php echo base_url() . 'admin/applications_healthyrecipes/recipes/' . $recipe_view_list_item[3]['id']; ?>">
                                        <img id="image_position_4" style="width: 500px;height: 150px;" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_view_list_item[3]['main_picture']; ?>" class="img-responsive" alt=""/>
                                    </a>
                                <?php endif; ?>
                                <h3 id="title_4" class="reciepe_title" style="color: #7092BE"><?php echo (!empty($recipe_view_list_item[3]['title'])) ? $recipe_view_list_item[3]['title'] : ''; ?></h3>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" id="side_panel">
                    <?php if (array_key_exists(4, $recipe_view_list_item)) : ?>
                        <?php if (!empty($recipe_view_list_item[4]['main_picture'])): ?>
                            <button style="z-index: 500; position: relative" id="button_edit_recipe_<?php echo $recipe_view_list_item[4]["id"]; ?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_recipe_<?php echo $recipe_view_list_item[4]["id"]; ?>', '5')">
                                Edit
                            </button>
                            <input type="hidden" name="right_up_extra" id="position_of_recipe_5" value="<?php echo $recipe_view_list_item[4]["id"]; ?>">
                            <a href="<?php echo base_url() . 'admin/applications_healthyrecipes/recipes/' . $recipe_view_list_item[4]['id']; ?>">
                                <img id="image_position_5" style="width: 500px;height: 150px;" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_view_list_item[4]['main_picture']; ?>" class="img-responsive" alt=""/>
                            </a>
                        <?php endif; ?>
                        <h3 id="title_5" class="reciepe_title" style="color: #7092BE"><?php echo (!empty($recipe_view_list_item[4]['title'])) ? $recipe_view_list_item[4]['title'] : ''; ?></h3>
                    <?php endif; ?>
                    <?php if (array_key_exists(5, $recipe_view_list_item)) : ?>
                        <?php if (!empty($recipe_view_list_item[5]['main_picture'])): ?>
                            <button style="z-index: 500; position: relative" id="button_edit_recipe_<?php echo $recipe_view_list_item[5]["id"]; ?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_recipe_<?php echo $recipe_view_list_item[5]["id"]; ?>', '6')">
                                Edit
                            </button>
                            <input type="hidden" name="right_down_extra" id="position_of_recipe_6" value="<?php echo $recipe_view_list_item[5]["id"]; ?>">
                            <a href="<?php echo base_url() . 'admin/applications_healthyrecipes/recipes/' . $recipe_view_list_item[5]['id']; ?>">
                                <img id="image_position_6" style="width: 500px;height: 150px;" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_view_list_item[5]['main_picture']; ?>" class="img-responsive" alt=""/>
                            </a>
                        <?php endif; ?>
                        <h3 id="title_6" class="reciepe_title" style="color: #7092BE"><?php echo (!empty($recipe_view_list_item[5]['title'])) ? $recipe_view_list_item[5]['title'] : ''; ?></h3>
                    <?php endif; ?>
                    <?php if (array_key_exists(6, $recipe_view_list_item)) : ?>
                        <?php if (!empty($recipe_view_list_item[6]['main_picture'])): ?>
                            <button style="z-index: 500; position: relative" id="button_edit_recipe_<?php echo $recipe_view_list_item[6]["id"]; ?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_recipe_<?php echo $recipe_view_list_item[6]["id"]; ?>', '7')">
                                Edit
                            </button>
                            <input type="hidden" name="right_right" id="position_of_recipe_7" value="<?php echo $recipe_view_list_item[6]["id"]; ?>">
                            <a href="<?php echo base_url() . 'admin/applications_healthyrecipes/recipes/' . $recipe_view_list_item[6]['id']; ?>">
                                <img id="image_position_7" style="width: 500px;height: 150px;" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_view_list_item[6]['main_picture']; ?>" class="img-responsive" alt=""/>
                            </a>
                        <?php endif; ?>
                        <h3 id="title_7" class="reciepe_title" style="color: #7092BE"><?php echo (!empty($recipe_view_list_item[6]['title'])) ? $recipe_view_list_item[6]['title'] : ''; ?></h3>
                    <?php endif; ?>
                </div>

            </div>

            <div class="row col-md-12" style="margin-top: 30px;">

            </div>
        </div>
        <div class="row col-md-12">
            <div class ="col-sm-3">
                <input type="text" class="form-control" id="date_for_show_item" name="date_for_show_item" value=""/>
            </div>
            <div class="col-sm-2">
                <button id="save_your_setting" onclick="submit_setting();" value="" class="form-control btn button-custom">
                    Submit
                </button>
            </div>
            <input type="button" style="width:120px; float: right" value="Back" id="back_button" onclick="goBackByURL('<?php echo base_url(); ?>admin/applications_healthyrecipes')" class="form-control btn button-custom">
        </div>
                    
    </div>
</div>
<?php $this->load->view("admin/applications/healthy_recipes/modal_edit_recipe_item_home_page"); ?>
<?php $this->load->view("admin/applications/healthy_recipes/modal_edit_recipes_item"); ?>
<!-- Written by Omar -->
<script type="text/javascript">
    function openModal(val, id) {
        $('#get_selected_id').val(id);
        $('#modal_edit_recipe_item_home_page').modal('show');
    }
</script>
<script type="text/javascript">
    $(function() {
        $("#button_edit_recipes").on("click", function() {
            $('#modal_edit_recipes').modal('show');
        });
    });
</script>
<script type="text/javascript">
    function submit_setting() {
        var value_top_left = $('#position_of_recipe_1').val();
        var value_top_right = $('#position_of_recipe_2').val();
        var value_bottom_left = $('#position_of_recipe_3').val();
        var value_bottom_right = $('#position_of_recipe_4').val();
        var value_bottom_up_extra = $('#position_of_recipe_5').val();
        var value_bottom_down_extra = $('#position_of_recipe_6').val();
        var value_bottom_down = $('#position_of_recipe_7').val();
        
        //alert(value_top_left+' '+value_top_right+' '+value_bottom_left+' '+value_bottom_right+' '+value_bottom_up_extra+' '+value_bottom_down_extra+' '+value_bottom_down)
        var recipes_list = $('#recipes_list_after_select').val();

//        alert(recipes_list);
        //alert(value_top_left + ' ' + value_top_right + ' '+ value_bottom_left + ' ' + value_bottom_right );
        if (value_top_left === '') {
            alert('you have to select a item for top left position');
            return;
        }

        if (value_top_right === '') {
            alert('you have to select a item for top right position');
            return;
        }

        if (value_bottom_left === '') {
            alert('you have to select a item for bottom left position');
            return;
        }

        if (value_bottom_right === '') {
            alert('you have to select a item for bottom right position');
            return;
        }
        
        var id = $('#panel').val();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/applications_healthyrecipes/save_selected_recipe",
            data: {
                value_top_left: value_top_left,
                value_top_right: value_top_right,
                value_bottom_left: value_bottom_left,
                value_bottom_right: value_bottom_right,
                value_bottom_up_extra: value_bottom_up_extra,
                value_bottom_down_extra: value_bottom_down_extra,
                value_bottom_down: value_bottom_down,
                recipes_list: recipes_list,
                save_id: id
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

</script>
<script type="text/javascript">
    var a = <?php echo $show_advertise;?>;
        if(a==1){
           $('#side_panel').hide(); 
        }  
    function panel_change(){
        var id = $('#panel').val();
        if(id==3) $('#side_panel').hide();
        if(id==1) $('#side_panel').show();
    }
</script>
