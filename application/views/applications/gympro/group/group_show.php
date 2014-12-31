<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-3">
            <!--left nav custom for this page-->
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/groups.png">
                <a onclick="$('.hidden_tab').hide();$('#group_details_tab').show();">GROUP DETAILS</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/groups.png">
                <a onclick="$('.hidden_tab').hide();$('#group_contacts_tab').show();">GROUP CONTACTS</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/groups.png">
                <a onclick="$('.hidden_tab').hide();$('#group_clients_tab').show();">GROUP CLIENTS</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/groups.png">
                <a onclick="$('.hidden_tab').hide();$('#notes_tab').show();">NOTES</a>
            </div>
        </div>
        <div class="col-md-8">
            <div class="pad_title">
            GROUP INFO
            </div>
            <div style="border-top: 2px solid lightgray; margin-left: 20px"></div>
            <div class="pad_body">
                <?php if (isset($message) && ($message != NULL)){?>
                    <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
                <?php } ?>
                <div class="row hidden_tab" id="group_details_tab" style="display: block">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Title:</label>
                            <label class="col-md-8 control-label">&nbsp;<?php echo $group_info['title'];?></label>
                        </div>
                    </div>
                </div>
                <div class="row hidden_tab" id="group_contacts_tab">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Phone Number:</label>
                            <label class="col-md-8 control-label">&nbsp;<?php echo $group_info['phone'];?></label>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Mobile Number:</label>
                            <label class="col-md-8 control-label">&nbsp;<?php echo $group_info['mobile'];?></label>
                        </div>
                    </div>
                </div>
                <div class="row hidden_tab" id="group_clients_tab">
                    <div class="col-md-12">
                                           
                    </div>
                </div>
                <div class="row hidden_tab" id="notes_tab">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Notes:</label>
                            <label class="col-md-8 control-label">&nbsp;<?php echo $group_info['notes'];?></label>
                        </div>
                    </div>
                </div>                    
            </div>
              
        </div>
    </div>
</div>