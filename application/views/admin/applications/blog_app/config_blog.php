<script type="text/javascript">
    /*$(function() {
     $("#blog_list_for_home_page").on("click", function() {
     var selected_date_for_item = $('#date_for_show_item').val();
     if(selected_date_for_item.length == 0)
     {
     alert('please select a date to config your blog item');
     return;
     }
     var selected_blog_array = Array();
     
     $("#tbody_blog_list_for_home_page tr").each(function() {
     var lastColumn = $(this).find('td:last');
     var blogListCheckBox = $(lastColumn).find("input:checkbox");
     if($(blogListCheckBox).prop('checked') == true){
     selected_blog_array.push(blogListCheckBox.attr('id'));
     }
     });
     
     if(selected_blog_array.length == 6)
     {
     $.ajax({
     dataType: 'json',
     type: "POST",
     url: '<?php echo base_url(); ?>' + "admin/blogapp/blog_list_for_home_page",
     data: {
     selected_blog_array_list: JSON.stringify(selected_blog_array),
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
     } else if(selected_blog_array.length > 13)
     {
     alert('Please select 6 blog for your home page');
     } else 
     {
     alert('Please select 6 blog for your home page');
     }
     });
     });*/
    
    $(function() {
        var id = <?php echo $show_advertise;?>;
    
        if(id == 1){
            $('select option[value="2"]').attr("selected",true);
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
<div class="panel panel-default">
    <div class="panel-heading">
        News List
        <div class="pull-right">
            <form action="">
                <select name="cars" onchange="panel_change()" id="panel_dd">
                    <option value="1">Show Blogs</option>
                    <option value="2">Hide</option>
                    <option value="3">Show advertise</option> 
                </select>
            </form>
        </div>
    </div>
    <div class="panel-body">

        <div class="row"><!--place cards here-->
            <input type="hidden" name="get_selected_id" id="get_selected_id" value="">
            <?php if (count($region_id_blog_id_map) > 0): ?>
                <?php $j = 1; ?>
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <?php $j = $i + 1; ?>
                    <div class="col-md-3">
                        <?php if (array_key_exists($i, $region_id_blog_id_map)): ?>
                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px">
                                <div class="blog_post_home_cards"><!--cards-->
                                    <button style="z-index: 500; position: relative;" id="button_edit_recipe_<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['blog_id']; ?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_recipe_<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['blog_id']; ?>', '<?php echo $i; ?>')">
                                        Edit
                                    </button>
                                    <input type="hidden" name="position_of_blog_<?php echo $i; ?>" id="position_of_blog_<?php echo $i; ?>" value="<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['blog_id']; ?>">
                                    <img id="image_position_<?php echo $i; ?>" class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['picture']; ?>"/>
                                    <br>
                                    <br>
                                    <span class="blog_post_home_cards_heading">
                                        <h2 id="title_<?php echo $i; ?>">
                                            <a href="<?php echo base_url(); ?>admin/applications_blogs/blog_detail/<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['blog_id']; ?>">
                                                <?php echo html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$i]]['title'])); ?>
                                            </a>
                                        </h2>
                                    </span><!--card heading-->
                                    <div class="blog_post_body_text" id="description_<?php echo $i; ?>">
                                        <?php echo substr(html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$i]]['description'])),0,255)." ....."; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (array_key_exists($j, $region_id_blog_id_map)): ?>
                            <?php $i++; ?>
                            <div class="col-md-12" style="padding-left: 0px; padding-right: 0px">
                                <div class="blog_post_home_cards"><!--cards-->
                                    <button style="z-index: 500; position: relative;" id="button_edit_recipe_<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['blog_id']; ?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_recipe_<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['blog_id']; ?>', '<?php echo $i; ?>')">
                                        Edit
                                    </button>
                                    <input type="hidden" name="position_of_blog_<?php echo $i; ?>" id="position_of_blog_<?php echo $i; ?>" value="<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['blog_id']; ?>">
                                    <img id="image_position_<?php echo $i; ?>" class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['picture']; ?>"/>
                                    <br>
                                    <br>
                                    <span class="blog_post_home_cards_heading">
                                        <h2 id="title_<?php echo $i; ?>">
                                            <a href="<?php echo base_url(); ?>admin/applications_blogs/blog_detail/<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['blog_id']; ?>">
                                                <?php echo html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$i]]['title'])); ?>
                                            </a>
                                        </h2>
                                    </span><!--card heading-->
                                    <div class="blog_post_body_text" id="description_<?php echo $i; ?>">
                                        <?php echo substr(html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$i]]['description'])),0,255)." ....."; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endfor; ?>
                <div class="col-md-3" id="right_column">
                    <?php $j = $i + 1; ?>
                    <?php if (array_key_exists($i, $region_id_blog_id_map)): ?>
                        <div class="col-md-12" style="padding-left: 0px; padding-right: 0px">
                            <div class="blog_post_home_cards"><!--cards-->
                                <button style="z-index: 500; position: relative;" id="button_edit_recipe_<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['blog_id']; ?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_recipe_<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['blog_id']; ?>', '<?php echo $i; ?>')">
                                    Edit
                                </button>
                                <input type="hidden" name="position_of_blog_<?php echo $i; ?>" id="position_of_blog_<?php echo $i; ?>" value="<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['blog_id']; ?>">
                                <img id="image_position_<?php echo $i; ?>" class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['picture']; ?>"/>
                                <br>
                                <br>
                                <span class="blog_post_home_cards_heading">
                                    <h2 id="title_<?php echo $i; ?>">
                                        <a href="<?php echo base_url(); ?>admin/applications_blogs/blog_detail/<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['blog_id']; ?>">
                                            <?php echo html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$i]]['title'])); ?>
                                        </a>
                                    </h2>
                                </span><!--card heading-->
                                <div class="blog_post_body_text" id="description_<?php echo $i; ?>">
                                    <?php echo substr(html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$i]]['description'])),0,255)." ....."; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (array_key_exists($j, $region_id_blog_id_map)): ?>
                        <?php $i++; ?>
                        <div class="col-md-12" style="padding-left: 0px; padding-right: 0px">
                            <div class="blog_post_home_cards"><!--cards-->
                                <button style="z-index: 500; position: relative;" id="button_edit_recipe_<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['blog_id']; ?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_recipe_<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['blog_id']; ?>', '<?php echo $i; ?>')">
                                    Edit
                                </button>
                                <input type="hidden" name="position_of_blog_<?php echo $i; ?>" id="position_of_blog_<?php echo $i; ?>" value="<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['blog_id']; ?>">
                                <img id="image_position_<?php echo $i; ?>" class="img-responsive" src="<?php echo base_url() . BLOG_POST_IMAGE_PATH . $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['picture']; ?>"/>
                                <br>
                                <br>
                                <span class="blog_post_home_cards_heading">
                                    <h2 id="title_<?php echo $i; ?>">
                                        <a href="<?php echo base_url(); ?>admin/applications_blogs/blog_detail/<?php echo $blog_id_blog_info_map[$region_id_blog_id_map[$i]]['blog_id']; ?>">
                                            <?php echo html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$i]]['title'])); ?>
                                        </a>
                                    </h2>
                                </span><!--card heading-->
                                <div class="blog_post_body_text" id="description_<?php echo $i; ?>">
                                    <?php echo substr(html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$i]]['description'])),0,255)." ....."; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class ="col-md-offset-7 col-sm-3">
                <input type="text" class="form-control" id="date_for_show_item" name="date_for_show_item" value=""/>
            </div>
            <div class=" col-sm-2">
                <button id="save_your_setting" onclick="submit_setting();" value="" class="form-control btn button-custom">
                    Submit
                </button>
            </div>
        </div>

        <div class="btn-group" style="padding-left: 10px;">
            <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
        </div>
        <div class="row col-md-12" style="margin-top: 30px;">

        </div>


        <!--<div class="row col-md-12">
            <div class="row form-group">
                <div class="col-sm-6"></div>
                <div class ="col-sm-3">
                    <input type="text" class="form-control" id="date_for_show_item" name="date_for_show_item" value=""/>
                </div>
                <div class ="col-sm-3" >
                    <button id="blog_list_for_home_page" value="" class="form-control btn button-custom pull-right">
                        Submit your List 
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>News Category</th>
                                
                                <th>News Title</th>
                                <th>Created On</th>
                                <th>Select News Item</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_blog_list_for_home_page">
        <?php if (count($blog_list) > 0): ?>
            <?php $i = 1; ?>
            <?php foreach ($blog_list as $blog): ?>
                                            <tr>
                                                <td><?php echo $blog['id']; ?></td>
                                                <td><?php echo $blog['blog_category_name'] ?></td>
                                                
                                                <td><?php echo html_entity_decode(html_entity_decode($blog['title'])); ?></td>
                                                <td><?php echo unix_to_human($blog['created_on']); ?></td>
                                                <td>
                                                    <input id="<?php echo $blog['id'] ?>" class="" type="checkbox" name="item[]" />
                                                </td>
                                            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>-->

    </div>
