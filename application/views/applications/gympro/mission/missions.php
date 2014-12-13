<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-7">
            <div class="row form-group">
                <div class="col-md-2">
                    <a href="<?php echo base_url()?>applications/gympro/create_mission"><button class="btn button-custom btn_gympro">New Mission</button></a>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <table class="table table-condensed table-responsive gympro_table">
                        <tbody>
                            <tr>
                                <th>CREATED</th>
                                <th>LABEL</th>
                                <th>EDIT</th>
                                <th>DELETE</th>                                
                            </tr>
                            <?php foreach($mission_list as $mission_info){?>
                            <tr>
                                <td><?php echo $mission_info['created_on']?></td>
                                <td><?php echo $mission_info['label']?></td>
                                <td><a href="<?php echo base_url()."applications/gympro/edit_mission/".$mission_info['mission_id']?>">Edit</a></td>
                                <td style="text-align: center">
                                <a onclick="open_modal_delete_confirm(<?php echo $mission_info['mission_id'] ?>)" >
                                    Delete
                                </a>
                            </td>
                            </tr>                            
                            <?php } ?>                           
                        </tbody>
                    </table>
                </div>                
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("applications/gympro/mission/mission_delete_confirm_modal");