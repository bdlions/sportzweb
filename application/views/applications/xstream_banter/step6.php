<div class="col-md-9 column join-chat-room">
    <div class="row col-md-4">
        <a href="<?php echo base_url().'applications/xstream_banter'; ?>" >
            <img class="img-responsive" src="<?php echo base_url() ?>resources/images/xb_logo.png" />
        </a>        
    </div>
    <div class="row">    
        <?php echo form_open("applications/xstream_banter/step6/".$match_id, array('id' => 'form_enter_chat_room', 'class' => 'form-horizontal')); ?>
        <div class="row">
            <div class ="row">
                <div class="col-md-8"><?php echo $message; ?></div>
            </div>
            <div class="row form-group">
                <label class="col-md-6 control-label join-chat-room-label">Enter access code to join a chat room:</label>
                <div class ="col-md-3">
                    <?php echo form_input($group_access_code+array('class'=>'form-control join-chat-room-code'));?>
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
    <div>
        <br>
        <br>
        <br>
        <h3><b>Previous chat room access code:</b></h3>
        <h3>
        <?php
        foreach($previous_chat_rooms as $chat_room)
        {
            echo $match_info['team1_title']?> v <?php echo $match_info['team2_title'];?> : <?php echo '<a href="'.base_url().'applications/xstream_banter/step7/'.$chat_room['xb_chat_room_id'].'">'.$chat_room['group_access_code'].'</a>';?><br><?php
        }
        
        ?>
        </h3>
    </div>
</div>
<div class="col-md-3 column">
    
</div>