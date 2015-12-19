<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<script type="text/javascript">
    $(function() {
        $("#submit_button").on("click", function() {
            if ($("#client_list").val() == 0)
            {
                // alert("Please select the person you are assessing from the drop menu.");
                var message = "Please select the person you are assessing from the drop menu.";
                print_common_message(message);
                return false;
            }
            $('#date').val(convert_date_from_user_to_db($('#date').val()));
            $('#reassess').val(convert_date_from_user_to_db($('#reassess').val()));
            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>applications/gympro/create_assessment',
                data: $("#form_assesment").serializeArray(),
                success: function(data) {
                    var message = data.message;
                    print_common_message(message);
                    window.location = '<?php echo base_url(); ?>applications/gympro/manage_assessments';
                }
            });
        });
        $('#date').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#date').text($('#date').data('date'));
            $('#date').datepicker('hide');
        });
        $('#reassess').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#reassess').text($('#reassess').data('date'));
            $('#reassess').datepicker('hide');
        });
    });
</script>
<div class="container-fluid">
    <div class="row top_margin">
        <?php
        if ($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT) {
            $this->load->view("applications/gympro/template/sections/client_left_pane");
        } else {
            $this->load->view("applications/gympro/template/sections/pt_left_pane");
        }
        ?>
        <div class="col-md-8">
            <?php echo form_open("applications/gympro/create_assessment/", array('id' => 'form_assesment', 'class' => 'form-horizontal', 'onsubmit' => 'return false;')); ?>
            <div class="pad_title">
                NEW ASSESSMENT
                <div class="col-md-3 pull-right">
                    <?php $this->load->view("applications/gympro/template/user_category_dropdown"); ?>
                </div>
            </div>
            <div style="border-top: 2px solid lightgray; margin-left: 20px"></div>
            <div class="pad_body">
                <?php if (isset($message) && ($message != NULL)) { ?>
                    <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
                <?php } ?> 
                <div class="row form-group">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-md-4">Date:</div>
                            <div class="col-md-5">
                                <?php echo form_input($date + array('class' => 'form-control')) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Weight:</div>
                            <div class="col-md-5">
                                <?php echo form_input($weight + array('class' => 'form-control')) ?>
                            </div>kg
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Height:</div>
                            <div class="col-md-5">
                                <?php echo form_input($head + array('class' => 'form-control')) ?>
                            </div>cm
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Neck:</div>
                            <div class="col-md-5">
                                <?php echo form_input($neck + array('class' => 'form-control')) ?>
                            </div>cm
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Chest:</div>
                            <div class="col-md-5">
                                <?php echo form_input($chest + array('class' => 'form-control')) ?>
                            </div>cm
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-md-4">Reassess:</div>
                            <div class ="col-md-5">
                                <?php echo form_input($reassess + array('class' => 'form-control')) ?>
                            </div> 
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Body fat:</div>
                            <div class="col-md-5">
                                <?php echo form_input($body_fat + array('class' => 'form-control')) ?>
                            </div>%
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Abdominal:</div>
                            <div class="col-md-5">
                                <?php echo form_input($abdominal + array('class' => 'form-control')) ?>
                            </div>cm
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Waist:</div>
                            <div class="col-md-5">
                                <?php echo form_input($waist + array('class' => 'form-control')) ?>
                            </div>cm
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">Hip:</div>
                            <div class="col-md-5">
                                <?php echo form_input($hip + array('class' => 'form-control')) ?>
                            </div>cm
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div style="background-color: white">
                            <div class="row form-group">
                                <div class="col-md-2">LEFT SIDE</div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2">RIGHT SIDE</div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-4">Arm Relaxed:</div>
                                        <div class="col-md-5">
                                            <?php echo form_input($ls_arm_relaxed + array('class' => 'form-control')) ?>
                                        </div>cm
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">Arm Flexed:</div>
                                        <div class="col-md-5">
                                            <?php echo form_input($ls_arm_flexed + array('class' => 'form-control')) ?>
                                        </div>cm
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">Forearm:</div>
                                        <div class="col-md-5">
                                            <?php echo form_input($ls_forearm + array('class' => 'form-control')) ?>
                                        </div>cm
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">Wrist:</div>
                                        <div class="col-md-5">
                                            <?php echo form_input($ls_wrist + array('class' => 'form-control')) ?>
                                        </div>cm
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">Thigh (gluteal):</div>
                                        <div class="col-md-5">
                                            <?php echo form_input($ls_thigh_gluteal + array('class' => 'form-control')) ?>
                                        </div>cm
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">Thigh (mid):</div>
                                        <div class="col-md-5">
                                            <?php echo form_input($ls_thigh_mid + array('class' => 'form-control')) ?>
                                        </div>cm
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">Kalf:</div>
                                        <div class="col-md-5">
                                            <?php echo form_input($ls_calf + array('class' => 'form-control')) ?>
                                        </div>cm
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">Ankle:</div>
                                        <div class="col-md-5">
                                            <?php echo form_input($ls_ankle + array('class' => 'form-control')) ?>
                                        </div>cm
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="col-md-4">Arm Relaxed:</div>
                                        <div class="col-md-5">
                                            <?php echo form_input($rs_arm_relaxed + array('class' => 'form-control')) ?>
                                        </div>cm
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">Arm Flexed:</div>
                                        <div class="col-md-5">
                                            <?php echo form_input($rs_arm_flexed + array('class' => 'form-control')) ?>
                                        </div>cm
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">Forearm:</div>
                                        <div class="col-md-5">
                                            <?php echo form_input($rs_forearm + array('class' => 'form-control')) ?>
                                        </div>cm
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">Wrist:</div>
                                        <div class="col-md-5">
                                            <?php echo form_input($rs_wrist + array('class' => 'form-control')) ?>
                                        </div>cm
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">Thigh (gluteal):</div>
                                        <div class="col-md-5">
                                            <?php echo form_input($rs_thigh_gluteal + array('class' => 'form-control')) ?>
                                        </div>cm
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">Thigh (mid):</div>
                                        <div class="col-md-5">
                                            <?php echo form_input($rs_thigh_mid + array('class' => 'form-control')) ?>
                                        </div>cm
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">Kalf:</div>
                                        <div class="col-md-5">
                                            <?php echo form_input($rs_calf + array('class' => 'form-control')) ?>
                                        </div>cm
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">Ankle:</div>
                                        <div class="col-md-5">
                                            <?php echo form_input($rs_ankle + array('class' => 'form-control')) ?>
                                        </div>cm
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pad_footer">
                    <?php echo form_input($submit_button) ?> or <a href="<?php echo base_url() ?>applications/gympro/manage_assessments">Previous</a>
                </div>            
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>