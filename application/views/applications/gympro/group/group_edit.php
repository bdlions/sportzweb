<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
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
    $(function () {
        $('.clientgroups_checkbox').on('click', function() {
            var checkbox_div = $(this).parent();
            if ($(this).is(":checked")) {
                checkbox_div.attr("class", "clientrow_added");
                checkbox_div.appendTo("#selected_clients");
            }
            else {
                checkbox_div.attr("class", "clientrow");
                checkbox_div.appendTo("#unselected_clients");
            }
	});
        $("#submit_edit_group").on("click", function(){
            var selected_client_list = new Array();
            var counter = 0;
            $("input", "#selected_clients").each(function() {
                if ($(this).attr("type") === "hidden")
                {
                    selected_client_list[counter++] = $(this).attr("id");
                }
            });
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url().'applications/gympro/edit_group/'.$group_info['group_id'];?>',
                data: $("#form_edit_group").serialize()+"&selected_client_list=" + selected_client_list,
                success: function(data) {
                   // alert(data.message);
                   var message = data.message;
                    print_common_message(message);
                    window.location = '<?php echo base_url();?>applications/gympro/manage_groups';
                }
            });
        });
    });    	
</script>
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
                EDIT GROUP
            </div>
            <div style="border-top: 2px solid lightgray; margin-left: 20px"></div>
            <?php echo form_open("applications/gympro/edit_group/".$group_info['group_id'], array('id' => 'form_edit_group', 'class' => 'form-horizontal', 'onsubmit' => 'return false;')); ?>
            <div class="pad_body">
                <?php if (isset($message) && ($message != NULL)){?>
                    <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
                <?php } ?>
                <div class="row hidden_tab" id="group_details_tab" style="display: block">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Title: </label>
                            <div class="col-sm-8">
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
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6" style="padding: 0px;">
                                    <div class="pad_white" style="min-height: 300px;">
                                        <div id="unselected_clients">
                                            <?php foreach($client_list as $client_info){
                                            if(!in_array($client_info['client_id'], $selected_client_id_list)){ ?>
                                                <div class="clientrow">
                                                    <input type="hidden" id="<?php echo $client_info['client_id']?>">
                                                    <input class="clientgroups_checkbox" type="checkbox">
                                                    <?php echo $client_info['first_name'].' '.$client_info['last_name']?>
                                                </div>    
                                            <?php }} ?>                                              
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding: 0px;">
                                    <div class="pad_white" style="min-height: 300px;">
                                        <div id="selected_clients">
                                            <?php foreach($client_list as $client_info){
                                            if(in_array($client_info['client_id'], $selected_client_id_list)){ ?>
                                                <div class="clientrow_added">
                                                    <input type="hidden" id="<?php echo $client_info['client_id']?>">
                                                    <input class="clientgroups_checkbox" type="checkbox" checked="">
                                                    <?php echo $client_info['first_name'].' '.$client_info['last_name']?>
                                                </div>    
                                            <?php }} ?>
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
                <?php echo form_input($submit_edit_group);?> or <a href="<?php echo base_url()?>applications/gympro/manage_groups">Go Back</a>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>