<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<div class="container-fluid">
    
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-10">
            <div class="pad_title">
                ADDING EXERCISE
            </div>
            <div class="pad_body">
                <?php echo form_open("applications/gympro/create_assessment/", array('id' => 'form_assesment', 'class' => 'form-horizontal')); ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row form-group">
                            <div class="col-md-4">
                                Category:*
                            </div>
                            <div class="col-md-6">
                                <select class="form-control"></select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Name:*
                            </div>
                            <div class="col-md-6">
                                <input class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Description:
                            </div>
                            <div class="col-md-8">
                                <textarea class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Upload a photo:
                            </div>
                            <div class="col-md-6">
                                <input type="file">
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="pad_footer">
                <button>Save Exercise</button> or <a href="<?php echo base_url()?>applications/gympro/exercises">Cancel</a>
            </div>
        </div>
    </div>

</div>