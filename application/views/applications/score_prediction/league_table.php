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
                //generate the league table content based on the ajax response using template
            }
        });        
    }
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
        <table class="table-condensed table-responsive table" id="">
            <tbody id="tbl_team_standings">
            </tbody>
        </table>
    </div>
</div>