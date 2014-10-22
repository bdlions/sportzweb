<?php $this->load->view("toms/topnav"); ?>

<div class="row">
    
    <!--VERTI MENU-->
    <div id="left_menu" class="col-md-3 pull-left">
        
        <!--MENU BOXES-->
        <div class="menubox">
            <div class="expandable">
                first
                <div class="plus_minus pull-right">+</div>
            </div>            
            <div class="collupsible">
                <div>first item </div>
                <div>first item </div>
                <div>first item </div>
                <div>first item </div>
                <div>first item </div>
            </div>
        </div>
        
        <div class="menubox">
            <div class="expandable">
                Second
                <div class="plus_minus pull-right">+</div>
            </div>            
            <div class="collupsible">
                <div>first item </div>
                <div>first item </div>
                <div>first item </div>
                <div>first item </div>
                <div>first item </div>
            </div>
        </div>
        <div>
            <div class="menubox">
                <div class="expandable">
                    inner
                    <div class="plus_minus pull-right">+</div>
                </div>            
                <div class="collupsible">
                    <div>first item </div>
                    <div>first item </div>
                    <div>first item </div>
                    <div>first item </div>
                    <div>first item </div>
                </div>
            </div>
            <div class="menubox">
                <div class="expandable">
                    inner
                    <div class="plus_minus pull-right">+</div>                
                </div>            
                <div class="collupsible">
                    <div>first item </div>
                    <div>first item </div>
                    <div>first item </div>
                    <div>first item </div>
                    <div>first item </div>
                </div>
            </div>
            <div class="menubox">
                <div class="expandable">
                    inner
                    <div class="plus_minus pull-right">+</div>
                </div>            
                <div class="collupsible">
                    <div>first item </div>
                    <div>first item </div>
                    <div>first item </div>
                    <div>first item </div>
                    <div>first item </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <!--ITEMS-->
    <div class="col-md-8 pull-right">
        <div class="container-fluid ">
            <div class="row">
                <div class="col-md-3 col-xs-3 col-sm-3">
                    <div class="row item_card">
                        <div class="col-md-12" >
                            <img class="" src="<?php echo base_url() ?>resources/images/video.jpg" />
                        </div>
                        <div class="col-md-12" >
                            BEST SELLERS
                            BEST SELLERS
                            BEST SELLERS
                            BEST SELLERS
                            <span>BEST SELLERS</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-3 col-sm-3">
                    <div class="row item_card">
                        <div class="col-md-12" >
                            <img class="" src="<?php echo base_url() ?>resources/images/video.jpg" />
                        </div>
                        <div class="col-md-12" >
                            BEST SELLERS
                            BEST SELLERS
                            BEST SELLERS
                            BEST SELLERS
                            <span>BEST SELLERS</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-3 col-sm-3">
                    <div class="row item_card">
                        <div class="col-md-12" >
                            <img class="" src="<?php echo base_url() ?>resources/images/video.jpg" />
                        </div>
                        <div class="col-md-12" >
                            BEST SELLERS
                            BEST SELLERS
                            BEST SELLERS
                            BEST SELLERS
                            <span>BEST SELLERS</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-3 col-sm-3">
                    <div class="row item_card">
                        <div class="col-md-12" >
                            <img class="" src="<?php echo base_url() ?>resources/images/video.jpg" />
                        </div>
                        <div class="col-md-12" >
                            BEST SELLERS
                            BEST SELLERS
                            BEST SELLERS
                            BEST SELLERS
                            <span>BEST SELLERS</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!--TEST ITEMCARD-->
<div class="container-fluid ">
    <div class="row">
        <div class="col-md-3 col-xs-3 col-sm-3">
            <div class="row item_card">
                <div class="col-md-12" >
                    <img class="" src="<?php echo base_url()?>resources/images/video.jpg" />
                </div>
                <div class="col-md-12" >
                    BEST SELLERS
                    BEST SELLERS
                    BEST SELLERS
                    BEST SELLERS
                    <span>BEST SELLERS</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.expandable').each(function(){
        if ($(this).siblings('.collupsible:first').is(":visible")) {
            $(this).children(".plus_minus").text("--");
        }
        else {
            $(this).children(".plus_minus").text("+");
        }
    });
    $('.expandable').click(function(){
        var collup_var = $(this).siblings('.collupsible:first');
            collup_var.toggle();
            if (collup_var.is(":visible")) {
                $(this).children(".plus_minus").text("--");
            }
            else {
                $(this).children(".plus_minus").text("+");
            }
//                $(this).siblings('.collupsible:first').slideToggle();
        }
    );
</script>