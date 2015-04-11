<div class="panel panel-default">
    <div class="panel-heading">Applications</div>
    <div class="panel-body">
        <div class="row col-md-12">
             <?php if ($allow_write) { ?>
            <div class="row form-group">
                <div class ="pull-left" style="padding-left: 25px;">
                    <a href="<?php echo base_url(); ?>admin/applications_directory/create_application">
                        <button class="btn button-custom">Create Application</button>
                    </a>
                </div>
            </div>
             <?php } ?>
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered" style="text-align: center;">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Id</th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Application Order</th>
                                <th style="text-align: center;">Description</th> 
                                <?php if ($allow_edit) { ?>
                                <th style="text-align: center;">Edit</th> 
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="tbody_application_list">
                            <?php if ($all_applications): ?>
                                <?php foreach ($all_applications as $row): ?>
                                    <tr>
                                        <td>
                                            <a href="#">
                                                <?php echo $row['id']; ?>
                                            </a>
                                        </td>
                                        <td>
                                            <div id="app_title_<?php echo $row['id']; ?>">
                                                <?php echo $row['title']; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php echo $row['order']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['description']; ?>
                                        </td>
                                        <?php if ($allow_edit) { ?>
                                        <td>
                                            <a href="<?php echo base_url(); ?>admin/applications_directory/update_application/<?php echo $row['id']; ?>">
                                                Edit
                                            </a>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="btn-group" style="padding-left: 25px;">
                    <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
                </div>
            </div>            
        </div>
    </div>
</div>
