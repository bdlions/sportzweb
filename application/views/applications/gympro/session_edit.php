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
            if($("#dd_type").val()!='1')
            {
                $("#dd_rep").show();
            }
            else if($("#dd_type").val()=='1')
            {
                $("#dd_rep").hide();
            }
        });
        $("#dd_cost").change(function() {
            
            if($("#dd_cost").val()=='other')
            {
                $("#inp_cost").show();
            }
            else if($("#dd_cost").val()!='other')
            {
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
                    Edit session
                    <div class="row form-group">
                        <div class="col-md-4" style="border-bottom: 1px solid #999999"></div>
                    </div>
                </div>
            </div>
            <?php echo form_open('applications/gympro/update_session/'. $session_id, array('class'=>'form-horizontal'));?>
            <div class="row">
                <?php var_dump($session_info);?>
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
                            
                            <!--INCOMPLETE !!!!!!!!!!!!!! -->
                            <select class="form-control" name="group_client">
                            <optgroup label="Groups">
                                <?php foreach ($group_list as $group_info): ?>
                                <option <?php echo ($group_info['group_id'] == $session_info['group_id'])? 'selected': NULL ;?> value="<?php echo $group_info['group_id']; ?>"><?php echo $group_info['title']; ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                            <optgroup label="Clients">
                                <option>Shem Haye</option>
                                <?php foreach ($client_list as $client_info): ?>
                                <option <?php echo ($group_info['client_id'] == $session_info['reference_id'])? 'selected': NULL ;?> value="<?php echo $client_info['client_id']; ?>"><?php echo $client_info['first_name'].' '.$client_info['last_name']; ?></option>
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
                        <div class="col-md-3">Start:</div>
                        <div class="col-md-4">
                            <select class="form-control" name="start">
                                <?php foreach ($meal_time_list as $key => $meal_time): ?>
                                    <option <?php echo ($key+1 == $session_info['start'])? 'selected': NULL ;?> value="<?php echo $key+1; ?>"><?php echo $meal_time; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Finish:</div>
                        <div class="col-md-4">
                            <select class="form-control" name="end">
                                <?php foreach ($meal_time_list as $key => $meal_time): ?>
                                    <option <?php echo ($key+1 == $session_info['end'])? 'selected': NULL ;?> value="<?php echo $key+1; ?>"><?php echo $meal_time; ?></option>
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
                                <?php foreach ($session_repeat as $key => $repeat): ?>
                                    <option <?php echo ($key+1 == $session_info['type_id'])? 'selected': NULL ;?> value="<?php echo $key+1; ?>"><?php echo $repeat['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Cost:</div>
                        <div class="col-md-4">
                            <select class="form-control" name="cost">
                                <?php foreach ($session_costs as $key => $cost): ?>
                                    <option <?php echo ($key+1 == $session_info['cost'])? 'selected': NULL ;?> value="<?php echo $key+1; ?>"><?php echo $cost['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
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
                    <button class="btn btn-success" type="submit" >Update Session</button>
                </div> 
            </div>
            <?php echo form_close();?>
        </div>
    </div>
</div>
<?php
//$this->load->view("applications/gympro/template/modal/browse_exercise");
?>