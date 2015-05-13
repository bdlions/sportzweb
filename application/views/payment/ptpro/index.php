<div class ="form-horizontal">
    <?php echo form_open("paypal/payments_pro/Do_direct_payment_ptpro/".$session_info['session_id'], array('id' => 'form_Do_direct_payment_demo', 'class' => 'form-horizontal')); ?>
    <div class="row col-md-6">        
        <div class="form-group">
            <label for="payment_types" class="col-md-6 control-label requiredField">
                Payment Type
            </label>
            <div class ="col-md-6" id="unit_dropdown">
                <?php echo form_dropdown('payment_types', $payment_types, 'MasterCard', 'class=form-control id=payment_types'); ?>
            </div> 
        </div>   
        <div class="form-group">
            <label for="card_number" class="col-md-6 control-label requiredField">
                Card Number
            </label>
            <div class ="col-md-6">
                <?php echo form_input($card_number+array('class'=>'form-control')); ?>
            </div> 
        </div>
        <div class="form-group">
            <label for="expired" class="col-md-6 control-label requiredField">
                Expiration Date
            </label>
            <div class ="col-md-3">
                <?php echo form_dropdown('expired_month', $expired_month, '', 'class=form-control id=expired_month'); ?>
            </div>
            <div class ="col-md-3">
                <?php echo form_dropdown('expired_year', $expired_year, '', 'class=form-control id=expired_year'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="ccv_code" class="col-md-6 control-label requiredField">
                CCV Code
            </label>
            <div class ="col-md-6">
                <?php echo form_input($ccv_code+array('class'=>'form-control')); ?>
            </div> 
        </div>
        <div class="form-group">
            <label for="amount" class="col-md-6 control-label requiredField">
                Amount
            </label>
            <label for="code" class="col-md-6 control-label">
                <?php echo $session_info['cost'].' '.$session_info['currency_title'] ?>
            </label>
        </div>
        <div class="form-group">
            <label for="address" class="col-md-6 control-label requiredField">
            </label>
            <div class ="col-md-3 col-md-offset-3">
                <?php echo form_input($submit_pay_session+array('class'=>'form-control button-custom')); ?>
            </div> 
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<div class ="form-horizontal">
<?php $payPalURL = base_url().'paypal/payments_pro/set_express_checkout_ptpro/'.$schedule_id;?>
<!-- PayPal Logo --><table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="<?php echo $payPalURL;?>" title="Pay with PayPal"><img src="https://www.paypalobjects.com/webstatic/en_AU/i/buttons/btn_paywith_primary_l.png" alt="Pay with PayPal" /></a></td></tr></table><!-- PayPal Logo -->
</div>
