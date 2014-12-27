<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-9">
            <div class="row form-group">
                <div class="col-md-12">
                    <span>The smarter way to fiend sports buddiesand personal trainers</span>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <div style="position: relative">
                        <div style="position: absolute; top: 15px; left: 25px; background-color: whitesmoke; padding: 5px; width: 300px;">
                            <?php $this->load->view("applications/gympro/template/user_category_dropdown"); ?>
                        </div>
                        <img class="img-responsive" src="<?php echo base_url(); ?>resources/images/applications/gympro/personal-trainers.jpg">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>