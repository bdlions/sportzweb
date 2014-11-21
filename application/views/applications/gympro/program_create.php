<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-10">
            <div class="pad_title">
                CREATE PROGRAMME
            </div>
            <div class="pad_body">
                <form class="form-horizontal" role="form">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Programme Focus: </label>
                                <div class="col-sm-6">
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Start date: </label>
                                <div class="col-sm-4">
                                    <input class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Review In: </label>
                                <div class="col-sm-5">
                                    <select style=" margin-right: 15px; width: 100px;">
                                        <option> </option>
                                        <option>TIME</option>
                                        <option>oajsodjaosc</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Description: </label>
                                <div class="col-sm-8">
                                    <textarea class="form-control"></textarea>
                                </div>
                            </div>
                            <!--                            <div class="form-group">
                                                            <div class="col-sm-offset-2 col-sm-10">
                                                                <button type="submit" class="btn btn-default">Sign in</button>
                                                            </div>
                                                        </div>-->
                        </div>
                        <div class="col-md-5">

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Warm Up: </label>
                                <div class="col-sm-8">
                                    <textarea class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Cooldown: </label>
                                <div class="col-sm-8">
                                    <textarea class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div style="background-color: #fff; margin-bottom: 1px; padding: 10px; display: inline-block; width: 100%">
                    <span style="font-weight: bold;">Exercie name: &nbsp;&nbsp;</span>
                    <input style="width: 40%; min-width: 150px;">
                    <img onclick="open_modal_browse_exercise()" src="<?php echo base_url();?>resources/images/browse.png" style="margin: 4px">
                </div>
                <div style="background-color: #fff; margin-bottom: 1px; padding: 10px; display: inline-block; width: 100%">
                    <div>
                        <div class="col-md-6" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Description</div>
                            <div><textarea style="width: 100%; min-height: 50px;"></textarea></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Sets</div>
                            <div><input style="width: 100%"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Reps</div>
                            <div><input style="width: 100%"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Weights</div>
                            <div><input style="width: 100%"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Reps</div>
                            <div><input style="width: 100%"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Tempo</div>
                            <div><input style="width: 100%"></div>
                        </div>
                    </div>
                </div>
                <div style="width: 100%; display: inline-block;">
                    <div style="font-size: 16px; line-height: 33px; float: right">
                        Add another: <a href="" >Weight exercise</a>&nbsp; or &nbsp;<a href="">Cardio Exercise</a>
                    </div>
                </div>
<!--                <div>
                    <button style="line-height: 22px;">Save Changes</button> or <a href="" style="font-size: 16px; line-height: 22px;">Go Back</a>
                </div>-->
            </div>
            <div class="pad_footer">
                <button>Save Changes</button> or <a href="<?php echo base_url()?>applications/gympro/programs">Go Back</a>
            </div>
        </div>
    </div>

</div>
<?php
$this->load->view("applications/gympro/template/modal/browse_exercise");
?>