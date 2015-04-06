<script type="text/javascript">
    $(function() {
        $('#account_type_list').change(function() {
            $('#form_account').submit();
        });
    });
</script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<div class="container-fluid">    
    <div class="row top_margin">
        <div class="col-md-2">
            <?php //$this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-9">
            <div class="row form-group">
                <div class="col-md-12">
                    <span>Please select if you are a client or personal trainer</span>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <div style="position: relative">
                        <div style="position: absolute; top: 15px; left: 25px; background-color: whitesmoke; padding: 5px;">
                            <?php echo form_open("applications/gympro/account/".$user_id, array('id' => 'form_account', 'class' => 'form-horizontal')); ?>
                                <?php echo form_dropdown('account_type_list', array('0' => 'Select')+$account_type_list, '', 'class=form-control id=account_type_list'); ?>
                            <?php echo form_close(); ?>
                        </div>
                        <img class="img-responsive" src="<?php echo base_url(); ?>resources/images/applications/gympro/personal-trainers.jpg">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>