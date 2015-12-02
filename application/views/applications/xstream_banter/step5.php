<div class="row col-md-9 column create-chat-room">
    <div class="row col-md-4">
        <a href="<?php echo base_url().'applications/xstream_banter'; ?>" >
            <img class="img-responsive" src="<?php echo base_url() ?>resources/images/xb_logo.png" />
        </a>        
    </div>
    <div class="row blank-row"></div>
    <div class="row col-md-12">
        <h3>Create your group and invite your friends to join your private chat room</h3>
    </div>
    <div class="row blank-row"></div>
    <div class="row col-md-12"><h4>Group Access Code:</h4><h2><?php echo $group_access_code?></h2></div>
    <div class="row blank-row"></div>
    <div class="row blank-row"></div>
    <div class="row col-md-12 form-horizontal">    
        <?php echo form_open("applications/xstream_banter/step5/".$match_info['id'], array('id' => 'form_select_sports', 'class' => 'form-horizontal')); ?>
        <div class="row col-md-12">
            <div class="form-group">
                <div class ="col-md-6">
                    <?php echo form_dropdown('team_list', $team_list, '', 'class="form-control create-chat-room-form-control" id="team_list"'); ?>
                </div> 
            </div>
            <div class="row blank-row"></div>
            <div class="form-group">
                <div class ="col-md-2 col-md-offset-4">
                    <?php echo form_input($submit_enter_chat_room+array('class'=>'form-control btn-xstream-banter')); ?>
                </div> 
            </div>
            <input type="hidden" id="xb_chat_room_id" name="xb_chat_room_id" value="<?php echo $xb_chat_room_id?>">
        </div>                
        <?php echo form_close(); ?>    
    </div>
    
</div>
<div class="col-md-3 column">
    
</div>