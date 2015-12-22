<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<script type="text/javascript">
    $(function() {
        $('#start_date').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#start_date').text($('#start_date').data('date'));
            $('#start_date').datepicker('hide');
        });        
        $('#end_date').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#end_date').text($('#end_date').data('date'));
            $('#end_date').datepicker('hide');
        });
        $('#birth_date').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#birth_date').text($('#birth_date').data('date'));
            $('#birth_date').datepicker('hide');
        });
    });
</script>
<script>
$(function () {
    $("#submit_create_client").on("click", function(){
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url().'applications/gympro/create_client/'.$member_info['user_id'];?>',
            data: $("#form_create_client").serializeArray(),
            success: function(data) {
                var message = data.message;
                print_common_message(message);
                window.location = '<?php echo base_url();?>applications/gympro/manage_clients';
            }
        });
    });
});
</script>
<style>
    #health input{
        height: 20px;
        font-size: 14px;
        padding: 0 8px;
        vertical-align: bottom;
    }
    #health{
        font-size: 14px;
    }
</style>
<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/home.png">
                <a href="<?php echo base_url() . 'applications/gympro' ?>">Home</a>
            </div>
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/client.png">
                <a href="<?php echo base_url() . 'applications/gympro/manage_clients' ?>">Clients</a>
            </div>
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/groups.png">
                <a href="<?php echo base_url() . 'applications/gympro/manage_groups' ?>">Groups</a>
            </div>
            <div class="nav_separate_border"></div>
            <!--left nav custom for this page-->
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#add_client').show();$('#add_client_btn').show();">Personal details</a>
            </div>
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#contact_details').show();$('#contact_details_btn').show();">Contact details</a>
            </div>
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#health').show();$('#health_btn').show();">Health details</a>
            </div>
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#notes').show();$('#notes_btn').show();">Notes</a>
            </div>
        </div>
        <!--ADDING CLIENT-->
        <div class="col-md-7">
            <div class="pad_title">
                <div class="row">
                    <div class="col-md-8">
                        <span>ADDING CLIENT</span>
                    </div>
                </div>
            </div>
            <div style="border-top: 2px solid lightgray; margin-left: 20px"></div>
            <div class="pad_body">
                <?php if (isset($message) && ($message != NULL)){?>
                    <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
                <?php } ?>
                <?php echo form_open("applications/gympro/create_client", array('id' => 'form_create_client', 'class' => 'form-horizontal', 'onsubmit' => 'return false;'))?>
                <!--Personal details-->
                <div class="row hidden_tab" id="add_client" style="display: block">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label class="col-sm-4">Name: </label>
                            <div class="col-sm-6">
                                <label class=""><?php echo $member_info['first_name'];?> <?php echo $member_info['last_name'];?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 ">Gender </label>
                            <div class="col-sm-4">
                                <label class="">
                                    <?php if( $member_info['gender_id'] == GENDER_MALE )
                                            echo "Male";
                                            else echo 'Female';?>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 ">Email: </label>
                            <div class="col-sm-6">
                                <label class=""><?php echo $member_info['email'];?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 ">Date of birth: </label>
                            <div class="col-sm-4">
                                <label class=""><?php echo convert_date_from_db_to_user($member_info['dob']);?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 ">Occupation: </label>
                            <div class="col-sm-4">
                                <label class=""><?php echo $member_info['occupation'];?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 ">Employer: </label>
                            <div class="col-sm-4">
                                <label class=""><?php echo $member_info['employer'];?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 ">Client Status </label>
                            <div class="col-sm-4">
                                <?php echo form_dropdown('client_status_list', $client_status_list, '', 'class=form-control id=client_status_list'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 ">Start Date: </label>
                            <div class="col-sm-4">
                                <?php echo form_input($start_date + array('class' => 'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 ">End Date: </label>
                            <div class="col-sm-4">
                                <?php echo form_input($end_date + array('class' => 'form-control'));?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Contact details-->
                <div class="row hidden_tab" id="contact_details">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label class="col-sm-4 ">Telephone: </label>
                            <div class="col-sm-6">
                                <label class=""><?php echo $member_info['telephone'];?></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 ">Mobile: </label>
                            <div class="col-sm-6">
                                <?php echo form_input($mobile + array('class' => 'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 ">Address: </label>
                            <div class="col-sm-6">
                                <?php echo form_textarea($address + array('class' => 'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 ">Emergency contact: </label>
                            <div class="col-sm-6">
                                <?php echo form_input($emergency_contact + array('class' => 'form-control'));?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 ">Emergency phone: </label>
                            <div class="col-sm-6">
                                <?php echo form_input($emergency_phone + array('class' => 'form-control'));?>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Health details-->
                <div class="row hidden_tab" id="health">
                    <div class="col-md-12">
                        <?php foreach ($question_list as $question_info){?>
                        <div class="row form-group">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="radio" name="question_radio_<?php echo $question_info['question_id'] ?>" value="yes"> Yes
                                        </div>
                                        <div class="col-md-6">
                                            <input type="radio" name="question_radio_<?php echo $question_info['question_id'] ?>" value="no"> No 
                                            <input type="hidden" value="question_id_<?php echo $question_info['question_id'] ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="patapota"><?php echo $question_info['title'] ?></label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div style="display: <?php echo ($question_info['show_additional_info'] == 1) ? 'block' : 'none'; ?>" >
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label style="padding-left:0px;">Additional info: </label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <input class="form-control" type="text" id="question_additional_info_<?php echo $question_info['question_id'] ?>" name="question_additional_info_<?php echo $question_info['question_id'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>Height (cm): </label>
                            </div>
                            <div class="col-md-9">
                                <?php echo form_input($height + array('class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>Resting Heart Rate: </label>
                            </div>
                            <div class="col-md-9">
                                <?php echo form_input($resting_heart_rate + array('class' => 'form-control')); ?>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label>Blood Pressure: </label>
                            </div>
                            <div class="col-md-9">
                                <?php echo form_input($blood_pressure + array('class' => 'form-control')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Notes-->
                <div class="row hidden_tab" id="notes">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label class="col-sm-4 ">Notes: </label>
                            <div class="col-sm-8">
                                <?php echo form_textarea($notes + array('class' => 'form-control'));?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pad_title" style="padding-left:15px">                
                    <div class="row">
                        <div class="col-md-5">
                            <div class="hidden_tab" id="add_client_btn" style="display: block">
                                <button onclick="$('.hidden_tab').hide();$('#contact_details').show();$('#contact_details_btn').show();">Next</button>
                            </div>
                            <div class="hidden_tab" id="contact_details_btn">
                                <button onclick="$('.hidden_tab').hide();$('#add_client').show();$('#add_client_btn').show();">Previous</button>
                                &nbsp;&nbsp;
                                <button onclick="$('.hidden_tab').hide();$('#health').show();$('#health_btn').show();">Next</button>
                            </div>
                            <div class="hidden_tab" id="health_btn">
                                <button onclick="$('.hidden_tab').hide();$('#contact_details_btn').show();$('#contact_details').show();">Previous</button>
                                &nbsp;&nbsp;
                                <button onclick="$('.hidden_tab').hide();$('#notes_btn').show();$('#notes').show();">Next</button>
                            </div>
                            <div class="hidden_tab" id="notes_btn">
                                <button onclick="$('.hidden_tab').hide();$('#health_btn').show();$('#health').show();">Previous</button>
                                &nbsp;&nbsp;
                                <button id="submit_create_client" name="submit_create_client">Save Changes</button>
                            </div>
                        </div> 
                    </div>
                </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>