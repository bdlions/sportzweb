<script type="text/javascript">
    $(function() {
        var show_advertise = '<?php echo $show_advertise;?>';
        if(show_advertise == 1){
           $('#side_panel').hide(); 
        }
        $('#input_configuration_date').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#input_configuration_date').text($('#input_configuration_date').data('date'));
            $('#input_configuration_date').datepicker('hide');
        });
        $("#button_submit_category_page_configuration").click(function(){
            var news_category_id = <?php echo $news_category_info['news_category_id'];?>;
            var configuration_date = $('#input_configuration_date').val();
            if(configuration_date.length == 0)
            {
                alert('please select a date to configure your news item');
                return;
            }
            var show_advertise = 1;
            if($('#advertise_selection_option').val() == '<?php echo NEWS_CONFIGURATION_SHOW_ALL?>'){ 
                show_advertise = 0;
            }
            var region_id_news_id_map = {};
            var length = <?php echo NEWS_CONFIGURATION_COUNTER;?>;
            for(var i=1;i<=length;i++)
            {
                region_id_news_id_map['position_'+i] = $('#position_of_news_'+i).val();
            }

            var region_id_is_ignored_map = {};
            for(var i=1;i<=length;i++)
            {
                region_id_is_ignored_map['position_'+i] = ($('#checkbox_'+i).prop('checked')===false)?0:1;
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_news/save_news_category_page_configuration",
                data: {
                    region_id_news_id_map:region_id_news_id_map,
                    region_id_is_ignored_map:region_id_is_ignored_map,
                    show_advertise:show_advertise,
                    news_category_id: news_category_id,
                    selected_date: configuration_date
                },
                success: function(data){
                    alert(data['message']);
                }
            });
        });
    });
    function openModal(val,id) {        
        $('#get_selected_id').val(id);
        $('#modal_edit_news_item_for_category').modal('show');
    }
    function advertise_selection_option_change(){
        var advertise_option_selected_item = $('#advertise_selection_option').val();
        if(advertise_option_selected_item == '<?php echo NEWS_CONFIGURATION_SHOW_ALL?>') $('#side_panel').show();
        if(advertise_option_selected_item == '<?php echo NEWS_CONFIGURATION_SHOW_ADVERTISE?>') $('#side_panel').hide();        
    }
