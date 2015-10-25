<script type="text/javascript">
    $(function() {
        $("#tournament_list").change(function() {
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
                if(data.table_title !== "" && data.table_title != null)
                {
                    $('#table_title').html(data.table_title); 
                }                       
                $('#league_table_content').html(data.league_table);
                //$('#league_table_content').html(tmpl('tlmp_table_header', data.league_table_header_title_list));
                //$('#league_table_content').append(tmpl('tlmp_league_table', data.team_list));
            }
        });
    }
</script>
<!--<script type="text/x-tmpl" id="tlmp_table_header">    
    <tr style="background-color: rgb(0, 0, 0); color: whitesmoke; font-size: 15px;">
    {% var i=0, team_list = ((o instanceof Array) ? o[i++] : o); %}
    {% while(team_list){ %}    
    <th>{%= team_list%}</th>    
    {% team_list = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}   
    </tr>
</script>-->
<!--<script type="text/x-tmpl" id="tlmp_league_table">
    {% var i=0, team_list = ((o instanceof Array) ? o[i++] : o); %}
    {% while(team_list){ %}
    <tr>
    {% if(team_list.hasOwnProperty("column1")) { %}
    <td>{%= team_list.column1%}</td>
    {% }if(team_list.hasOwnProperty("column2")) { %}
    <td>{%= team_list.column2%}</td>
    {% }if(team_list.hasOwnProperty("column3")) { %}
    <td>{%= team_list.column3%}</td>
    {% }if(team_list.hasOwnProperty("column4")) { %}
    <td>{%= team_list.column4%}</td>
    {% }if(team_list.hasOwnProperty("column5")) { %}
    <td>{%= team_list.column5%}</td>
    {% }if(team_list.hasOwnProperty("column6")) { %}
    <td>{%= team_list.column6%}</td>
    {% }if(team_list.hasOwnProperty("column7")) { %}
    <td>{%= team_list.column7%}</td>
    {% } %}
    </tr>
    {% team_list = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>-->

<div class="row form-group heading blue_banner prediction_league_table_header">
    <div class="col-md-12" id="table_title">
        <?php if(isset($sports_info))
        { 
            echo $sports_info['table_title'];
        }?>
    </div>
</div>
<div class="row" style="padding-top:10px; padding-bottom: 10px;">
    <div class="col-md-12 requiredField">
        <?php echo form_dropdown('tournament_list', array('0' => 'Select') + $tournament_list, '', 'class="form-control" id="tournament_list"'); ?>
    </div> 
</div>
<div class="row form-group">
    <div class="col-md-12">
        <div id="league_table_id">
            <table class="table">
                <tbody id="league_table_content">
                </tbody>
            </table>
        </div>
    </div>
</div>