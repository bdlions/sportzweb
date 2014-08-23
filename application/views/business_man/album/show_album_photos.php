<div class="row">
    <div class="col-md-9">
        <ul class="row" style="padding-top: 15px;list-style-type: none;">
            <?php foreach ($photos as $photo_data){?>
            <li class="col-md-3">
                <img src="<?php echo base_url() ?>resources/uploads/albums/<?php echo $photo_data->photo ?>" class="img-responsive"/> 
                <div>
                    <?php echo $photo_data->description?>
                </div>
            </li>
            <?php }?>
        </ul>
    </div>
</div>