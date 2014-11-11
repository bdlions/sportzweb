<div class="panel panel-default">
    <div class="panel-heading">Shop</div>
    <div class="panel-body">
        <div class="row col-md-12">            
            <div class="row form-group" style="padding-left: 10px;">
                <?php if($allow_write){ ?>
                <div class ="col-md-2 pull-left">
                    <button onclick="open_modal_product_category_create()" value="" class="form-control btn button-custom">Create Product Category</button>
                </div>
                <?php } ?>
                <div class ="col-md-2 pull-left">
                    <a href="<?php echo base_url()."admin/applications_shop/manage_colors"; ?>">
                        <button class="form-control btn button-custom pull-right">Product Color</button>  
                    </a>
                </div>
                <div class ="col-md-2 pull-left">
                    <a href="<?php echo base_url()."admin/applications_shop/manage_feature"; ?>">
                        <button class="form-control btn button-custom pull-right">Product Features</button>  
                    </a>
                </div>
                <div class ="col-md-2 pull-left">
                    <a href="<?php echo base_url()."admin/applications_shop/manage_inform"; ?>">
                        <button class="form-control btn button-custom pull-right">Product Informations</button>  
                    </a>
                </div>
            </div>
            <div class="row form-group" style="padding-left: 10px; margin-top: 8px">
                <div class ="col-md-2 pull-left">
                    <a href="<?php echo base_url()."admin/applications_shop/manage_size_men"; ?>">
                        <button class="form-control btn button-custom pull-right">Sizing: MEN</button>  
                    </a>
                </div>
                <div class ="col-md-2 pull-left">
                    <a href="<?php echo base_url()."admin/applications_shop/manage_size_women"; ?>">
                        <button class="form-control btn button-custom pull-right">Sizing: WEMEN</button>  
                    </a>
                </div>
                <div class ="col-md-2 pull-left">
                    <a href="<?php echo base_url()."admin/applications_shop/manage_size_tinytoms"; ?>">
                        <button class="form-control btn button-custom pull-right">Sizing: TINY TOMS</button>  
                    </a>
                </div>
                <div class ="col-md-2 pull-left">
                    <a href="<?php echo base_url()."admin/applications_shop/manage_size_youth"; ?>">
                        <button class="form-control btn button-custom pull-right">Sizing: YOUTH</button>  
                    </a>
                </div>
            </div>
            
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <?php if($allow_edit){ ?>
                                <th style="text-align: center">Edit</th>
                                <?php } ?>
                                <?php if($allow_delete){ ?>
                                <th style="text-align: center">Delete</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="tbody_product_category_list">                
                            <?php foreach($product_category_list as $product_category){?>
                            <tr>
                                <td><?php echo $product_category['category_id']?></a></td>
                                <td><?php echo $product_category['title']?></td>
                                <?php if($allow_edit){ ?>
                                <td>
                                    <button onclick="open_modal_product_category_update(<?php echo $product_category['category_id']?>)" value="" class="form-control btn">
                                        Edit
                                    </button> 
                                </td>
                                <?php } ?>
                                <?php if($allow_delete){ ?>
                                <td>
                                    <button onclick="open_modal_category_delete_confirm(<?php echo $product_category['category_id']?>)" value="" class="form-control btn">
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
$this->load->view("admin/applications/shop/modal/product_category_create");
$this->load->view("admin/applications/shop/modal/product_category_delete_confirm");
$this->load->view("admin/applications/shop/modal/product_category_update");
?>
