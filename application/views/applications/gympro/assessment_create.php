<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-8">
            <div class="pad_title">
                NEW ASSESSMENT
            </div>
            <div class="pad_body">
                <?php echo form_open("applications/gympro/create_assessment/", array('id' => 'form_assesment', 'class' => 'form-horizontal')); ?>

                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-md-4">Date:</div>
                            <div class="col-md-5"><input class="form-control"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Weight:</div>
                            <div class="col-md-5"><input class="form-control"></div>kg
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Head:</div>
                            <div class="col-md-5"><input class="form-control"></div>cm
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Neck:</div>
                            <div class="col-md-5"><input class="form-control"></div>cm
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Chest:</div>
                            <div class="col-md-5"><input class="form-control"></div>cm
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-md-4">Reassess in:</div>
                            <div class="col-md-4">
                                <select class="form-control">

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Body fat:</div>
                            <div class="col-md-5"><input class="form-control"></div>%
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Abdominal:</div>
                            <div class="col-md-5"><input class="form-control"></div>cm
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Waist:</div>
                            <div class="col-md-5"><input class="form-control"></div>cm
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Hip:</div>
                            <div class="col-md-5"><input class="form-control"></div>cm
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div style="background-color: white">
                            <div class="row form-group">
                                <div class="col-md-2"></div>
                                <div class="col-md-2" style="text-align: center">LEFT SIDE</div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2" style="text-align: center">RIGHT SIDE</div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-5">Arm Relaxed:</div>
                                            <div class="col-md-6"><input class="form-control"></div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Arm Flexed:</div>
                                            <div class="col-md-6"><input class="form-control"></div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Forearm:</div>
                                            <div class="col-md-6"><input class="form-control"></div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Wrist:</div>
                                            <div class="col-md-6"><input class="form-control"></div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Thigh (gluteal):</div>
                                            <div class="col-md-6"><input class="form-control"></div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Thigh (mid):</div>
                                            <div class="col-md-6"><input class="form-control"></div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Kalf:</div>
                                            <div class="col-md-6"><input class="form-control"></div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Ankle:</div>
                                            <div class="col-md-6"><input class="form-control"></div>cm
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-5">Arm Relaxed:</div>
                                            <div class="col-md-6"><input class="form-control"></div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Arm Flexed:</div>
                                            <div class="col-md-6"><input class="form-control"></div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Forearm:</div>
                                            <div class="col-md-6"><input class="form-control"></div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Wrist:</div>
                                            <div class="col-md-6"><input class="form-control"></div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Thigh (gluteal):</div>
                                            <div class="col-md-6"><input class="form-control"></div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Thigh (mid):</div>
                                            <div class="col-md-6"><input class="form-control"></div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Kalf:</div>
                                            <div class="col-md-6"><input class="form-control"></div>cm
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-5">Ankle:</div>
                                            <div class="col-md-6"><input class="form-control"></div>cm
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="pad_footer">
                <button>Save</button> or <a href="<?php echo base_url() ?>applications/gympro/assessments">Go Back</a>
            </div>
        </div>
    </div>
</div>