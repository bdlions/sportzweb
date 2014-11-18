<div class="panel panel-default">
    <div class="panel-heading">Manage height unit types</div>
    <div class="panel-body">
        <?php if ($allow_write) { ?>
        <div class="row form-group">
            <div class ="col-md-3 pull-left">
                <button onclick="open_modal_create()" class="form-control btn button-custom">Create height unit types</button>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th style="text-align: center">ID</th>
                            <th style="text-align: center">TITLE</th>
                            <th style="text-align: center">EDIT</th>
                            <th style="text-align: center">DELETE</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_product_category_list">
                        <?php foreach($height_unit_types_list as $type_info):?>
                        <tr>
                            <td style="text-align: center"><?php echo $type_info['id'];?></td>
                            <td style="text-align: center"><?php echo $type_info['title'];?></td>
                            <?php if($allow_edit){ ?>
                                <td style="text-align: center">
                                    <button onclick="open_modal_update(<?php echo $type_info['id']?>)" value="" class="form-control btn">
                                        Edit
                                    </button> 
                                </td>
                                <?php } ?>
                            <?php if($allow_delete){ ?>
                            <td style="text-align: center">
                                <button onclick="open_modal_delete_confirm(<?php echo $type_info['id']?>)" value="" class="form-control btn">
                                    Delete
                                </button>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php endforeach?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php 
$this->load->view("admin/applications/gympro/modal/height_unit_types_create");
$this->load->view("admin/applications/gympro/modal/height_unit_types_edit");
$this->load->view("admin/applications/gympro/modal/height_unit_types_delete_confirm");
?>
