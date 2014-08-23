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
            <?php if($allow_access){ ?>
            <div class="row form-group">
                <div class ="col-sm-10"></div>
                <div class ="col-sm-2">
                    <a href="<?php echo base_url()."admin/applications_servicedirectory/create_service/".$service_category_id ?>" >
                        <button id="" value="" class="btn button-custom" style="margin-left: -10px;">
                        Create Service 
                        </button>
                    </a> 
                </div>
            </div>
            <?php } ?>
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
                                <?php if($allow_access){ ?>
                                <th>Edit</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="tbody_recipe_list">
                            <?php foreach ($services_list as $service): ?>
                                <tr>
                                <td><?php echo $service['category_description']; ?></td>
                                <td><?php echo $service['title']; ?></td>
                                <td><a href="<?php echo base_url().'admin/applications_servicedirectory/service_show/'.$service['id']?>">view</a></td>
                                <td><a href="<?php echo base_url().'admin/applications_servicedirectory/service_comments/'.$service['id']?>">comments</a></td>
                                <td><a href="<?php echo base_url().'admin/applications_servicedirectory/service_pictures/'.$service['id']?>">pictures</a></td>
                                <?php if($allow_access){ ?>
                                <td><a href="<?php echo base_url().'admin/applications_servicedirectory/service_edit/'.$service['id']?>">Edit</a></td>
                                <?php } ?>
                               </tr>
                            <?php endforeach; ?>                       
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="btn-group" style="padding-left: 10px;">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
        </div>
    </div>
</div>
