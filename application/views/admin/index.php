<div class="panel panel-default">
    <div class="panel-heading">Overview</div>
    <div class="panel-body">
        <div class="row col-md-10">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Total number of members : </div></label>
                    <div class="col-sm-6"><?php echo $total_members?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
                    <div class="col-sm-6"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Total male members : </div></label>
                    <div class="col-sm-6"><?php echo $total_male_members?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Total female members : </div></label>
                    <div class="col-sm-6"><?php echo $total_female_members?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
                    <div class="col-sm-6"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Average time spent logged in : </div></label>
                    <div class="col-sm-6"><?php echo $hour.":".$minute." hours"?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
                    <div class="col-sm-6"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Total number of applications : </div></label>
                    <div class="col-sm-6"><?php echo $total_applications?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Total number of business profiles : </div></label>
                    <div class="col-sm-6"><?php echo $total_business_profiles?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Total members connected to business profiles : </div></label>
                    <div class="col-sm-6"><?php echo $business_profile;?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
                    <div class="col-sm-6"></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Total log ins yesterday : </div></label>
                    <div class="col-sm-6"><?php echo $yesterday?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Total log ins today : </div></label>
                    <div class="col-sm-6"><?php echo $today_count?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Total log ins last week : </div></label>
                    <div class="col-sm-6"><?php echo $last_week?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Total log ins this week : </div></label>
                    <div class="col-sm-6"><?php echo $this_week?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Total log ins last month : </div></label>
                    <div class="col-sm-6"><?php echo $last_month?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">Total log ins this month : </div></label>
                    <div class="col-sm-6"><?php echo $this_month?></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
                    <div class="col-sm-6"></div>
                </div>
            </div>
            <?php $i=1;foreach($most_visited_pages as $page):?>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right"><?php echo 'Most visited page '.$i++.' : ';?></div></label>
                        <div class="col-sm-6"><?php echo $page;?></div>
                    </div>
                </div>
            <?php endforeach;?>
            
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
                    <div class="col-sm-6"></div>
                </div>
            </div>
            <?php $i=1;foreach($most_visited_applications as $application):?>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right"><?php echo 'Most visited application '.$i++.' : ';?></div></label>
                        <div class="col-sm-6"><?php echo $application;?></div>
                    </div>
                </div>
            <?php endforeach;?>
            
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
                    <div class="col-sm-6"></div>
                </div>
            </div>
            
            
            <?php $i=1;foreach($most_visited_business_profiles as $business):?>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right"><?php echo 'Most visited business profile'.$i++.' : ';?></div></label>
                        <div class="col-sm-6"><?php echo $business;?></div>
                    </div>
                </div>
            <?php endforeach;?>
            
        </div>
    </div>
</div>

