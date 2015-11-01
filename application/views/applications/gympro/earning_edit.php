<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-10">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row form-group">
                            <div class="col-md-2 control-div">Title: </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 control-div">Client</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option class="form-control">
                                        test
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 control-div">Group</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option class="form-control">
                                        test
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 control-div">Date:</div>
                            <div class="col-md-6">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 control-div">Start:</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option class="form-control">
                                        strattest
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2 control-div">Finish:</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option class="form-control">
                                        strattest
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 control-div">Location</div>
                            <div class="col-md-6">
                                <input type="text" class="form-control"> 
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 control-div">Type:</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option class="form-control">
                                        type
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 control-div">Cost:</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option class="form-control">
                                        cost
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 control-div">Status:</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option class="form-control">
                                        Status
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 control-div">Clint:</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option class="form-control">
                                        Clint
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 control-div">Start:</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option class="form-control">
                                        start
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 control-div">Finish:</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option class="form-control">
                                        finish
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-2 control-div">Type:</div>
                            <div class="col-md-4">
                                <select class="form-control">
                                    <option class="form-control">
                                        type
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row form-group">
                            <div class="col-md-2 control-div">Notes</div> 
                            <div class="col-md-9">
                                <textarea class="form-control" rows="10"></textarea>
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