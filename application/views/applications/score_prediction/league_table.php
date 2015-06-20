<div style="">
    <div class="row heading blue_banner" style="padding: 5px; font-size: 20px;">
        League Table
    </div>
    <div class="row" style="padding-top:10px;padding-bottom:10px;">
<!--        <label for="phone" class="col-md-3 control-label ">
            Show me:
        </label>-->
        <div class ="col-md-12 requiredField">
            <?php echo form_dropdown('dd_tournaments', $tournament_list, '1', 'class="form-control" id="dd_tournaments"'); ?>
        </div> 
    </div>
    <div class="row">
        <table class="table-condensed table-responsive table" id="">
            <tbody id="tbl_team_standings">
            </tbody>
        </table>
    </div>
</div>