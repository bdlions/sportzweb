<script>
    $(function(){
        $("#button_share_service").on("click", function() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>' + "share/share_application",
                dataType: 'json',
                data: {
                    status_category_id: '<?php echo STATUS_CATEGORY_USER_NEWSFEED?>',                    
                    description: $("#text_share").val(),
                    shared_type_id: '<?php echo STATUS_SHARE_SERVICE_DIRECTORY?>',
                    reference_id: <?php echo $service_info['id']?>
                },
                success: function(data) {
                    window.location = '<?php echo base_url()?>';
                }
            });
        });
    });
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />

<div class="row">
    <div class="col-md-9 cus_service_detail_box">
        <div class="row">
            <div class="col-md-10">
                <?php if (!empty($service_info['title'])) { ?>
                <h3><?php echo $service_info['title']; ?></h3>
                <?php } ?>
            </div>
            <div class="col-md-2">
                <img onclick="javascript:history.back();" src="<?php echo base_url(); ?>resources/images/button-back-mapservice.png"/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?php if (!empty($service_info['address'])) { ?>
                <h4 class="cus_service_detail_heading">Store Address</h4>
                <!-- echo address here-->
                <?php echo $service_info['address']; ?>
                <?php } ?>
            </div>
            <div class="col-md-4">
                <?php if (!empty($service_info['opening_hours'])) { ?>
                <h4 class="cus_service_detail_heading">Opening hours</h4>
                <!-- echo text here-->
                <?php echo $service_info['opening_hours']; ?>
                <?php } ?>
            </div>
            <div class="col-md-4">
                <?php if (!empty($service_info['telephone'])) { ?>
                <h4 class="cus_service_detail_heading">Telephone</h4>
                <!-- echo text here-->
                <?php echo $service_info['telephone']; ?>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php if (!empty($service_info['website'])) { ?>
                <h4 class="cus_service_detail_heading">Website</h4>
                <!-- echo text here-->
                <a href="<?php echo $service_info['website']; ?>" target="_blank"><?php echo $service_info['website']; ?></a>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
                <?php if (!empty($service_info['business_name'])) { ?>
                <h4 class="cus_service_detail_heading">Sonuto profile</h4>
                <!-- echo text here-->
                <a href="#"><?php echo $service_info['business_name']; ?></a>
                <?php } ?>
            </div>
            <div class="col-md-2">
                <button class="btn sd_recommend_btn" data-toggle="modal" data-target="#modal_share_service">Recommend</button>
            </div>
        </div>
        <?php if (!empty($service_info['picture'])) { ?>
        <img src="<?php echo base_url() . SERVICE_IMAGE_PATH . $service_info['picture']; ?>" class="sd_business_profile_image"/>
        <?php } ?>

    </div>
</div>

<div class="row">
    <div class="col-md-9">
        <?php $this->load->view("applications/comments", $this->data); ?>
    </div>
    <div class="col-md-3"></div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_share_service" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" id="myModalLabel">Share This Service</h3>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col-md-6">
                        <img
                            src="<?php echo base_url() . SERVICE_IMAGE_PATH .$service_info['picture']; ?>"
                            class="img-responsive"
                            alt="<?php echo $service_info['title']; ?>"
                            />
                    </div>    
                    <div class="col-md-6">
                        <h4><?php echo $service_info['title']; ?></h4>
                    </div>
                </div>
                <textarea id="text_share" name="text_share" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="button_share_service">
                    <b>Share</b>
                </button>
            </div>
        </div>
    </div>
</div>
