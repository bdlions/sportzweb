<div class="panel panel-default">
    <div class="panel-heading">Create Match</div>
    <div class="panel-body">
        <div class="form-background top-bottom-padding">
            <div class="row">
                <div class ="col-md-offset-3 col-md-5 margin-top-bottom">
                    <?php // echo form_open_multipart("admin/applications_scoreprediction/create_match/".$tournament_id, array('id' => 'form_create_match', 'class' => 'form-horizontal', 'onsubmit'=>"return false;")); ?>
                    <!--<form id="form_create_match" role="form" class="form-horizontal" method="post" action="admin/applications_scoreprediction/create_match/" onsubmit="return false">-->
                    <form id="form_create_match" role="form" class="form-horizontal" method="post" onsubmit="">
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label requiredField">
                                Home Team:
                            </label>
                            <div class ="col-md-9">
                                <select name="hometeam" class="form-control">
                                    <?php foreach ($teams as $team): ?>
                                        <option value="<?php echo $team['id']; ?>"><?php echo $team['title']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label requiredField">
                                Away team:
                            </label>
                            <div class ="col-md-9">
                                <select name="awayteam" class="form-control">
                                    <?php foreach ($teams as $team): ?>
                                        <option value="<?php echo $team['id']; ?>"><?php echo $team['title']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label requiredField">
                                Date: 
                            </label>
                            <div class ="col-md-9">
                                <input id="datepicker" name="date" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label requiredField">
                                Time (24HR): 
                            </label>
                            <div class ="col-md-9">
                                <input name="time" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label requiredField">
                                Home Score: 
                            </label>
                            <div class ="col-md-9">
                                <input name="homescore" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label requiredField">
                                Away Score: 
                            </label>
                            <div class ="col-md-9">
                                <input name="awayscore" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label requiredField">
                                Match status: 
                            </label>
                            <div class ="col-md-9">
                                <select name="status" class="form-control">
                                    <option val="1">Upcoming</option>
                                    <option val="2">Win-Home</option>
                                    <option val="3">Win-Away</option>
                                    <option val="4">Draw</option>
                                    <option val="5">Cancel</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="form-group">
                        <div class="pull-right col-md-4">
                            <button id="btnSubmit" name="btnSubmit" class="btn button-custom pull-right">Create Match</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php // echo form_close(); ?>
        </div>
    </div>
</div>
<script>
 $(function() {
    $( "#datepicker" ).datepicker({
        showOn: "button",
        buttonText: "Datepicker",
        dateFormat: "mm/dd/yy"
    });
    
    $("#btnSubmit").on("click", function(){
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url();?>admin/applications_scoreprediction/create_match/<?php echo $tournament_id?>',
            data: $("#form_create_match").serializeArray(),
            success: function(data) {
                alert(data.message);
                window.location = '<?php echo base_url();?>admin/applications_scoreprediction/manage_matches/<?php echo $tournament_id?>';
            }
        });
    });
});


</script>