</script>
<div class="panel panel-default">
    <div class="panel-heading">
        <?php echo $news_category_info['title'];?>
        <div class="pull-right">            
            <select name="advertise_selection_option" onchange="advertise_selection_option_change()" id="advertise_selection_option">
                <option value="<?php echo NEWS_CONFIGURATION_SHOW_ALL?>">Show all</option>
                <option <?php if($show_advertise == 1) echo 'selected="selected"'?> value="<?php echo NEWS_CONFIGURATION_SHOW_ADVERTISE?>">Show Advertise</option>                    
            </select>            
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
        <div class="col-md-9">
            <?php if (array_key_exists(0, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[0], $news_id_news_info_map)){?>
            <div class="row" style="padding-bottom: 20px"><!--Greatest news-->
                <div class="col-md-6 col-lg-6">                    
                    <a href="<?php echo base_url() ?>admin/applications_news/news_details/<?php echo $news_id_news_info_map[$region_id_news_id_map[0]]['news_id'];?>">
                        <img id="image_position_1" style="width:280px;" class="img-responsive" src="<?php echo base_url().NEWS_HOME_TOP_LEFT_IMAGE_PATH.$news_id_news_info_map[$region_id_news_id_map[0]]['picture'];?>"/>
                    </a>                    
                </div>
                <button style="z-index: 500;" id="button_edit_news_1" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_1', '1')">
                    Edit
                </button>
                <input type="checkbox" id="checkbox_1" <?php echo $region_id_is_news_ignored_map[0]==1?'checked':''?>/>
                <input type="hidden" name="position_of_news_1" id="position_of_news_1" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[0]]['news_id']) ? $news_id_news_info_map[$region_id_news_id_map[0]]['news_id'] : ''; ?>">
                <input type="hidden" name="get_selected_id" id="get_selected_id" value="">
                <div class="col-md-6 col-lg-6">                    
                    <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php echo $news_id_news_info_map[$region_id_news_id_map[0]]['news_id'];?>">
                        <span class="cus_news_headline">
                            <p id="heading_1"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[0]]['headline']));?></p>
                        </span>
                    </a>
                    <span class="cus_news_descr">
                        <p id="summary_1"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[0]]['summary']));?></p>
                    </span>                    
                </div>
            </div>
            <?php } ?>
            <div class="row" style="padding-bottom: 20px"><!--top news loop...3 news per row-->
                <div class="col-md-4 col-lg-4">
                <?php if (array_key_exists(1, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[1], $news_id_news_info_map)){?>
                    <button style="z-index: 5;position: relative;" id="button_edit_news_2" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_2', '2')">
                        Edit
                    </button>
                    <input type="checkbox" id='checkbox_2' <?php echo $region_id_is_news_ignored_map[1]==1?'checked':''?>/>
                    <input type="hidden" name="position_of_news_2" id="position_of_news_2" value="<?php echo (array_key_exists(1, $region_id_news_id_map)) ? $news_id_news_info_map[$region_id_news_id_map[1]]['news_id'] : ''; ?>">
                    <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(1, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[1]]['news_id']; }?>">
                        <img id="image_position_2" style="width:180px;height:120px;" class="img-responsive" src="<?php if (array_key_exists(1, $region_id_news_id_map)){ echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[1]]['picture'];} ?>"/>
                    </a>
                    <br>                    
                    <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php  if (array_key_exists(1, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[1]]['news_id']; }?>">
                        <span class="cus_news_subheadline">
                            <p id="heading_2"><?php if (array_key_exists(1, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[1]]['headline']));} ?></p>
                        </span>
                    </a>
                    <span class="cus_news_descr">
                        <p id="summary_2"><?php if (array_key_exists(1, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[1]]['summary']));} ?></p>
                    </span>
                <?php } ?>
                </div>
                <div class="col-md-4 col-lg-4">
                <?php if(array_key_exists(2, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[2], $news_id_news_info_map)){ ?>
                    <button style="z-index: 5;position: relative;" id="button_edit_news_3" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_3', '3')">
                        Edit
                    </button>
                    <input type="checkbox" id='checkbox_3' <?php echo $region_id_is_news_ignored_map[2]==1?'checked':''?>/>
                    <input type="hidden" name="position_of_news_3" id="position_of_news_3" value="<?php echo (array_key_exists(2, $region_id_news_id_map))?$news_id_news_info_map[$region_id_news_id_map[2]]['news_id'] : ''; ?>">
                    <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(2, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[2]]['news_id']; }?>">
                        <img id="image_position_3" style="width:180px;height:120px;" class="img-responsive" src="<?php if (array_key_exists(2, $region_id_news_id_map)){ echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[2]]['picture'];} ?>"/>
                    </a>                    
                    <br>
                    <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(2, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[2]]['news_id']; }?>">
                        <span class="cus_news_subheadline">
                            <p id="heading_3">
                                <?php if (array_key_exists(2, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[2]]['headline']));} ?>
                            </p>
                        </span>
                    </a>
                    <span class="cus_news_descr">
                        <p id="summary_3">
                            <?php if (array_key_exists(2, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[2]]['summary']));} ?>
                        </p>
                    </span>
                <?php } ?>
                </div>
                <div class="col-md-4 col-lg-4">
                <?php if(array_key_exists(3, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[3], $news_id_news_info_map)){ ?>
                    <button style="z-index: 5;position: relative;" id="button_edit_news_4" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_4', '4')">
                        Edit
                    </button>
                    <input type="checkbox" id='checkbox_4' <?php echo $region_id_is_news_ignored_map[3]==1?'checked':''?>/>
                    <input type="hidden" name="position_of_news_4" id="position_of_news_4" value="<?php echo (array_key_exists(3, $region_id_news_id_map)) ? $news_id_news_info_map[$region_id_news_id_map[3]]['news_id'] : ''; ?>">
                    <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(3, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[3]]['news_id']; }?>">
                        <img id="image_position_4" style="width:180px;height:120px;" class="img-responsive" src="<?php if (array_key_exists(3, $region_id_news_id_map)){ echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[3]]['picture'];} ?>"/>
                    </a>
                    <br>
                    <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(3, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[3]]['news_id']; }?>">
                        <span class="cus_news_subheadline">
                            <p id="heading_4">
                               <?php if (array_key_exists(3, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[3]]['headline']));} ?>
                            </p>
                        </span>
                    </a>
                    <span class="cus_news_descr">
                        <p id="summary_4">
                            <?php if (array_key_exists(3, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[3]]['summary']));} ?>
                        </p>
                    </span>
                <?php } ?>
                </div>
            </div>
            <div class="row" style="padding-bottom: 10px"><!--small news loop...2 news per row-->
                <?php if(array_key_exists(4, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[4], $news_id_news_info_map)) : ?>
                    <div class="col-md-3 col-lg-3">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_5" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_5', '5')">
                            Edit
                        </button>
                        <input type="checkbox" id='checkbox_5' <?php echo $region_id_is_news_ignored_map[4]==1?'checked':''?>/>
                        <input type="hidden" name="position_of_news_5" id="position_of_news_5" value="<?php echo (array_key_exists(4, $region_id_news_id_map)) ? $news_id_news_info_map[$region_id_news_id_map[4]]['news_id'] : ''; ?>">
                        <?php //if (array_key_exists(4, $region_id_news_id_map)) : ?>
                            <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(4, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[4]]['news_id']; }?>">
                                <img id="image_position_5" style="width:150px;height:100px;" class="img-responsive" src="<?php if (array_key_exists(4, $region_id_news_id_map)){ echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[4]]['picture'];} ?>"/>
                            </a>
                        <?php //endif; ?>
                    </div>
                    <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
                        <?php //if (array_key_exists(4, $region_id_news_id_map)) : ?>
                            <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(4, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[4]]['news_id']; }?>">
                                <span class="cus_news_subheadline">
                                    <p id="heading_5">
                                        <?php if (array_key_exists(4, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[4]]['headline']));} ?>
                                    </p>
                                </span>
                            </a>
                        <?php //endif; ?>
                    </div>
                <?php endif; ?>
                <?php if(array_key_exists(5, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[5], $news_id_news_info_map)) : ?>
                    <div class="col-md-3 col-lg-3">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_6" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_6', '6')">
                            Edit
                        </button>
                        <input type="checkbox" id='checkbox_6' <?php echo $region_id_is_news_ignored_map[5]==1?'checked':''?>/>
                        <input type="hidden" name="position_of_news_6" id="position_of_news_6" value="<?php echo (array_key_exists(5, $region_id_news_id_map)) ? $news_id_news_info_map[$region_id_news_id_map[5]]['news_id'] : ''; ?>">
                        <?php //if (array_key_exists(5, $region_id_news_id_map)) : ?>
                            <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(5, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[5]]['news_id']; }?>">
                                <img id="image_position_6" style="width:150px;height:100px;" class="img-responsive" src="<?php if (array_key_exists(5, $region_id_news_id_map)){ echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[5]]['picture'];} ?>"/>
                            </a>
                        <?php //endif; ?>
                    </div>
                    <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
                        <?php //if (array_key_exists(4, $region_id_news_id_map)) : ?>
                            <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(5, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[5]]['news_id']; }?>">
                                <span class="cus_news_subheadline">
                                    <p id="heading_6">
                                         <?php if (array_key_exists(5, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[5]]['headline']));} ?>
                                    </p>
                                </span>
                            </a>
                        <?php //endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row" style="padding-bottom: 10px"><!--small news loop...2 news per row-->
                <?php if(array_key_exists(6, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[6], $news_id_news_info_map)) : ?>
                    <div class="col-md-3 col-lg-3">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_7" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_7', '7')">
                            Edit
                        </button>
                        <input type="checkbox" id='checkbox_7' <?php echo $region_id_is_news_ignored_map[6]==1?'checked':''?>/>
                        <input type="hidden" name="position_of_news_7" id="position_of_news_7" value="<?php echo (array_key_exists(6, $region_id_news_id_map)) ? $news_id_news_info_map[$region_id_news_id_map[6]]['news_id'] : ''; ?>">
                        <?php //if (array_key_exists(6, $region_id_news_id_map)) : ?>
                            <a href="<?php echo base_url()?>admin/applications/applications_news/news_item/<?php if (array_key_exists(6, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[6]]['news_id']; }?>">
                                <img id="image_position_7" style="width:150px;height:100px;" class="img-responsive" src="<?php if (array_key_exists(6, $region_id_news_id_map)){ echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[6]]['picture'];} ?>"/>
                            </a>
                        <?php //endif; ?>
                    </div>
                    <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
                        <?php //if (array_key_exists(6, $region_id_news_id_map)) : ?>
                            <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(6, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[6]]['news_id']; }?>">
                                <span class="cus_news_subheadline">
                                    <p id="heading_7"><?php if (array_key_exists(6, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[6]]['headline']));} ?></p>
                                </span>
                            </a>
                        <?php //endif; ?>
                    </div>
                <?php endif; ?>
                <?php if(array_key_exists(7, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[7], $news_id_news_info_map)) : ?>
                    <div class="col-md-3 col-lg-3">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_8" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_8', '8')">
                            Edit
                        </button>
                        <input type="checkbox" id='checkbox_8' <?php echo $region_id_is_news_ignored_map[7]==1?'checked':''?>/>
                        <input type="hidden" name="position_of_news_8" id="position_of_news_8" value="<?php echo (array_key_exists(7, $region_id_news_id_map)) ? $news_id_news_info_map[$region_id_news_id_map[7]]['news_id'] : ''; ?>">
                        <?php //if (array_key_exists(7, $region_id_news_id_map)) : ?>
                            <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(7, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[7]]['news_id']; }?>">
                                <img id="image_position_8" style="width:150px;height:100px;" class="img-responsive" src="<?php if (array_key_exists(7, $region_id_news_id_map)){ echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[7]]['picture'];} ?>"/>
                            </a>
                        <?php //endif; ?>
                    </div>
                    <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
                        <?php //if (array_key_exists(7, $region_id_news_id_map)) : ?>
                            <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(7, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[7]]['news_id']; }?>">
                                <span class="cus_news_subheadline">
                                    <p id="heading_8">
                                        <?php if (array_key_exists(7, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[7]]['headline']));} ?></p>
                                </span>
                            </a>
                        <?php //endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row" style="padding-bottom: 10px; padding-top: 30px"><!--small news area-->
                <div class="col-md-8 col-lg-8"><!--small news loop...2 news per row-->
                    <div class="row">
                        <?php if(array_key_exists(8, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[8], $news_id_news_info_map)) : ?>
                            <div class="col-md-6 col-lg-6">
                                <button style="z-index: 5;position: relative;" id="button_edit_news_9>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_9', '9')">
                                    Edit
                                </button>
                                <input type="checkbox" id='checkbox_9' <?php echo $region_id_is_news_ignored_map[8]==1?'checked':''?>/>
                                <input type="hidden" name="position_of_news_9" id="position_of_news_9" value="<?php echo (array_key_exists(8, $region_id_news_id_map)) ? $news_id_news_info_map[$region_id_news_id_map[8]]['news_id'] : ''; ?>">
                                <?php //if (array_key_exists(8, $region_id_news_id_map)) : ?>
                                    <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(8, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[8]]['news_id']; }?>">
                                        <span class="cus_news_smallheadline">
                                            <p id="heading_9"><?php if (array_key_exists(8, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[8]]['headline']));} ?></p>
                                        </span>
                                    </a>
                                    <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(8, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[8]]['news_id']; }?>">
                                        <span class="cus_news_descr">
                                            <p id="summary_9"><?php if (array_key_exists(8, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[8]]['summary']));} ?></p>
                                        </span>
                                    </a>
                                <?php //endif; ?>
                            </div>
                        <?php endif; ?>                        
                        <?php if(array_key_exists(9, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[9], $news_id_news_info_map)) : ?>
                            <div class="col-md-6 col-lg-6">
                                <button style="z-index: 5;position: relative;" id="button_edit_news_10" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_10', '10')">
                                    Edit
                                </button>
                                <input type="checkbox" id='checkbox_10' <?php echo $region_id_is_news_ignored_map[9]==1?'checked':''?>/>
                                <input type="hidden" name="position_of_news_10" id="position_of_news_10" value="<?php echo (array_key_exists(9, $region_id_news_id_map)) ? $news_id_news_info_map[$region_id_news_id_map[9]]['news_id'] : ''; ?>">
                                <?php //if (array_key_exists(9, $region_id_news_id_map)) : ?>
                                    <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(9, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[9]]['news_id']; }?>">
                                        <span class="cus_news_smallheadline">
                                            <p id="heading_10"><?php if (array_key_exists(9, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[9]]['headline']));} ?></p>
                                        </span>
                                    </a>
                                    <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(9, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[9]]['news_id']; }?>">
                                        <span  class="cus_news_descr">
                                            <p id="summary_10">
                                                <?php if (array_key_exists(9, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[9]]['summary']));} ?>
                                            </p>
                                        </span>
                                    </a>
                                <?php //endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <?php if(array_key_exists(10, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[10], $news_id_news_info_map)) : ?>
                            <div class="col-md-6 col-lg-6">
                                <button style="z-index: 5;position: relative;" id="button_edit_news_11" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_11', '11')">
                                    Edit
                                </button>
                                <input type="checkbox" id='checkbox_11' <?php echo $region_id_is_news_ignored_map[10]==1?'checked':''?>/>
                                <input type="hidden" name="position_of_news_11" id="position_of_news_11" value="<?php echo (array_key_exists(10, $region_id_news_id_map)) ? $news_id_news_info_map[$region_id_news_id_map[10]]['news_id'] : ''; ?>">
                                <?php //if (array_key_exists(10, $region_id_news_id_map)) : ?>
                                    <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(10, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[10]]['news_id']; }?>">
                                        <span class="cus_news_smallheadline">
                                            <p id="heading_11"><?php if (array_key_exists(10, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[10]]['headline']));} ?></p>
                                        </span>
                                    </a>
                                    <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(10, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[10]]['news_id']; }?>">
                                        <span class="cus_news_descr">
                                            <p id="summary_11">
                                                <?php if (array_key_exists(10, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[10]]['summary']));} ?>
                                            </p>
                                        </span>
                                    </a>
                                <?php //endif; ?>
                            </div>
                        <?php endif; ?>                        
                        <?php if(array_key_exists(11, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[11], $news_id_news_info_map)) : ?>
                            <div class="col-md-6 col-lg-6">
                                <button style="z-index: 5;position: relative;" id="button_edit_news_12" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_12', '12')">
                                    Edit
                                </button>
                                <input type="checkbox" id="checkbox_12" <?php echo $region_id_is_news_ignored_map[11]==1?'checked':''?>/>
                                <input type="hidden" name="position_of_news_12" id="position_of_news_12" value="<?php echo (array_key_exists(11, $region_id_news_id_map)) ? $news_id_news_info_map[$region_id_news_id_map[11]]['news_id'] : ''; ?>">
                                <?php //if (array_key_exists(11, $region_id_news_id_map)) : ?>
                                    <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(11, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[11]]['news_id']; }?>">
                                        <span class="cus_news_smallheadline">
                                            <p id="heading_12"><?php if (array_key_exists(11, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[11]]['headline']));} ?></p>
                                        </span>
                                    </a>
                                    <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(11, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[11]]['news_id']; }?>">
                                        <span class="cus_news_descr">
                                            <p id="summary_12">
                                                <?php if (array_key_exists(11, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[11]]['summary']));} ?>
                                            </p>
                                        </span>
                                    </a>
                                <?php //endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                <?php if(array_key_exists(12, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[12], $news_id_news_info_map)) : ?>
                    <button style="z-index: 5;position: relative;" id="button_edit_news_13" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_13', '13')">
                        Edit
                    </button>
                    <input type="checkbox" id='checkbox_13' <?php echo $region_id_is_news_ignored_map[12]==1?'checked':''?>/>
                    <input type="hidden" name="position_of_news_13" id="position_of_news_13" value="<?php echo (array_key_exists(12, $region_id_news_id_map)) ? $news_id_news_info_map[$region_id_news_id_map[12]]['news_id'] : ''; ?>">
                    <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(12, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[12]]['news_id']; }?>">
                        <img style="min-width: 200px;" id="image_position_13" class="img-responsive" src="<?php if (array_key_exists(12, $region_id_news_id_map)){ echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[12]]['picture'];} ?>"/>
                    </a>
                    <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists(12, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[12]]['news_id']; }?>">
                        <span class="cus_news_subheadline" id="heading_13">
                            <p>
                                <?php if (array_key_exists(12, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[12]]['headline']));} ?>
                            </p>
                        </span>
                    </a>
                <?php endif; ?>
                </div>
            </div>            
        </div><!--main body end-->
        <div class="col-md-3" id="side_panel">
            <?php for($i=14;$i<18;$i++){?>
                <?php if(array_key_exists($i-1, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[$i-1], $news_id_news_info_map)) : ?>
                <div class="row col-md-12 col-lg-12">
                    <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $i;?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $i;?>', '<?php echo $i;?>')">
                        Edit
                    </button>
                    <input type="checkbox" id='checkbox_<?php echo $i;?>' <?php echo $region_id_is_news_ignored_map[$i-1]==1?'checked':''?>/>
                    <input type="hidden" name="position_of_news_<?php echo $i;?>" id="position_of_news_<?php echo $i;?>" value="<?php echo (array_key_exists($i-1, $region_id_news_id_map)) ? $news_id_news_info_map[$region_id_news_id_map[$i-1]]['news_id'] : ''; ?>">
                    <?php //if (array_key_exists(1, $region_id_news_id_map)) : ?>
                        <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php if (array_key_exists($i-1, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[$i-1]]['news_id']; }?>">
                            <img id="image_position_<?php echo $i;?>" style="width:180px;height:120px;" class="img-responsive" src="<?php if (array_key_exists($i-1, $region_id_news_id_map)){ echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[$i-1]]['picture'];} ?>"/>
                        </a>
                    <?php //endif; ?>
                    <br>
                    <?php //if (array_key_exists(1, $region_id_news_id_map)) : ?>
                        <a href="<?php echo base_url()?>admin/applications_news/news_details/<?php  if (array_key_exists($i-1, $region_id_news_id_map)){ echo $news_id_news_info_map[$region_id_news_id_map[$i-1]]['news_id']; }?>">
                            <span class="cus_news_subheadline">
                                <p id="heading_<?php echo $i;?>"><?php if (array_key_exists($i-1, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[$i-1]]['headline']));} ?></p>
                            </span>
                        </a>
<!--                        <span class="cus_news_descr">
                            <p id="summary_<?php echo $i;?>"><?php if (array_key_exists($i-1, $region_id_news_id_map)){ echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[$i-1]]['summary']));} ?></p>
                        </span>-->
                    <?php //endif; ?>
                </div>
                <?php endif;  ?>
            <?php }?>
        </div>
        </div>
        <div class="row">
            <div class ="col-md-3 pull-left">
                <input type="button" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
            </div>
            <div class ="col-md-offset-4 col-md-5">
                <div class="row">
                    <div class ="col-md-8" style="z-index: 6">
                        <input type="text" class="form-control" id="input_configuration_date" name="input_configuration_date" value=""/>
                    </div>
                    <div class ="col-md-4">
                        <button id="button_submit_category_page_configuration" name="button_submit_category_page_configuration" value="" class="form-control btn button-custom">
                            Submit
                        </button>    
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
<?php $this->load->view("admin/applications/news_app/modal_edit_news_item_for_category"); ?>