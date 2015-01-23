<script type="text/javascript">
</script>  
<script type="text/x-tmpl" id="tmpl_topic_list">
  
</script>
                            
<div class="panel panel-default">
    <div class="panel-heading">Customer Feedback</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row form-group">
                <div class ="col-md-2" style="padding-left: 25px;">
                    <a href="<?php echo base_url();?>admin/contact_us/manage_topic">
                        <button style="width:100%" id="button_create_topic_name" class="btn button-custom pull-left" >
                            Topics
                        </button>
                    </a>
                </div>
                <div class="col-md-2"></div>
                <div class =" col-md-2">
                    <a href="<?php echo base_url().'admin/contact_us/manage_os' ?>">
                        <button style="width:100%" id="button_create_os_name" value="" class="btn button-custom " style="margin-left: 0px;">
                            Operating Systems
                        </button>
                    </a>
                </div>
                <div class="col-md-2"></div>
                <div class =" col-md-2">
                    <a href="<?php echo base_url().'admin/contact_us/manage_browser' ?>">
                        <button style="width:100%" id="button_create_browser_name" value="" class="btn button-custom pull-right " style="margin-left: 0px;">
                            Browsers
                        </button>
                    </a>
                </div>
            </div>
            <div class="row form-group">
                <div class ="col-md-2" style="padding-left: 25px;">
                    <a href="<?php echo base_url();?>admin/contact_us/member_feedback">
                        <button style="width:100%" id="button_create_topic_name" class="btn button-custom pull-left" >
                            Member Feedback
                        </button>
                    </a>
                </div>
                <div class =" col-md-2">
                    <a href="<?php echo base_url().'admin/contact_us/non_member_feedback' ?>">
                        <button style="width:100%" id="button_create_os_name" value="" class="btn button-custom " style="margin-left: 0px;">
                            Non Member Feedback
                        </button>
                    </a>
                </div>
            </div>
            <div class="btn-group" style="padding-left: 10px;">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
            </div>
        </div>        
    </div>
</div>
