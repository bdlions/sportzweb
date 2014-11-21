<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-10">
            <div class="pad_title">
                NEW ASSESSMENT
            </div>
            <div class="pad_body">
                <div style="display: inline-block; width: 100%">
                    <form class="form-horizontal" role="form">
                        
                    </form>
                </div>
            </div>
            <div class="pad_footer">
                <button>Save</button> or <a href="<?php echo base_url()?>applications/gympro/assessments">Go Back</a>
            </div>
        </div>
    </div>
</div>