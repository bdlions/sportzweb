<script type="text/javascript">
    $(function() {
        $("#tournament_list").on("change", function() {
            $("#form_select_tournament").submit();
        });
    });
</script>
<div class="col-md-9 column xb-home">
    <div class="row col-md-6 col-md-offset-5">
        <div class="row" style="padding-bottom:150px"></div>
        <a href="<?php echo base_url().'applications/xstream_banter'; ?>" ><img src="<?php echo base_url() ?>resources/images/xb_logo.png" /></a>
    </div>
    <div class="row col-md-6 col-md-offset-5 form-horizontal">        
        <?php echo form_open("applications/xstream_banter/step2/".$sports_id, array('id' => 'form_select_tournament', 'class' => 'form-horizontal')); ?>
        <div class="form-group">
            <div class ="col-md-12">
                <?php echo form_dropdown('tournament_list', array(''=>'Select tournament...')+$tournament_list, '', 'class="form-control xb-home-form-control" id="tournament_list"'); ?>
            </div> 
        </div> 
        <?php echo form_close(); ?>       
    </div>
</div>
<div class="col-md-3 column">
    
</div>