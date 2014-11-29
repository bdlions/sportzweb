<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-7">
            <div class="row form-group">
                <div class="col-md-2">
                    <a href="<?php echo base_url()?>applications/gympro/create_exercise"><button class="btn button-custom btn_gympro">New Exercise</button></a>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <table class="table table-condensed table-responsive gympro_table">
                        <tbody>
                            <tr>
                                <th>CREATED</th>
                                <th>CLIENT</th>
                                <th>LABEL</th>
                                <th>EDIT</th>
                            </tr>
                            <tr>
                                <td>20th Nov 2014</td>
                                <td>Shem Haye</td>
                                <td>Label1</td>
                                <td><a>Edit</a></td>
                            </tr>
                            <tr>
                                <td>20th Nov 2014</td>
                                <td>Shem Haye</td>
                                <td>Label2</td>
                                <td><a>Edit</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>                
            </div>
        </div>
    </div>

</div>