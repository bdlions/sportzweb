<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-7">
            <div class="row">
                <div class="col-md-2">
                    <a href="<?php echo base_url().'applications/gympro/create_client'?>">
                        <button class="btn button-custom btn_gympro">New Client</button>
                    </a>
                    
                </div>
            </div>
<!--            <div class="row top_margin">
                <div class="col-md-4 right_padding_zero">
                    <div class="user_prof">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <img class="img-circle img-responsive" src="<?php echo base_url() ?>resources/images/face.jpg">
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-8">
                                <a href="">Shemai Khan</a>
                            </div>
                        </div>
                        <div class="pull-right">
                            <a href=""><span>Edit</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 right_padding_zero">
                    <div class="user_prof">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <img class="img-circle img-responsive" src="<?php echo base_url() ?>resources/images/face.jpg">
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-8">
                                <a href="">Shemai Khan</a>
                            </div>
                        </div>
                        <div class="pull-right">
                            <a href=""><span>Edit</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 right_padding_zero">
                    <div class="user_prof">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <img class="img-circle img-responsive" src="<?php echo base_url() ?>resources/images/face.jpg">
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-8">
                                <a href="">Shemai Khan</a>
                            </div>
                        </div>
                        <div class="pull-right">
                            <a href=""><span>Edit</span></a>
                        </div>
                    </div>
                </div>
            </div>-->
<!--            <div class="row top_margin">-->
            <?php
            $total_clients = count($client_list);
            $counter = 0;
            foreach($client_list as $client_info)
            {
                if($counter%APP_GYMPRO_MANAGE_CLIENTS_CLIENTS_PER_ROW == 0)
                {
                    echo '<div class="row top_margin">';
                    echo '<div class="col-md-4 right_padding_zero">';
                }
                else
                {
                    echo '<div class="col-md-4 right_padding_zero">';
                }
                ?>
            <div class="user_prof">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <img class="img-circle img-responsive" src="<?php echo base_url() ?>resources/images/face.jpg">
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-8">
                        <a href=""><?php echo $client_info['first_name'].' '.$client_info['last_name']?></a>
                    </div>
                </div>
                <div class="pull-right">
                    <a href="<?php echo base_url().'applications/gympro/update_client/'.$client_info['client_id']?>"><span>Edit</span></a>
                </div>
            </div>
        </div>
        <?php
        
        if($counter%APP_GYMPRO_MANAGE_CLIENTS_CLIENTS_PER_ROW == (APP_GYMPRO_MANAGE_CLIENTS_CLIENTS_PER_ROW-1) || $counter == $total_clients)
        {
            echo '</div>';
        }  
        $counter++;
    }
    ?>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-8">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>