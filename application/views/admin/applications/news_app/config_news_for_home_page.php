<?php //echo '<pre/>';print_r($region_id_news_id_map[$news_id_news_info_map[1]]['news_id']]);exit;?>
<script type="text/javascript">
    /* this is section is for old system */
    /*$(function() {
        $("#news_list_for_home_page").on("click", function() {
            var selected_date_for_item = $('#date_for_show_item').val();
            //alert(selected_date_for_item);
            if(selected_date_for_item.length == 0)
            {
                alert('please select a date to config your news item');
            }
            var selected_news_array = Array();

            $("#tbody_news_list_for_home_page tr").each(function() {
                var lastColumn = $(this).find('td:last');
                var newsListCheckBox = $(lastColumn).find("input:checkbox");
                if($(newsListCheckBox).prop('checked') == true){
                    selected_news_array.push(newsListCheckBox.attr('id'));
                } 
            });
            
            if(selected_news_array.length == 13)
            {
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "admin/newsapp/news_list_for_home_page",
                    data: {
                        selected_news_array_list: JSON.stringify(selected_news_array),
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
            } else if(selected_news_array.length > 13)
            {
                alert('Please select 13 news for your home page');
            } else 
            {
                alert('Please select 13 news for your home page');
            }
        });
    });*/
</script> 
<script type="text/javascript">
    $(function() {
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
                <select name="sports" onchange="panel_change()" id="panel">
                    <option value="1">Show all</option>
                    <option value="2">Show Advertise</option>
                    <option value="3">Hide</option>
                </select>
            </form>
        </div>
    </div>
    <div class="panel-body">
        
        
        <div class="row col-md-9">
            <?php //if(count($news_id_news_info_map) >= 13): ?>
            <?php if(array_key_exists(0, $region_id_news_id_map)) : ?>
                <div class="row" style="padding-bottom: 20px"><!--Greatest news-->
                    <div class="col-md-6 col-lg-6">
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[0]]['news_id']; ?>">
                            <img id="image_position_1" style="width:280px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_TOP_LEFT_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[0]]['picture'] ?>"/>
                        </a>
                    </div>
                    <button style="z-index: 500;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[0]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[0]]['news_id'];?>','1')">
                        Edit
                    </button>
                        <input type="hidden" name="position_of_news_1" id="position_of_news_1" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[0]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[0]]['news_id']:'';?>">
                        <input type="hidden" name="get_selected_id" id="get_selected_id" value="">
                    <div class="col-md-6 col-lg-6">
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[0]]['news_id']; ?>">
                            <span class="cus_news_headline">
                                <p id="heading_1"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[0]]['headline']));?></p>
                            </span>
                        </a>
                        <span class="cus_news_descr">
                            <p id="summary_1"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[0]]['summary']));?></p>
                        </span>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row" style="padding-bottom: 20px"><!--top news loop...3 news per row-->
                <?php if(array_key_exists(1, $region_id_news_id_map)) : ?>
                    <div class="col-md-4 col-lg-4">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[1]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[1]]['news_id'];?>','2')">
                            Edit
                        </button>

                        <input type="hidden" name="position_of_news_2" id="position_of_news_2" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[1]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[1]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[1]]['news_id']; ?>">
                            <img id="image_position_2" style="width:180px;height:120px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[1]]['picture'] ?>"/>
                        </a>
                        <br>
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[1]]['news_id']; ?>">
                            <span class="cus_news_subheadline">
                                <p id="heading_2"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[1]]['headline']));?></p>
                            </span>
                        </a>
                        <span class="cus_news_descr">
                            <p id="summary_2"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[1]]['summary']));?></p>
                        </span>
                    </div>
                <?php endif; ?>
                
                <?php if(array_key_exists(2, $region_id_news_id_map)) : ?>
                    <div class="col-md-4 col-lg-4">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[2]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[2]]['news_id'];?>','3')">
                            Edit
                        </button>

                        <input type="hidden" name="position_of_news_3" id="position_of_news_3" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[2]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[2]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[2]]['news_id']; ?>">
                            <img id="image_position_3" style="width:180px;height:120px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[2]]['picture'] ?>"/>
                        </a>
                        <br>
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[2]]['news_id']; ?>">
                            <span class="cus_news_subheadline">
                                <p id="heading_3">
                                    <?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[2]]['headline']))?>
                                </p>
                            </span>
                        </a>
                        <span class="cus_news_descr">
                            <p id="summary_3"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[2]]['summary']));?></p>
                        </span>
                    </div>
                <?php endif;  ?>
                
                <?php if(array_key_exists(3, $region_id_news_id_map)) : ?>
                    <div class="col-md-4 col-lg-4">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[3]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[3]]['news_id'];?>','4')">
                            Edit
                        </button>

                        <input type="hidden" name="position_of_news_4" id="position_of_news_4" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[3]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[3]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[3]]['news_id']; ?>">
                            <img id="image_position_4" style="width:180px;height:120px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[3]]['picture'] ?>"/>
                        </a>
                        <br>
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[3]]['news_id']; ?>">
                            <span class="cus_news_subheadline">
                                <p id="heading_4">
                                    <?php echo $news_id_news_info_map[$region_id_news_id_map[3]]['headline']?>
                                </p>
                            </span>
                        </a>
                        <span class="cus_news_descr">
                            <p id="summary_4">
                                <?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[3]]['summary']));?>
                            </p>
                        </span>
                    </div>
                <?php endif;  ?>
            </div>
            
            <div class="row" style="padding-bottom: 10px"><!--small news loop...2 news per row-->
                <?php if(array_key_exists(4, $region_id_news_id_map)) : ?>
                    <div class="col-md-3 col-lg-3">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[4]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[4]]['news_id'];?>','5')">
                            Edit
                        </button>

                        <input type="hidden" name="position_of_news_5" id="position_of_news_5" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[4]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[4]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[4]]['news_id']; ?>">
                            <img id="image_position_5" style="width:150px;height:100px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[4]]['picture'] ?>"/>
                        </a>
                    </div>
                    <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[4]]['news_id']; ?>">
                            <span class="cus_news_subheadline">
                                <p id="heading_5">
                                    <?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[4]]['headline']));?>
                                </p>
                            </span>
                        </a>
                    </div>
                <?php endif; ?>
                
                <?php if(array_key_exists(5, $region_id_news_id_map)) : ?>
                    <div class="col-md-3 col-lg-3">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[5]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[5]]['news_id'];?>','6')">
                            Edit
                        </button>

                        <input type="hidden" name="position_of_news_6" id="position_of_news_6" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[5]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[5]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[5]]['news_id']; ?>">
                            <img id="image_position_6" style="width:150px;height:100px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[5]]['picture'] ?>"/>
                        </a>
                    </div>
                    <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[5]]['news_id']; ?>">
                            <span class="cus_news_subheadline">
                                <p id="heading_6">
                                    <?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[5]]['headline']));?>
                                </p>
                            </span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row" style="padding-bottom: 10px"><!--small news loop...2 news per row-->
                <?php if(array_key_exists(6, $region_id_news_id_map)) : ?>
                    <div class="col-md-3 col-lg-3">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[6]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[6]]['news_id'];?>','7')">
                            Edit
                        </button>

                        <input type="hidden" name="position_of_news_7" id="position_of_news_7" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[6]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[6]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[6]]['news_id']; ?>">
                            <img id="image_position_7" style="width:150px;height:100px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[6]]['picture'] ?>"/>
                        </a>
                    </div>
                    <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[6]]['news_id']; ?>">
                            <span class="cus_news_subheadline">
                                <p id="heading_7"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[6]]['headline']));?></p>
                            </span>
                        </a>
                    </div>
                <?php endif; ?>
                
                <?php if(array_key_exists(7, $region_id_news_id_map)) : ?>
                    <div class="col-md-3 col-lg-3">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[7]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[7]]['news_id'];?>','8')">
                            Edit
                        </button>
                        <input type="hidden" name="position_of_news_8" id="position_of_news_8" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[7]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[7]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[7]]['news_id']; ?>">
                            <img id="image_position_8" style="width:150px;height:100px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[7]]['picture'] ?>"/>
                        </a>
                    </div>
                    <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[7]]['news_id']; ?>">
                            <span class="cus_news_subheadline">
                                <p id="heading_8"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[7]]['headline']));?></p>
                            </span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row" style="padding-bottom: 10px; padding-top: 30px"><!--small news area-->
                <div class="col-md-8 col-lg-8"><!--small news loop...2 news per row-->
                    <div class="row">
                        <?php if(array_key_exists(8, $region_id_news_id_map)) : ?>
                            <div class="col-md-6 col-lg-6">
                                <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[8]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[8]]['news_id'];?>','9')">
                                Edit
                            </button>
                            <input type="hidden" name="position_of_news_9" id="position_of_news_9" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[8]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[8]]['news_id']:'';?>">
                                <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[8]]['news_id']; ?>">
                                    <span class="cus_news_smallheadline">
                                        <p id="heading_9"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[8]]['headline']));?></p>
                                    </span>
                                </a>
                                <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[8]]['news_id']; ?>">
                                    <span class="cus_news_descr">
                                        <p id="summary_9"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[8]]['summary']));?></p>
                                    </span>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(array_key_exists(9, $region_id_news_id_map)) : ?>
                            <div class="col-md-6 col-lg-6">
                                <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[9]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[9]]['news_id'];?>','10')">
                                    Edit
                                </button>
                                <input type="hidden" name="position_of_news_10" id="position_of_news_10" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[9]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[9]]['news_id']:'';?>">
                                <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[9]]['news_id']; ?>">
                                    <span class="cus_news_smallheadline">
                                        <p id="heading_10"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[9]]['headline'])) ;?></p>
                                    </span>
                                </a>
                                <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[9]]['news_id']; ?>">
                                    <span  class="cus_news_descr">
                                        <p id="summary_10"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[9]]['summary']));?></p>
                                    </span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <?php if(array_key_exists(10, $region_id_news_id_map)) : ?>
                            <div class="col-md-6 col-lg-6">
                                <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[10]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[10]]['news_id'];?>','11')">
                                    Edit
                                </button>
                                <input type="hidden" name="position_of_news_11" id="position_of_news_11" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[10]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[10]]['news_id']:'';?>">
                                <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[10]]['news_id']; ?>">
                                    <span class="cus_news_smallheadline">
                                        <p id="heading_11"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[10]]['headline']));?></p>
                                    </span>
                                </a>
                                <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[10]]['news_id']; ?>">
                                    <span class="cus_news_descr">
                                        <p id="summary_11"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[10]]['summary']));?></p>
                                    </span>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(array_key_exists(11, $region_id_news_id_map)) : ?>
                            <div class="col-md-6 col-lg-6">
                                <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[11]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[11]]['news_id'];?>','12')">
                                    Edit
                                </button>
                                <input type="hidden" name="position_of_news_12" id="position_of_news_12" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[11]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[11]]['news_id']:'';?>">
                                <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[11]]['news_id']; ?>">
                                    <span class="cus_news_smallheadline">
                                        <p id="heading_12"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[11]]['headline']));?></p>
                                    </span>
                                </a>
                                <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[11]]['news_id']; ?>">
                                    <span class="cus_news_descr">
                                        <p id="summary_12"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[11]]['summary']));?></p>
                                    </span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if(array_key_exists(12, $region_id_news_id_map)) : ?>
                    <div class="col-md-4 col-lg-4">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[12]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[12]]['news_id'];?>','13')">
                            Edit
                        </button>
                        <input type="hidden" name="position_of_news_13" id="position_of_news_13" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[12]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[12]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[12]]['news_id']; ?>">
                            <img id="image_position_13" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[12]]['picture'] ?>"/>
                        </a>
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[12]]['news_id']; ?>">
                            <span class="cus_news_subheadline" id="heading_13">
                                <p>
                                    <?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[12]]['headline']));?>
                                </p>
                            </span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <?php //endif;?>
        </div>
        <div class="col-md-3" id="side_panel">
            <?php for($fi=0;$fi<4;$fi++):?>
                <?php if(array_key_exists(13+$fi, $region_id_news_id_map)) : ?>
                    <div class="col-md-12 col-lg-12">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[13+$fi]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[13+$fi]]['news_id'];?>','<?php echo (14+$fi)?>')">
                            Edit
                        </button>
                        <input type="hidden" name="position_of_news_<?php echo 14+$fi;?>" id="position_of_news_<?php echo 14+$fi;?>" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[13+$fi]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[13+$fi]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[13+$fi]['id']; ?>">
                            <img id="image_position_<?php echo 14+$fi;?>" style="width:180px;height:120px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[13+$fi]]['picture'] ?>"/>
                        </a>
                        <br>
                        <a href="<?php echo base_url() . 'admin/newsapp/news_details/'.$news_id_news_info_map[$region_id_news_id_map[13+$fi]]['news_id']; ?>">
                            <span class="cus_news_subheadline">
                                <p id="heading_<?php echo 14+$fi;?>">
                                    <?php echo $news_id_news_info_map[$region_id_news_id_map[13+$fi]]['headline']?>
                                </p>
                            </span>
                        </a>
                        <span class="cus_news_descr">
                            <p id="summary_<?php echo 14+$fi;?>">
                                <?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[13+$fi]]['summary']));?>
                            </p>
                        </span>
                    </div>
                <?php endif;  ?>
            <?php endfor;?>
        </div>
        
            
            
        <div class="row col-md-12">
            <div class ="col-md-6 pull-left">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="goBackByURL('<?php echo base_url(); ?>admin/newsapp')" class="form-control btn button-custom">
            </div>
            <div class ="row col-md-6 pull-right">
                <div class ="col-md-8" style="z-index: 6">
                    <input type="text" class="form-control" id="date_for_show_item" name="date_for_show_item" value=""/>
                </div>
                <div class ="col-md-4">
                    <button id="save_your_setting" onclick="submit_setting();" value="" class="form-control btn button-custom">
                        Submit
                    </button>    
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("admin/applications/news_app/modal_edit_news_item_home_page"); ?>

