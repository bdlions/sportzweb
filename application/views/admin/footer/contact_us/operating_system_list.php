<script type="text/javascript">
    $(function() {
        $("#button_create_os").on("click", function() {
            $('#modal_create_os').modal('show');
        });
    });
</script>  
<script type="text/x-tmpl" id="tmpl_os_list">
  
</script>
                            
<div class="panel panel-default">
    <div class="panel-heading">Operating System List</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row form-group">
                <div class ="col-sm-3" style="padding-left: 35px;">
                    <?php if($allow_write){ ?>
                    <button id="button_create_os" value="" class="btn button-custom " style="margin-left: -10px;">
                        Create Operating System
                    </button> 
                    <?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered" style="text-align: center;">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Id</th>
                                <th style="text-align: center;">Name</th>
                                <?php if($allow_edit){ ?><th style="text-align: center;">Edit</th><?php } ?>               
                                <?php if($allow_delete){ ?><th style="text-align: center;">Delete</th><?php } ?>             
                            </tr>
                        </thead>
                        <tbody id="tbody_os_list">
                            <?php foreach ($all_os as $os):?>
                            <tr>
                                <td><div><?php echo $os['id'];?></div></td>
                                <td><div><?php echo $os['title'];?></div></td>
                                <?php if($allow_edit){ ?>
                                <td>
                                    <button onclick="showmodal(<?php echo $os['id'];?>)" value="" class="form-control btn pull-right">
                                        Edit
                                    </button>
                                </td>
                                <?php } ?>
                                <?php if($allow_delete){ ?>
                                <td>
                                    <button onclick="showmodaldel(<?php echo $os['id'];?>)" value="" class="form-control btn pull-right">
                                        Delete
                                    </button>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php endforeach;?>                  
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
<?php $this->load->view("admin/footer/contact_us/modal_create_os"); ?>
<?php $this->load->view("admin/footer/contact_us/modal_edit_os"); ?>
