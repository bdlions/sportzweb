<div class="panel panel-default">
    <div class="panel-heading">Exercise Categories</div>
    <div class="panel-body">
        <div class ="row">
            <div class="col-md-4"></div>
            <div class="col-md-8"><?php echo $message; ?></div>
        </div>
        <div class="row form-group" style="padding-left: 10px;">
                <div class ="col-md-3 pull-right">
                    <a href="<?php echo base_url()."admin/applications_gympro/create_exercise_category";?>">
                        <button value="" class="form-control btn button-custom pull-right">Create Exercise Category</button>  
                    </a>
                </div>
            </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th style="text-align: center">Id</th>
                            <th style="text-align: center">Title</th>
                            <th style="text-align: center">Type</th>
                            <th style="text-align: center">Edit</th>
                            <th style="text-align: center">Delete</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_product_category_list">
                        <?php foreach($exercise_category_list as $exercise_category_info):?>
                        <tr>
                            
                            <td style="text-align: center">
                                <a href="<?php echo base_url().'admin/applications_gympro/manage_exercise_subcategories/'.$exercise_category_info['exercise_category_id']?>">
                                <?php echo $exercise_category_info['exercise_category_id'];?>
                                </a>                                
                            </td>                                                       
                            <td style="text-align: center"><?php echo $exercise_category_info['title'];?></td> 
                            <td style="text-align: center"><?php echo $exercise_category_info['exercise_type'];?></td> 
                            <td style="text-align: center">
                                <a href="<?php echo base_url().'admin/applications_gympro/update_exercise_category/'.$exercise_category_info['exercise_category_id']?>">
                                Edit
                                </a>                                
                            </td> 
                            <td>
                                <button onclick="open_modal_exercise_category_delete_confirm('<?php echo $exercise_category_info['exercise_category_id']; ?>')" value="" class="form-control btn pull-right">
                                    Delete
                                </button>
                            </td>
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
$this->load->view("admin/applications/gympro/modal/exercise_category_delete_confirm");