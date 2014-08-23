<div class="row">
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
            <div class="col-sm-6"></div>
        </div>
    </div>
    <?php if(empty($page_visit)){ ?>
        <div class="row">
            <div class="form-group">
                <label class="col-sm-7"><div class="pull-right">No page visited</div></label>

            </div>
        </div>
    <?php }?>
    <?php $i=1;foreach($page_visit as $page):?>
        <div class="row">
            <div class="form-group">
                <label class="col-sm-6"><div class="pull-right"><?php echo 'Most visited page '.$i++.' : ';?></div></label>
                <div class="col-sm-6"><?php echo $page?></div>
            </div>
        </div>
    <?php endforeach;?>
    
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
            <div class="col-sm-6"></div>
        </div>
    </div>
    <?php if(empty($application_visit)){ ?>
        <div class="row">
            <div class="form-group">
                <label class="col-sm-7"><div class="pull-right">No application visited</div></label>

            </div>
        </div>
    <?php }?>
    <?php $i=1;foreach($application_visit as $application):?>
        <div class="row">
            <div class="form-group">
                <label class="col-sm-6"><div class="pull-right"><?php echo 'Most visited application '.$i++.' : ';?></div></label>
                <div class="col-sm-6"><?php echo $application?></div>
            </div>
        </div>
    <?php endforeach;?>
    
    <div class="row">
        <div class="form-group">
            <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
            <div class="col-sm-6"></div>
        </div>
    </div>
    <?php if(empty($business_profile_visit)){ ?>
        <div class="row">
            <div class="form-group">
                <label class="col-sm-7"><div class="pull-right">No business profile visited</div></label>

            </div>
        </div>
    <?php }?>
    <?php $i=1;foreach($business_profile_visit as $business):?>
        <div class="row">
            <div class="form-group">
                <label class="col-sm-6"><div class="pull-right"><?php echo 'Most visited business profile '.$i++.' : ';?></div></label>
                <div class="col-sm-6"><?php echo $business?></div>
            </div>
        </div>
    <?php endforeach;?>
</div>