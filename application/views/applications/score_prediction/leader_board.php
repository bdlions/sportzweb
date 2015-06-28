<script type="text/javascript">
    $(function(){
        populate_leader_board('<?php echo LEADER_BOARD_OPTION_ALL_TIME?>');
        $("#leader_board_options").change(function(){
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
            success: function(data) {
                //generate the leader board content based on the ajax response using template
            }
        });        
    }
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
            <table class="table table-hover text_align">
                <tr>
                    <td>Rank</td>
                    <td>Voter</td>
                    <td>Prediction(%)</td>
                    <td>Score</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>
                        <img class="img-rounded" height="25" width="25" src="<?php echo base_url(); ?>resources/images/user_male.png">
                        <span class="Leader_board_table_user_name_style">Shem Haye</span>
                    </td>
                    <td>95%</td>
                    <td>95</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>
                        <img class="img-rounded" height="25" width="25" src="<?php echo base_url(); ?>resources/images/user_female.png">
                        <span class="Leader_board_table_user_name_style">Juliana</span>
                    </td>
                    <td>90%</td>
                    <td>90</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>
                        <img class="img-rounded" height="25" width="25" src="<?php echo base_url(); ?>resources/images/user_male.png">
                        <span class="Leader_board_table_user_name_style">Alamgir Kabir</span>
                    </td>
                    <td>85%</td>
                    <td>85</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>
                        <img class="img-rounded" height="25" width="25" src="<?php echo base_url(); ?>resources/images/user_female.png">
                        <span class="Leader_board_table_user_name_style">Jessica</span>
                    </td>
                    <td>80%</td>
                    <td>80</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>
                        <img class="img-rounded" height="25" width="25" src="<?php echo base_url(); ?>resources/images/user_male.png">
                        <span class="Leader_board_table_user_name_style">Robart</span>
                    </td>
                    <td>67%</td>
                    <td>67</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>
                        <img class="img-rounded" height="25" width="25" src="<?php echo base_url(); ?>resources/images/user_female.png">
                        <span class="Leader_board_table_user_name_style">Rashida Sultana</span>
                    </td>
                    <td>63%</td>
                    <td>63</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>
                        <img class="img-rounded" height="25" width="25" src="<?php echo base_url(); ?>resources/images/user_male.png">
                        <span class="Leader_board_table_user_name_style">Nazmul Hasan</span>
                    </td>
                    <td>60%</td>
                    <td>60</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>
                        <img class="img-rounded" height="25" width="25" src="<?php echo base_url(); ?>resources/images/user_female.png">
                        <span class="Leader_board_table_user_name_style">Salma Akter</span>
                    </td>
                    <td>55%</td>
                    <td>55</td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>
                        <img class="img-rounded" height="25" width="25" src="<?php echo base_url(); ?>resources/images/user_male.png">
                        <span class="Leader_board_table_user_name_style">Nazrul Islam</span>
                    </td>
                    <td>52%</td>
                    <td>52</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>
                        <img class="img-rounded" height="25" width="25" src="<?php echo base_url(); ?>resources/images/user_female.png">
                        <span class="Leader_board_table_user_name_style">Maria De Souza</span>
                    </td>
                    <td>49%</td>
                    <td>49</td>
                </tr>
            </table>
        </div>
    </div>
</div>