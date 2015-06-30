<script type="text/javascript">
    $(function(){
        $("#tournament_list").change(function(){
            populate_league_table($("#tournament_list").val());
        });
    });
    function populate_league_table(tournament_id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "<?php echo base_url() . 'applications/score_prediction/get_league_table_data'; ?>",
            data: {
                tournament_id: tournament_id
            },
            success: function(data) {
                $('#league_table_id').html(tmpl('tlmp_league_table', data.team_list));
                //generate the league table content based on the ajax response using template
            }
        });        
    }
</script>
<script type="text/x-tmpl" id="tlmp_league_table">

          <table class="table">
            <tr style="background-color: rgb(0, 0, 0); color: whitesmoke; font-size: 15px;">
            <th>POS</th>
            <th>Team </th>
            <th>P</th>
            <th>GD</th>
            <th>Pts</th>
            </tr>
    {% var i=0, team_list = ((o instanceof Array) ? o[i++] : o); %}
    {% while(team_list){ %}
            <tr>
            <td>{%= team_list.position%}</td>
            <td>{%= team_list.title%}</td>
            <td>{%= team_list.point%}</td>
            <td>{%= team_list.difference%}</td>
            <td>{%= team_list.points%}</td>
            </tr>
 {% team_list = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
        </table>



</script>
<div style="">
    <div class="row heading blue_banner" style="padding: 5px; font-size: 20px;">
        League Table
    </div>
    <div class="row" style="padding-top:10px;padding-bottom:10px;">
        <div class ="col-md-12 requiredField">
            <?php echo form_dropdown('tournament_list', array('0'=>'Select')+$tournament_list, '', 'class="form-control" id="tournament_list"'); ?>
        </div> 
    </div>
    <div class="row">
        <div id="league_table_id"></div>
    </div>
</div>