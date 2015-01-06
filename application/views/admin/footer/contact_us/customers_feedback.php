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
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered" style="text-align: center;">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Topic</th>
                                <th style="text-align: center;">Operating System</th>
                                <th style="text-align: center;">Browser</th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Customer Email</th>
                                <th style="text-align: center;">Phone</th>
                                <th style="text-align: center;">Feedback</th>
                                <th style="text-align: center;">Time</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_feedback_list">
                            <?php foreach($feedback_list as $feedback){?>
                            <tr>
                                <td><?php echo $feedback['topic']?></td>
                                <td><?php echo $feedback['operating_system']?></td>
                                <td><?php echo $feedback['browser']?></td>
                                <td><?php echo $feedback['name']?></td>
                                <td><?php echo $feedback['email']?></td>
                                <td><?php echo $feedback['phone']?></td>
                                <td><?php echo $feedback['description']?></td>
                                <td><?php echo $feedback['created_on']?></td>                
                            </tr> 
                            <?php } ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="btn-group" style="padding-left: 10px;">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
            </div>
        </div>        
    </div>
</div>
