<script type="text/javascript">
    $(function() {
        $('#selected_date').datepicker({
            dateFormat: 'dd-mm-yy',
            startDate: '-3d'
        }).on('changeDate', function(ev) {
            $('#selected_date').text($('#selected_date').data('date'));
            $('#selected_date').datepicker('hide');
        });
    });
    
</script>
<h3>Configure Home Page</h3>
<div class ="form-horizontal form-background top-bottom-padding">
    <?php echo form_open("admin/applications_scoreprediction/configure_home_page", array('id' => 'form_configure_homepage', 'class' => 'form-horizontal')); ?>
    <div class="row">
        <div class ="col-md-5 col-md-offset-2 margin-top-bottom">
            <div class ="row">
                <div class="col-md-4"></div>
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="form-group">
                <label for="sports_list" class="col-md-6 control-label requiredField">
                    Select Sports
                </label>
                <div class ="col-md-6" id="unit_dropdown">
                    <?php echo form_dropdown('sports_list', $sports_list, '', 'class=form-control id=dropdown'); ?>
                </div> 
            </div>
           
            <div class="form-group">
                <label for="selected_date" class="col-md-6 control-label requiredField">
                    Date
                </label>
                <div class ="col-md-6">
                    <?php echo form_input($selected_date+array('class'=>'form-control')); ?>
                </div> 
            </div>
            
             <div class="form-group">
                <label for="submit_configure_homepage" class="col-md-6 control-label requiredField">

                </label>
                <div class ="col-md-3 col-md-offset-3">
                    <?php echo form_input($submit_configure_homepage+array('class'=>'form-control btn button-custom')); ?>
                </div> 
            </div>
        </div>
    </div>
    <div class="btn-group" style="padding-left: 10px;">
        <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">
    $(function() {
        
    });
    
</script>