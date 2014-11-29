<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-7">
            <div class="row form-group">
                <div class="col-md-2">
                    <a href="<?php echo base_url()?>applications/gympro/create_group"><button class="btn button-custom btn_gympro">New Group</button></a>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <table class="table table-condensed table-responsive gympro_table">
                        <tbody>
                            <tr>
                                <th>Group Name</th>
                                <th>Number of Clients</th>
                                <th>Group Created</th>
                                <th>Edit</th>
                            </tr>
                            <tr>
                                <td>tata</td>
                                <td>22</td>
                                <td>acsaasdc</td>
                                <td><a>Edit</a></td>
                            </tr>
                            <tr>
                                <td>acsaasdc</td>
                                <td>acsaasdc</td>
                                <td>acsaasdc</td>
                                <td><a>Edit</a></td>                                
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>

</div>