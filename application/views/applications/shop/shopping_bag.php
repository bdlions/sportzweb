<?php $this->load->view("applications/shop/templates/topnav"); ?>
<?php $this->load->view("applications/shop/templates/breadcrumb"); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="bag_big_header">
                SHOPPING BAG  <span>1 item</span>
            </div>
        </div>
        <div class="col-md-12">
            <div class="bag_item_header">
                <div class="col-md-2">ITEM</div>
                <div class="col-md-4"></div>
                <div class="col-md-2">PRICE</div>
                <div class="col-md-2">QTY</div>
                <div class="col-md-2">SUBTOTAL</div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="bag_item_row">
                <div class="col-md-2">
                    <img src="<?php echo base_url(); ?>/resources/images/video.jpg" style="max-height: 100px;">
                </div>
                <div class="col-md-4 small_text_dark">
                    <div>Womens classic canvas</div>
                    <div>size 22 33 44</div>
                    <div>Colour: RED</div>
                </div>
                <div class="col-md-2 small_text_dark">$33.22</div>
                <div class="col-md-2 small_text_dark">
                    <input class="bag_item_input" value="11">
                    <a href="">Remove</a>
                </div>
                <div class="col-md-2 small_text_dark">asc</div>
            </div>
        </div>
        
        <div class="col-md-5 pull-right">
            <div class="bag_cashbox">
                <div>
                    <div class="col-md-6" style="padding: 20px; border-right: 1px solid #ccc;">
                        subtotal
                    </div>
                    <div class="col-md-6" style="padding: 20px;">
                        34.99 taka
                    </div>
                </div>
                
                <div>
                    <div class="col-md-6" style="border-right: 1px solid #ccc; padding: 20px;">
                        EST SHIPPING
                    </div>
                    <div class="col-md-6" style="padding: 20px;">
                        0.99 taka
                    </div>
                </div>
                
                <div>
                    <div class="col-md-6" style="border: 1px solid #ccc; border-left: 0px; padding: 20px;">
                        TOTAL
                    </div>
                    <div class="col-md-6" style="border: 1px solid #ccc; border-left: 0px;  border-right: 0px;  padding: 20px;">
                        0.99 taka
                    </div>
                </div>
                <div style="width: 80%; margin: 0 auto;">
                    <div style="margin-top: 30px; display: inline-block; width: 100%;">
                        <button class="bag_checkout_button_gr">CHECKOUT</button>
                    </div>
                    <div style="margin-top: 20px; display: inline-block; width: 100%;">
                        <button class="bag_checkout_button_wh">CHECKOUT</button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>