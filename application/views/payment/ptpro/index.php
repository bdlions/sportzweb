<?php $payPalURL = base_url().'paypal/payments_pro/set_express_checkout_ptpro/'.$schedule_id;?>
<!-- PayPal Logo --><table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="<?php echo $payPalURL;?>" title="Pay with PayPal"><img src="https://www.paypalobjects.com/webstatic/en_AU/i/buttons/btn_paywith_primary_l.png" alt="Pay with PayPal" /></a></td></tr></table><!-- PayPal Logo -->
<div class ="form-horizontal">
    <?php echo form_open("paypal/payments_pro/Do_direct_payment_demo", array('id' => 'form_Do_direct_payment_demo', 'class' => 'form-horizontal')); ?>
    <div class="row">
        
            <div class="row form-group">
                <div class="col-sm-4">
                    <label>Payment Type:</label>
                    <select class="form-control">
                        <option>Visa</option>
                    </select>
                </div>
            </div>   
            <div class="row form-group">
                <div class="col-sm-4">
                    <label>Card Number:</label>
                    <input class="form-control" value="4032032716273062">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <label>Expiration Date:</label>
                </div>
                <div class="col-sm-4">
                    <label>CCV code:</label>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-2">
                    <select class="form-control">
                        <option value="">Month</option>
                        <option value="01">01-January</option>
                        <option value="02"  selected>02-February</option>
                        <option value="03">03-March</option>
                        <option value="04">04-April</option>
                        <option value="05">05-May</option>
                        <option value="06">06-June</option>
                        <option value="07">07-July</option>
                        <option value="08">08-August</option>
                        <option value="09">09-September</option>
                        <option value="10">10-October</option>
                        <option value="11">11-November</option>
                        <option value="12">12-December</option>
                    </select>
                </div>
                <div class="col-sm-1">
                    <select class="form-control">
                        <option value="select-one">Year</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020" selected>2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        <option value="2031">2031</option>
                    </select>
                </div>
                <div class="col-sm-1">
                    <input class="form-control" value="123">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-4">
                    <label>Amount:</label>
                    <input name="amount" class="form-control" value="100">
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-4">
                    <input type="submit" class="btn btn-success" value="Submit">
                </div>
            </div>
        
    </div>
    <?php //echo form_close(); ?>
</div>
