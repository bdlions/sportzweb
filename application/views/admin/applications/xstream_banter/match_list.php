<div class="panel panel-default">
    <div class="panel-heading">Matches</div>
    <div class="panel-body">
        <div class="row col-md-12">            
            <div class="row form-group" style="padding-left: 10px;">
                <?php if($allow_write){ ?>
                <div class ="col-md-2 pull-left">
                    <a href="<?php echo base_url()."admin/applications_xstreambanter/create_match/".$tournament_id;?>">
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
                                <th style="text-align: center">Id</th>
                                <th style="text-align: center">Tournament</th>
                                <th style="text-align: center">Season</th>
                                <th style="text-align: center">Home</th>
                                <th style="text-align: center">Away</th>
                                <th style="text-align: center">Date</th>
                                <th style="text-align: center">Time</th>
                                <th style="text-align: center">Edit</th>
                                <th style="text-align: center">Delete</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_sports_list">                
                            <?php foreach($match_list as $match){?>
                            <tr>
                                <td style="text-align: center"><?php echo $match['match_id']?></td>
                                <td style="text-align: center"><?php echo $match['tournament_name']?></td>
                                <td style="text-align: center"><?php echo $match['season']?></td>
                                <td style="text-align: center"><?php echo $match['home_team_name']?></td>
                                <td style="text-align: center"><?php echo $match['away_team_name']?></td>
                                <td style="text-align: center"><?php echo $match['date']?></td>
                                <td style="text-align: center"><?php echo $match['time']?></td>
                                <td style="text-align: center">
                                    <a href="<?php echo base_url()."admin/applications_xstreambanter/update_match/".$match['match_id'];?>">
                                        Edit
                                    </a>
                                </td>
                                <?php if($allow_delete){ ?> 
                                <td style="text-align: center">
                                    <button onclick="open_modal_match_delete_confirm('<?php echo $match['match_id']; ?>')" value="" class="form-control btn pull-right">
                                        Delete
                                    </button>
                                </td>
                                <?php } ?>
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
<?php 
$this->load->view("admin/applications/xstream_banter/modal/match_delete_confirm");
?>