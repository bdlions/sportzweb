<div class="panel panel-default">
    <div class="panel-heading">Product Feature</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row form-group" style="padding-left: 10px;">
                <?php if($allow_write){ ?>
                <div class ="col-md-2 pull-left">
                    <a href="<?php echo base_url()?>admin/applications_shop/create_feature"><button onclick="" value="" class="form-control btn button-custom">Create Product Feature</button></a>
                </div>
                <?php } ?>
            </div>
            
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Feature Title</th>
                                <?php if($allow_edit){ ?>
                                <th style="text-align: center">Edit</th>
                                <?php } ?>
                                <?php if($allow_delete){ ?>
                                <th style="text-align: center">Delete</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>                
                            <?php foreach($product_feature_list as $feature_data){?>
                            <tr>
                                <td><?php echo $feature_data['id']?></a></td>
                                <td><?php echo $feature_data['title']?></td>
                                <?php if($allow_edit){ ?>
                                <td>
                                    <button onclick="location.href='<?php echo base_url()?>admin/applications_shop/update_feature/<?php echo $feature_data["id"]?>'" class="form-control btn">
                                        Edit
                                    </button> 
                                </td>
                                <?php } ?>
                                <?php if($allow_delete){ ?>
                                <td>
                                    <button onclick="open_modal_feature_delete_confirm(<?php echo $feature_data['id']?>)" class="form-control btn">
                                        Delete
                                    </button>
                                </td>
                                <?php } ?>
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
<?php 
$this->load->view("admin/applications/shop/modal/product_feature_delete_confirm");
?>
