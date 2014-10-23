<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">

<div class="container-fluid">
    
    <div class="row top_margin">
        <div class="col-md-2">
            <?php $this->load->view("gympro/gympro_leftnav"); ?>
        </div>
        <div class="col-md-10">
            <div style="background-color: #E4E4E4; margin-bottom: 1px; padding: 10px; padding-left: 20px; font-weight: bold">
                NEW NUTRITION PLAN
            </div>
            <div style="background-color: #E4E4E4; margin-bottom: 1px; padding: 20px; display: inline-block; width: 100%">
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
                </div>
                <div style="background-color: #fff; margin-bottom: 1px; padding: 10px; display: inline-block; width: 100%">
                    
                    <div>
                        <div class="col-md-5" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Label</div>
                            <div><input style="width: 100%"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Quantity</div>
                            <div><input style="width: 100%"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Qty.Unit</div>
                            <div><input style="width: 100%"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Calories</div>
                            <div><input style="width: 100%"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Protin</div>
                            <div><input style="width: 100%"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Carbs</div>
                            <div><input style="width: 100%"></div>
                        </div>
                        <div class="col-md-1" style="padding: 0px; margin: 2px;">
                            <div style="font-size: 14px;">Fats</div>
                            <div><input style="width: 100%"></div>
                        </div>
                    </div>
                </div>
                <div>
                    <a href="" style="font-size: 16px; line-height: 33px;">+Add another meal</a>
                </div>
                <div>
                    <button style="width: 54px;">Save</button> or <a href="" style="font-size: 16px; line-height: 33px;">Cancel</a>
                </div>
            </div>
        </div>
    </div>

</div>