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
        <div class="col-md-7">
            <div class="row">
                <div class="col-md-2" style="font-size: 20px; color: maroon">
                    Clients
                </div>
                <div class="col-md-3 pull-right right_padding_zero">
                    <a href="<?php echo base_url().'applications/gympro/search_client'?>">
                        <button class="btn button-custom btn_gympro pull-right">New Client</button>
                    </a>
                </div>
            </div>
            <div style="border-top: 2px solid lightgray; margin-right:-20px; margin-top:10px;"></div>
            <?php
            $total_clients = count($client_list);
            $counter = 0;
            foreach($client_list as $client_info)
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
                        <a href="<?php echo base_url().'applications/gympro/show_client/'.$client_info['client_id']?>">
                            <?php if(isset($client_info['photo']) && $client_info['photo'] != ''){ ?>
                            <img onerror="this.src='<?php echo base_url().DEFAULT_LOGO ?>'" style="width: 100%; background-color: #75B3E6" class="img-responsive" src="<?php echo base_url().PROFILE_PICTURE_PATH_W50_H50.$client_info['photo'] ?>"/>
                            <?php }else{?>
                            <img onerror="this.src='<?php echo base_url().DEFAULT_LOGO ?>'" style="width: 100%; background-color: #75B3E6" class="img-responsive" src="<?php echo base_url().DEFAULT_LOGO ?>"/>
                            <?php } ?>
                        </a>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <a style="font-size: 18px" href="<?php echo base_url().'applications/gympro/show_client/'.$client_info['client_id']?>"><?php echo $client_info['first_name'].' '.$client_info['last_name']?></a>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <div class="dropdown friends-satus-dropdown">
                            <a id="friends_status" data-toggle="dropdown" href="#" >
                                <img style="float: left; padding-top: 4px" src="<?php echo base_url() ?>resources/images/friends_status.png" alt=""/>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="friends_status">
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo base_url().'applications/gympro/edit_client/'.$client_info['client_id']?>" >Edit</a>
                                </li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="open_modal_delete_confirm(<?php echo $client_info['client_id'] ?>)">Delete</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
<!--                <div class="pull-right">
                    <a href="<?php echo base_url().'applications/gympro/edit_client/'.$client_info['client_id']?>"><span>Edit</span></a>
                </div>-->
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
        </div>
 <?php $this->load->view("applications/gympro/client/client_delete_confirm_modal");