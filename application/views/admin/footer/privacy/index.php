<div class="panel panel-default">
    <div class="panel-heading">Privacy</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row form-group">
                <div class ="col-md-3">
                    <a href="<?php echo base_url();?>admin/footer/update_privacy">
                        <button style="width:100%" id="button_create_topic_name" class="btn button-custom pull-left" >
                            Update Privacy
                        </button>
                    </a>
                </div>                
            </div>
            <div class="row" style="padding-left:15px;padding-bottom:15px;">
                <?php foreach($privacy_list as $list){?>
               <?php echo $list['description']?>
               <?php } ?>
            </div>
            <div class="row form-group">
                <div class ="col-md-3">
                    <input type="button" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
                </div>
            </div>
        </div>        
    </div>
</div>
