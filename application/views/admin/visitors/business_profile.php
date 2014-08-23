<div class="panel panel-default">
    <div class="panel-heading">Business Profile</div>
    <div class="panel-body">
        <div class="row col-md-10">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
                    <div class="col-sm-6"></div>
                </div>
            </div>
            <?php $i=1;foreach($business_list as $business):?>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right"><?php echo 'Most visited Business Profile '.$i++.' : ';?></div></label>
                        <div class="col-sm-6"><?php echo $business;?></div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>

