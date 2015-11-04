<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<script>
    $(function () {
        $("#sort_assessments").on('change', function () {
            window.location = '<?php echo base_url();?>applications/gympro/manage_assessments/'+$("#sort_assessments").val();
        });
        $("#sort_assessments").val('<?php echo $sort; ?>');
    });    
</script>
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
                    <span>Assessments</span>
                </div>
                <div class="col-md-3 pull-right right_padding_zero">
                    <a href="<?php echo base_url()?>applications/gympro/create_assessment"><button class="pull-right btn button-custom btn_gympro">New Assessment</button></a>
                </div>
            </div>
            <div class="form-group" style="border-top: 2px solid lightgray; margin-right:-20px"></div>
            <div class="row">
                <div class="col-md-9">
                    <span class="text_size_14px">Add assessments and assign to your clients for them to instantly see</span>
                </div>
                <div class="col-md-3">
                    <select id="sort_assessments" class="form-control form_control_custom">
                        <option value="2">Client</option>
                        <option value="1">Date</option>
                    </select> 
                </div>
            </div>
            <div class="row col-md-12" id="assessment_list">
                
            <?php
            $total_assessments = count($assessment_list);
            $counter = 0;
            foreach($assessment_list as $assessment)
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
                        <a href="<?php echo base_url().'applications/gympro/show_assessment/'.$assessment['assessment_id'];?>">
                            <?php if(isset($assessment['profile_picture']) && $assessment['profile_picture'] != ''){ ?>
                            <img style="width: 100%" class="img-responsive" src="<?php echo base_url().PROFILE_PICTURE_PATH_W100_H100.$assessment['profile_picture'] ?>"/>
                            <?php }else{?>
                            <img style="background-color: #76B4E7; width: 100%" class="img-responsive" src="<?php echo base_url().GYMPRO_IMAGES_DEFAULT_PATH.GYMPRO_DEFAULT_PICTURE_NAME ?>"/>
                            <?php } ?>
                        </a>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <a style="font-size: 18px" href="<?php echo base_url().'applications/gympro/show_assessment/'.$assessment['assessment_id'];?>"><?php echo $assessment['first_name'].' '.$assessment['last_name'].'</br>'.convert_date_from_db_to_user($assessment['date'])?></a>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-2">
                        <div class="dropdown friends-satus-dropdown">
                            <a id="friends_status" data-toggle="dropdown" href="#" >
                                <img style="float: left; padding-top: 4px" src="<?php echo base_url() ?>resources/images/friends_status.png" alt=""/>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="friends_status">
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo base_url().'applications/gympro/edit_assessment/'.$assessment['assessment_id'];?>" >Edit</a>
                                </li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo base_url().'applications/gympro/clone_assessment/'.$assessment['assessment_id'];?>" >Copy</a>
                                </li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="javascript:void(0)" onclick="open_modal_delete_confirm(<?php echo $assessment['assessment_id'] ?>)">Delete</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        
        if($counter%APP_GYMPRO_MANAGE_CLIENTS_CLIENTS_PER_ROW == (APP_GYMPRO_MANAGE_CLIENTS_CLIENTS_PER_ROW-1) || $counter == $total_assessments)
        {
            echo '</div>';
        }  
        $counter++;
            }
            ?>
        </div>
        </div>
    </div>

</div>
<?php $this->load->view("applications/gympro/assessment/assessment_delete_confirm_modal");