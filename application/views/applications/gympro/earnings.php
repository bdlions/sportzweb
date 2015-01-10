<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<style>
    .calender_cell:hover
    {
        background-color: #aaa;
        color: white;
    }
    .calender_cell
    {
        background-color: #ddd;
        padding: 10px;
        width: 13.5%;
        height: 60px;
        overflow: hidden;
        float: left;
        margin: 1px;
        font-size: 12px;
    }
</style>
<div class="container-fluid">
    <div class="row top_margin">
        <?php 
        if($account_type_id == APP_GYMPRO_ACCOUNT_TYPE_ID_CLIENT)
        {
            $this->load->view("applications/gympro/template/sections/client_left_pane"); 
        }
        else
        {
            $this->load->view("applications/gympro/template/sections/pt_left_pane"); 
        }            
        ?>
        <div class="col-md-10">
            <div class="row form-group">
                <div class="col-md-2">
                    <a href="<?php echo base_url() ?>applications/gympro/create_session"><button class="btn button-custom btn_gympro">New Session</button></a>
                </div>
                <div class="col-md-2">
                    <a href="<?php echo base_url() ?>applications/gympro/earnings_summary"><button class="btn button-custom btn_gympro">Earnings Summery</button></a>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <span style="font-size: 20px">October</span>
                    <div class="pull-right">
                        View: 
                        <select>
                            <option selected="">Month</option>
                            <option>Week</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-md-12">
                    <?php for ($j = 0; $j < 6; $j++): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <?php for ($i = 0; $i < 7; $i++): ?>
                                    <div style="" class="calender_cell">
                                        7 Calender cell
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>