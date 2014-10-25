<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/blog_app.css" />
<div class="container-fluid">
    <div class="row">
        <h1>Score Prediction</h1>
        <?php $this->load->view("applications/score_prediction/templates/header_menu"); ?>
        <div class="col-md-7 pull-left">
            <div class="heading blue_banner">
                Barclay premier league 2014
            </div>
            <div style="height: 50px">
                <input class="lr_image" type="image" src="<?php echo base_url();?>resources/images/caret_l.png">
                <span class="heading">month</span>
                <input class="lr_image" type="image" src="<?php echo base_url();?>resources/images/caret_r.png">
            </div>
            <div>
                <table class="table-responsive table ">
                    <tr style="background-color: #EAEAEA">
                        <th class="title" colspan="4">table header 26 September</th>
                    </tr>
                    
                    <tr>
                        <td style="text-align: right">liverpool</td>
                        <td style="text-align: center"> 12.33</td>
                        <td>Everton</td>
                        <td>
                            <a style="float: right"><img src="<?php echo base_url();?>resources/images/predict_button.png"></a>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="4">
                            <div class="col-md-4">
                                <div class="title">Manchester</div>
                                <div onclick="confirmation_vote(1)" style="height: 100px; border: 1px solid blue; margin: 20px; background-color: lightgray">
                                    <div style="background-color: white; height: 44px">
                                        <div class="title" style="padding-top: 25%">10%</div>
                                    </div>
                                </div>
                                <input type="hidden" id=""value="">
                            </div>
                            <div class="col-md-4">
                                <div class="title">Manchester</div>
                                <div onclick="confirmation_vote(1)"  style="height: 100px; border: 1px solid blue; margin: 20px; background-color: lightgray">
                                    <div style="background-color: white; height: 40px">
                                        <div class="title" style="padding-top: 25%">adasd</div>
                                    </div>
                                </div>
                                <input type="hidden" id=""value="">
                            </div>
                            <div class="col-md-4">
                                <div class="title">Manchester</div>
                                <div onclick="confirmation_vote(1)" style="height: 100px; border: 1px solid blue; margin: 20px; background-color: lightgray">
                                    <div style="background-color: white; height: 14px">
                                        <div class="title" style="padding-top: 25%">adasd</div>
                                    </div>
                                </div>
                                <input type="hidden" id=""value="">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="col-md-4 pull-right">
            <div class="heading blue_banner" style="padding: 5px; font-size: 20px;">
                League Table
            </div>
            <div style="height: 40px; padding: 10px">
                <span style="font-size: 15px; padding-right: 15px">Show me: </span>
                <select>
                    <option>Premier League</option>
                    <option>Premier League</option>
                    <option>Premier League</option>
                </select>
            </div>
            <div >
                <table class="table-condensed table-responsive table">
                    <tr style="font-size: 15px; color: whitesmoke; background-color: #000">
                        <th>POS</th>
                        <th>Team </th>
                        <th>P</th>
                        <th>GD</th>
                        <th>Pts</th>
                    </tr>
                    <tr style="background-color: whitesmoke">
                        <td>1 -</td>
                        <td>Chelsea</td>
                        <td>5</td>
                        <td>9</td>
                        <td>13</td>
                    </tr>
                    <tr style="background-color: whitesmoke">
                        <td>1 -</td>
                        <td>Chelsea</td>
                        <td>5</td>
                        <td>9</td>
                        <td>13</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal fade" id="confirmModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Confirm Vote...</h4>
            </div>
            <div class="modal-body">
                <h3>Are you sure you want to vote?</h3>
            </div>
            <div class="modal-footer">
                <button onclick="post_vote()" type="button" class="btn btn-primary">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <input id="league_id" name="league_id" type="hidden" value="">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    function confirmation_vote(league_id)
    {
        $("#league_id").val(league_id);
        $("#confirmModal").modal("show");
    }
    function post_vote()
    {
        var league_id = $("#league_id").val();
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>' + "asdasd/application/xstreambanter/post_vote",
                dataType: 'json',
                data: {
                    league_id: league_id
                },
                success: function(data) {
                    location.reload();
                }
            });
    }
</script>
<style>
    .blue_banner
    {
        color: white;
        background-color:#3F48CC;
    }
    .title{
        font-size: 20px;
        text-align: center;
    }
    .heading{
        padding: 15px;
        font-size: 25px;
        text-align: center;
    }
    .lr_image
    {
        height: 18px;
        padding: 4px 0px 0px;
    }
</style>



<!--<div class="col-md-6">
    <?php echo 'echo error: ';?>
    <?php echo $error;?>
    <?php var_dump($error);?>

    <?php echo form_open_multipart('test/upload_crop');?>

        <input type="file" name="userfile" size="20" />
        <br /><br />
        <input type="submit" value="upload" />

    <?php echo form_close();?>
        
        
        
</div>-->