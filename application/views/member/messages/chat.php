<script type="text/javascript" src="<?php echo base_url()?>resources/bootstrap3/js/chat.js"></script>

<div id="chatFollowers">
    <div class="panel panel-default" style="width: 180px; right:0px; bottom: -20px;position: fixed; max-height:150px;overflow-x: hidden;">
        <div class="panel-body">
            <?php $followers = get_followers(); foreach ($followers as $follower) { ?>
                <div class="row">
                    <a href="#" onclick="javascript:chatWith('<?php echo $follower->first_name . " " . $follower->last_name ?>', '<?php echo $follower->user_id ?>'); return false;">
                        <div class="col-md-12">
                            <img src="<?php echo base_url() . 'resources/images/' . ($follower->online_status == TRUE ? 'online.png' : 'offline.png') ?>" />
                            <?php echo $follower->first_name . " " . $follower->last_name ?>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script type="text/x-tmpl" id="tmpl-chatbox">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <h3 class="panel-title col-md-8" id="chatTitle">{%= o.title%}</h3>
                <div class="col-md-2 close" id="chatClose" onclick="javascript:closeChatBox('{%= o.user_id %}')">&times;</div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12" id="chatContent" style="height:200px;overflow-x: hidden;"></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <input type="text" class="form-control" id="chatInput" onkeydown="javascript:return checkChatBoxInputKey(event,this,'{%= o.user_id %}');" />
                </div>
            </div>
        </div>
    </div>
</script>
<div id="chatBoxesArea">
    <script type="text/x-tmpl" id="tmpl-followers">
        <div class="panel panel-default" style="width: 180px; right:0px; bottom: -20px;position: fixed; max-height:150px;overflow-x: hidden;">
            <div class="panel-body">
                {% for(var i = 0, online_status_image; i < o.length; i ++){ %}
                    <div class="row">
                        <a href="#" onclick="javascript:chatWith('{%=o[i].first_name + " "+ o[i].last_name %}', '{%= o[i].user_id%}'); return false;">
                            <div class="col-md-12">
                                {% if(o[i].online_status == "1"){ %}
                                {%   online_status_image = "online.png";  %}
                                {% }else{ %}
                                {% online_status_image = "offline.png"; %}
                                {% }%}
                                <img src="<?php echo base_url() . 'resources/images/{%= online_status_image %}' ?>" />
                                {%=o[i].first_name + " "+ o[i].last_name %}
                            </div>
                        </a>
                    </div>
                {% } %}
            </div>
        </div>
    </script>
</div>