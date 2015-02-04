<script>
    $(function () {
        $("#datepicker").datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url();?>resources/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select date",
            dateFormat: 'dd-mm-yy'
        });
        
        $("#dd_type").change(function() {
            if($("#dd_type").val()!='1'){
                $("#dd_rep").show();
            }
            else if($("#dd_type").val()=='1'){
                $("#dd_rep").hide();
            }
        });
        if( '<?php echo $session_info['type_id']?>' !='1' ){$("#dd_rep").show();}
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
            <?php if(isset($message) && ($message != NULL)): ?>
            <div class="alert alert-info alert-dismissible"><?php echo $message; ?></div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-12">
                    Edit session
                    <div class="row form-group">
                        <div class="col-md-4" style="border-bottom: 1px solid #999999"></div>
                    </div>
                </div>
            </div>
            <?php echo form_open('applications/gympro/update_session/'. $session_id, array('class'=>'form-horizontal'));?>
            <div class="row">
                <div class="col-md-6">
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Title: </div>
                        <div class="col-md-9">
                            <input class="form-control" name="title" value="<?php echo $session_info['title'];?>">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Group and Client</div>
                        <div class="col-md-4">
                            <select class="form-control" name="group_client">
                                <optgroup label="Groups">
                                    <?php foreach ($group_list as $group_info): ?>
                                        <option <?php echo ('1' == $session_info['created_for_type_id'] && $session_info['reference_id'] == $group_info['group_id']) ? 'selected' : NULL; ?> value="1_<?php echo $group_info['group_id']; ?>"><?php echo $group_info['title']; ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                                <optgroup label="Clients">
                                    <?php foreach ($client_list as $client_info): ?>
                                        <option <?php echo ('2' == $session_info['created_for_type_id'] && $session_info['reference_id'] == $client_info['client_id']) ? 'selected' : NULL; ?> value="2_<?php echo $client_info['client_id']; ?>"><?php echo $client_info['first_name'] . ' ' . $client_info['last_name']; ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Date:</div>
                        <div class="col-md-6">
                            <input class="" id="datepicker" name="datepicker" value="<?php echo $session_info['date'];?>" >
                        </div>
                    </div>
                    <div class="row form-group">
                        <?php // var_dump($session_info);?>
                        <?php // var_dump($session_times);?>
                        <div class="col-md-3">Start:</div>
                        <div class="col-md-4">
                            <select class="form-control" name="start">
                                <?php foreach ($session_times as $key => $session_time): ?>
                                    <option <?php echo ( (string)$session_time['title_24'] == (string)$session_info['start']) ? 'selected': NULL ;?> value="<?php echo $session_time['title_24']; ?>"><?php echo $session_time['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Finish:</div>
                        <div class="col-md-4">
                            <select class="form-control" name="end">
                                <?php foreach ($session_times as $key => $session_time): ?>
                                    <option <?php echo ( (string)$session_time['title_24'] == (string)$session_info['end']) ? 'selected': NULL ;?> value="<?php echo $session_time['title_24']; ?>"><?php echo $session_time['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Location</div>
                        <div class="col-md-9">
                            <input class="form-control" name="location" value="<?php echo $session_info['location'];?>"> 
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Type:</div>
                        
                        <div class="col-md-4">
                            <select class="form-control" name="type_id" id="dd_type">
                                <?php foreach ($session_types as $key => $type): ?>
                                    <option <?php echo ($key+1 == $session_info['type_id'])? 'selected': NULL ;?> value="<?php echo $key+1; ?>"><?php echo $type['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control" id="dd_rep" name="repeat" style="display: none">
                                <?php foreach ($session_repeats as $key => $repeat): ?>
                                    <option <?php echo ($key+1 == $session_info['repeat'])? 'selected': NULL ;?> value="<?php echo $key+1; ?>"><?php echo $repeat['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Cost:</div>
                        <div class="col-md-4">
                            <select class="form-control" name="cost" id="dd_cost">
                                    <option value="other" >Other</option>
                                <?php foreach ($session_costs as $key => $cost): ?>
                                    <option <?php echo ($cost['title'] == $session_info['cost'])? 'selected': NULL ;?>  value="<?php echo $cost['title']; ?>"><?php echo $cost['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input value="<?php echo $session_info['cost'];?>" type="text" id="inp_cost" name="cost" <?php if($dont_show_cost_text==1){echo 'style="display: none"';}?> placeholder="Enter cost">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Status:</div>
                        <div class="col-md-4">
                            <select class="form-control" name="status">
                                <?php foreach ($session_statuses as $key => $status): ?>
                                    <option <?php echo ($key+1 == $session_info['status_id'])? 'selected': NULL ;?> value="<?php echo $key+1; ?>"><?php echo $status['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <div class="row form-group">
                        <div class="col-md-1 control-div">Notes</div> 
                        <div class="col-md-10">
                            <textarea class="form-control" name="note" rows="10"><?php echo $session_info['note'];?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-4 pull-right">
                    <button class="btn button-custom btn_gympro" type="submit" >Update Session</button>
                </div> 
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>
<?php
//$this->load->view("applications/gympro/template/modal/browse_exercise");
?>