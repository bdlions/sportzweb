<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-10">
            <div class="pad_title">
                NEW MISSION
            </div>
            <div class="pad_body">
                <div style="display: inline-block; width: 100%">
                    <form class="form-horizontal" role="form">
                        <div class="row form-group">
                            <label class="col-sm-2 control-label">Label: </label>
                            <div class="col-sm-4">
                                <input class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 control-label">Mission Ends: </label>
                            <div class="col-sm-2">
                                <input class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 control-label">Mission Starts: </label>
                            <div class="col-sm-2">
                                <input class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-offset-1 col-sm-9 top_margin">
                                Please enter the Health & Fitness Missions for each day below.
                                If there is more than one mission for a particular day please enter it on a new line.
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 control-label">Sunday: </label>
                            <div class="col-sm-6">
                                <textarea class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 control-label">Monday: </label>
                            <div class="col-sm-6">
                                <textarea class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 control-label">Tuesday: </label>
                            <div class="col-sm-6">
                                <textarea class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 control-label">Wednesday: </label>
                            <div class="col-sm-6">
                                <textarea class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 control-label">Thursday: </label>
                            <div class="col-sm-6">
                                <textarea class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 control-label">Friday: </label>
                            <div class="col-sm-6">
                                <textarea class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 control-label">Saturday: </label>
                            <div class="col-sm-6">
                                <textarea class="form-control"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="pad_footer">
                <button>Save Changes</button> or <a href="">Go Back</a>
            </div>
        </div>
    </div>

</div>
<?php
$this->load->view("applications/gympro/template/modal/browse_exercise");
?>