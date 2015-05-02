<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<div class="container-fluid">
    <div class="row top_margin">
        <?php 
        if ($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT) {
            $this->load->view("applications/gympro/template/sections/client_left_pane");
            echo '<div class="col-md-9">';
        } else {
            $this->load->view("applications/gympro/template/sections/pt_left_pane");
            echo '<div class="col-md-10">';
        }
        ?>
            <div class="row">
                <div class="row col-md-12 form-group"></div>
                <div class="col-md-12 heading_medium_thin">
                    Show session
                    <div class="row form-group">
                        <div class="col-md-4" style="border-bottom: 1px solid #999999"></div>
                    </div>
                    <div class="row form-group"></div>
                </div>
            </div>
            <?php if(isset($message) && ($message != NULL)): ?>
            <div class="alert alert-info alert-dismissible"><?php echo $message; ?></div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="row form-group">
                        <div class="col-md-4 content_text">Title: </div>
                        <div class="col-md-8">
                            <?php echo $session_info['title'];?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4 content_text">Group / Client</div>
                        <div class="col-md-8">
                            <?php 
                                if (($session_info['created_for_type_id']) == SESSION_CREATED_FOR_GROUP_TYPE_ID) {
                                 foreach ($group_list as $group_info) {
                                    echo $group_info['title'] . ' (group)';
                                    break;
                                }
                            }
                            ?>
                            <?php 
                                if (($session_info['created_for_type_id']) == SESSION_CREATED_FOR_CLIENT_TYPE_ID){
                                  foreach ($client_list as $client_info){
                                    echo $client_info['first_name'].' (client)';
                                    break;
                                }
                            } ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4 content_text">Date:</div>
                        <div class="col-md-8">
                            <?php echo $session_info['date'];?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4 content_text">Start:</div>
                        <div class="col-md-8">
                            <?php foreach ($session_times as $session_time){
                                if( (string)$session_time['title_24'] == (string)$session_info['start']){
                                    echo $session_time['title'];
                                    break;
                                }
                            } ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4 content_text">Finish:</div>
                        <div class="col-md-8">
                            <?php foreach ($session_times as $session_time){
                                if( (string)$session_time['title_24'] == (string)$session_info['end']){
                                    echo $session_time['title'];
                                    break;
                                }
                            } ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4 content_text">Location</div>
                        <div class="col-md-8">
                            <?php echo $session_info['location'];?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4 content_text">Type:</div>
                        
                        <div class="col-md-4">
                            <?php foreach ($session_types as $type){
                                if($type['id'] == $session_info['type_id']){
                                    echo $type['title'];
                                    break;
                                }
                            } ?>
                        </div>
                        <div class="col-md-4">
                            <div class="row" id="dd_rep" style="display: none">
                                <div class="col-sm-3"> For</div>
                                <div class="col-sm-6">
                                    <?php foreach ($session_repeats as $repeat){
                                        if($session_info['repeat']==$repeat['title']){
                                            echo $repeat['title'];
                                            break;
                                        }
                                    } ?>
                                </div>
                                <div class="col-sm-3"> sessions</div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4 content_text">Cost:</div>
                        <div class="col-md-8">
                            <?php echo $session_info['cost'];?> <?php echo $session_info['currency_title'];?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-4 content_text">Status:</div>
                        <div class="col-md-8">
                            <?php foreach ($session_statuses as $status){
                                if($status['id'] == $session_info['status_id']){
                                    echo $status['title'];
                                    break;
                                }
                            } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-md-offset-1">
                    <div class="row form-group">
                        <div class="col-md-1 content_text">Notes</div> 
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <?php echo $session_info['note'];?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>