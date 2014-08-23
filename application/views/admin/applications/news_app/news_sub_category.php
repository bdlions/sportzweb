<script type="text/javascript">
    $(function() {
        $("#button_create_news_sub_category").on("click", function() {
            $('#modal_create_news_sub_category').modal('show');
        });
    });
</script>

<script type="text/x-tmpl" id="tmpl_news_sub_category_list">
    {% var i=0, news_sub_category_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(news_sub_category_info){ %}
    <tr>
        <td><a href="<?php echo base_url()."admin/applications_news/sub_category_news_list/{%= news_sub_category_info.id%}"; ?>">{%= news_sub_category_info.id%}</td>
        <td><div id="news_title_{%= news_sub_category_info.id%}">{%= news_sub_category_info.title%}</div></td>
        <td><button id="button_edit_news_sub_category_{%= news_sub_category_info.id%}" onclick="openModal('button_edit_news_sub_category_{%= news_sub_category_info.id%}','{%= news_sub_category_info.id%}')" value="" class="form-control btn pull-right">Edit</button></td>
        <td><a href="<?php echo base_url()."admin/applications_news/config_news_for_sub_category/{%=news_sub_category_info.id%}";?>">Config</a></td>
    </tr>
    {% news_sub_category_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>

<div class="panel panel-default">
    <div class="panel-heading">News Sub Category List</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <?php if($allow_access){ ?>
            <div class="row form-group">
                <div class ="col-sm-9"></div>
                
                <div class ="col-sm-3" style="padding-right: 0px;">
                    <button id="button_create_news_sub_category" value="" class="form-control btn button-custom pull-right">Create Sub Category</button>  
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered" style="text-align: center;">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Id</th>
                                <th style="text-align: center;">Name</th>
                                <?php if($allow_access){ ?>
                                <th style="text-align: center;">Edit</th>  
                                <?php } ?>
                                <?php if($allow_access){ ?>
                                <th style="text-align: center;">Config</th> 
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="tbody_news_sub_category_list">
                            <?php foreach($news_sub_category as $sub_category): ?>
                                <tr>
                                    <td><?php echo $sub_category['id'];?></td>
                                    <td><div id="news_title_<?php echo $sub_category['id'];?>"><?php echo $sub_category['title']?></div></td>
                                    <?php if($allow_access){ ?>
                                    <td><button id="button_edit_news_category_<?php echo $sub_category['id'];?>" onclick="openModal('button_edit_news_sub_category_<?php echo $sub_category["id"];?>','<?php echo $sub_category['id'];?>')" value="" class="form-control btn pull-right">Edit</button></td>
                                    <?php } ?>
                                    <?php if($allow_access){ ?>
                                    <td><a href="<?php echo base_url().'admin/applications_news/config_news_for_sub_category/'.$sub_category['id']?>">Config</a></td>
                                    <?php } ?>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
        <div class="btn-group" style="padding-left: 10px;">
            <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
        </div>
    </div>  
</div>

<!--<div class="panel panel-default">
    <div class="panel-heading">News List</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row form-group">
                <div class ="col-sm-9"></div>
                
                <div class ="col-sm-3" style="padding-right: 0px;">
                    <a href="<?php echo base_url()."admin/applications_news/create_news/".$news['id'] ?>" >
                        <button id="" value="" class="form-control btn button-custom pull-right">
                        Create News
                        </button>
                    </a> 
                </div>
            </div>
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>HeadLine</th>
                                <th>Description</th>
                                <th>Comments</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_recipes_category_list">
                            <?php $news = $news['news_list'];$i=1;?>
                            <?php if(count($news)>0): ?>
                                <?php foreach($news as $row): ?>
                                    <?php if(!empty($row)): ?>
                                        <tr>
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo html_entity_decode(html_entity_decode($row[0]['headline']));?></td>
                                            <td><?php echo html_entity_decode(html_entity_decode($row[0]['description']));?></td>
                                            <td><a href="<?php echo base_url().'admin/applications_news/all_comments/'.$row[0]['id']?>">comments</a></td>
                                            <td><a href="<?php echo base_url().'admin/applications_news/edit_news/'.$row[0]['id']?>">Edit</a></td>
                                        </tr>
                                    <?php endif;?>
                                <?php endforeach;?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>        
    </div>
</div>-->
<?php $this->load->view("admin/applications/news_app/modal_create_news_sub_category"); ?>
<?php $this->load->view("admin/applications/news_app/modal_edit_news_sub_category"); ?>
