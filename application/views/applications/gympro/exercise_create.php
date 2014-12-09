<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<div class="container-fluid">
    
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-10">
            <div class="pad_title">
                ADDING EXERCISE
            </div>
            <?php echo form_open("applications/gympro/create_exercise", array('id' => '', 'class' => 'form-horizontal')); ?>
            <div class="pad_body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="row form-group">
                            <div class="col-md-4">
                                Category:*
                            </div>
                            <div class="col-md-6">
                                <select class="form-control" name="category_id">
                                    <?php foreach ($category_array as $category):?>
                                    <option value="<?php echo $category['id']?>"><?php echo $category['title'];?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Name:*
                            </div>
                            <div class="col-md-6">
                                <?php echo form_input($name + array('class' => 'form-control')) ?>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Description:
                            </div>
                            <div class="col-md-8">
                                <?php echo form_textarea($description + array('class' => 'form-control')) ?>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                Upload a photo:
                            </div>
                            <div class="col-md-6">
                                <input type="file">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pad_footer">
                <?php echo form_input($submit_button) ?>  or <a href="<?php echo base_url()?>applications/gympro/exercises">Cancel</a>
            </div>
                <?php echo form_close(); ?>
        </div>
    </div>

</div>