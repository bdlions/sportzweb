<script type="text/javascript">
    $(function() {
        $("#button_create_service").on("click", function() {
            $('#modal_create_service').modal('show');
        });
    });
</script>
                            
<div class="panel panel-default">
    <div class="panel-heading">Service List</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row form-group">
                <div class ="col-sm-10"></div>
                <!--<div class ="col-sm-2">
                    <button id="button_create_recipe" value="" class="form-control btn button-custom pull-right">Create Recipe</button>  
                </div>-->
                <div class ="col-sm-2">
                    <a href="<?php echo base_url()."admin/servicedirectory/create_service/".$service_category_id ?>" >
                        <button id="" value="" class="btn button-custom" style="margin-left: -10px;">
                        Create Service 
                        </button>
                    </a> 
                </div>
            </div>
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Service Category</th>
                                <th>Service Title</th>
                                <th>View</th>
                                <th>Comments</th>
                                <th>Pictures</th>                                
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_recipe_list">
                            <?php foreach ($services_list as $service): ?>
                                <tr>
                                <td><?php echo $service['category_description']; ?></td>
                                <td><?php echo $service['title']; ?></td>
                                <td><a href="<?php echo base_url().'admin/servicedirectory/service_show/'.$service['id']?>">view</a></td>
                                <td><a href="<?php echo base_url().'admin/servicedirectory/service_comments/'.$service['id']?>">comments</a></td>
                                <td><a href="<?php echo base_url().'admin/servicedirectory/service_pictures/'.$service['id']?>">pictures</a></td>
                                <td><a href="<?php echo base_url().'admin/servicedirectory/service_edit/'.$service['id']?>">Edit</a></td>
                               </tr>
                            <?php endforeach; ?>                       
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="btn-group" style="padding-left: 10px;">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="goBackByURL('<?php echo base_url();?>admin/servicedirectory')" class="form-control btn button-custom">
        </div>
    </div>
</div>
