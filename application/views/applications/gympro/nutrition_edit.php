<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("applications/gympro/template/sections/left_pane"); ?>
        </div>
        <div class="col-md-10">
            <div class="pad_title">
                EDIT NUTRITION PLAN
            </div>
            <?php echo form_open("applications/gympro/edit_nutritition", array('id' => 'form_create_program', 'class' => 'form-horizontal')) ?>            
            <div class="pad_body">
                <div style="background-color: #fff; margin-bottom: 1px; padding: 10px; display: inline-block; width: 100%">
                    <select style=" margin-right: 15px; width: 100px;">
                        <option>MEAL TIME</option>
                        <option>MEAL TIME MEAL TIME MEAL TIME MEAL TIME MEAL TIME</option>
                        <option>kada</option>
                    </select>
                    <select style="margin-right: 15px; width: 100px;">
                        <option>Pre workout</option>
                        <option>kada</option>
                        <option>kada</option>
                    </select>
                    <img class="pull-right" onclick="alert('Cross pressed')" src="<?php echo base_url();?>resources/images/cross.png" style="margin: 4px">
                    <img class="pull-right" onclick="alert('asdas')" src="<?php echo base_url();?>resources/images/add.png" style="margin: 4px">
                </div>
                <div style="background-color: #fff; margin-bottom: 1px; padding: 10px; display: inline-block; width: 100%">
                    
                    <div>
                        <div class="col-md-5" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Label</div>
                            <div><input style="width: 100%" name="label" value="<?php echo $nutrition['label'];?>"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Quantity</div>
                            <div><input style="width: 100%"  name="quan" value="<?php echo $nutrition['quan'];?>"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Qty.Unit</div>
                            <div><input style="width: 100%" name="unit" value="<?php echo $nutrition['unit'];?>"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Calories</div>
                            <div><input style="width: 100%" name="cal" value="<?php echo $nutrition['cal'];?>"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Protin</div>
                            <div><input style="width: 100%" name="prot" value="<?php echo $nutrition['prot'];?>"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Carbs</div>
                            <div><input style="width: 100%" name="carb" value="<?php echo $nutrition['carb'];?>"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Fats</div>
                            <div><input style="width: 100%" name="fats" value="<?php echo $nutrition['fats'];?>"></div>
                        </div>
                    </div>
                </div>
                <div>
                    <a href="" style="font-size: 16px; line-height: 33px;">+Add another meal</a>
                </div>
<!--                <div>
                    <button style="width: 54px;">Save</button> or <a href="" style="font-size: 16px; line-height: 33px;">Cancel</a>
                </div>-->
            </div>
            
            <div class="pad_footer">
                <button type="submit">Save Changes</button> or <a href="<?php echo base_url()?>applications/gympro/nutrition">Go Back</a>
            </div>
            <?php echo form_close();?>
        </div>
    </div>

</div>