<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-3">
            <?php $this->load->view("applications/gympro/template/sections/client_left_pane"); ?>
        </div>
        <div class="col-md-7">
            <div class="row form-group">
                <div class="col-md-2" style="font-size: 20px; color: maroon">
                    <span>Exercises</span>
                </div>
                <div class="col-md-3 pull-right right_padding_zero">
                    <a href="<?php echo base_url()?>applications/gympro/create_exercise"><button class="pull-right btn button-custom btn_gympro">New Exercise</button></a>
                </div>
            </div>
            <?php
            $total_exercise = count($exercise_list);
            $counter = 0;
            foreach($exercise_list as $exercise)
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
                        <a href="<?php echo base_url().'applications/gympro/show_exercise/'.$exercise['exercise_id'];?>">
                            <?php if(isset($exercise['picture']) && $exercise['picture'] != ''){ ?>
                            <img style="width: 100%" class="img-responsive" src="<?php echo base_url().EXERCISE_IMAGES_PATH_W50_H50.$exercise['picture'] ?>"/>
                            <?php }else{?>
                            <img style="background-color: #76B4E7; width: 100%" class="img-responsive" src="<?php echo base_url().GYMPRO_IMAGES_DEFAULT_PATH.GYMPRO_DEFAULT_PICTURE_NAME ?>"/>
                            <?php } ?>
                        </a>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <a style="font-size: 18px" href="<?php echo base_url().'applications/gympro/show_exercise/'.$exercise['exercise_id'];?>"><?php echo $exercise['name']?></a>
                    </div>
                </div>
<!--                <div class="pull-right">
                    <a href="<?php echo base_url().'applications/gympro/edit_client/'.$client_info['client_id']?>"><span>Edit</span></a>
                </div>-->
            </div>
        </div>
        <?php
        
        if($counter%APP_GYMPRO_MANAGE_CLIENTS_CLIENTS_PER_ROW == (APP_GYMPRO_MANAGE_CLIENTS_CLIENTS_PER_ROW-1) || $counter == $total_exercise)
        {
            echo '</div>';
        }  
        $counter++;
            }
            ?>

        </div>
    </div>
</div>
<?php $this->load->view("applications/gympro/exercise/exercise_delete_confirm_modal");