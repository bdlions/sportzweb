<script type="text/javascript">
    
       function selected_news_id_list(selected_array,news_id){
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
                            alert('This news already selected in one position');
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
                $('#common_modal_edit_news_item').modal('hide');
            } else {
                alert('You can only select one news for this position');
                return ;
            }
        
        }
</script>
