<script>
    $(function () {
        $("#datepicker").datepicker({
            showOn: "button",
            buttonImage: "<?php echo base_url(); ?>resources/images/calendar.png",
            buttonImageOnly: true,
            buttonText: "Select date"
        });
    });
</script>

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-12">
                    Earnings Summery
                    <div class="row form-group">
                        <div class="col-md-4" style="border-bottom: 1px solid #999999">

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Client:</div>
                        <div class="col-md-7">
                            <select class="form-control">
                                <option>
                                    Client
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Start:</div>
                        <div class="col-md-7">
                            <select class="form-control">
                                <option>
                                    start
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Finish:</div>
                        <div class="col-md-7">
                            <select class="form-control">
                                <option>
                                    finish
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3 control-div">Type:</div>
                        <div class="col-md-7">
                            <select class="form-control">
                                <option>
                                    type
                                </option>
                            </select>
                        </div>
                    </div>                        
                </div>
                <div class="col-md-8">
                    <div class="row form-group" style="text-align: center">
                        <div class="col-md-4" style="background-color: lightblue; padding: 10px 0px 10px 0px">
                            <div style="font-size: 15px">
                                Prepaid
                            </div>
                            <div style="font-size: 20px">
                                120
                            </div>
                            <div style="font-size: 12px">
                                2 sess
                            </div>
                        </div>
                        <div class="col-md-2" style="background-color: lightgreen; padding: 10px 0px 10px 0px" >
                            <div style="font-size: 15px">
                                Paid
                            </div>
                            <div style="font-size: 20px">
                                120
                            </div>
                            <div style="font-size: 12px">
                                2 sess
                            </div>
                        </div>
                        <div class="col-md-3" style="background-color: lightsalmon; padding: 10px 0px 10px 0px" >
                            <div style="font-size: 15px">
                                Cancelled
                            </div>
                            <div style="font-size: 20px">
                                120
                            </div>
                            <div style="font-size: 12px">
                                2 sess
                            </div>
                        </div>
                        <div class="col-md-3" style="background-color: #ff9; padding: 10px 0px 10px 0px" >
                            <div style="font-size: 15px">
                                Total
                            </div>
                            <div style="font-size: 20px">
                                120
                            </div>
                            <div style="font-size: 12px">
                                2 sess
                            </div>
                        </div>
                    </div>
                    <div class="row form-group" style="border-bottom: 2px solid lightgray; padding-bottom: 10px">
                        <div class="col-md-9" style="font-size: 15px; font-weight: bold; padding-left: 0px">
                            Schedule Session
                        </div>
                        <div class="col-md-3" style="padding-right: 0px">
                            <select class="form-control">
                                <option>
                                    Mark as
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4" style="color: red; border-bottom: 2px solid darkred; padding: 0px 0px 5px 0px">
                            Sunday, 23 November 2121
                        </div>
                    </div>
                    <div class="row form-group" style="border-bottom: 2px solid lightgray; padding-bottom: 10px">
                        <div class="row">
                            <div class="col-md-4">
                                Time range 
                            </div>
                            <div class="col-md-3">
                                name's
                            </div>
                            <div class="col-md-2">
                                dollar 
                            </div>
                            <div class="col-md-2">
                                paid
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4" style="color: red; border-bottom: 2px solid darkred; padding: 0px 0px 5px 0px">
                            Sunday, 23 November 2121
                        </div>
                    </div>
                    <div class="row form-group" style="border-bottom: 2px solid lightgray; padding-bottom: 10px">
                        <div class="row">
                            <div class="col-md-4">
                                Time range 
                            </div>
                            <div class="col-md-3">
                                name's
                            </div>
                            <div class="col-md-2">
                                dollar 
                            </div>
                            <div class="col-md-2">
                                paid
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group" style="border-bottom: 2px solid lightgray; padding-bottom: 10px">
                        <div class="row">
                            <div class="col-md-4">
                                Time range 
                            </div>
                            <div class="col-md-3">
                                name's
                            </div>
                            <div class="col-md-2">
                                dollar 
                            </div>
                            <div class="col-md-2">
                                paid
                            </div>
                            <div class="col-md-1">
                                <input type="checkbox">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view("applications/gympro/template/modal/browse_exercise");
?>