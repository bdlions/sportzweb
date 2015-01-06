<div class="panel panel-default">
    <div class="panel-heading">Teams</div>
    <div class="panel-body">
        <div class="row col-md-12">            
            <div class="row form-group" style="padding-left: 10px;">
                <?php if($allow_write){ ?>
                <div class ="col-md-2 pull-left">
                    <button onclick="open_modal_team_create()" value="" class="form-control btn button-custom pull-right">Create Team</button>  
                </div>
                <?php } ?>
            </div>
            
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: right">Id</th>
                                <th style="text-align: center">Title</th>
                                <?php if($allow_edit){ ?>
                                <th style="text-align: center">Edit</th>
                                <?php } ?>
                                <?php if($allow_delete){ ?>
                                <th style="text-align: center">Delete</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="tbody_team_list">                
                            <?php foreach($team_list as $team){?>
                            <tr>
                                <td style="text-align: right"><?php echo $team['team_id']?></td>
                                <td style="text-align: center"><?php echo $team['title']?></td>
                                <?php if($allow_edit){ ?>
                                <td style="text-align: center">
                                    <button onclick="open_modal_team_update('<?php echo $team['team_id']; ?>')" value="" class="form-control btn pull-right">
                                        Edit
                                    </button>
                                </td> 
                                <?php } ?>
                                
                                <?php if($allow_delete){ ?> 
                                <td style="text-align: center">
                                    <button onclick="open_modal_team_delete_confirm('<?php echo $team['team_id']; ?>')" value="" class="form-control btn pull-right">
                                        Delete
                                    </button>
                                </td>
                                <?php } ?>
                            </tr>
                            <?php } ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="btn-group" style="padding-left: 10px;">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
            </div>
        </div>
    </div>
</div>

<?php 
$this->load->view("admin/applications/xstream_banter/modal/team_create");
$this->load->view("admin/applications/xstream_banter/modal/team_update");
$this->load->view("admin/applications/xstream_banter/modal/team_delete_confirm");
?>