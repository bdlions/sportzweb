<div class="row">
    <div class="col-md-5" style="padding: 0px;">
        <?php $this->load->view('member/album/photo_header');?>
    </div>
    <?php if($user_id == $current_user_id){ ?>
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-offset-8 col-md-4">
                <?php echo form_open(base_url()."user_album/create_album");?>
                <button class="btn button-custom">Create Album</button>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<div class="row">
    <div class="col-md-9 row">
        <ul class="list-unstyled row" style="padding-top: 15px;">
            <?php foreach ($albums as $album){?>
            <li class="col-md-3" style="padding-bottom: 10px">
                <a href="<?php echo base_url().'user_album/show_album/'.$album['album_id'] ?>">
                    <img style="height:100px" src="<?php echo base_url().ALBUM_IMAGE_PATH.$album['img']?>" class="img-responsive"/> 
                </a>
                <div style="font-size: 15px">
                    <?php echo $album['title']?>
                </div>
            </li>
            <?php }?>
        </ul>
    </div>
</div>
