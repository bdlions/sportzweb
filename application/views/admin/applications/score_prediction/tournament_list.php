<div class="panel panel-default">
    <div class="panel-heading">Tournaments</div>
    <div class="panel-body">
        <div class="row col-md-12">            
            <div class="row form-group" style="padding-left: 10px;">
                <?php if($allow_write){ ?>
                <div class ="col-md-2 pull-left">
                    <button onclick="open_modal_tournament_create()" value="" class="form-control btn button-custom pull-right">Create Tournament</button>  
                </div>
                <?php } ?>
                <div class ="col-md-2 pull-left">
                    <a href="<?php echo base_url()."admin/applications_scoreprediction/manage_teams/".$sports_id; ?>">
                        <button id="button_manage_teams" value="" class="form-control btn button-custom pull-right">Teams</button>  
                    </a>
                </div>
            </div>
            
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center">Id</th>
                                <th style="text-align: center">Title</th>
                                <th style="text-align: center">Season</th>
                                <th style="text-align: center">Edit</th>
                                <th style="text-align: center">Delete</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_tournament_list">                
                            <?php foreach($tournament_list as $tournament){?>
                            <tr>
                                <td style="text-align: center"><a href="<?php echo base_url()."admin/applications_scoreprediction/manage_matches/".$tournament['tournament_id']; ?>"><?php echo $tournament['tournament_id']?></a></td>
                                <td style="text-align: center"><?php echo $tournament['title']?></td>
                                <td style="text-align: center"><?php echo $tournament['season']?></td>
                                <?php if($allow_edit){ ?>
                                <td>                                   
                                    <a href="<?php echo base_url().'admin/applications_scoreprediction/update_tournament/'.$tournament['tournament_id']?>">
                                        Update
                                    </a>
                                </td>
                                <?php } ?>
                                <?php if($allow_delete){ ?>
                                <td>
                                    <button onclick="open_modal_tournament_delete_confirm('<?php echo $tournament['tournament_id']; ?>')" value="" class="form-control btn pull-right">
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
$this->load->view("admin/applications/score_prediction/modal/tournament_create");
$this->load->view("admin/applications/score_prediction/modal/tournament_update");
$this->load->view("admin/applications/score_prediction/modal/tournament_delete_confirm");
?>