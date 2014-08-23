<div class="panel panel-default">
    <div class="panel-heading">Page</div>
    <div class="panel-body">
        <div class="row col-md-10">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
                    <div class="col-sm-6"></div>
                </div>
            </div>
            <?php $i=1;foreach($visited_page as $page):?>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right"><?php echo 'Most visited page '.$i++.' : ';?></div></label>
                        <div class="col-sm-6"><?php echo $page;?></div>
                    </div>
                </div>
            <?php endforeach;?>
            
        </div>
    </div>
</div>

