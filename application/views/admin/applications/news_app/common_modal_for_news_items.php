<script type="text/javascript">
    $(function() {
        $('#search_news_start_date').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#search_news_start_date').text($('#search_news_start_date').data('date'));
            $('#search_news_start_date').datepicker('hide');
        });
        $('#search_news_end_date').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#search_news_end_date').text($('#search_news_end_date').data('date'));
            $('#search_news_end_date').datepicker('hide');
        });
      
        $("#Search_news_items").on("click",function(){
            
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_news/search_news_items_by_date",
                data: {
                    search_news_start_date: $('#search_news_start_date').val(),
                    search_news_end_date: $('#search_news_end_date').val(),
                },
               success: function(data) {
                   $("#tbody_news_list").html(tmpl("tmpl_news_list", data))
                   
               }
            });
        });
        
         $("#search_box").typeahead([
            {
                name:"search_news",
                valuekey:"value",
                remote:'<?php echo base_url(); ?>' + "admin/applications_news/search_items_by_news_type?query=%QUERY",
                header: '<div class="col-md-12" style="font-size: 15px; font-weight:bold">News</div>',
                template: [
                    '<div class="row"><div class=" col-lg-offset-1 col-md-11"><div class="form-horizontal"><span>{{headline}}</span></div></div></div>'
                  ].join(''),
                engine: Hogan
            }
    ]).on('typeahead:selected', function (obj, datum) {
        if(datum.id)
        {
            $("#tbody_news_list").html(tmpl("tmpl_news_list", datum))
        }
        });
        
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
            
            
            if($('#hidden_field_for_key').val() == <?php echo NEWS_MANAGE_HOME_PAGE_KEY ?>)
            {
                add_selected_news(selected_array,news_id);
            }else if($('#hidden_field_for_key').val() == <?php echo NEWS_CONFIG_CATEGORY_PAGE_KEY ?>)
            {
              add_selected_news(selected_array,news_id);  
            }else if($('#hidden_field_for_key').val() == <?php echo NEWS_CONFIG_SUB_CATEGORY_PAGE_KEY ?>)
            {
                add_selected_news(selected_array,news_id);
            }else if($('#hidden_field_for_key').val() == <?php echo BREAKING_NEWS_SELECTION_KEY ?>)
            {
                append_selected_breaking_news(selected_array);
            }else if($('#hidden_field_for_key').val() == <?php echo LATEST_NEWS_SELECTION_KEY ?>)
            {
                append_selected_latest_news(selected_array);
            }
            
        });
    });
    
</script>
<script type="text/x-tmpl" id="tmpl_news_list">
    {% var i=0, news_list = ((o instanceof Array) ? o[i++] : o); %}
    {% while(news_list){ %}
    <tr>
    <td style="width: 20px; padding: 0px" ><label for="<?php echo '{%= news_list.id%}'; ?>" style="padding: 5px 40px;"><input id="<?php echo '{%= news_list.id%}'; ?>" name="checkbox[]" class="" type="checkbox"></label></td>
    <td id="<?php echo '{%= news_list.id%}'; ?>"><?php echo '{%= news_list.headline%}'; ?></td>
    </tr>
    {% news_list = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<div class="modal fade" id="common_modal_news_list" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">News List</h4>
            </div>
            <div class="modal-body" style="max-height: 300px; overflow-y: auto;">
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label>Type News</label>
                    <div class="twitter-typeahead" style="position: relative;"><input type="text" disabled="" spellcheck="off" autocomplete="off" class="tt-hint form-control" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; background: none repeat scroll 0% 0% transparent;"><input type="text" dir="auto" style="position: relative; vertical-align: top; background-color: transparent;" spellcheck="false" autocomplete="off" id="search_box" class="form-control tt-query" placeholder="Search for News"><div style="position: absolute; left: -9999px; visibility: hidden; white-space: nowrap; font-family: Calibri,Arial,Helvetica,sans-serif; font-size: 12px; font-style: normal; font-variant: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: optimizelegibility; text-transform: none;"></div><div class="tt-dropdown-menu dropdown-menu" style="position: absolute; top: 100%; left: 0px; z-index: 100; display: none;"></div></div>
                    </div>
                    <div class="col-md-3 form-group">
                        <label>Start Date</label>
                        <input type="text" id="search_news_start_date" name="search_news_start_date" class="form-control">
                    </div>
                    <div class="col-md-3 form-group">
                        <label>End Date</label>
                        <input type="text" id="search_news_end_date" name="search_news_end_date" class="form-control">
                    </div>
                    <div class="col-md-2 form-group">
                        <button type="button" id="Search_news_items" name="search_news_items" class="btn button-custom" style="margin-top: 22px">Search</button>
                    </div>
                </div>
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
                            <?php foreach ($news_list as $key => $news) :?>
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
