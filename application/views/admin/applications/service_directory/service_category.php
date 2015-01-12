<script type="text/javascript">
    $(function () {
        $("#button_create_service_category").on("click", function () {
            $('#modal_create_service_category').modal('show');
        });
    });    
    
</script>
<script type="text/x-tmpl" id="tmpl_service_category_list">
    {% var i=0, service_category_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(service_category_info){ %}
    <tr>
    <td><a href="<?php echo base_url() . "admin/applications_servicedirectory/service_category/{%= service_category_info.id%}"; ?>">{%= service_category_info.id%}</td>
    <td><div id="service_desc_{%= service_category_info.id%}">{%= service_category_info.description%}</div></td>
    <td><button id="button_edit_service_category_{%= service_category_info.id%}" onclick="openModal('button_edit_service_category_{%= service_category_info.id%}','{%= service_category_info.id%}')" value="" class="form-control btn pull-right">Edit</button></td>
    </tr>
    {% service_category_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<div class="panel panel-default">
    <div class="panel-heading">Service Directory</div>
    <div class="panel-body">
        <div class="row form-group">
            <?php if ($allow_write) { ?>
                <div class ="col-xs-3" style="padding-right: 0px;">
                    <a href="<?php echo base_url(); ?>admin/applications_servicedirectory/create_service_category"><button id="button_create_service_category" value="" class="form-control btn button-custom pull-right">Create Service Category</button></a>
                </div>
                <div class ="col-xs-4" style="padding-right: 0px;">
                    <a href="<?php echo base_url(); ?>admin/applications_servicedirectory/auto_retrive_and_store_latlong"><button id="button_create_service_category" value="" class="form-control btn button-custom pull-right">Auto retrive and store Latitude Longitude</button></a>
                </div>
            <?php } ?>
            <?php if ($allow_writing) { ?>
                <div class ="col-xs-2 pull-right">
                    <a href="<?php echo base_url(); ?>admin/applications_servicedirectory/page_import_service">
                        <button class="form-control btn button-custom">Import services</button>
                    </a>
                </div>
            <?php } ?>
        </div>            
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered" style="text-align: center;">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Id</th>
                                <th style="text-align: center;">Name</th>
                                <?php if ($allow_edit) { ?>
                                    <th style="text-align: center;">Edit</th>
                                <?php } ?>
                                <?php if ($allow_delete) { ?>
                                    <th style="text-align: center;">Delete</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="tbody_service_category_list">
                            <?php foreach ($service_category_list as $service_category): ?>
                                <tr>
                                    <td><a href="<?php echo base_url() . 'admin/applications_servicedirectory/service_category/' . $service_category['id'] ?>"><?php echo $service_category['id']; ?></a></td>
                                    <td><div id="service_desc_<?php echo $service_category['id']; ?>"><?php echo $service_category['description'] ?></div></td>
                                    <?php if ($allow_edit) { ?>
                                        <td>
                                            <a href="<?php echo base_url(); ?>admin/applications_servicedirectory/edit_service_category/<?php echo $service_category['id']; ?>">
                                                Edit
                                            </a>
                                        </td>
                                    <?php } ?>
                                    <?php if ($allow_delete) { ?>
                                        <td>
                                            <a role="button" tabindex="0" onclick="confirmation_delete(<?php echo $service_category['id']; ?>)" >Delete</a>
                                        </td>
                                    <?php } ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div></div>
        <div style="width: 100%">
            <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
        </div>


    </div>
</div>
<!-- for add and edit service category with modal -->
<?php //$this->load->view("admin/applications/service_directory/modal_create_service_category"); ?>
<?php //$this->load->view("admin/applications/service_directory/modal_edit_service_category"); ?>


<div class="modal fade" id="confirmModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Confirm Delete...</h4>
            </div>
            <div class="modal-body">
                <h3>Are you sure you want to delete this service category?</h3>
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
        $("#service_id").val(service_id);
        $("#confirmModal").modal("show");
    }
    function delete_service()
    {
        var service_id = $("#service_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>' + "admin/applications_servicedirectory/delete_service_catagory",
            dataType: 'json',
            data: {
                service_id: service_id
            },
            success: function (data) {
                //alert(service_id);
                location.reload();
            }
        });
    }
</script>