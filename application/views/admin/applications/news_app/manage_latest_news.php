<script type="text/javascript">
    $(function() {
        $("#news_list_for_home_page").on("click", function() {
            var selected_news_array = Array();
            $("#tbody_news_list_for_home_page tr").each(function() {
                var lastColumn = $(this).find('td:last');
                var newsListCheckBox = $(lastColumn).find("input:checkbox");
                if($(newsListCheckBox).prop('checked') == true){
                    selected_news_array.push(newsListCheckBox.attr('id'));
                } 
            });
            
            if(selected_news_array.length > 0)
            {
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "admin/newsapp/latest_news_for_home_page",
                    data: {
                        selected_news_array_list: JSON.stringify(selected_news_array)
                    },
                    success: function(data) {
                    alert(data['message']);
                    if (data['status'] === 1)
                    {
                       location.reload(); 
                    }
                }
                });
            }else 
            {
                alert('Please select atleast 1 news as a latest news');
            }
        });
    });
</script> 

<div class="panel panel-default">
    <div class="panel-heading">Manage Latest News</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row form-group">
                <div class="col-sm-6"></div>
                <div class ="col-sm-3 pull-right" style="padding-right: 0px;">
                    <button id="news_list_for_home_page" value="" class="form-control btn button-custom pull-right">
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
                                <th>News Title</th>
                                <th>Created On</th>
                                <th>Select News Item</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_news_list_for_home_page">
                            <?php if(count($news_list)>0): ?>
                                <?php $i=1; ?>
                                <?php foreach($news_list as $news):?>
                                    <tr>
                                        <td><a href="<?php echo base_url().'admin/newsapp/news_details/'.$news['id'] ?>"><?php echo $i++; ?></a></td>
                                        <td><?php echo html_entity_decode(html_entity_decode($news['headline'])) ;?></td>
                                        <td><?php echo $news['news_date']?></td>
                                        <td>
                                            <input id="<?php echo $news['id'] ?>" class="" type="checkbox" name="item[]" />
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="btn-group" style="padding-left: 10px;">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="goBackByURL('<?php echo base_url();?>admin/newsapp')" class="form-control btn button-custom">
            </div>
        </div>
        
    </div>
</div>