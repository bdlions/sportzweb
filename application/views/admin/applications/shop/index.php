<div class="panel panel-default">
    <div class="panel-heading">Shop</div>
    <div class="panel-body">
        <div class="row col-md-12">            
            <div class="row form-group" style="padding-left: 10px;">
                <?php if($allow_write){ ?>
                <div class ="col-md-2 pull-left">
                    <button onclick="" value="" class="form-control btn button-custom pull-right">Create Product Category</button>  
                </div>
                <?php } ?>
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
                        <tbody id="tbody_sports_list">                
                            <?php foreach($product_category_list as $product_category){?>
                            <tr>
                                <td><?php echo $sports['sports_id']?></a></td>
                                <td><?php echo $sports['title']?></td>
                                <?php if($allow_edit){ ?>
                                <td>
                                    <button onclick="" value="" class="form-control btn pull-right">
                                        Edit
                                    </button> 
                                </td>
                                <?php } ?>
                                <?php if($allow_delete){ ?>
                                <td>
                                    <button onclick="" value="" class="form-control btn pull-right">
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