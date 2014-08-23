<script type="text/javascript">
    $(function() {
        $("#button_save_news").on("click", function() {
            
            var selected_array = Array();
            var news_id;
            $("#tbody_news_list tr").each(function() {
                $("td:first input:checkbox", $(this)).each(function() {
                    if (this.checked == true)
                    {
                        selected_array.push(this.id);
                        news_id = this.id;
                    }
                });
            });

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
                    url: '<?php echo base_url(); ?>' + "admin/newsapp/get_selected_news_data",
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
                $('#modal_edit_news_item_home_page').modal('hide');
            } else {
                alert('You can only select one news for this position');
                return ;
            }
           
        });
    });
</script>
<div class="modal fade" id="modal_edit_news_item_home_page" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Recipe List</h4>
            </div>
            <div class="modal-body" style="max-height: 300px; overflow-y: auto;">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Check box</th>
                                    <th>Headline</th>
                                </tr>
                            </thead>
                            
                            <tbody id="tbody_news_list">
                            <?php foreach ($news_list_old as $key => $news) :?>
                                <tr>
                                    <td><input id="<?php echo $news['id'] ?>" name="checkbox[]" class="" type="checkbox" /></td>
                                    <td id="<?php echo $news['id'] ?>"><?php echo html_entity_decode(html_entity_decode($news['headline'])); ?></td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button id="button_save_news" name="button_save_news" value="" class="btn button-custom">Save</button>
                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
