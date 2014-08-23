<div class="panel panel-default">
    <div class="panel-heading">News List</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row form-group">
                <div class ="col-sm-9">
                    
                </div>
                <div class ="col-sm-3" style="padding-right: 10px;">
                    <a href="<?php echo base_url()."admin/newsapp/create_sub_news/".$news['id'] ?>" >
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
                                            <td><a href="<?php echo base_url().'admin/newsapp/news_details/'.$row[0]['id']?>">Edit</a></td>
                                        </tr>
                                    <?php endif;?>
                                <?php endforeach;?>
                            <?php endif; ?>
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