<div class="row">
    <h1>PayPal Form</h1>
    <div>
            <?php echo form_open("payment/pay_ptpro/".$session_info['session_id'], array('id' => 'form_adaptive_payment_demo', 'class' => 'form-horizontal')); ?>
                    <input type="submit" value="Pay by PayPal">
            <?php echo form_close(); ?>
    </div>
    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>
