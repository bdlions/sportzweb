<div class="col-md-4">
    <?php echo form_open("follower/invite"); ?>
    <div class="form-group">
        <input type="text" class="form-control" name="email1" placeholder="Enter email address"/>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="email2" placeholder="Enter email address"/>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="email3" placeholder="Enter email address"/>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="email4" placeholder="Enter email address"/>
    </div>
    <div class="form-group  has-success">
        <input type="text" class="form-control" name="email5" placeholder="Enter email address"/>
    </div>
    <div class="form-group">
        <button class="btn button-custom pull-right">Invite</button>
    </div>
    <?php echo form_close(); ?>
</div>