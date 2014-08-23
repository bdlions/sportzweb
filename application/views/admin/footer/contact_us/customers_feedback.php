<script type="text/javascript">
</script>  
<script type="text/x-tmpl" id="tmpl_topic_list">
  
</script>
                            
<div class="panel panel-default">
    <div class="panel-heading">Customer Feedback</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row form-group">
                    <div class ="col-sm-4" style="padding-left: 25px;">
                        <a href="<?php echo base_url();?>admin/contact_us/create_topic">
                            <button id="button_create_topic_name" class="btn button-custom pull-left" >
                                Create Topic
                            </button>
                        </a>
                    </div>
                    <div class =" col-sm-4">
                        <a href="<?php echo base_url().'admin/contact_us/create_os' ?>">
                            <button id="button_create_os_name" value="" class="btn button-custom " style="margin-left: 0px;">
                                Create Operating System name
                            </button>
                        </a>
                    </div>
                    <div class =" col-sm-4">
                        <a href="<?php echo base_url().'admin/contact_us/create_browser' ?>">
                            <button id="button_create_browser_name" value="" class="btn button-custom pull-right " style="margin-left: 0px;">
                                Create Browser name
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
                                <th style="text-align: center;">Customer Email</th>
                                <th style="text-align: center;">Phone</th>
                                <th style="text-align: center;">Feedback</th>
                                <th style="text-align: center;">Reply</th>
                                <th style="text-align: center;">Edit</th>
                                <th style="text-align: center;">Delete</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_feedback_list">
                            <tr>
                                <td><div>Photo Upload</div></td>
                                <td><div>Windows 7</div></td>
                                <td><div>Google Chromo</div></td>
                                <td><div>Omar@yahoo.com</div></td>
                                <td><div>0175879658</div></td>
                                <td><div id="browser_desc_1">This is problem</div></td>
                                <td>
                                    <button id="button_edit_browser_list" onclick="openModal('button_edit_browser_list_1','<?php echo 1;?>')" value="" class="form-control btn pull-right">
                                        Reply
                                    </button>
                                </td>
                                <td>Edit</td>
                                <td>Delete</td>
                            </tr> 
                            <tr>
                                <td><div>Status update</div></td>
                                <td><div>Windows 8</div></td>
                                <td><div>Opera 10</div></td>
                                <td><div>Omarfaruk.sust@gmail.com</div></td>
                                <td><div>01670800187</div></td>
                                <td><div id="browser_desc_2">This is problem 4</div></td>
                                <td>
                                    <button id="button_edit_browser_list" onclick="openModal('button_edit_browser_list_2','<?php echo 2;?>')" value="" class="form-control btn pull-right">
                                        Reply
                                    </button>
                                </td>
                                <td>Edit</td>
                                <td>Delete</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="btn-group" style="padding-left: 10px;">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="goBackByURL('<?php echo base_url();?>admin/overview')" class="form-control btn button-custom">
            </div>
        </div>        
    </div>
</div>
