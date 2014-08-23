<div class="col-md-9 column join-chat-room">
    <div class="row col-md-4">
        <a href="<?php echo base_url().'applications/xstream_banter'; ?>" >
            <img class="img-responsive" src="<?php echo base_url() ?>resources/images/xb_logo.png" />
        </a>        
    </div>
    <div class="row">    
        <div class="row blank-row"></div>
        <div class="row blank-row"></div>
        <?php echo form_open("applications/xstream_banter/chat_room_team_map/".$xb_chat_room_id.'/'.$match_id, array('id' => 'form_enter_chat_room', 'class' => 'form-horizontal')); ?>
        <div class="row">
            <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class ="col-md-6">
                    <?php echo form_dropdown('team_list', $team_list, '', 'class="form-control join-chat-room-form-control" id="team_list"'); ?>
                </div> 
            </div>
            <div class="row blank-row"></div>
            <div class="row form-group">
                <label class="col-md-7 control-label"></label>
                <div class ="col-md-2">
                    <?php echo form_input($submit_enter_chat_room+array('class'=>'form-control btn-xstream-banter')); ?>
                </div>
            </div>
        </div>                
        <?php echo form_close(); ?>    
    </div>    
</div>
<div class="col-md-3 column">
    
</div>