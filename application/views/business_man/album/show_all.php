<div class="row">
    <div class="col-md-5" style="padding: 0px;">
        <div class="row">
            <?php echo form_open(base_url()."business_album/", "class='col-md-2'");?>
            <button class="btn button-custom">My Photos</button>
            <?php echo form_close();?>
            <?php echo form_open(base_url()."business_album/show_albums", "class='col-md-2'");?>
            <button class="btn button-custom">Album</button>
            <?php echo form_close();?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-offset-8 col-md-4" style="padding-right: 0px; padding-left: 30px;">
                <?php echo form_open(base_url()."business_album/create_album");?>
                <button class="btn button-custom">Create Album</button>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>
<div class="row col-md-9">
    <ul class="row" style="padding-top: 15px;list-style-type: none;">
        <?php foreach ($albums as $album){?>
        <li class="col-md-3" style="padding-bottom: 25px;">
            <a href="<?php echo base_url().'business_album/show_album/'.$album->album_id ?>">
                <img src="<?php echo base_url()?>resources/uploads/albums/<?php echo $album->photo?>" class="img-responsive"/> 
            </a>
            <div style="font-size: 15px">
                <?php echo $album->title?>
            </div>
        </li>
        <?php }?>
    </ul>
</div>
