<div class="panel panel-default">
    <div class="panel-heading">Service List</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <?php if($allow_configuration){ ?>
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
                                <?php if($allow_configuration){ ?>
                                <th>Edit</th>
                                <th>Delete</th>
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
                                <?php if($allow_configuration){ ?>
                                <td><a href="<?php echo base_url().'admin/applications_servicedirectory/service_edit/'.$service['id']?>">Edit</a></td>
                                <td><a role="button" tabindex="0" onclick="confirmation_delete(<?php echo $service['id'];?>)" >Delete</a></td>
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

<div class="modal fade" id="confirmModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Confirm Delete...</h4>
            </div>
            <div class="modal-body">
                <h3>Are you sure you want to delete this service?</h3>
            </div>
            <div class="modal-footer">
                <button onclick="delete_service()" type="button" class="btn btn-primary">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <input id="service_id" name="service_id" type="hidden" value="">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    function confirmation_delete(service_id)
    {
        var link = document.getElementById("idstore");
//        link.setAttribute("value", id);
        $("#service_id").val(service_id);
        $("#confirmModal").modal("show");
    }
    function delete_service()
    {
        var service_id = $("#service_id").val();
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>' + "admin/applications_servicedirectory/delete_service",
                dataType: 'json',
                data: {
                    service_id: service_id
                },
                success: function(data) {
                    //alert(service_id);
                    location.reload();
                }
            });
    }
</script>
<!--<script>
    function confirmation_delete(cata, id)
    {
        var addr = "<?php echo base_url().'admin/applications_servicedirectory/service_delete/'?>" + id;
        var link = document.getElementById("delbtn");
        link.setAttribute("href", addr);
        $("#confirmModal").modal("show");
    
    
        $.ajax({
                    url: <?php echo base_url().'admin/applications_servicedirectory/service_delete/'?>+id,
                    success: function(data) {
                        location.reload();
                    }
                }
            );
    }
</script>-->