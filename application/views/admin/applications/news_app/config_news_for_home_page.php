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
        $("#button_submit_home_page_configuration").click(function(){
            var configuration_date = $('#input_configuration_date').val();
            if(configuration_date.length == 0)
            {
               // alert('please select a date to configure your news item');
               var message = "please select a date to configure your news item";
                print_common_message(message);
                return;
            }
            var show_advertise = 1;
            if($('#advertise_selection_option').val() == '<?php echo NEWS_CONFIGURATION_SHOW_ALL?>'){ 
                show_advertise = 0;
            }
            var region_id_news_id_map = {};
            var length = <?php echo NEWS_CONFIGURATION_COUNTER?>;
            for(var i=1;i<=length;i++)
            {
                region_id_news_id_map['position_'+i] = $('#position_of_news_'+i).val();
            }
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_news/save_news_home_page_configuration",
                data: {
                    region_id_news_id_map:region_id_news_id_map,
                    show_advertise:show_advertise,
                    configuration_date: configuration_date
                },
                success: function(data){
                    var message = data['message'];
                    print_common_message(message);
                }
            });
        });
    });
    function selected_news_id(selected_array,news_id){
            if(selected_array.length == 1) {
                
                var present_value = $('#get_selected_id').val();
                var id = '#position_of_news_'+present_value;  
                var position = $(id+"").val(news_id);
                var position_array = [];
                var length = <?php echo NEWS_CONFIGURATION_COUNTER;?>;
                var panel = $('#panel').val();
                if(panel==3) length = length - 4;
                for(var i=1;i<=length;i++)
                {
                    position_array[i] = $('#position_of_news_'+i).val();
                }
                
                for(var i=1;i<=length;i++)
                {
                    if(i != present_value) continue;
                    for(var j=1;j<=length;j++)
                    {
                        if(i == j) continue;
                        if(news_id == position_array[j])
                        {
                           // alert('This news already selected in one position');
                            var message = "This news already selected in one position";
                            print_common_message(message);
                            return;
                        }
                    }
                }
                 
                
                
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "admin/applications_news/get_selected_news_data",
                    data: {
                        news_id: news_id
                    },
                    success: function(data) {
                        var img_position = $("#image_position_" + present_value);
                        
                        if(img_position != undefined){
                            img_position.attr("src", "<?php echo base_url().NEWS_IMAGE_PATH;?>" + data.picture.replace(/(\r\n|\n|\r)/gm,""));
                        }
                        
                        var heading_ = $("#heading_" + present_value);
                        if(heading_ != undefined){
                            //alert($("<div/>").html($("<div/>").html(data.headline).text()).text());
                            heading_.text($("<div/>").html($("<div/>").html(data.headline).text()).text().replace(/(<([^>]+)>)/ig, ""));
                        }
                        
                        var summaray_ = $("#summary_" + present_value);
                        if(summaray_ != undefined){
                            //summaray_.text(data.summary);
                            summaray_.text($("<div/>").html($("<div/>").html(data.summary).text()).text().replace(/(<([^>]+)>)/ig, ""));
                        }
                    }
                });
                $('#common_modal_news_list').modal('hide');
            } else {
                //alert('You can only select one news for this position');
                 var message = "You can only select one news for this position";
                 print_common_message(message);
                return ;
            }
        
        }
</script>
<script type="text/javascript">
    function openModal(val,id) {
        $('#hidden_field_for_key').val(<?php echo NEWS_MANAGE_HOME_PAGE_KEY; ?> );
        $('#get_selected_id').val(id);
        $('#common_modal_news_list').modal('show');
    }
    function advertise_selection_option_change(){
        var advertise_option_selected_item = $('#advertise_selection_option').val();
        if(advertise_option_selected_item == '<?php echo NEWS_CONFIGURATION_SHOW_ALL?>') $('#side_panel').show();
        if(advertise_option_selected_item == '<?php echo NEWS_CONFIGURATION_SHOW_ADVERTISE?>') $('#side_panel').hide();        
    }
