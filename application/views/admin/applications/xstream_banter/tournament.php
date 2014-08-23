<script type="text/javascript">
    $(function() {
        $("#button_create_match").on("click", function() {
            $('#modal_create_match').modal('show');
        });   
        $("#button_assign_teams_tournament").on("click", function() {
            $('#modal_assign_teams_tournament').modal('show');
        });
    });
</script>

<!--Written By Omar for  -->
<script type="text/javascript">
    $(function () {
        $("#tbody_team_list").on("click", "button", function(e) {
            $('#modal_confirm').modal('show');
            //console.log(this.id);
            var target = e.target;
            var team_id = this.id;
            //console.log(target);
            $("#submit_yes").on("click", function() {
                var modal_confirm_val = $('#submit_yes').val();
                if(modal_confirm_val=='YES') {
                    $(target).closest('tr').remove();
                    //alert(modal_confirm_val);
                    $.ajax({
                        dataType: 'json',    
                        type: "POST",
                        url: '<?php echo base_url(); ?>' + "admin/application/remove_team_from_tournament",
                        data: {
                            team_id:team_id,
                            tournament_id:'<?php echo $tournament_id;?>'
                        },
                        success: function(data) {
                            alert(data['message']);
                            if(data['status'] == 1)
                            {
                                window.location.reload();
                            }
                        }
                    }); 
                } else {
                    alert('You can not delete this row');
                }
            
            });
        })
    });
</script>
<div class="panel panel-default">
    <div class="panel-heading"><?php echo $tournament_info['title']?></div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row form-group">
                <div class ="col-sm-10"></div>
                <div class ="col-sm-2">
                    <button id="button_assign_teams_tournament" name="button_assign_teams_tournament" type="submit" value="" class="form-control btn button-custom pull-right">Assign Team</button>  
                </div>
            </div>            
            <div class="row form-group">
                <label class="col-sm-2 control-label">Start Date:</label>
                <div class ="col-sm-2">
                    <input type="text" class="form-control"/>
                </div>
                <label class="col-sm-2 control-label">End Date:</label>
                <div class ="col-sm-2">
                    <input type="text" class="form-control"/>
                </div>
                <div class ="col-sm-2">
                    <input type="button" value="Search" class="form-control btn button-custom pull-right"/>  
                </div>
                <div class ="col-sm-2">
                    <button id="button_create_match" type="button" value="" class="form-control btn button-custom pull-right">Create Match</button>  
                </div>
            </div>
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Team A</th> 
                                <th>Team B</th> 
                                <th>Date</th> 
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_match_list">                
                            <?php foreach($match_list as $match){?>
                                <tr>
                                    <td><a href="<?php echo base_url()."admin/application/xstream_banter_match/".$match['id']; ?>"><?php echo $match['id'];?></a></td>
                                    <td><?php echo $match['team1_title']?></td>
                                    <td><?php echo $match['team2_title']?></td>
                                    <td><?php echo $match['date']?></td>
                                    <td><?php echo $match['time']?></td>
                                </tr>
                            <?php } ?>                             
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row col-md-12">
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Team name</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_team_list"> 
                            <?php //echo '<pre/>';print_r($team_list);exit; ?>
                            <?php foreach($team_list as $team){?>
                                <tr>
                                    <td><?php echo $team['title']?></td>
                                    <td><?php echo $team['created_on']?></td>
                                    <td>
                                        <button id="<?php echo $team['id'];?>" class="glyphicon glyphicon-trash middle"></button>
                                    </td>
                                </tr>
                            <?php } ?> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="btn-group" style="padding-left: 10px;">
            <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
        </div>
    </div>
</div>
<?php $this->load->view("admin/applications/xstream_banter/modal_create_match"); ?>
<?php $this->load->view("admin/applications/xstream_banter/modal_assign_teams_tournament"); ?>


<div class="modal fade" id="modal_confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                <div class="row col-md-offset-1">
                    <!--<div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-6">Are you sure to delete this record?</div>
                    </div>-->
                    <h3>Are you sure to delete this record?</h3>             
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-custom" name="submit_yes" id="submit_yes" value="YES">Yes</button>
                <button type="button" class="btn button-custom" data-dismiss="modal" name="submit_no" id="submit_no">No</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


