<div class="row">
    <div style=" padding-left: 14px;">
        <?php echo form_open(base_url() . "user_album/photos/" . $user_id, "class='col-md-2'"); ?>
        <?php if ($user_id == $current_user_id) { ?>
            <button class="btn button-custom">My Photos</button>
        <?php } else { ?>
            <button class="btn button-custom">Photos</button>
        <?php } ?>
        <?php echo form_close(); ?>
        <?php echo form_open(base_url() . "user_album/albums/" . $user_id, "class='col-md-2'"); ?>
        <div style=" padding-left: 6px;">
            <button class="btn button-custom">Albums</button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>