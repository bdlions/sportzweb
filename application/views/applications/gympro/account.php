<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<div class="container-fluid">    
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-7" style="height: 400px; background-color: lightgray;">
            <div class="row form-group" style="position: absolute; top: 50%; display: inline-block; width: 100%">
                <div class="col-md-offset-1 col-md-3">
                    <label class="control-label pull-right">Height Unit:</label>
                </div>
                <div class="col-md-5">
                    <select class="form-control">
                        <option>Lightweight</option>
                        <option>middleweight</option>
                        <option>Heavy weight</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

</div>