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
        <div class="col-md-9">
            <div class="row form-group">
                <div class="col-md-12">
                    
                    <?php if(isset($message) && ($message != NULL)): ?>
                    <div class="alert alert-info alert-dismissible"><?php echo $message; ?></div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>