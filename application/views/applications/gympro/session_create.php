<script>
    $(function () {
        $("#session_date").datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url();?>resources/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select date",
            dateFormat: 'dd-mm-yy'
        });
        
        $("#dd_start_date").change(function() {
            var start_index = document.getElementById("dd_start_date").selectedIndex;
            var dd_length      = document.getElementById("dd_start_date").length;
            var end_index = (start_index>=dd_length-1)? dd_length-1 : start_index+1;
            document.getElementById("dd_end_date").selectedIndex = (end_index);
        });
        $("#dd_type").change(function() {
            if($("#dd_type").val()!='1'){
                $("#dd_rep").show();
            }
            else if($("#dd_type").val()=='1'){
                $("#dd_rep").hide();
            }
        });
            
        $("#dd_cost").change(function() {
            if($("#dd_cost").val()=='other'){
                $("#inp_cost").show();
            }
            else if($("#dd_cost").val()!='other'){
                $("#inp_cost").hide();
                $("#inp_cost").val( $("#dd_cost").val() );
            }
        })
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
                <div class="col-md-12">
                    Adding new session
                    <div class="row form-group">
                        <div class="col-md-4" style="border-bottom: 1px solid #999999"></div>
                    </div>
                </div>
            </div>
            <?php if(isset($message) && ($message != NULL)): ?>
            <div class="alert alert-info alert-dismissible"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <?php echo form_open('applications/gympro/create_session', array('class'=>'form-horizontal'));?>
            <div class="row">
                <div class="col-md-6">
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Title: </div>
                        <div class="col-md-9">
                            <input class="form-control" name="title" value="<?php echo set_value('title'); ?>" >
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Group and Client</div>
                        <div class="col-md-4">
                            <select class="form-control" name="group_client">
                                <optgroup label="Groups">
                                    <?php foreach ($group_list as $group_info): ?>
                                        <option value="<?php echo SESSION_CREATED_FOR_GROUP_TYPE_ID.SESSION_CREATED_FOR_TYPE_EXPLODER.$group_info['group_id']; ?>"><?php echo $group_info['title']; ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                                <optgroup label="Clients">
                                    <?php foreach ($client_list as $client_info): ?>
                                        <option value="<?php echo SESSION_CREATED_FOR_CLIENT_TYPE_ID.SESSION_CREATED_FOR_TYPE_EXPLODER.$client_info['client_id']; ?>"><?php echo $client_info['first_name'] . ' ' . $client_info['last_name']; ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Date:</div>
                        <div class="col-md-6">
                            <input class="" id="session_date" name="session_date" value="<?php echo set_value('session_date'); ?>" >
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">Start:</div>
                        <div class="col-md-4">
                            <select class="form-control" name="start" id="dd_start_date">
                                <?php foreach ($session_times as $session_time){ ?>
                                    <option value="<?php echo $session_time['title_24']; ?>"><?php echo $session_time['title']; ?></option>
                                <?php }; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Finish:</div>
                        <div class="col-md-4">
                            <select class="form-control" name="end" id="dd_end_date">
                                <?php foreach ($session_times as $session_time){ ?>
                                    <option value="<?php echo $session_time['title_24']; ?>"><?php echo $session_time['title']; ?></option>
                                <?php }; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Location</div>
                        <div class="col-md-9">
                            <input class="form-control" name="location" value="<?php echo set_value('location'); ?>" > 
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Type:</div>
                        <div class="col-md-4">
                            <select class="form-control" name="type_id" id="dd_type">
                                <?php foreach ($session_types as $type){ ?>
                                    <option value="<?php echo $type['id']; ?>"><?php echo $type['title']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <div class="row" id="dd_rep" style="display: none">
                                <div class="col-sm-3"> For</div>
                                <div class="col-sm-6">
                                    <select class="form-control" name="repeat">
                                        <?php foreach ($session_repeats as $repeat){ ?>
                                            <option value="<?php echo $repeat['id']; ?>"><?php echo $repeat['title']; ?></option>
                                        <?php }; ?>
                                    </select>
                                </div>
                                <div class="col-sm-3"> sessions</div>
                            
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Cost:</div>
                        <div class="col-md-4">
                            <select class="form-control" id="dd_cost">
                                <?php foreach ($session_costs as $cost): ?>
                                    <option value="<?php echo $cost['title']; ?>"><?php echo $cost['title']; ?></option>
                                <?php endforeach; ?>
                                    <option value="other" >Other</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input value="<?php echo $session_costs[0]['title'];?>" type="text" id="inp_cost" name="cost" style="display: none" placeholder="Enter cost">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Status:</div>
                        <div class="col-md-4">
                            <select class="form-control" name="status">
                                <?php foreach ($session_statuses as $status): ?>
                                    <option value="<?php echo $status['id']; ?>"><?php echo $status['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <div class="row form-group">
                        <div class="col-md-1 control-div">Notes</div> 
                        <div class="col-md-10">
                            <textarea class="form-control" name="note" rows="10"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-4 pull-right">
                    <button class="btn button-custom btn_gympro" type="submit" >Create Session</button>
                </div>
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>