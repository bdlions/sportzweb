<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<div class="container-fluid">
    <div class="row top_margin">
        <?php 
        if($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT)
        {
            $this->load->view("applications/gympro/template/sections/client_left_pane"); 
        }
        else
        {
            $this->load->view("applications/gympro/template/sections/pt_left_pane"); 
        }            
        ?>
        <div class="col-md-offset-2 col-md-6" style="padding: 200px,100px,00px,100px">
            <div class="row form-group"></div>
            <div class="row form-group"></div>
            <div class="row form-group"></div>
            <div class="row form-group"></div>
            <div class="row form-group"><span style="color: #880015;font-size: 20px">Sorry! You are not permitted to edit this assessment</span></div>
        </div>
    </div>
</div>
