<div class="panel panel-default">
    <div class="panel-heading">Pictures</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row">
                <div class="col-md-9">
                    <ul class="list-inline list-unstyled row files" id="files">
                        <li class="col-md-3" style="padding-bottom: 10px">
                            <img  src="<?php echo base_url() . SERVICE_IMAGE_PATH . $service_info['picture']; ?>" class="img-responsive" style="min-height: 208px; min-width: 208px;" />
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="btn-group" style="padding-left: 10px;">
            <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
        </div>
    </div>
</div>
