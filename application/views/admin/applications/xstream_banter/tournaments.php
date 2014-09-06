<script type="text/javascript">
    $(function() {
        $("#button_create_tournament").on("click", function() {
            $('#modal_create_tournament').modal('show');
        });
        $("#button_create_team").on("click", function() {
            $('#modal_create_team').modal('show');
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_tournament_list">
    {% var i=0, tournament_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(tournament_info){ %}
    <tr>
        <td><a href="<?php echo base_url()."admin/applications_xstreambanter/xstream_banter_tournament/{%= tournament_info.id%}"; ?>">{%= tournament_info.title%}</a></td>
        <td>{%= tournament_info.total_teams%}</td>
    </tr>
    {% tournament_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<script type="text/x-tmpl" id="tmpl_team_list">
    {% var i=0, team_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(team_info){ %}
    <tr>
        <td>{%= team_info.title%}</td>
        <td>{%= team_info.created_on%}</td>
    </tr>
    {% team_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<div class="panel panel-default">
    <div class="panel-heading">Tournaments</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <?php if($allow_configuration){ ?>
            <div class="row form-group">
                <div class ="col-sm-9"></div>
                <div class ="col-sm-3">
                    <button id="button_create_tournament" value="" class="form-control btn button-custom pull-right">Create Tournament</button>  
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Total teams</th>                
                            </tr>
                        </thead>
                        <tbody id="tbody_tournament_list">                
                            <?php foreach($tournament_list as $tournament){?>
                            <tr>
                                <td><a href="<?php echo base_url()."admin/applications_xstreambanter/xstream_banter_tournament/".$tournament['id']; ?>"><?php echo $tournament['title']?></a></td>
                                <td><?php echo $tournament['total_teams']?></td>
                            </tr>
                            <?php } ?>                            
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
        <div class="row col-md-12">
            <?php if($allow_configuration){ ?>
            <div class="row form-group">
                <div class ="col-sm-10"></div>
                <div class ="col-sm-2">
                    <button id="button_create_team" value="" class="form-control btn button-custom pull-right">Create Team</button>  
                </div>                
            </div>
            <?php } ?>
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Team name</th>
                                <th>Created Date</th>  
                            </tr>
                        </thead>
                        <tbody id="tbody_team_list">                
                            <?php foreach($team_list as $team){?>
                                <tr>
                                    <td><?php echo $team['title']?></td>
                                    <td><?php echo $team['created_on']?></td>
                                </tr>
                            <?php } ?> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="btn-group" style="padding-left: 10px;">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="goBackByURL('<?php echo base_url();?>admin/applications_xstreambanter/xstream_banter')" class="form-control btn button-custom">
        </div>
    </div>
</div>
<?php $this->load->view("admin/applications/xstream_banter/modal_create_tournament"); ?>
<?php $this->load->view("admin/applications/xstream_banter/modal_create_team"); ?>

