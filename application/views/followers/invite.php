<div class="col-md-2 column">
    <?php $this->load->view("templates/sections/member_profile_left_pane"); ?>
</div>
<div class="col-md-9">
    <?php if($my_user_id == $user_id){?>
        <?php $this->load->view("followers/template/section/member_header"); ?>
    <?php } ?>
    <?php echo form_open("followers/invite"); ?>
    <?php for($i = 1; $i <= 5; $i ++){?>
    <div class="row form-group <?php echo $emailList['email'.$i]['status'] ?>">
        <div class="col-md-6">
            <input type="text" class="form-control col-md-6" value="<?php echo $emailList['email'.$i]['email']?>" name="email<?php echo $i?>" placeholder="Enter email address"/>
        </div>
        <label class="col-md-4 control-label"  style="font-weight: normal;"><?php echo $emailList['email'.$i]['message'] ?></label>
    </div>
     <?php }?>
    <div class="row form-group">
        <div class="col-md-6">
            <button class="btn button-custom pull-right">Invite</button>
        </div>
    </div>
   
    <?php echo form_close(); ?>
</div>