<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-9">
            <div class="row form-group">
                <div class="col-md-12">
                    <span style="color: maroon; font-size: 16px">The smarter way to fiend sports buddies and personal trainers</span>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <div style="position: relative">
                        <div style="position: absolute; top: 15px; left: 25px; background-color: whitesmoke; padding: 5px; width: 300px;">
                            <select class="form-control" name="client_list" id="client_list">        
                                <option selected="selected" value="0">Select...</option> 
                                <option value="1">Sports buddy</option> 
                                <option value="2">Personal Trainer</option>
                            </select>
                        </div>
                        <img class="img-responsive" src="<?php echo base_url(); ?>resources/images/applications/gympro/personal-trainers.jpg">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>