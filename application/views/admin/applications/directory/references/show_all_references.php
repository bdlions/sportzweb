<div class="panel panel-default">
    <div class="panel-heading">Application References</div>
    <div class="panel-body">
        <div class="row col-md-12">            
            <div class="row form-group">
                <div class ="col-md-2">
                    <a href="<?php echo base_url();?>admin/applications_directory/create_app_item_reference">
                        <button id="button_manage_recipe_for_home_page" value="" class="btn button-custom ">
                           Create Reference
                        </button>
                    </a>
                </div>
            </div>
            <div class="row form-group">
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered" style="text-align: center;">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Url</th>
                                <th style="text-align: center;">Edit</th>
                                <th style="text-align: center;">Delete</th> 
                            </tr>
                             <?php foreach($app_item_reference_list as $app_reference){?>
                            <tr>
                                <td><?php echo $app_reference['title']; ?></td>
                                <td><?php echo html_entity_decode(html_entity_decode($app_reference['link'])); ?></td>
                                <td><a href="<?php echo base_url().'admin/applications_directory/update_app_item_reference/'.$app_reference['reference_id'];?>">Edit</a></td>
                                <td>
                                    <button onclick="open_modal_delete_reference_confirm('<?php echo $app_reference['reference_id'];?>')" value="" class="form-control btn pull-right">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                             <?php }?>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="row col-md-12">
                <div class="col-md-2 btn-group">
                    <input type="button" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
                </div>
            </div>
        </div>        
    </div>
    </div>
</div> 
<?php $this->load->view("admin/applications/directory/references/modal_delete_reference");
