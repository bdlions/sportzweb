<div class="panel panel-default">
    <div class="panel-heading">Workout</div>
    <div class="panel-body">
        <?php if ($allow_write) { ?>
        <div class="row form-group">
            <div class ="col-md-3 pull-left">
                <button onclick="open_modal_create()" class="form-control btn button-custom">Create Workouts</button>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th style="text-align: center">Id</th>
                            <th style="text-align: center">Title</th>
                            <th style="text-align: center">Edit</th>
                            <th style="text-align: center">Delete</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_product_category_list">
                        <?php foreach($data_list as $data_each):?>
                        <tr>
                            <td style="text-align: center"><?php echo $data_each['id'];?></td>
                            <td style="text-align: center"><?php echo $data_each['title'];?></td>
                             <?php if($allow_edit){ ?>
                            <td style="text-align: center">
                                <button onclick="open_modal_update(<?php echo $data_each['id']?>)" value="" class="form-control btn">
                                    Edit
                                </button> 
                            </td>
                            <?php } ?>
                            <?php if($allow_delete){ ?>
                            <td style="text-align: center">
                                <button onclick="open_modal_delete_confirm(<?php echo $data_each['id']?>)" value="" class="form-control btn">
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
        <div class="btn-group" style="padding-left: 10px;">
            <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
        </div>
    </div>
</div>
<?php 
$this->load->view("admin/applications/gympro/modal/workouts_create");
$this->load->view("admin/applications/gympro/modal/workouts_edit");
$this->load->view("admin/applications/gympro/modal/workouts_delete_confirm");
?>
