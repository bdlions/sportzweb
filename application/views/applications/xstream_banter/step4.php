<div class="row col-md-9 column selected-match">
    <div class="row col-md-4">
        <a href="<?php echo base_url().'applications/xstream_banter'; ?>" >
            <img class="img-responsive" src="<?php echo base_url() ?>resources/images/xb_logo.png" />
        </a>        
    </div>
    <div class="row col-md-12">
        <h4>Create a private chat room or join your friends</h4>
        <h3><?php echo $match_info['tournament_title'];?> <?php echo $match_date;?></h3>
        <div><h2><?php echo $match_info['team1_title']?> v <?php echo $match_info['team2_title']?></h2></div>    
    </div>
    <div class="kick-off">Kick off (<?php echo $match_info['time']?>)</div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-3">
            <?php echo form_open('applications/xstream_banter/step5/'.$match_info['id'], array('id' => 'form_create_a_group', 'class' => 'form-horizontal')); ?>
            <input id="button_create_group" name="button_create_group" type="submit" value="Create chat room" class="form-control btn-xstream-banter"/>
            <?php echo form_close(); ?>
        </div>  
        <div class="col-md-3"></div>
        <div class="col-md-3">
            <?php echo form_open('applications/xstream_banter/step6/'.$match_info['id'], array('id' => 'form_join_a_group', 'class' => 'form-horizontal')); ?>
            <input id="button_join_group" name="button_join_group" type="submit" value="Join chat room" class="form-control btn-xstream-banter"/>
            <?php echo form_close(); ?>
        </div>        
    </div>
</div>
<div class="col-md-3 column">
    
</div>