<script type="text/javascript">
    $(function() {
        $("#button_create_service_category").on("click", function() {
            $('#modal_create_service_category').modal('show');
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_service_category_list">
    {% var i=0, service_category_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(service_category_info){ %}
    <tr>
        <td><a href="<?php echo base_url()."admin/applications_servicedirectory/service_category/{%= service_category_info.id%}"; ?>">{%= service_category_info.id%}</td>
        <td><div id="service_desc_{%= service_category_info.id%}">{%= service_category_info.description%}</div></td>
        <td><button id="button_edit_service_category_{%= service_category_info.id%}" onclick="openModal('button_edit_service_category_{%= service_category_info.id%}','{%= service_category_info.id%}')" value="" class="form-control btn pull-right">Edit</button></td>
    </tr>
    {% service_category_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<div class="panel panel-default">
    <div class="panel-heading">Service Directory</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <?php if($allow_access){ ?>
            <div class="row form-group">
                <div class ="col-sm-3" style="padding-right: 0px;">
                    <a href="<?php echo base_url();?>admin/applications_servicedirectory/create_service_category"><button id="button_create_service_category" value="" class="form-control btn button-custom pull-right">Create Service Category</button></a>
                </div>
                <div class ="col-sm-2 pull-right" style="padding-right: 0px;">
                    <a href="<?php echo base_url();?>admin/applications_servicedirectory/page_import_service">
                        <button class="form-control btn button-custom">Import services</button>
                    </a>
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered" style="text-align: center;">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Id</th>
                                <th style="text-align: center;">Name</th>
                                <?php if($allow_access){ ?>
                                <th style="text-align: center;">Edit</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="tbody_service_category_list">
                            <?php foreach($service_category_list as $service_category):?>
                            <tr>
                                <td><a href="<?php echo base_url().'admin/applications_servicedirectory/service_category/'.$service_category['id']?>"><?php echo $service_category['id']; ?></a></td>
                                <td><div id="service_desc_<?php echo $service_category['id'];?>"><?php echo $service_category['description']?></div></td>
                                <?php if($allow_access){ ?>
                                <td>
                                    <a href="<?php echo base_url();?>admin/applications_servicedirectory/edit_service_category/<?php echo $service_category['id'];?>">
                                        Edit
                                    </a>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php endforeach; ?>
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
<!-- for add and edit service category with modal -->
<?php //$this->load->view("admin/applications/service_directory/modal_create_service_category"); ?>
<?php //$this->load->view("admin/applications/service_directory/modal_edit_service_category"); ?>