</script>
<div class="panel panel-default">
    <div class="panel-heading">
        News List
        <div class="pull-right">            
            <select name="advertise_selection_option" onchange="advertise_selection_option_change()" id="advertise_selection_option">
                <option value="<?php echo NEWS_CONFIGURATION_SHOW_ALL?>">Show all</option>
                <option <?php if($show_advertise == 1) echo 'selected="selected"'?> value="<?php echo NEWS_CONFIGURATION_SHOW_ADVERTISE?>">Show Advertise</option>                    
            </select>            
        </div>
    </div>
    <div class="panel-body">
        <div class="row col-md-9">
            <?php if(array_key_exists(0, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[0], $news_id_news_info_map)) : ?>
            <div class="row" style="padding-bottom: 20px"><!--Greatest news-->
                    <div class="col-md-5 col-lg-5">
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/' . $news_id_news_info_map[$region_id_news_id_map[0]]['news_id']; ?>">
                            <img id="image_position_1" style="width:280px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_TOP_LEFT_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[0]]['picture'] ?>"/>
                        </a>
                    </div>
                    <input type="hidden" name="position_of_news_1" id="position_of_news_1" value="<?php echo!empty($news_id_news_info_map[$region_id_news_id_map[0]]['news_id']) ? $news_id_news_info_map[$region_id_news_id_map[0]]['news_id'] : ''; ?>">
                    
                    <div class="col-md-6 col-lg-6">
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/' . $news_id_news_info_map[$region_id_news_id_map[0]]['news_id']; ?>">
                            <span class="cus_news_headline">
                                <p id="heading_1"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[0]]['headline'])); ?></p>
                            </span>
                        </a>
                        <span class="cus_news_descr">
                            <p id="summary_1"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[0]]['summary'])); ?></p>
                        </span>
                    </div>
                    <div class="col-md-1 col-lg-1"> 
                        <button style="z-index: 500;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[0]]['news_id']; ?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[0]]['news_id']; ?>','1')">
                            Edit
                        </button> 
                    </div>
                </div>
            <?php endif; ?>
            <div class="row" style="padding-bottom: 20px"><!--top news loop...3 news per row-->
                <?php if(array_key_exists(1, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[1], $news_id_news_info_map)) : ?>
                    <div class="col-md-4 col-lg-4">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[1]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[1]]['news_id'];?>','2')">
                            Edit
                        </button>
                        <input type="hidden" name="position_of_news_2" id="position_of_news_2" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[1]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[1]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[1]]['news_id']; ?>">
                            <img id="image_position_2" style="width:180px;height:120px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[1]]['picture'] ?>"/>
                        </a>
                        <br>
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[1]]['news_id']; ?>">
                            <span class="cus_news_subheadline">
                                <p id="heading_2"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[1]]['headline']));?></p>
                            </span>
                        </a>
                        <span class="cus_news_descr">
                            <p id="summary_2"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[1]]['summary']));?></p>
                        </span>
                    </div>
                <?php endif; ?>                
                <?php if(array_key_exists(2, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[2], $news_id_news_info_map)) : ?>
                    <div class="col-md-4 col-lg-4">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[2]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[2]]['news_id'];?>','3')">
                            Edit
                        </button>
                        <input type="hidden" name="position_of_news_3" id="position_of_news_3" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[2]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[2]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[2]]['news_id']; ?>">
                            <img id="image_position_3" style="width:180px;height:120px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[2]]['picture'] ?>"/>
                        </a>
                        <br>
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[2]]['news_id']; ?>">
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
                <?php if(array_key_exists(3, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[3], $news_id_news_info_map)) : ?>
                    <div class="col-md-4 col-lg-4">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[3]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[3]]['news_id'];?>','4')">
                            Edit
                        </button>
                        <input type="hidden" name="position_of_news_4" id="position_of_news_4" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[3]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[3]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[3]]['news_id']; ?>">
                            <img id="image_position_4" style="width:180px;height:120px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[3]]['picture'] ?>"/>
                        </a>
                        <br>
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[3]]['news_id']; ?>">
                            <span class="cus_news_subheadline">
                                <p id="heading_4">
                                    <?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[3]]['headline']))?>
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
                <?php if(array_key_exists(4, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[4], $news_id_news_info_map)) : ?>
                    <div class="col-md-3 col-lg-3">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[4]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[4]]['news_id'];?>','5')">
                            Edit
                        </button>
                        <input type="hidden" name="position_of_news_5" id="position_of_news_5" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[4]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[4]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[4]]['news_id']; ?>">
                            <img id="image_position_5" style="width:150px;height:100px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[4]]['picture'] ?>"/>
                        </a>
                    </div>
                    <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[4]]['news_id']; ?>">
                            <span class="cus_news_subheadline">
                                <p id="heading_5">
                                    <?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[4]]['headline']));?>
                                </p>
                            </span>
                        </a>
                    </div>
                <?php endif; ?>
                
                <?php if(array_key_exists(5, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[5], $news_id_news_info_map)) : ?>
                    <div class="col-md-3 col-lg-3">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[5]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[5]]['news_id'];?>','6')">
                            Edit
                        </button>
                        <input type="hidden" name="position_of_news_6" id="position_of_news_6" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[5]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[5]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[5]]['news_id']; ?>">
                            <img id="image_position_6" style="width:150px;height:100px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[5]]['picture'] ?>"/>
                        </a>
                    </div>
                    <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[5]]['news_id']; ?>">
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
                <?php if(array_key_exists(6, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[6], $news_id_news_info_map)) : ?>
                    <div class="col-md-3 col-lg-3">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[6]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[6]]['news_id'];?>','7')">
                            Edit
                        </button>
                        <input type="hidden" name="position_of_news_7" id="position_of_news_7" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[6]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[6]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[6]]['news_id']; ?>">
                            <img id="image_position_7" style="width:150px;height:100px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[6]]['picture'] ?>"/>
                        </a>
                    </div>
                    <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[6]]['news_id']; ?>">
                            <span class="cus_news_subheadline">
                                <p id="heading_7"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[6]]['headline']));?></p>
                            </span>
                        </a>
                    </div>
                <?php endif; ?>                
                <?php if(array_key_exists(7, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[7], $news_id_news_info_map)) : ?>
                    <div class="col-md-3 col-lg-3">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[7]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[7]]['news_id'];?>','8')">
                            Edit
                        </button>
                        <input type="hidden" name="position_of_news_8" id="position_of_news_8" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[7]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[7]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[7]]['news_id']; ?>">
                            <img id="image_position_8" style="width:150px;height:100px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[7]]['picture'] ?>"/>
                        </a>
                    </div>
                    <div class="col-md-3 col-lg-3" style="padding-left: 0px;">
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[7]]['news_id']; ?>">
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
                        <?php if(array_key_exists(8, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[8], $news_id_news_info_map)) : ?>
                            <div class="col-md-6 col-lg-6">
                                <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[8]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[8]]['news_id'];?>','9')">
                                Edit
                            </button>
                            <input type="hidden" name="position_of_news_9" id="position_of_news_9" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[8]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[8]]['news_id']:'';?>">
                                <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[8]]['news_id']; ?>">
                                    <span class="cus_news_smallheadline">
                                        <p id="heading_9"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[8]]['headline']));?></p>
                                    </span>
                                </a>
                                <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[8]]['news_id']; ?>">
                                    <span class="cus_news_descr">
                                        <p id="summary_9"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[8]]['summary']));?></p>
                                    </span>
                                </a>
                            </div>
                        <?php endif; ?>                        
                        <?php if(array_key_exists(9, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[9], $news_id_news_info_map)) : ?>
                            <div class="col-md-6 col-lg-6">
                                <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[9]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[9]]['news_id'];?>','10')">
                                    Edit
                                </button>
                                <input type="hidden" name="position_of_news_10" id="position_of_news_10" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[9]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[9]]['news_id']:'';?>">
                                <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[9]]['news_id']; ?>">
                                    <span class="cus_news_smallheadline">
                                        <p id="heading_10"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[9]]['headline'])) ;?></p>
                                    </span>
                                </a>
                                <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[9]]['news_id']; ?>">
                                    <span  class="cus_news_descr">
                                        <p id="summary_10"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[9]]['summary']));?></p>
                                    </span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <?php if(array_key_exists(10, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[10], $news_id_news_info_map)) : ?>
                            <div class="col-md-6 col-lg-6">
                                <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[10]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[10]]['news_id'];?>','11')">
                                    Edit
                                </button>
                                <input type="hidden" name="position_of_news_11" id="position_of_news_11" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[10]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[10]]['news_id']:'';?>">
                                <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[10]]['news_id']; ?>">
                                    <span class="cus_news_smallheadline">
                                        <p id="heading_11"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[10]]['headline']));?></p>
                                    </span>
                                </a>
                                <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[10]]['news_id']; ?>">
                                    <span class="cus_news_descr">
                                        <p id="summary_11"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[10]]['summary']));?></p>
                                    </span>
                                </a>
                            </div>
                        <?php endif; ?>                        
                        <?php if(array_key_exists(11, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[11], $news_id_news_info_map)) : ?>
                            <div class="col-md-6 col-lg-6">
                                <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[11]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[11]]['news_id'];?>','12')">
                                    Edit
                                </button>
                                <input type="hidden" name="position_of_news_12" id="position_of_news_12" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[11]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[11]]['news_id']:'';?>">
                                <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[11]]['news_id']; ?>">
                                    <span class="cus_news_smallheadline">
                                        <p id="heading_12"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[11]]['headline']));?></p>
                                    </span>
                                </a>
                                <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[11]]['news_id']; ?>">
                                    <span class="cus_news_descr">
                                        <p id="summary_12"><?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[11]]['summary']));?></p>
                                    </span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if(array_key_exists(12, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[12], $news_id_news_info_map)) : ?>
                    <div class="col-md-4 col-lg-4">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[12]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[12]]['news_id'];?>','13')">
                            Edit
                        </button>
                        <input type="hidden" name="position_of_news_13" id="position_of_news_13" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[12]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[12]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[12]]['news_id']; ?>">
                            <img id="image_position_13" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_BOTTOM_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[12]]['picture'] ?>"/>
                        </a>
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[12]]['news_id']; ?>">
                            <span class="cus_news_subheadline" id="heading_13">
                                <p>
                                    <?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[12]]['headline']));?>
                                </p>
                            </span>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-3" id="side_panel">
            <?php for($fi=0;$fi<4;$fi++):?>
                <?php if(array_key_exists(13+$fi, $region_id_news_id_map) && array_key_exists($region_id_news_id_map[13+$fi], $news_id_news_info_map)) : ?>
                    <div class="col-md-12 col-lg-12">
                        <button style="z-index: 5;position: relative;" id="button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[13+$fi]]['news_id'];?>" value="" class="btn button-custom pull-right" onclick="openModal('button_edit_news_<?php echo $news_id_news_info_map[$region_id_news_id_map[13+$fi]]['news_id'];?>','<?php echo (14+$fi)?>')">
                            Edit
                        </button>
                        <input type="hidden" name="position_of_news_<?php echo 14+$fi;?>" id="position_of_news_<?php echo 14+$fi;?>" value="<?php echo !empty($news_id_news_info_map[$region_id_news_id_map[13+$fi]]['news_id'])?$news_id_news_info_map[$region_id_news_id_map[13+$fi]]['news_id']:'';?>">
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[13+$fi]]['news_id']; ?>">
                            <img id="image_position_<?php echo 14+$fi;?>" style="width:180px;height:120px;" class="img-responsive" src="<?php echo base_url() . NEWS_HOME_MIDDLE_IMAGE_PATH . $news_id_news_info_map[$region_id_news_id_map[13+$fi]]['picture'] ?>"/>
                        </a>
                        <br>
                        <a href="<?php echo base_url() . 'admin/applications_news/news_details/'.$news_id_news_info_map[$region_id_news_id_map[13+$fi]]['news_id']; ?>">
                            <span class="cus_news_subheadline">
                                <p id="heading_<?php echo 14+$fi;?>">
                                    <?php echo html_entity_decode(html_entity_decode($news_id_news_info_map[$region_id_news_id_map[13+$fi]]['headline']));?>
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
        <div class="row">
            <div class ="col-md-3 col-xs-2">
                <input type="button" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
            </div>
            <div class="col-md-4"></div>
            <div class ="col-md-5">
                <div class="row">
                <div class ="col-md-8 col-xs-5">
                    <input type="text" class="form-control" id="input_configuration_date" name="input_configuration_date" value=""/>
                </div>
                <div class ="col-md-4 col-xs-5">
                    <button id="button_submit_home_page_configuration" name="button_submit_home_page_configuration" value="" class="form-control btn button-custom">
                        Submit
                    </button>    
                </div>
            </div>
            </div>
        </div>
        <input type="hidden" name="get_selected_id" id="get_selected_id" value="">
        <input type="hidden" id="hidden_field_for_key">
    </div>
</div>
<?php $this->load->view("admin/applications/news_app/common_modal_for_news_items");?>
<?php $this->load->view("admin/applications/news_app/common_js_for_news"); ?>