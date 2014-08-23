<div class="panel panel-default">
    <div class="panel-heading"><?php echo $match_info['team1_title']?> vs <?php echo $match_info['team2_title']?></div>
    <div class="panel-body">
        <div class="row col-md-12">             
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Room id</th>
                                <th>Creator</th>
                                <th>Code</th> 
                                <th>Conversation</th> 
                            </tr>
                        </thead>
                        <tbody id="tbody_business_profiles">                
                            <?php foreach($chat_room_list as $chat_room){?>
                                <tr>
                                    <td><?php echo $chat_room['id']?></td>
                                    <td><?php echo $chat_room['first_name'].' '.$chat_room['last_name']?></td>
                                    <td><?php echo $chat_room['group_access_code']?></td>
                                    <td><a href="<?php echo base_url()."admin/applications_xstreambanter/xstream_banter_room_conversation/".$chat_room['id']; ?>">view</a></td>                                    
                                </tr>
                            <?php } ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

