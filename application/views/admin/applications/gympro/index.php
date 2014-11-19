<div class="panel panel-default">
    <div class="panel-heading">GYMPRO</div>
    <div class="panel-body">
        <?php if ($allow_write) { ?>
        <div class="row form-group">
            <div class ="col-md-3 pull-left">
                <a href="<?php echo base_url()?>admin/applications_gympro/manage_account_types"><button class="form-control btn button-custom">Manage Account Type</button></a>
            </div>
            <div class ="col-md-3 pull-left">
                <a href="<?php echo base_url()?>admin/applications_gympro/manage_health_questions"><button class="form-control btn button-custom">Manage Health Questions</button></a>
            </div>
        </div>
        <div class="row form-group">
            <div class ="col-md-3 pull-left">
                <a href="<?php echo base_url()?>admin/applications_gympro/manage_users"><button class="form-control btn button-custom">Manage Users</button></a>
            </div>
            <div class ="col-md-3 pull-left">
                <a href="<?php echo base_url()?>admin/applications_gympro/manage_clients"><button class="form-control btn button-custom">Manage Clients</button></a>
            </div>
        </div>
        
        <?php } ?>
        <div class="row form-group">
            <div class="col-md-12">
                
            </div>
        </div>
    </div>
</div>