<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-3">
            <?php $this->load->view("applications/gympro/template/sections/client_left_pane"); ?>
        </div>
        <div class="col-md-7">
            <div class="row form-group">
                <div class="col-md-2" style="font-size: 20px; color: maroon">
                    <span>Missions</span>
                </div>
            </div>
            <?php
            $total_missions = count($mission_list);
            $counter = 0;
            foreach($mission_list as $mission_info)
            {
                if($counter%APP_GYMPRO_MANAGE_CLIENTS_CLIENTS_PER_ROW == 0)
                {
                    echo '<div class="row top_margin">';
                    echo '<div class="col-md-6 right_padding_zero">';
                }
                else
                {
                    echo '<div class="col-md-6 right_padding_zero">';
                }
                ?>
            <div class="user_prof">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <a href="<?php echo base_url().'applications/gympro/show_my_mission/'.$mission_info['mission_id']?>">
                            <?php if(isset($mission_info['picture']) && $mission_info['picture'] != ''){ ?>
                            <img style="width: 100%" class="img-responsive" src="<?php echo base_url().CLIENT_PROFILE_PICTURE_PATH_W50_H50.$mission_info['picture'] ?>"/>
                            <?php }else{?>
                            <img style="width: 100%" class="img-responsive" src="<?php echo base_url().CLIENT_PROFILE_PICTURE_PATH_W50_H50.CLIENT_DEFAULT_PROFILE_PICTURE_NAME ?>"/>
                            <?php } ?>
                        </a>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <a style="font-size: 18px" href="<?php echo base_url().'applications/gympro/show_my_mission/'.$mission_info['mission_id']?>"><?php echo $mission_info['label']?></a>
                    </div>
                </div>
            </div>
        </div>
        <?php
        
        if($counter%APP_GYMPRO_MANAGE_CLIENTS_CLIENTS_PER_ROW == (APP_GYMPRO_MANAGE_CLIENTS_CLIENTS_PER_ROW-1) || $counter == $total_missions)
        {
            echo '</div>';
        }  
        $counter++;
            }
            ?>

        </div>
    </div>
</div>