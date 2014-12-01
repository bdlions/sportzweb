<script src="http://31.222.168.64:8082/socket.io/socket.io.js"></script>
<script type="text/javascript">
    function MessageInfo(){
        this.roomId = "";
        this.userId = "";
        this.message = "";
    };
</script>
<script type="text/javascript">
    function UserInfo(){
        this.userId = "3";
        this.roomId = "axcvvy";
        this.roomName = "axcvvy";
        this.teamId = "1";
        this.teamName = "Bangladesh";
        this.firstName = "Alamgir";
        this.lastName = "Kabir";
    };
</script>
<script type="text/javascript">
$(function(){
    
    var socket = io.connect('http://31.222.168.64:8082/');
    //var socket = io.connect('http://127.0.0.1:8082/');
    socket.on('connect', function(){
        //console.log('a user conneccted to the server.');

        var userInfo = new UserInfo();
        userInfo.roomId = '<?php echo $xb_chat_room_id?>';
        //console.log(userInfo);
        socket.emit('adduser', JSON.stringify(userInfo));
    });
    socket.on('updatemessages', function (data) {
        //$("#chatHistory").append(username + " " +data + "<br/>");
        console.log(data);
        data = JSON.parse(data);
        $("#chat_messages").html(tmpl("tmpl_message_list",  data['messageInfo']) +  $("#chat_messages").html());
    });    
    /*setInterval(function (){
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "applications/xstream_banter/get_chat_messages",
            data: {
                xb_chat_room_id: '<?php echo $xb_chat_room_id?>'
            },
            success: function(data) {
                $("#chat_messages").html(tmpl("tmpl_message_list",  data['chat_room_message_list']));
            }
        });
    }, 4000);*/
    $("#button_send_message2").on("click", function() {
        var messageInfo = new MessageInfo();
        messageInfo.roomId = '<?php echo $xb_chat_room_id?>';
        messageInfo.userId = '<?php echo $user_id?>';
        messageInfo.message = $("#textarea_chat_message").val();
        socket.emit('sendmessage', JSON.stringify(messageInfo));
        
        $("#textarea_chat_message").val('')
        /*$.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "applications/xstream_banter/store_chat_message",
            data: {
                xb_chat_room_id: '<?php echo $xb_chat_room_id?>',
                message: $("#textarea_chat_message").val()
            },
            success: function(data) {
                $("#textarea_chat_message").val('');
                $("#chat_messages").html(tmpl("tmpl_message_list",  data['chat_room_message_list']));
            }
        });*/
        
    });
});
</script>
<script type="text/x-tmpl" id="tmpl_message_list">
    {% var i=0, message_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(message_info){ %}
        <div class="row col-md-10 chat_message">
            <div class="col-md-4 chat_message-left">
                <span>({%= message_info.time%})</span><br/>
                {%= message_info.first_name%} {%= message_info.last_name%} - {%= message_info.team_name%}:
            </div>
            <div class="col-md-8 chat_message-right"><br/>{%= message_info.message%}</div>
        </div>
    {% message_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
<div class="col-md-9 column chat-room">
    <div class="row col-md-4">
        <a href="<?php echo base_url().'applications/xstream_banter'; ?>" >
            <img class="img-responsive" src="<?php echo base_url() ?>resources/images/xb_logo.png" />
        </a>        
    </div>
    <div class="row chat-room-code">
        Group Access Code : <?php echo $group_access_code;?>
    </div>
    <div class="row">
        <h3><?php echo $match_info['tournament_title'];?> <?php echo $match_date;?></h3>
        <h4><?php echo $match_info['team1_title']?> v <?php echo $match_info['team2_title']?> (<?php echo $match_info['time']?>)</h4>
    </div>
    <div class="row pre-scrollable chat_message-pre-scrollable" id="chat_messages">
        <?php foreach($chat_room_message_list as $chat_room_message) {?>
            <div class="row col-md-10 chat_message">
                <div class="col-md-4 chat_message-left">
                    <span>(<?php echo $chat_room_message['time'];?>)</span><br/>
                    <?php echo $chat_room_message['first_name'];?> <?php echo $chat_room_message['last_name'];?> - <?php echo $chat_room_message['team_name'];?>:
                </div>
                <div class="col-md-8 chat_message-right"><br/><?php echo $chat_room_message['message'];?></div>
            </div>
        <?php } ?>        
    </div>
    <div class="row" style="margin-top:20px"></div>
    <div class="row col-md-12">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8" style="padding-left: 35px;padding-right: 0px">
                <textarea id="textarea_chat_message" name="textarea_chat_message" placeholder="Write a comment"></textarea>
            </div>            
        </div>
        <div class="row" style="margin-top:25px"></div>
        <div class="row form-group">
            <label class="col-md-8 control-label"></label>
            <div class ="col-md-2">
                <input id="button_send_message2" name="button_send_message2" type="button" value="send" class="form-control button-custom pull-right"/>
            </div>
        </div>
    </div>
</div>
<div class="col-md-3 column">
    
</div>