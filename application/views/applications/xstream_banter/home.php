<script type="text/javascript">
    $(function() {
        $("#sports_list").on("change", function() {
            $("#form_select_sports").submit();
        });
    });
</script>
<div class="row col-md-6 col-md-offset-5">
    <div class="row" style="padding-bottom:150px"></div>
    <a href="<?php echo base_url().'applications/xstream_banter'; ?>" ><img src="<?php echo base_url() ?>resources/images/xb_logo.png" /></a>
</div>
<div class="row col-md-6 col-md-offset-5 form-horizontal">    
    <?php echo form_open("applications/xstream_banter", array('id' => 'form_select_sports', 'class' => 'form-horizontal')); ?>
    <div class="form-group">
        <div class ="col-md-12">
            <?php echo form_dropdown('sports_list', array(''=>'Select sports...')+$sports_list, '', 'class="form-control xb-home-form-control" id="sports_list"'); ?>
        </div> 
    </div> 
    <?php echo form_close(); ?>    
</div>