<script type="text/javascript">
    var weight = 1;
    $(function() {
        $('#start_date').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#start_date').text($('#start_date').data('date'));
            $('#start_date').datepicker('hide');
        });
        
        $("#exercise_box").append(tmpl("tmpl_weight_exercise",weight));
        
            
    });
    
    function add_weight_exercise()
    {
        weight++;
        $("#exercise_box").append(tmpl("tmpl_weight_exercise",weight));
    }
    var cardio=0;
    function add_cardio_exercise()
    {
        cardio++;
        $("#exercise_box").append(tmpl("tmpl_cardio_exercise",cardio));
    }
    

</script>
<script type="text/x-tmpl" id="tmpl_weight_exercise">
    {% var weight=0, weight_num = ((o instanceof Array) ? o[weight++] : o); %}
    <div id="">
            <div class="deletable_box">
                <div class="pad_white">
                    <div class="row">
                        <div class="col-md-12">
                            <span style="font-weight: bold;">Exercie name: &nbsp;&nbsp;</span>
                            <input style="width: 40%; min-width: 150px;" name="ex_name_<?php echo '{%= weight_num%}'; ?>">
                            <img onclick="open_modal_browse_exercise()" src="<?php echo base_url(); ?>resources/images/browse.png" style="margin: 4px">
                            <img class="pull-right" onclick="$(this).closest('.deletable_box').remove()" src="<?php echo base_url(); ?>resources/images/cross.png" style="margin: 4px">
                        </div>
                    </div>
                </div>
                <div class="pad_white">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Description</div>
                                <div><textarea style="width: 100%; min-height: 50px;" name="ex_description_<?php echo '{%= weight_num%}'; ?>"></textarea></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Sets</div>
                                <div><input style="width: 100%" name="ex_sets_<?php echo '{%= weight_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Reps</div>
                                <div><input style="width: 100%" name="ex_reps_<?php echo '{%= weight_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Weights</div>
                                <div><input style="width: 100%" name="ex_weights_<?php echo '{%= weight_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Reps</div>
                                <div><input style="width: 100%" name="ex_reps2_<?php echo '{%= weight_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Tempo</div>
                                <div><input style="width: 100%" name="ex_tempo_<?php echo '{%= weight_num%}'; ?>"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group"></div>
            </div>
        </div>
    
</script>
<script type="text/x-tmpl" id="tmpl_cardio_exercise" >
    {% var i=0, cardio_num = ((o instanceof Array) ? o[i++] : o); %}
    <div id="">
            <div class="deletable_box">
                <div class="pad_white">
                    <div class="row">
                        <div class="col-md-12">
                            <span style="font-weight: bold;">Exercie name: &nbsp;&nbsp;</span>
                            <input style="width: 40%; min-width: 150px;" name="ex_name_<?php echo '{%= cardio_num%}'; ?>">
                            <img onclick="open_modal_browse_exercise()" src="<?php echo base_url(); ?>resources/images/browse.png" style="margin: 4px">
                            <img class="pull-right" onclick="$(this).closest('.deletable_box').remove()" src="<?php echo base_url(); ?>resources/images/cross.png" style="margin: 4px">
                        </div>
                    </div>
                </div>
                <div class="pad_white">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Description</div>
                                <div><textarea style="width: 100%; min-height: 50px;" name="ex_description_<?php echo '{%= cardio_num%}'; ?>"></textarea></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Level</div>
                                <div><input style="width: 100%" name="ex_reps2_<?php echo '{%= cardio_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Speed</div>
                                <div><input style="width: 100%" name="ex_sets_<?php echo '{%= cardio_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Time</div>
                                <div><input style="width: 100%" name="ex_reps_<?php echo '{%= cardio_num%}'; ?>"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Target H.R</div>
                                <div><input style="width: 100%" name="ex_weights_<?php echo '{%= cardio_num%}'; ?>"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group"></div>
            </div>
    </div>
    
</script>



