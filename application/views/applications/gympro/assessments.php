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
                                <th>CLIENT</th>
                                <th>EDIT</th>
                            </tr>
                            <tr>
                                <td>20th Nov 2014</td>
                                <td>Shem Haye</td>
                                <td><a>Edit</a></td>
                            </tr>
                            <tr>
                                <td>20th Nov 2014</td>
                                <td>This table is partially dynamic</td>
                                <td><a>Edit</a></td>
                            </tr>
                            <?php foreach ($assessments_array as $assessment):?>
                            <tr>
                                <td><?php echo $assessment['created_on']?></td>
                                <td><?php echo $assessment['client_name']?></td>
                                <td><a href="<?php echo base_url().'applications/gympro/'.$assessment['assessment_id'];?>"></a></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>                
            </div>
        </div>
    </div>

</div>