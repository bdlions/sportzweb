<script type="text/javascript">
    $(function() {
        $('#start_date').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#start_date').text($('#start_date').data('date'));
            $('#start_date').datepicker('hide');
        });
        
    });
    
</script>



<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">

    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-10">
            <div class="pad_title">
                EDIT PROGRAMME
            </div>
            <?php echo form_open("applications/gympro/edit_program/", array('id' => 'form_create_program', 'class' => 'form-horizontal')) ?>
            <div class="pad_body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Programme Focus: </label>
                            <div class="col-sm-6">
                                <input class="form-control" name="focus" value="<?php echo $program['focus'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Start date: </label>
                            <div class="col-sm-4">
                                <input class="form-control" name="start_date" id="start_date" value="<?php echo $program['start_date'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Review In: </label>
                            <div class="col-sm-4">
                                <select class="form-control" name="review_id">
                                    <?php foreach ($review_array as $review): ?>
                                        <option <?php if($program['review_id'] == $review['id']) echo"selected "?>value="<?php echo $review['id']; ?>"><?php echo $review['title']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description"><?php echo $program['description'];?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Warm Up: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="warm_up"><?php echo $program['warm_up'];?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cooldown: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="cool_down"><?php echo $program['cool_down'];?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color: #fff; margin-bottom: 1px; padding: 10px; display: inline-block; width: 100%">
                    <span style="font-weight: bold;">Exercie name: &nbsp;&nbsp;</span>
                    <input style="width: 40%; min-width: 150px;" name="ex_name" value="<?php echo $exercise['ex_name'];?>">
                    <img onclick="open_modal_browse_exercise()" src="<?php echo base_url(); ?>resources/images/browse.png" style="margin: 4px">
                </div>
                <div style="background-color: #fff; margin-bottom: 1px; padding: 10px; display: inline-block; width: 100%">
                    <div>
                        <div class="col-md-6" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Description</div>
                            <div><textarea style="width: 100%; min-height: 50px;" name="ex_description"><?php echo $exercise['ex_description'];?></textarea></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Sets</div>
                            <div><input style="width: 100%" name="ex_sets" value="<?php echo $exercise['ex_sets'];?>"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Reps</div>
                            <div><input style="width: 100%" name="ex_reps" value="<?php echo $exercise['ex_reps'];?>"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Weights</div>
                            <div><input style="width: 100%" name="ex_weights" value="<?php echo $exercise['ex_weights'];?>"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Reps</div>
                            <div><input style="width: 100%" name="ex_reps2" value="<?php echo $exercise['ex_reps2'];?>"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Tempo</div>
                            <div><input style="width: 100%" name="ex_tempo" value="<?php echo $program['focus'];?>"></div>
                        </div>
                    </div>
                </div>
                <div style="width: 100%; display: inline-block;">
                    <div style="font-size: 16px; line-height: 33px; float: right">
                        Add another: <a href="" >Weight exercise</a>&nbsp; or &nbsp;<a href="">Cardio Exercise</a>
                    </div>
                </div>
            </div>
            <div class="pad_footer">
                <input type="submit" name="submitButton" value="Save Changes"> or <a href="<?php echo base_url() ?>applications/gympro/programs">Go Back</a>
            </div>
            <?php echo form_close();?>
        </div>
    </div>

</div>
<?php
$this->load->view("applications/gympro/template/modal/browse_exercise");
?>