<div class="panel panel-default">
    <div class="panel-heading">Tournaments</div>
    <div class="panel-body">
        <div class="row col-md-12">            
            <div class="row form-group" style="padding-left: 10px;">
                <?php if($allow_write){ ?>
                <div class ="col-md-2 pull-left">
                    <button id="button_create_tournament" value="" class="form-control btn button-custom pull-right">Create Tournament</button>  
                </div>
                <?php } ?>
            </div>
            
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Season</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_sports_list">                
                            <?php foreach($tournament_list as $tournament){?>
                            <tr>
                                <td><a href="<?php echo base_url()."admin/applications_scoreprediction/manage_matches/".$tournament['tournament_id']; ?>"><?php echo $tournament['tournament_id']?></a></td>
                                <td><?php echo $tournament['title']?></td>
                                <td><?php echo $tournament['season']?></td>
                                <td>Edit</td>
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