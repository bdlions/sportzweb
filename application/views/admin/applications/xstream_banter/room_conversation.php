<div class="panel panel-default">
    <div class="panel-heading"><?php echo $room_conversation_match_info['team1_title']?> vs <?php echo $room_conversation_match_info['team2_title']?></div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Team name</th>
                                <th>Total users</th>  
                            </tr>
                        </thead>
                        <tbody id="tbody_business_profiles">                
                            <tr>
                                <td><?php echo $room_conversation_match_info['team1_title']?></td>
                                <td><?php echo $team_total_users_map[$room_conversation_match_info['team1_id']]?></td>
                            </tr>
                            <tr>
                                <td><?php echo $room_conversation_match_info['team2_title']?></td>
                                <td><?php echo $team_total_users_map[$room_conversation_match_info['team2_id']]?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Message</th>  
                            </tr>
                        </thead>
                        <tbody id="tbody_business_profiles">                
                            <?php foreach($chat_room_message_list as $chat_room_message) {?>
                            <tr>
                                <td><?php echo $chat_room_message['time'];?></br><?php echo $chat_room_message['first_name'];?> <?php echo $chat_room_message['last_name'];?> - <?php echo $chat_room_message['team_name'];?></td>
                                <td><?php echo $chat_room_message['message'];?></td>
                            </tr>
                            <?php } ?> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