</div>

<?php $this->load->view("admin/applications/blog_app/modal_edit_blog_for_home_page"); ?>

<script type="text/javascript">
    function openModal(val, id) {
        $('#get_selected_id').val(id);
        $('#modal_edit_blog_home_page').modal('show');
    }
</script>

<script type="text/javascript">
    /*function submit_setting() {
        var selected_date_for_item = $('#date_for_show_item').val();
        if (selected_date_for_item.length == 0)
        {
            alert('please select a date to config your blog item');
            return;
        }
        var position_0 = $('#position_of_blog_0').val();
        var position_1 = $('#position_of_blog_1').val();
        var position_2 = $('#position_of_blog_2').val();
        var position_3 = $('#position_of_blog_3').val();
        var position_4 = $('#position_of_blog_4').val();
        var position_5 = $('#position_of_blog_5').val();
        var position_6 = $('#position_of_blog_6').val();
        var position_7 = $('#position_of_blog_7').val();
//        alert(position_0 + ' ' + position_1 + ' '+ position_6 + ' ' + position_7 );
        var id = $('#panel_dd').val();
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/blogapp/save_selected_blog",
            data: {
                position_of_blog_0: position_0,
                position_of_blog_1: position_1,
                position_of_blog_2: position_2,
                position_of_blog_3: position_3,
                position_of_blog_4: position_4,
                position_of_blog_5: position_5,
                position_of_blog_6: position_6,
                position_of_blog_7: position_7,
                selected_date: selected_date_for_item,
                show_advertise: id
            },
            success: function(data) {
                alert(data['message']);
                if (data['status'] === 1)
                {
                    location.reload();
                }
            }
        });
    }*/
    
    function submit_setting() {
        var show_advertise;
        //update it if you do not want to show advertise
        var selected_date_for_item = $('#date_for_show_item').val();
        if (selected_date_for_item.length == 0)
        {
            alert('please select a date to config your blog item');
            return;
        }        
        var id = $('#panel_dd').val();
        if(id!=2) {
            show_advertise = 0;
        } else {
            show_advertise = 1;
        }
        var region_id_blog_id_map = {};
        // here key1 = region_id, value=blog_id
        var length = <?php echo BLOG_CONFIGURATION_COUNTER; ?>;
        for(var i=0;i<length;i++) {
            region_id_blog_id_map[''+i+''] = $('#position_of_blog_'+i).val();
        }
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/applications_blogs/save_selected_blog",
            data: {
                region_id_blog_id_map:region_id_blog_id_map,
                selected_date: selected_date_for_item,
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
    
    function panel_change(){
        var id = $('#panel_dd').val();
        if(id==2) $('#right_column').hide();
        if(id==1) $('#right_column').show();
    }

    var adv = <?php echo $show_advertise;?>;
    
    if(adv==1) $('#right_column').hide();
</script>