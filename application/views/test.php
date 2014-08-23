<div class="col-md-6">
    <?php echo 'echo error: ';?>
    <?php echo $error;?>
    <?php var_dump($error);?>

    <?php echo form_open_multipart('test/upload_crop');?>

        <input type="file" name="userfile" size="20" />
        <br /><br />
        <input type="submit" value="upload" />

    <?php echo form_close();?>
</div>