<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <!--left nav custom for this page-->
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#add_client').show();">Client Info</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#contact_details').show();">Contact Details</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#health').show();">Health Questions</a>
            </div>
            <div class="ln_item" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#notes').show();">Notes</a>
            </div>
        </div>
        <div class="col-md-7">
            <div class="pad_title">
                SHOW CLIENT
            </div>
            <div class="row row form-group">
                <label class="col-md-4 control-label">First Name: </label>
                <div class="col-md-8"><?php echo $client_info['first_name']; ?></div>
            </div>
            <div class="row row form-group">
                <label class="col-md-4 control-label">Last Name: </label>
                <div class="col-md-8"><?php echo $client_info['last_name']; ?></div>
            </div>
            <div class="row form-group">
                <label class="col-md-4 control-label">Gender </label>
                <div class="col-md-8"><?php echo $client_info['gender_name']; ?></div>
            </div>
            <div class="row form-group">
                <label class="col-md-4 control-label">Email: </label>
                <div class="col-md-8"><?php echo $client_info['email']; ?></div>
            </div>
            <div class="row form-group">
                <label class="col-md-4 control-label">Start Date: </label>
                <div class="col-md-8"><?php echo $client_info['start_date']; ?></div>
            </div>
            <div class="row form-group">
                <label class="col-md-4 control-label">End Date: </label>
                <div class="col-md-8"><?php echo $client_info['end_date']; ?></div>
            </div>
            <div class="row form-group">
                <label class="col-md-4 control-label">Birth Date: </label>
                <div class="col-md-8"><?php echo $client_info['birth_date']; ?></div>
            </div>
            <div class="row form-group">
                <label class="col-md-4 control-label">Client Status </label>
                <div class="col-md-8"><?php echo $client_info['status_title']; ?></div>
            </div>
            <div class="row form-group">
                <label class="col-md-4 control-label">Occupation: </label>
                <div class="col-md-8"><?php echo $client_info['occupation']; ?></div>
            </div>
            <div class="row form-group">
                <label class="col-md-4 control-label">Company Name: </label>
                <div class="col-md-8"><?php echo $client_info['company_name']; ?></div>
            </div>





        </div>
        <div class="col-md-3">
            
        </div>
    </div>
</div>