<script>
    $(function() {
        $("#session_date").datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url(); ?>resources/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select date",
            dateFormat: 'dd-mm-yy'
        });

//        // may not be useful for editing, hence commented
//        $("#dd_start_date").change(function() {
//            var start_index = document.getElementById("dd_start_date").selectedIndex;
//            var dd_length      = document.getElementById("dd_start_date").length;
//            var end_index = (start_index>=dd_length-1)? dd_length-1 : start_index+1;
//            document.getElementById("dd_end_date").selectedIndex = (end_index);
//        });
        $("#dd_type").change(function() {
            if ($("#dd_type").val() != '1') {
                $("#dd_rep").show();
            }
            else if ($("#dd_type").val() == '1') {
                $("#dd_rep").hide();
            }
        });
        if ('<?php echo $session_info['type_id'] ?>' != '1') {
            $("#dd_rep").show();
        }
        $("#dd_cost").change(function() {
            if ($("#dd_cost").val() == 'other') {
                $("#inp_cost").show();
            }
            else if ($("#dd_cost").val() != 'other') {
                $("#inp_cost").hide();
                $("#inp_cost").val($("#dd_cost").val());
            }
        });
        $("#inp_cost").change(function() {
            if($("#inp_cost").val() < 10)
            {
                print_common_message("Please assign a cost value more than or equal to 10");
                $("#inp_cost").val('');
            }
            
        });
    });
</script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<div class="container-fluid">
    <div class="row top_margin">
        <?php
        if ($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT) {
            $this->load->view("applications/gympro/template/sections/client_left_pane");
        } else {
            $this->load->view("applications/gympro/template/sections/pt_left_pane");
        }
        ?>
        <div class="col-md-10">

            <div class="row">
                <div class="col-md-12 heading_medium_thin">
                    Edit session
                    <div class="row form-group">
                        <div class="col-md-4" style="border-bottom: 1px solid #999999"></div>
                    </div>
                    <div class="row form-group"></div>
                </div>
            </div>
            <?php if (isset($message) && ($message != NULL)): ?>
                <div class="alert alert-info alert-dismissible"><?php echo $message; ?></div>
            <?php endif; ?>
            <?php echo form_open('applications/gympro/update_session/' . $session_id, array('class' => 'form-horizontal')); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="row form-group">
                        <div class="col-md-3 content_text">Title: </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="title" value="<?php echo $session_info['title']; ?>">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 content_text">Group and Client</div>
                        <div class="col-md-4">
                            <select class="form-control" name="group_client">
                                <optgroup label="Groups">
                                    <?php foreach ($group_list as $group_info): ?>
                                        <option <?php echo ('1' == $session_info['created_for_type_id'] && $session_info['reference_id'] == $group_info['group_id']) ? 'selected' : NULL; ?> value="<?php echo SESSION_CREATED_FOR_GROUP_TYPE_ID . SESSION_CREATED_FOR_TYPE_EXPLODER . $group_info['group_id']; ?>"><?php echo $group_info['title']; ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                                <optgroup label="Clients">
                                    <?php foreach ($client_list as $client_info): ?>
                                        <option <?php echo ('2' == $session_info['created_for_type_id'] && $session_info['reference_id'] == $client_info['client_id']) ? 'selected' : NULL; ?> value="<?php echo SESSION_CREATED_FOR_CLIENT_TYPE_ID . SESSION_CREATED_FOR_TYPE_EXPLODER . $client_info['client_id']; ?>"><?php echo $client_info['first_name'] . ' ' . $client_info['last_name']; ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 content_text">Date:</div>
                        <div class="col-md-6">
                            <input type="text" class="" id="session_date" name="session_date" value="<?php echo $session_info['date']; ?>" >
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 content_text">Start:</div>
                        <div class="col-md-4">
                            <select class="form-control" name="start" id="dd_start_date">
                                <?php foreach ($session_times as $session_time): ?>
                                    <option <?php echo ( (string) $session_time['title_24'] == (string) $session_info['start']) ? 'selected' : NULL; ?> value="<?php echo $session_time['title_24']; ?>"><?php echo $session_time['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 content_text">Finish:</div>
                        <div class="col-md-4">
                            <select class="form-control" name="end" id="dd_end_date">
                                <?php foreach ($session_times as $session_time): ?>
                                    <option <?php echo ( (string) $session_time['title_24'] == (string) $session_info['end']) ? 'selected' : NULL; ?> value="<?php echo $session_time['title_24']; ?>"><?php echo $session_time['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 content_text">Location</div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="location" value="<?php echo $session_info['location']; ?>"> 
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 content_text">Type:</div>

                        <div class="col-md-4">
                            <select class="form-control" name="type_id" id="dd_type">
                                <?php foreach ($session_types as $type): ?>
                                    <option <?php echo ($type['id'] == $session_info['type_id']) ? 'selected' : NULL; ?> value="<?php echo $type['id']; ?>"><?php echo $type['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <div class="row" id="dd_rep" style="display: none">
                                <div class="col-sm-3"> For</div>
                                <div class="col-sm-6">
                                    <select class="form-control" name="repeat">
                                        <?php foreach ($session_repeats as $repeat): ?>
                                            <option <?php echo ($session_info['repeat'] == $repeat['title']) ? 'selected ' : NULL; ?>value="<?php echo $repeat['title']; ?>"><?php echo $repeat['title']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-3"> sessions</div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 content_text">Cost:</div>
                        <div class="col-md-4">
                            <select class="form-control" name="cost" id="dd_cost">
                                <option value="other" >Other</option>
                                <?php foreach ($session_costs as $cost): ?>
                                    <option <?php echo ($cost['title'] == $session_info['cost']) ? 'selected' : NULL; ?>  value="<?php echo $cost['title']; ?>"><?php echo $cost['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input value="<?php echo $session_info['cost']; ?>" type="text" id="inp_cost" name="cost" <?php
                            if ($dont_show_cost_text == 1) {
                                echo 'style="display: none"';
                            }
                            ?> placeholder="Enter cost">
                        </div>
                    </div>
                      <div class="row form-group">
                        <div class="col-md-3 content_text ">Currency:</div>
                        <div class="col-md-4">
                             <?php echo form_dropdown('currency_list', $currency_list, $session_info['currency_id'], 'class=form-control id=currency_list'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 content_text">Status:</div>
                        <div class="col-md-4">
                            <?php if ($session_info['status_id'] == GYMPRO_SESSION_STATUS_UNPAID_ID) { ?>
                                <select class="form-control" name="status">
                                    <?php foreach ($session_statuses as $status): ?>
                                        <option <?php echo ($status['id'] == $session_info['status_id']) ? 'selected' : NULL; ?> value="<?php echo $status['id']; ?>"><?php echo $status['title']; ?></option>  
                                    <?php endforeach; ?>
                                </select>
                                <?php
                            } else {
                                foreach ($session_statuses as $status) {
                                    if ($status['id'] == $session_info['status_id']) {
                                        echo $status['title'];
                                    }
                                }
                            }
                            ?>

                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <div class="row form-group">
                        <div class="col-md-1 content_text">Notes</div> 
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <textarea class="form-control" name="note" rows="10"><?php echo $session_info['note']; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-4 pull-right">
                    <button class="btn button-custom btn_gympro" type="submit" >Update Session</button>
                </div> 
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>