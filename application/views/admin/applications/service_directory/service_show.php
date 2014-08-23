<div class="panel panel-default">
    <div class="panel-heading"><?php echo $service_info['title']; ?></div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row">
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
                        <div class="col-sm-6"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">Name : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['title']; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">Address : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['address']; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">City : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['city']; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">Country : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['country_name']; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">Post Code : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['post_code']; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">Openning Hours : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['opening_hours']; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">Telephone : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['telephone']; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">Website : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['website']; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">Sportzweb Profile : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['business_name']; ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-group" style="padding-left: 10px;">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="goBackByURL('<?php echo base_url();?>admin/servicedirectory/service_category/<?php echo $service_info['service_category_id'];?>')" class="form-control btn button-custom">
        </div>
    </div>
</div>