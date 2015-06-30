
<script type="text/x-tmpl" id="tmpl_table_header">
    <tr style="font-size: 15px; color: whitesmoke; background-color: #000">
    <th>POS</th>
    <th>Team </th>
    <th>P</th>
    <th>GD</th>
    <th>Pts</th>
    </tr>
</script>
<script type="text/x-tmpl" id="tmpl_team_standings">
    {% var i=0, team = ((o instanceof Array) ? o[i++] : o); %}
    {% while(team){ %}
    <tr style="background-color: whitesmoke">
    <td> {%= i%} </td>
    <td> {%= team['team_name']%} </td>
    <td> {%= team['played']%} </td>
    <td> {%= team['gd']%} </td>
    <td> {%= team['point']%} </td>
    </tr>
    {% team = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/blog_app.css" />
<div class="container-fluid">
    <div class="row">
        <h1>Fixtures & Results</h1>
        <?php $this->load->view("applications/score_prediction/templates/header_menu"); ?>
        <div class="col-md-7 col-sm-7 col-xs-12 form-group"> 
            <?php $this->load->view("applications/score_prediction/process_match_list", $this->data); ?>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12 form-group pull-right">
            <?php $this->load->view("applications/score_prediction/leader_board"); ?>
        </div>

    </div>
    <?php $this->load->view("applications/score_prediction/prediction_confirmation_modal"); ?>
</div>
<div class="row form-group"></div>
<div class="row form-group"></div>
<div class="row form-group"></div>
<div class="row form-group"></div>














<!--<script>
$(function () {
    $('#predicted_id_01').on('click', function () {
        $('#predicted_football_game_01').toggle();
    });
    $('#predict_id_01').on('click', function () {
        $('#predict_football_game_01').toggle();
    });
    $('#predict_football_game_01_team_a_win').on('click', function () {
        $('#team_name').html("Arsenal");
        $('#confirmModal').modal('show');
        $('#vote_id').on('click', function () {
            $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_team_a").removeClass("team_a_previous_width_on_click_team_a");
            $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_draw").removeClass("team_a_previous_width_on_click_draw");
            $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_team_b").removeClass("team_a_previous_width_on_click_team_b");
            $("#predict_football_game_01_team_a_win").find(".progress_bar_width_catulate").addClass("team_a_present_width_on_click_team_a");
            $("#predict_football_game_01_team_a_win").find(".progress_bar_percentage_text").text('60%');

            $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_team_a").removeClass("draw_previous_width_on_click_team_a");
            $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_draw").removeClass("draw_previous_width_on_click_draw");
            $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_team_b").removeClass("draw_previous_width_on_click_team_b");
            $("#predict_football_game_01_draw").find(".progress_bar_width_catulate").addClass("draw_present_width_on_click_team_a");
            $("#predict_football_game_01_draw").find(".progress_bar_percentage_text").text('25%');

            $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_team_a").removeClass("team_b_previous_width_on_click_team_a");
            $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_draw").removeClass("team_b_previous_width_on_click_draw");
            $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_team_b").removeClass("team_b_previous_width_on_click_team_b");
            $("#predict_football_game_01_team_b_win").find(".progress_bar_width_catulate").addClass("team_b_present_width_on_click_team_a");
            $("#predict_football_game_01_team_b_win").find(".progress_bar_percentage_text").text('15%');

            $('#confirmModal').modal('hide');
            $("#predict_football_game_01_team_a_win").off('click');
            $("#predict_football_game_01_draw").off('click');
            $("#predict_football_game_01_team_b_win").off('click');
        });
        $('#vote_ignore_id').on('click', function () {
            $('#confirmModal').modal('hide');
        });
    });
    $('#predict_football_game_01_draw').on('click', function () {
        $('#team_name').html("Draw");
        $('#confirmModal').modal('show');
        $('#vote_id').on('click', function () {
            $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_team_a").removeClass("team_a_previous_width_on_click_team_a");
            $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_draw").removeClass("team_a_previous_width_on_click_draw");
            $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_team_b").removeClass("team_a_previous_width_on_click_team_b");
            $("#predict_football_game_01_team_a_win").find(".progress_bar_width_catulate").addClass("team_a_present_width_on_click_draw");
            $("#predict_football_game_01_team_a_win").find(".progress_bar_percentage_text").text('45%');

            $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_team_a").removeClass("draw_previous_width_on_click_team_a");
            $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_draw").removeClass("draw_previous_width_on_click_draw");
            $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_team_b").removeClass("draw_previous_width_on_click_team_b");
            $("#predict_football_game_01_draw").find(".progress_bar_width_catulate").addClass("draw_present_width_on_click_draw");
            $("#predict_football_game_01_draw").find(".progress_bar_percentage_text").text('40%');

            $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_team_a").removeClass("team_b_previous_width_on_click_team_a");
            $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_draw").removeClass("team_b_previous_width_on_click_draw");
            $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_team_b").removeClass("team_b_previous_width_on_click_team_b");
            $("#predict_football_game_01_team_b_win").find(".progress_bar_width_catulate").addClass("team_b_present_width_on_click_draw");
            $("#predict_football_game_01_team_b_win").find(".progress_bar_percentage_text").text('15%');

            $('#confirmModal').modal('hide');
            $("#predict_football_game_01_team_a_win").off('click');
            $("#predict_football_game_01_draw").off('click');
            $("#predict_football_game_01_team_b_win").off('click');
        });
        $('#vote_ignore_id').on('click', function () {
            $('#confirmModal').modal('hide');
        });
    });
    $('#predict_football_game_01_team_b_win').on('click', function () {
        $('#team_name').html("Swansea");
        $('#confirmModal').modal('show');
        $('#vote_id').on('click', function () {
            $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_team_a").removeClass("team_a_previous_width_on_click_team_a");
            $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_draw").removeClass("team_a_previous_width_on_click_draw");
            $("#predict_football_game_01_team_a_win").find(".team_a_previous_width_on_click_team_b").removeClass("team_a_previous_width_on_click_team_b");
            $("#predict_football_game_01_team_a_win").find(".progress_bar_width_catulate").addClass("team_a_present_width_on_click_team_b");
            $("#predict_football_game_01_team_a_win").find(".progress_bar_percentage_text").text('45%');

            $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_team_a").removeClass("draw_previous_width_on_click_team_a");
            $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_draw").removeClass("draw_previous_width_on_click_draw");
            $("#predict_football_game_01_draw").find(".draw_previous_width_on_click_team_b").removeClass("draw_previous_width_on_click_team_b");
            $("#predict_football_game_01_draw").find(".progress_bar_width_catulate").addClass("draw_present_width_on_click_team_b");
            $("#predict_football_game_01_draw").find(".progress_bar_percentage_text").text('25%');

            $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_team_a").removeClass("team_b_previous_width_on_click_team_a");
            $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_draw").removeClass("team_b_previous_width_on_click_draw");
            $("#predict_football_game_01_team_b_win").find(".team_b_previous_width_on_click_team_b").removeClass("team_b_previous_width_on_click_team_b");
            $("#predict_football_game_01_team_b_win").find(".progress_bar_width_catulate").addClass("team_b_present_width_on_click_team_b");
            $("#predict_football_game_01_team_b_win").find(".progress_bar_percentage_text").text('30%');
            $('#confirmModal').modal('hide');
            $("#predict_football_game_01_team_a_win").off('click');
            $("#predict_football_game_01_draw").off('click');
            $("#predict_football_game_01_team_b_win").off('click');
        });
        $('#vote_ignore_id').on('click', function () {
            $('#confirmModal').modal('hide');
        });
    });
});
</script>-->
<!--<script>
$(function () {
    $("#datepicker").datepicker({
        showOn: "button",
        buttonImage: "<?php echo base_url(); ?>resources/images/calendar.png",
        buttonImageOnly: true,
        buttonText: "Select a date"
    });
});

</script>-->
