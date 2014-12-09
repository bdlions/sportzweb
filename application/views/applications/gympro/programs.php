<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-7">
            <div class="row form-group">
                <div class="col-md-2">
                    <a href="<?php echo base_url() ?>applications/gympro/exercises"><button class="btn button-custom btn_gympro">Exercises</button></a>
                </div>
                <div class="col-md-2">
                    <a href="<?php echo base_url() ?>applications/gympro/create_program"><button class="btn button-custom btn_gympro">New Program</button></a>
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
                            <?php foreach ($program_list as $program): ?>
                                <tr>
                                    <td><?php echo $program['created_on'] ?></td>
                                    <td><a href="<?php echo base_url() . 'applications/gympro/edit_program/' . $program['program_id']; ?>">Edit</a></td>
                                    <td>
                                        <a href="" onclick="open_modal_delete_confirm(<?php echo $program['id'] ?>)" >
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>                
            </div>
        </div>
    </div>

</div>

<?php $this->load->view("applications/gympro/modal/program_delete_confirm");?>