<script type="text/javascript">
function openModal(val,id) {
    $('#get_selected_id').val(id);
    alert($('#get_selected_id').val());
    $('#modal_edit_news_item_home_page').modal('show');
}
</script>
<script type="text/javascript">
 
    function submit_setting() {       
        //take this value from dropdown
         
        var is_hide_advertisement = 0;
        
        
         // Problem
        var id = $('#panel').val();
        
        if(id==3) is_hide_advertisement = 1;
        
        var selected_date_for_item = $('#date_for_show_item').val();
        
        if(selected_date_for_item.length == 0)
        {
            alert('please select a date to config your news item');
            return;
        }
        //I have created sample key value pair array, use this array to send data
        var region_id_news_id_map = {};
        var length = <?php echo NEWS_CONFIGURATION_COUNTER?>;
        for(var i=1;i<=length;i++)
        {
            region_id_news_id_map['position_'+i] = $('#position_of_news_'+i).val();
        }
        
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "admin/newsapp/save_selected_news",
            data: {
                region_id_news_id_map:region_id_news_id_map,
                is_hide_advertisement:is_hide_advertisement,
                selected_date_for_item: selected_date_for_item
            },
            success: function(data){
                alert(data['message']);
            }
        });
    }
</script>

<script type="text/javascript">
    var a = <?php echo $show_advertise;?>;
    if(a == 1){
       $('#side_panel').hide();
       $('select option[value="3"]').attr("selected",true);  
    }
    
    function panel_change(){
        var id = $('#panel').val();
        if(id==3) $('#side_panel').hide();
        if(id==1) $('#side_panel').show();
    }
</script>