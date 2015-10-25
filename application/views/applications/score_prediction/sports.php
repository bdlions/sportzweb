<div class="row">
    <div class="col-md-12">
        <h1>Fixtures & Results</h1>
        <?php $this->load->view("applications/score_prediction/templates/header_menu"); ?>
    </div>
</div>
<div class="row" style="padding-bottom: 25px;">
    <div class="col-md-7 col-sm-7 col-xs-12 form-group">
        <?php $this->load->view("applications/score_prediction/process_match_list", $this->data); ?>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12 form-group pull-right">
        <?php 
            if(isset($sports_id) && $sports_id != APP_SP_BASKETBALL_SPORTS_ID )
            {
                $this->load->view("applications/score_prediction/league_table"); 
            }
        ?>
    </div>
</div>
