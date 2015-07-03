<script type="text/javascript">
    $(function () {
        populate_leader_board('<?php echo LEADER_BOARD_OPTION_ALL_TIME ?>');
        $("#leader_board_options").change(function () {
            populate_leader_board($("#leader_board_options").val());
        });
    });
    function populate_leader_board(leader_board_option)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "<?php echo base_url() . 'applications/score_prediction/get_leader_board_data'; ?>",
            data: {
                leader_board_option: leader_board_option
            },
            success: function (data) {
                $('#home_page_leader_board').empty().append(tmpl('tlmp_home_page_leader_board', data.user_list));               
            }
        });
    }
</script>
<script type="text/x-tmpl" id="tlmp_home_page_leader_board">
    <table class="table table-hover text_align">
        <tr>
            <td>Rank</td>
            <td>Voter</td>
            <td>Prediction(%)</td>
            <td>Score</td>
        </tr>
        {% var i=0, user_list = ((o instanceof Array) ? o[i++] : o); %}
        {% while(user_list){ %}
            <tr>
                <td>{%= i %}</td>
                <td>
                    <a href="<?php echo base_url().'member_profile/show/'.'{%= user_list.user_info.user_id %}'?>">
                    <img class="img-rounded" src="<?php echo base_url() . PROFILE_PICTURE_PATH_W32_H32?>{%= user_list.user_info.photo%}">
                    <span class="Leader_board_table_user_name_style">{%= user_list.user_info.first_name%} {%= user_list.user_info.last_name%}</span>
                    </a>
                </td>
                <td>{%= user_list.prediction_ratio+'%' %}</td>
                <td>{%= user_list.score%}</td>
            </tr>
        {% user_list = ((o instanceof Array) ? o[i++] : null); %}
        {% } %}
    </table>
</script>
<div>
    <div class="row form-group heading blue_banner prediction_leader_board_header">
        Voters Leader Board
    </div>
    <div class="row form-group font_10px">
        <div class="col-md-12">
            <?php echo form_dropdown('leader_board_options', $leader_board_options, '', 'class=form-control id=leader_board_options'); ?>
        </div>
    </div>
    <div class="row form-group font_10px">
        <div class="col-md-12">            
            <div id="home_page_leader_board"></div> 
        </div>
    </div>
</div>