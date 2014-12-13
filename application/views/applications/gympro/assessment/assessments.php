<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-7">
            <div class="row form-group">
                <div class="col-md-2">
                    <a href="<?php echo base_url()?>applications/gympro/create_assessment"><button class="btn button-custom btn_gympro">New Assessment</button></a>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <table class="table table-condensed table-responsive gympro_table">
                        <tbody>
                            <tr>
                                <th>CREATED</th>
                                <th>EDIT</th>
                                <th>DELETE</th>
                            </tr>
                            <?php foreach ($assessment_list as $assessment):?>
                            <tr>
                                <td><?php echo $assessment['created_on']?></td>
                                <td><a href="<?php echo base_url().'applications/gympro/edit_assessment/'.$assessment['assessment_id'];?>">Edit</a></td>
                                <td style="text-align: center">
                                <a onclick="open_modal_delete_confirm(<?php echo $assessment['assessment_id'] ?>)" >
                                    Delete
                                </a>
                            </td>
                            </tr>
                            
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>                
            </div>
        </div>
    </div>

</div>
<?php $this->load->view("applications/gympro/assessment/assessment_delete_confirm_modal");