
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
        <div class="col-md-10">
            <div class="pad_title">
                PROGRAMME INFO
            </div>
            <div class="pad_body">
                <div class="row">
                    <div class="col-md-7">
                        <div class=" row form-group">
                            <label class="col-sm-3 control-label">Programme Focus: </label>
                            <div class="col-md-9 "><?php echo $program_info['focus']; ?></div>
                        </div>

                        <div class="row form-group">
                            <label class="col-sm-3 control-label">Description: </label>
                            <div class="col-md-9 "><?php echo $program_info['description']; ?></div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row form-group">
                            <label class="col-sm-3 control-label">Start date: </label>
                            <div class="col-md-9 "><?php echo $program_info['start_date']; ?></div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 control-label">Review In: </label>
                            <div class="col-md-9 ">
                                <?php
                                foreach ($review_array as $review) {
                                    if ($program_info['review_id'] == $review['id']) {
                                        echo $review['title'];
                                        break;
                                    }
                                }
                                ?>

                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 control-label">Warm Up: </label>
                            <div class="col-md-9 "><?php echo $program_info['warm_up']; ?></div>
                        </div>

                        <div class="row form-group">
                            <label class="col-sm-3 control-label">Cooldown: </label>
                            <div class="col-md-9 "><?php echo $program_info['cool_down']; ?></div>
                        </div>
                    </div>
                </div>
                <?php   $count = 1; $cardio_count = 1; 
                        foreach ($exercise_list as $exercise) {
                            if ($exercise['type'] == "weight") { ?>
                        <div class="row form-group"></div>
                        Weight_exercise: <?php echo $count++; ?>
                        <div class="row form-group"></div>
                        <table class="table-bordered table-condensed" style="width: 100%">
                            <tr>
                                <th>Exercise name</th>
                                <th>Description</th>
                                <th>Sets</th>
                                <th>Reps</th>
                                <th>Weights</th>
                                <th>Rest</th>
                                <th>Tempo</th>
                            </tr>
                            <tr>
                                <td><?php echo $exercise['name']; ?></td>
                                <td><?php echo $exercise['description']; ?></td>
                                <td><?php echo $exercise['sets']; ?></td>
                                <td><?php echo $exercise['reps']; ?></td>
                                <td><?php echo $exercise['weights']; ?></td>
                                <td><?php echo $exercise['reps2']; ?></td>
                                <td><?php echo $exercise['tempo']; ?></td>
                            </tr> 
                        </table>
                        <div class="row form-group"></div>
                <?php   } elseif ($exercise['type'] == "cardio") { ?>
                        <div class="row form-group"></div>
                        Cardio_exercise: <?php echo $cardio_count++; ?>
                        <div class="row form-group"></div>
                        <table class="table-bordered table-condensed" style="width: 100%">
                            <tr>
                                <th>Exercise name</th>
                                <th>Description</th>
                                <th>Level</th>
                                <th>Speed</th>
                                <th>Time</th>
                                <th>Target H.R</th>
                            </tr>
                            <tr>
                                <td><?php echo $exercise['name']; ?></td>
                                <td><?php echo $exercise['description']; ?></td>
                                <td><?php echo $exercise['level']; ?></td>
                                <td><?php echo $exercise['speed']; ?></td>
                                <td><?php echo $exercise['time']; ?></td>
                                <td><?php echo $exercise['target']; ?></td>
                            </tr>
                        </table>
                        <div class="row form-group"></div>
                <?php   } ?>
            <?php   } ?>

            </div>
        </div>
    </div>
</div>






