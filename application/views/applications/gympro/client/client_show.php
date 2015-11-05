<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/home.png">
                <a href="<?php echo base_url() . 'applications/gympro' ?>">Home</a>
            </div>
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/client.png">
                <a href="<?php echo base_url() . 'applications/gympro/manage_clients' ?>">Clients</a>
            </div>
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/groups.png">
                <a href="<?php echo base_url() . 'applications/gympro/manage_groups' ?>">Groups</a>
            </div>
            <div class="nav_separate_border"></div>
            <!--left nav custom for this page-->
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#add_client').show();">Personal details</a>
            </div>
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#contact_details').show();">Contact details</a>
            </div>
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#health').show();">Health details</a>
            </div>
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#programmes').show();">Programmes</a>
            </div>
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#assessments').show();">Assessments</a>
            </div>
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#missions').show();">Missions</a>
            </div>
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#nutrition').show();">Nutrition</a>
            </div>
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="$('.hidden_tab').hide();$('#notes').show();">Notes</a>
            </div>
        </div>
        <!--ADDING CLIENT-->
        <div class="col-md-7">
            <div class="pad_title">
                <div class="row">
                    <div class="col-md-8">
                        <span>CLIENT INFO</span>
                    </div>                     
                </div>
            </div>
            <div style="border-top: 2px solid lightgray; margin-left: 20px"></div>
            <div class="pad_body">
                <?php if (isset($message) && ($message != NULL)){?>
                    <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
                <?php } ?>
                    <!--Personal details-->
                    <div class="row hidden_tab" id="add_client" style="display: block">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-sm-4 ">First Name:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['first_name'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Last Name:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['last_name'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Gender:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['gender_name'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Email:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['email'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Start Date:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['start_date'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">End Date:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['end_date'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Date of birth:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo convert_date_from_db_to_user($client_info['dob']);?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Client Status:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['status_title'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Occupation:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['occupation'];?></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 ">Employer:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['employer'];?></label>
                            </div>
                            <div class="form-group">
                                <label for="website" class="col-md-4  requiredField">
                                    Picture: 
                                </label>
                                <div class ="col-md-6">                                    
                                    <div class="col-md-12">
                                        <div class="profile-picture-box pull-right" >
                                            <div id="files" class="files">
                                                <?php if(isset($client_info['photo']) && $client_info['photo'] != ''){ ?>
                                                <img onerror="this.src='<?php echo base_url().DEFAULT_LOGO ?>'" style="width: 100%; background-color: #75B3E6" class="img-responsive" src="<?php echo base_url().PROFILE_PICTURE_PATH_W50_H50.$client_info['photo'] ?>"/>
                                                <?php }else{?>
                                                <img onerror="this.src='<?php echo base_url().DEFAULT_LOGO ?>'" style="width: 100%; background-color: #75B3E6" class="img-responsive" src="<?php echo base_url().DEFAULT_LOGO ?>"/>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Contact details-->
                    <div class="row hidden_tab" id="contact_details">
                        <div class="col-md-9">
                            <div class="row form-group">
                                <label class="col-sm-6 col-md-6">Telephone:</label>
                                <label class="col-sm-6 col-md-6">&nbsp;<?php echo $client_info['telephone'];?></label>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-6 col-md-6">Mobile:</label>
                                <label class="col-sm-6 col-md-6">&nbsp;<?php echo $client_info['mobile'];?></label>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-6 col-md-6">Address:</label>
                                <label class="col-sm-6 col-md-6">&nbsp;<?php echo $client_info['address'];?></label>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-6 col-md-6">Emergency contact:</label>
                                <label class="col-sm-6 col-md-6">&nbsp;<?php echo $client_info['emergency_contact'];?></label>                                
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-6 col-md-6">Emergency phone:</label>
                                <label class="col-sm-6 col-md-6">&nbsp;<?php echo $client_info['emergency_phone'];?></label>
                            </div>
                        </div>
                    </div>
                    <!--Health details-->
                    <div class="row hidden_tab" id="health">
                        <div class="col-md-12">
                            <?php foreach ($question_list as $question_info){ ?>
                            <div class="row form-group">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="patapota"><?php echo $question_info['title'] . ' ' . $question_id_answer_map[$question_info['question_id']]['answer'] ?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div style="display: <?php echo($question_info['show_additional_info'] == 1) ? 'block' : 'none'; ?>" style="float: left">
                                                    Additional info: 
                                                    <?php
                                                    if ($question_info['show_additional_info'] == 1) {
                                                        echo $question_id_answer_map[$question_info['question_id']]['additional_info'];
                                                    }
                                                    ?>
                                                </div>                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Height (cm):</label>
                                </div>
                                <div class="col-md-8">
                                    <label><?php echo $client_info['height']; ?></label>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Resting Heart Rate:</label>
                                </div>
                                <div class="col-md-8">
                                    <label><?php echo $client_info['resting_heart_rate']; ?></label>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Blood Pressure:</label>
                                </div>
                                <div class="col-md-8">
                                    <label>&nbsp;<?php echo $client_info['blood_pressure']; ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Programmes-->
                    <div class="row hidden_tab" id="programmes">
                        <?php
                            $total_programs = count($program_list);
                            $program_counter = 0;
                            foreach($program_list as $program)
                            {
                                if($program_counter%APP_GYMPRO_PROGRAMMES_PER_ROW == 0)
                                {
                                    //echo '<div class="row top_margin">';
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
                                            <a href="<?php echo base_url().'applications/gympro/show_program/'.$program['program_id']?>">
                                                <?php if(isset($program['picture']) && $program['picture'] != ''){ ?>
                                                <img style="width: 100%" class="img-responsive" src="<?php echo base_url().CLIENT_PROFILE_PICTURE_PATH_W50_H50.$program['picture'] ?>"/>
                                                <?php }else{?>
                                                <img style="background-color: #76B4E7; width: 100%" class="img-responsive" src="<?php echo base_url().GYMPRO_IMAGES_DEFAULT_PATH.GYMPRO_DEFAULT_PICTURE_NAME ?>"/>
                                                <?php } ?>
                                            </a>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <a style="font-size: 18px" href="<?php echo base_url().'applications/gympro/show_program/'.$program['program_id']?>"><?php echo $program['focus'] ?></a>
                                        </div>
                                    </div>
                                </div>
                            <?php echo '</div>'?>
                            <?php
                            if($program_counter%APP_GYMPRO_PROGRAMMES_PER_ROW == (APP_GYMPRO_PROGRAMMES_PER_ROW-1) || $program_counter == $total_programs)
                            {
                                //echo '</div>';
                            }  
                            $program_counter++;
                            }
                        ?>
                    </div>
                    <!--Assessments-->
                    <div class="row hidden_tab" id="assessments">
                        <?php
                        $total_assessments = count($assessment_list);
                        $assessment_counter = 0;
                        foreach($assessment_list as $assessment)
                        {
                            if($assessment_counter%APP_GYMPRO_ASSESSMENTS_PER_ROW == 0)
                            {
                                //echo '<div class="row top_margin">';
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
                                            <?php if(isset($assessment['picture']) && $assessment['picture'] != ''){ ?>
                                            <img style="width: 100%" class="img-responsive" src="<?php echo base_url().CLIENT_PROFILE_PICTURE_PATH_W50_H50.$assessment['picture'] ?>"/>
                                            <?php }else{?>
                                            <img style="background-color: #76B4E7; width: 100%" class="img-responsive" src="<?php echo base_url().GYMPRO_IMAGES_DEFAULT_PATH.GYMPRO_DEFAULT_PICTURE_NAME ?>"/>
                                            <?php } ?>
                                        </a>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <a style="font-size: 18px" href="<?php echo base_url().'applications/gympro/show_assessment/'.$assessment['assessment_id'];?>"><?php echo $assessment['first_name'].' '.$assessment['last_name'].'</br>'.$assessment['date']?></a>
                                    </div>
                                </div>
                            </div>
                        <?php echo '</div>'?>
                        <?php

                        if($assessment_counter%APP_GYMPRO_ASSESSMENTS_PER_ROW == (APP_GYMPRO_ASSESSMENTS_PER_ROW-1) || $assessment_counter == $total_assessments)
                        {
                            //echo '</div>';
                        }  
                        $assessment_counter++;
                        }
                        ?>
                    </div>
                    <!--Missions-->
                    <div class="row hidden_tab" id="missions">
                        <?php
                        $total_missions = count($mission_list);
                        $mission_counter = 0;
                        foreach($mission_list as $mission_info)
                        {
                            if($mission_counter%APP_GYMPRO_MISSIONS_PER_ROW == 0)
                            {
                                //echo '<div class="row top_margin">';
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
                                </div>
                            </div>
                        <?php echo '</div>'?>
                        <?php

                        if($mission_counter%APP_GYMPRO_MISSIONS_PER_ROW == (APP_GYMPRO_MISSIONS_PER_ROW-1) || $mission_counter == $total_missions)
                        {
                            //echo '</div>';
                        }  
                        $mission_counter++;
                        }
                        ?>
                    </div>
                    <!--Nutrition-->
                    <div class="row hidden_tab" id="nutrition">
                        <?php
                        $total_nutrition = count($nutrition_list);
                        $nutrition_counter = 0;
                        foreach($nutrition_list as $nutrition)
                        {
                            if($nutrition_counter%APP_GYMPRO_NUTRITION_PER_ROW == 0)
                            {
                                //echo '<div class="row top_margin">';
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
                                        <a href="<?php echo base_url().'applications/gympro/show_nutrition/' . $nutrition['nutrition_id']; ?>">
                                            <?php if(isset($nutrition['picture']) && $nutrition['picture'] != ''){ ?>
                                            <img style="width: 100%" class="img-responsive" src="<?php echo base_url().CLIENT_PROFILE_PICTURE_PATH_W50_H50.$nutrition['picture'] ?>"/>
                                            <?php }else{?>
                                            <img style="background-color: #76B4E7; width: 100%" class="img-responsive" src="<?php echo base_url().GYMPRO_IMAGES_DEFAULT_PATH.GYMPRO_DEFAULT_PICTURE_NAME ?>"/>
                                            <?php } ?>
                                        </a>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <a style="font-size: 18px" href="<?php echo base_url().'applications/gympro/show_nutrition/' . $nutrition['nutrition_id']; ?>"><?php echo $nutrition['first_name'].' '.$nutrition['last_name'] ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php echo '</div>'?>
                        <?php

                        if($nutrition_counter%APP_GYMPRO_NUTRITION_PER_ROW == (APP_GYMPRO_NUTRITION_PER_ROW-1) || $nutrition_counter == $total_nutrition)
                        {
                            //echo '</div>';
                        }  
                        $nutrition_counter++;
                        }
                        ?>
                    </div>
                    <!--Notes-->
                    <div class="row hidden_tab" id="notes">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-sm-4 ">Notes:</label>
                                <label class="col-sm-6 ">&nbsp;<?php echo $client_info['notes'];?></label>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>