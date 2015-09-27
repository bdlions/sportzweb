<script type="text/javascript">
    $(function () {
        var id = <?php echo $show_advertise; ?>;
        if (id == 1) {
            $('select option[value="3"]').attr("selected", true);            
        }
        else
        {
            $('select option[value="1"]').attr("selected", true);
        }
        panel_change();
        $('#date_for_show_item').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function (ev) {
            $('#date_for_show_item').text($('#date_for_show_item').data('date'));
            $('#date_for_show_item').datepicker('hide');
        });
    });
</script>
<script type="text/javascript">
    function submit_setting() {
        var show_advertise;
        var configuration_date = $('#date_for_show_item').val();
        configuration_date = convert_date_from_user_to_db(configuration_date);
        if (configuration_date.length === 0)
        {
            var message = "please select a date to config your blog item";
            print_common_message(message);
            return;
        }
        var id = $('#panel_dd').val();
        if (id != 3) {
            show_advertise = 0;
        } else {
            show_advertise = 1;
        }
        var region_id_blog_id_map = {};
        var length = <?php echo BLOG_CONFIGURATION_COUNTER; ?>;
        for (var i = 0; i < length; i++) {
            region_id_blog_id_map['' + i + ''] = $('#position_of_blog_' + i).val();
        }
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/applications_blogs/save_selected_blog",
            data: {
                region_id_blog_id_map: region_id_blog_id_map,
                selected_date: configuration_date,
                show_advertise: show_advertise
            },
            success: function (data) {
                var message = data['message'];
                print_common_message(message);
                if (data['status'] === 1)
                {
                    location.reload();
                }
            }
        });
    }

    function panel_change() {
        var id = $('#panel_dd').val();
        if (id == 1)
            $('#right_column').show();
        else if (id == 2 || id == 3)
            $('#right_column').hide();        
    }
    
    function openModal(val, id) {
        $('#get_selected_id').val(id);
        $('#modal_edit_blog_home_page').modal('show');
    }
</script>

<div class="panel panel-default">
    <div class="panel-heading">
        Blog List
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
                                        <?php echo substr(strip_tags(html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$i]]['description']))), 0, 255) . " ....."; ?>
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
                                        <?php echo substr(strip_tags(html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$i]]['description']))), 0, 255) . " ....."; ?>
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
                                    <?php echo substr(strip_tags(html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$i]]['description']))), 0, 255) . " ....."; ?>
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
                                    <?php echo substr(strip_tags(html_entity_decode(html_entity_decode($blog_id_blog_info_map[$region_id_blog_id_map[$i]]['description']))), 0, 255) . " ....."; ?>
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
    </div>
</div>
<?php $this->load->view("admin/applications/blog_app/modal_edit_blog_for_home_page"); ?>
