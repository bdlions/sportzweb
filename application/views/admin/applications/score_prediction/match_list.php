<div class="panel panel-default">
    <div class="panel-heading">Matches</div>
    <div class="panel-body">
        <div class="row col-md-12">            
            <div class="row form-group" style="padding-left: 10px;">
                <?php if($allow_write){ ?>
                <div class ="col-md-2 pull-left">
                    <a href="<?php echo base_url()."admin/applications_scoreprediction/create_match/".$tournament_id;?>">
                        <button value="" class="form-control btn button-custom pull-right">Create Match</button>  
                    </a>
                </div>
                <?php } ?>
            </div>
            
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tournament</th>
                                <th>Season</th>
                                <th>Home</th>
                                <th>Away</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Home Score</th>
                                <th>Away Score</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_sports_list">                
                            <?php foreach($match_list as $match){?>
                            <tr>
                                <td><?php echo $match['match_id']?></td>
                                <td><?php echo $match['tournament_name']?></td>
                                <td><?php echo $match['season']?></td>
                                <td><?php echo $match['home_team_name']?></td>
                                <td><?php echo $match['away_team_name']?></td>
                                <td><?php echo $match['date']?></td>
                                <td><?php echo $match['time']?></td>
                                <td><?php echo $match['score_home']?></td>
                                <td><?php echo $match['score_away']?></td>
                                <td><?php echo $match['match_status']?></td>
                                <td>
                                    <a href="<?php echo base_url()."admin/applications_scoreprediction/update_match/".$match['match_id'];?>">
                                        Edit
                                    </a>
                                </td>
                                <td>Delete</td>
                            </tr>
                            <?php } ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="btn-group" style="padding-left: 10px;">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
            </div>
        </div>
    </div>
</div>