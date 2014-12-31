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
            <div class="pad_title">
             EXERCISE INFO
                <div class="col-md-3 pull-right">
                    <?php 
                    if($account_type_id != APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT)
                    {
                        echo $exercise_info['first_name'].' '.$exercise_info['last_name'];
                    }         
                    ?>
                </div>
            </div>
            <div style="border-top: 2px solid lightgray; margin-left: 20px"></div>
            <div class="pad_body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row form-group">
                            <div class="col-md-4">
                                Category:
                            </div>
                             <label class="col-md-8 control-label"><?php echo $exercise_info['exercise_category'];?></label>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Name:
                            </div>
                             <label class="col-md-8 control-label"><?php echo $exercise_info['name'];?></label>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Description:
                            </div>
                             <label class="col-md-8 control-label"><?php echo $exercise_info['description'];?></label>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Picture: 
                            </div>
                            <div class ="col-md-6">
                                    <div class="profile-picture-box" >
                                        <div id="files" class="files">
                                            <?php if (!empty($exercise_info['picture'])): ?>
                                                <img style="width: 50px; height: 50px;" src="<?php echo base_url() . EXERCISE_IMAGES_PATH_W50_H50 . $exercise_info['picture']; ?>" class="img-responsive"/>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>