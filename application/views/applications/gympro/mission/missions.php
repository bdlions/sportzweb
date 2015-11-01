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
            <div class="row form-group">
                <div class="col-md-2" style="font-size: 20px; color: maroon">
                    <span>Missions</span>
                </div>
                <div class="col-md-3 pull-right right_padding_zero">
                    <a href="<?php echo base_url()?>applications/gympro/create_mission"><button class="pull-right btn button-custom btn_gympro">New Mission</button></a>
                </div>
            </div>
            <div class="form-group" style="border-top: 2px solid lightgray; margin-right:-20px"></div>
            <div class="row">
                <div class="col-md-9">
                    <span class="text_size_14px">Create missions for your clients to instantly see</span>
                </div>
                <div class="col-md-3">
                    <select class="form-control form_control_custom">
                        <option value="date">Date</option>
                        <option value="day">Day</option>
                        <option value="month">Month</option>
                        <option value="year">Year</option>
                    </select> 
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
                        <a href="<?php echo base_url().'applications/gympro/show_mission/'.$mission_info['mission_id']?>">
                            <?php if(isset($mission_info['picture']) && $mission_info['picture'] != ''){ ?>
                            <img style="width: 100%" class="img-responsive" src="<?php echo base_url().CLIENT_PROFILE_PICTURE_PATH_W50_H50.$mission_info['picture'] ?>"/>
                            <?php }else{?>
                            <img style="background-color: #76B4E7; width: 100%" class="img-responsive" src="<?php echo base_url().GYMPRO_IMAGES_DEFAULT_PATH.GYMPRO_DEFAULT_PICTURE_NAME ?>"/>
                            <?php } ?>
                        </a>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <a style="font-size: 18px" href="<?php echo base_url().'applications/gympro/show_mission/'.$mission_info['mission_id']?>"><?php echo $mission_info['label']?></a>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <div class="dropdown friends-satus-dropdown">
                            <a id="friends_status" data-toggle="dropdown" href="#" >
                                <img style="float: left; padding-top: 4px" src="<?php echo base_url() ?>resources/images/friends_status.png" alt=""/>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="friends_status">
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo base_url().'applications/gympro/edit_mission/'.$mission_info['mission_id']?>" >Edit</a>
                                </li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="open_modal_delete_confirm(<?php echo $mission_info['mission_id'] ?>)">Delete</a>
                                </li>
                            </ul>
                        </div>
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
            
            
            
            
            
            
            
            
            
<!--            <div class="row form-group">
                <div class="col-md-12">
                    <table class="table table-condensed table-responsive gympro_table">
                        <tbody>
                            <tr>
                                <th>CREATED</th>
                                <th>LABEL</th>
                                <th>EDIT</th>
                                <th>DELETE</th>                                
                            </tr>
                            <?php foreach($mission_list as $mission_info){?>
                            <tr>
                                <td><?php echo $mission_info['created_on']?></td>
                                <td><a href="<?php echo base_url()."applications/gympro/show_mission/".$mission_info['mission_id']?>"><?php echo $mission_info['label']?></a></td>
                                <td><a href="<?php echo base_url()."applications/gympro/edit_mission/".$mission_info['mission_id']?>">Edit</a></td>
                                <td style="text-align: center">
                                <a onclick="open_modal_delete_confirm(<?php echo $mission_info['mission_id'] ?>)" >
                                    Delete
                                </a>
                            </td>
                            </tr>                            
                            <?php } ?>                           
                        </tbody>
                    </table>
                </div>                
            </div>-->
        </div>
    </div>
</div>
<?php $this->load->view("applications/gympro/mission/mission_delete_confirm_modal");