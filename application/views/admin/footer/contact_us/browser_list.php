<script type="text/javascript">
    $(function() {
        $("#button_create_browser").on("click", function() {
            $('#modal_create_browser').modal('show');
        });
    });
</script>  
<script type="text/x-tmpl" id="tmpl_topic_list">
  
</script>
                            
<div class="panel panel-default">
    <div class="panel-heading">Browser List</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row form-group">
                <div class ="col-sm-3" style="padding-left: 35px;">
                    <button id="button_create_browser" value="" class="btn button-custom " style="margin-left: -10px;">
                        Create Browser
                    </button>  
                </div>
            </div>
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered" style="text-align: center;">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Id</th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Edit</th>               
                            </tr>
                        </thead>
                        <tbody id="tbody_topic_list">
                            <tr>
                                <td><div id="browser_desc_1">1</div></td>
                                <td><div id="browser_desc_1">Mozilla Firefox</div></td>
                                <td>
                                    <button id="button_edit_browser_list" onclick="openModal('button_edit_browser_list_1','<?php echo 1;?>')" value="" class="form-control btn pull-right">
                                        Edit
                                    </button>
                                </td>
                            </tr> 
                            <tr>
                                <td><div id="browser_desc_2">2</div></td>
                                <td><div id="browser_desc_2">Google Chromo</div></td>
                                <td>
                                    <button id="button_edit_browser_list" onclick="openModal('button_edit_browser_list_2','<?php echo 2;?>')" value="" class="form-control btn pull-right">
                                        Edit
                                    </button>
                                </td>
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
<?php $this->load->view("admin/footer/contact_us/modal_create_browser"); ?>
<?php $this->load->view("admin/footer/contact_us/modal_edit_browser"); ?>