<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css"/>
<?php
$this->load->view("applications/gympro/program/modal_exercise_program");
?>
<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-10">
            <div class="pad_title">
                CREATE PROGRAMME
            </div>
            <?php echo form_open("applications/gympro/create_program", array('id' => 'form_create_program', 'class' => 'form-horizontal')) ?>
            <div class="pad_body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Programme Focus: </label>
                            <div class="col-sm-6">
                                <input class="form-control" name="focus">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Start date: </label>
                            <div class="col-sm-4">
                                <input class="form-control" name="start_date" id="start_date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Review In: </label>
                            <div class="col-sm-4">
                                <select class="form-control" name="review_id">
                                    <?php foreach ($review_array as $review): ?>
                                        <option value="<?php echo $review['id']; ?>"><?php echo $review['title']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Warm Up: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="warm_up"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Cooldown: </label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="cool_down"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--EXERCISE BOXES ARE ADDED HERE-->
                <div id="exercise_box">
                </div>
                
                <div style="width: 100%; display: inline-block;">
                    <div style="font-size: 16px; line-height: 33px; float: right">
                        Add another: <a class="cursor_pointer" onclick="add_weight_exercise()">Weight exercise</a>&nbsp; or &nbsp;<a class="cursor_pointer" onclick="add_cardio_exercise()">Cardio Exercise</a>
                    </div>
                </div>
            </div>
            <div class="pad_footer">
                <input type="submit" name="submitButton" value="Save Changes"> or <a href="<?php echo base_url() ?>applications/gympro/programs">Go Back</a>
            </div>
            <?php echo form_close();?>
        </div>
    </div>

    <div class="pad_white">
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
    </div>
    
    
<!--    <div style="display: none">
        TEMPLATE
        <div id="weight_exercise">
            <div class="deletable_box">
                <div class="pad_white">
                    <div class="row">
                        <div class="col-md-12">
                            <span style="font-weight: bold;">Exercie name: &nbsp;&nbsp;</span>
                            <input style="width: 40%; min-width: 150px;" name="ex_name">
                            <img onclick="open_modal_browse_exercise()" src="<?php echo base_url(); ?>resources/images/browse.png" style="margin: 4px">
                            <img class="pull-right" onclick="$(this).closest('.deletable_box').remove()" src="<?php echo base_url(); ?>resources/images/cross.png" style="margin: 4px">
                        </div>
                    </div>
                </div>
                <div class="pad_white">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Description</div>
                                <div><textarea style="width: 100%; min-height: 50px;" name="ex_description"></textarea></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Sets</div>
                                <div><input style="width: 100%" name="ex_sets"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Reps</div>
                                <div><input style="width: 100%" name="ex_reps"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Weights</div>
                                <div><input style="width: 100%" name="ex_weights"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Reps</div>
                                <div><input style="width: 100%" name="ex_reps2"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Tempo</div>
                                <div><input style="width: 100%" name="ex_tempo"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group"></div>
            </div>
        </div>
        <div id="cardio_exercise">
            <div class="deletable_box">
                <div class="pad_white">
                    <div class="row">
                        <div class="col-md-12">
                            <span style="font-weight: bold;">Exercie name: &nbsp;&nbsp;</span>
                            <input style="width: 40%; min-width: 150px;" name="ex_name">
                            <img onclick="open_modal_browse_exercise()" src="<?php echo base_url(); ?>resources/images/browse.png" style="margin: 4px">
                            <img class="pull-right" onclick="$(this).closest('.deletable_box').remove()" src="<?php echo base_url(); ?>resources/images/cross.png" style="margin: 4px">
                        </div>
                    </div>
                </div>
                <div class="pad_white">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Description</div>
                                <div><textarea style="width: 100%; min-height: 50px;" name="ex_description"></textarea></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Level</div>
                                <div><input style="width: 100%" name="ex_reps2"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Speed</div>
                                <div><input style="width: 100%" name="ex_sets"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Time</div>
                                <div><input style="width: 100%" name="ex_reps"></div>
                            </div>
                            <div class="col-md-1" style="padding: 0px; margin: 2px;">
                                <div style="font-size: 14px;">Target H.R</div>
                                <div><input style="width: 100%" name="ex_weights"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group"></div>
            </div>
    </div>
</div>-->
</div>
