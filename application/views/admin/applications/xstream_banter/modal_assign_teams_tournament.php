<script type="text/javascript">
    $(function() {
        $("#button_select_teams_tournament").on("click", function() {
            var selected_array = Array();
            $("#tbody_team_list tr").each(function() {
                $("td:first input:checkbox", $(this)).each(function() {

                    if (this.checked == true)
                    {
                        selected_array.push(this.id);
                    }
                });
            });
            if(selected_array.length > 0)
            {
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "admin/application/assign_teams_tournament",
                    data: {
                        tournament_id:'<?php echo $tournament_id; ?>',
                        team_id_list: selected_array
                    },
                    success: function(data) {
                        if(data['status'] == 1)
                        {
                            window.location.reload();
                        }
                    }
                });
            }
        });
    });

</script>
<div class="modal fade" id="modal_assign_teams_tournament" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Select Teams</h4>
            </div>
            <div class="modal-body">
                <div class="row col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Check box</th>
                                    <th>Team Name</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_team_list">
                                <?php
                                foreach ($new_team_list as $key => $team) {
                                ?>
                                    <tr>
                                        <td><input id="<?php echo $team['id'] ?>" name="checkbox<?php echo $team['id'] ?>" class="" type="checkbox" /></td>
                                        <td id="<?php echo $team['id'] ?>"><?php echo $team['title'] ?></td>
                                    </tr>
                                <?php
                                }
                                ?>                            
                            </tbody>
                        </table>
                        <div class ="row form-group">
                            <div class="col-md-3 pull-right">
                                    <?php echo form_button(array('name' => 'button_select_teams_tournament', 'class' => 'form-control btn button-custom', 'id' => 'button_select_teams_tournament', 'content' => 'Select')); ?>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
