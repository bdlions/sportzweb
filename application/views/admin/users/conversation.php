<div class="panel panel-default">
    <div class="panel-heading">Conversation</div>
    <div class="panel-body">
        <div class="row col-md-10">
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Conversations</th>
                                <th>Time</th>
                                <th>Message</th>                            
                            </tr>
                        </thead>
                        <tbody id="tbody_business_profiles">                
                            <?php foreach($conversation_list as $conversation){?>
                                <tr>
                                    <td><?php echo $conversation['first_name'].' '.$conversation['last_name']?></td>
                                    <td><?php echo unix_to_human($conversation['send_date'])?></td>
                                    <td><?php echo $conversation['message']?></td>
                                </tr>
                            <?php } ?>                                                    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

