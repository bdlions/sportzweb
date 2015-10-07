<div class="panel panel-default">
    <div class="panel-heading">Sports</div>
    <div class="panel-body">
        <div class="row col-md-12">            
            <div class="row form-group" style="padding-left: 10px;">
                <?php if($allow_write){ ?>
                <div class ="col-md-2 pull-left">
                    <button onclick="open_modal_sports_create()" value="" class="form-control btn button-custom pull-right">Create Sports</button>  
                </div>
                <?php } ?>
                <?php if($allow_writing){ ?>
                <div class ="col-md-2 pull-left">
                    <a href="<?php echo base_url()."admin/applications_xstreambanter/import_matches"; ?>">
                        <button id="button_import_matches" value="" class="form-control btn button-custom pull-right">Import Matches</button>  
                    </a>
                </div>
                <?php } ?>
            </div>
            
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Order</th>
                                <?php if($allow_edit){ ?>
                                <th style="text-align: center">Edit</th>
                                <?php } ?>
                                <?php if($allow_delete){ ?>
                                <th style="text-align: center">Delete</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="tbody_sports_list">                
                            <?php foreach($sports_list as $sports){?>
                            <tr>
                                <td><a href="<?php echo base_url()."admin/applications_xstreambanter/manage_tournaments/".$sports['sports_id']; ?>"><?php echo $sports['sports_id']?></a></td>
                                <td><?php echo $sports['title']?></td>
                                <td><?php echo $sports['order']?></td>
                                <?php if($allow_edit){ ?>
                                <td>
                                    <button onclick="open_modal_sports_update('<?php echo $sports['sports_id']; ?>')" value="" class="form-control btn pull-right">
                                        Edit
                                    </button> 
                                </td>
                                <?php } ?>
                                <?php if($allow_delete){ ?>
                                <td>
                                    <button onclick="open_modal_sports_delete_confirm('<?php echo $sports['sports_id']; ?>')" value="" class="form-control btn pull-right">
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
$this->load->view("admin/applications/xstream_banter/modal/sports_create");
$this->load->view("admin/applications/xstream_banter/modal/sports_update");
$this->load->view("admin/applications/xstream_banter/modal/sports_delete_confirm");
?>