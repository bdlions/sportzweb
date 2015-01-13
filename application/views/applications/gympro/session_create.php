<script>
    $(function () {
        $("#datepicker").datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url();?>resources/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select date"
        });
    });
</script>

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    <div class="row top_margin">
        <?php 
        if($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT)
        {
            $this->load->view("applications/gympro/template/sections/client_left_pane"); 
        }
        else
        {
            $this->load->view("applications/gympro/template/sections/pt_left_pane"); 
        }            
        ?>
        <div class="col-md-10">
            
            
            <div class="row">
                <div class="col-md-12">
                    Adding new session
                    <div class="row form-group">
                        <div class="col-md-4" style="border-bottom: 1px solid #999999">

                        </div>

                    </div>
                </div>

                    
                    <div class="col-md-6">
                        <div class="row form-group">
                            <div class="col-md-3 control-div">Title: </div>
                            <div class="col-md-9">
                                <input class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3 control-div">Group and Client</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                <optgroup label="Groups">
                                    <option>Group- Alpha</option>
                                    <?php foreach ($group_list as $group_info): ?>
                                    <option value="<?php echo $group_info['group_id']; ?>"><?php echo $group_info['title']; ?></option>
                                <?php endforeach; ?>
                                </optgroup>
                                <optgroup label="Clients">
                                    <option>Shem Haye</option>
                                    <?php foreach ($client_list as $client_info): ?>
                                        <option value="<?php echo $client_info['client_id']; ?>"><?php echo $client_info['first_name'].' '.$client_info['last_name']; ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select>
                            </div>
                        </div>
<!--                        <div class="row form-group">
                            <div class="col-md-3 control-div">Group</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <?php foreach ($group_list as $group_info): ?>
                                        <option value="<?php echo $group_info['group_id']; ?>"><?php echo $group_info['title']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>-->
                        <div class="row form-group">
                            <div class="col-md-3 control-div">Date:</div>
                            <div class="col-md-6">
                                <input class="" id="datepicker" >
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3">Start:</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <?php foreach ($meal_time_list as $key => $meal_time): ?>
                                        <option value="<?php echo $key; ?>"><?php echo $meal_time; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3 control-div">Finish:</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <?php foreach ($meal_time_list as $key => $meal_time): ?>
                                        <option value="<?php echo $key; ?>"><?php echo $meal_time; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3 control-div">Location</div>
                            <div class="col-md-9">
                                <input class="form-control"> 
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3 control-div">Type:</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option>Single session</option>
                                    <option>Repeated daily</option>
                                    <option>Single weekly</option>
                                    <option>Single biweekly</option>
                                    <option>Single monthly</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3 control-div">Cost:</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option>Other</option>
                                    <?php
                                    for($counter = 5; $counter <=200; $counter++)
                                    {
                                        echo '<option>'.$counter.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-3 control-div">Status:</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option>
                                        Prepaid
                                    </option>
                                    <option>
                                        Paid
                                    </option>
                                    <option>
                                        Cancelled
                                    </option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-5 col-md-offset-1">
                        <div class="row form-group">
                            <div class="col-md-1 control-div">Notes</div> 
                            <div class="col-md-10">
                                <textarea class="form-control" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                </div>





        </div>
    </div>

</div>
<?php
//$this->load->view("applications/gympro/template/modal/browse_exercise");
?>