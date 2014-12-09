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
                NEW CLIENT GROUP
            </div>
            <?php echo form_open("applications/gympro/create_group", array('id' => 'form_group', 'class' => 'form-horizontal')); ?>
            <div class="pad_body">
                <div class="row hidden_tab" id="group_details_tab" style="display: block">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Title: </label>
                            <div class="col-sm-8">
                                <!--<input class="form-control" id="last_name" name="last_name">-->
                                <?php echo form_input($title + array('class' => 'form-control'));?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row hidden_tab" id="group_contacts_tab">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Phone Number: </label>
                            <div class="col-sm-6">
                                <?php echo form_input($phone + array('class' => 'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Mobile Number: </label>
                            <div class="col-sm-6">
                                <?php echo form_input($mobile + array('class' => 'form-control'));?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row hidden_tab" id="group_clients_tab">
                    <div class="col-md-12">
                        <!--<div style="width: 100%; display: inline-block;">-->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6" style="padding: 0px;">
                                    <div class="pad_white" style="min-height: 300px;">
                                        <div id="all">
                                            <div class="clientrow">
                                                <input class="clientgroups_checkbox" type="checkbox" value="8793" name="group[]">
                                                Shem Haye
                                            </div>
                                            <div class="clientrow">
                                                <input class="clientgroups_checkbox" type="checkbox" value="8800" name="group[]">
                                                Alamgir Kabir
                                            </div>
                                            <div class="clientrow">
                                                <input class="clientgroups_checkbox" type="checkbox" value="8800" name="group[]">
                                                Alamgir Kabir
                                            </div>
                                            <div class="clientrow">
                                                <input class="clientgroups_checkbox" type="checkbox" value="8800" name="group[]">
                                                Alamgir Kabir
                                            </div>
                                            <div class="clientrow">
                                                <input class="clientgroups_checkbox" type="checkbox" value="8800" name="group[]">
                                                Alamgir Kabir
                                            </div>
                                            <div class="clientrow">
                                                <input class="clientgroups_checkbox" type="checkbox" value="8800" name="group[]">
                                                Alamgir Kabir
                                            </div>
                                            <div class="clientrow">
                                                <input class="clientgroups_checkbox" type="checkbox" value="8800" name="group[]">
                                                Alamgir Kabir
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding: 0px;">
                                    <div class="pad_white" style="min-height: 300px;">
                                        <div id="added">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row hidden_tab" id="notes_tab">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Notes: </label>
                            <div class="col-sm-8">
                                <?php echo form_textarea($notes + array('class' => 'form-control'));?>
                            </div>
                        </div>
                    </div>
                </div>
                    
            </div>
            <div class="pad_footer">
                <?php echo form_input($submit_button);?> or <a href="<?php echo base_url()?>applications/gympro/programs">Go Back</a>
            </div>
            <?php echo form_close();?>
        </div>
    </div>

</div>
<style>
.clientrow {
    background: #dbdbdb;
    color: #000;
    height: 29px;
    line-height: 29px;
    margin-bottom: 5px;
    padding: 0 0 0 8px;
}

.clientrow_added {
    background: #ffd310;
    color: #000;
    height: 29px;
    line-height: 29px;
    margin-bottom: 5px;
    padding: 0 0 0 8px;
}
</style>
<script>
    	$('.clientgroups_checkbox').on('click', function() {
            var checkbox_div = $(this).parent();
            if ($(this).is(":checked")) {
                checkbox_div.attr("class", "clientrow_added");
                checkbox_div.appendTo("#added");
            }
            else {
                checkbox_div.attr("class", "clientrow");
                checkbox_div.appendTo("#all");
            }
	});
</script>