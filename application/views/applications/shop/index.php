<?php $this->load->view("applications/shop/templates/topnav"); ?>
<?php // $this->load->view("applications/shop/templates/breadcrumb"); ?>

<div class="row">
    <div class="col-md-12" style="margin-top: 20px; margin-bottom: 20px;">
        <div style="height: 400px" id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <img style="height: 400px; width: 100%" src="<?php echo base_url()?>resources/images/index1375310938.jpg" alt="...">
                    <div class="carousel-caption">
                        cap a
                    </div>
                </div>
                <div class="item">
                    <img style="height: 400px; width: 100%" src="<?php echo base_url()?>resources/images/fitness.jpg" alt="...">
                    <div class="carousel-caption">
                        cap a
                    </div>
                </div>
                <div class="item">
                    <img style="height: 400px; width: 100%" src="<?php echo base_url()?>resources/images/89801090_l.jpg" alt="...">
                    <div class="carousel-caption">
                        cap a
                    </div>
                </div>
            </div>
            <!-- Controls -->
             <a  href="#carousel-example-generic" data-slide="next">
            <!--<span class="glyphicon glyphicon-chevron-left"></span>-->
            <img class="imgbuttonf" src="<?php echo base_url(); ?>resources/images/frontArrow.png" onclick=""/>
        </a>
        <a  href="#carousel-example-generic" data-slide="prev">
            <!--<span class="glyphicon glyphicon-chevron-right"></span>-->
            <img class="imgbuttonb" src="<?php echo base_url(); ?>resources/images/backArrow.png" onclick=""/>
        </a>
            
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


<!--BEST SELLERS-->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 page_section_heading heading_medium" >
            BEST SELLERS
        </div>
    </div>
    <div style="">
        <div style="min-height: 200px" id="carousel-bestsellers" class="carousel slide" data-ride="carousel" data-interval="false">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-bestsellers" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-bestsellers" data-slide-to="1"></li>
                <li data-target="#carousel-bestsellers" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                
                <div class="item active">
                    <div class="col-md-3 col-xs-3 col-sm-3">
                        <div class="item_card">
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
                        <div class="item_card">
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
                        <div class="item_card">
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
                        <div class="item_card">
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
                <div class="item">
                    <div class="col-md-3 col-xs-3 col-sm-3">
                        <div class="item_card">
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
                <div class="item">
                    <div style="background: orangered; height: 201px">
                        
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-bestsellers" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-bestsellers" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div>
</div>
<!--<div class="mega_nav_tray container-fluid">
    <div class="row">
        <div style="height: 222px">
            
        </div>
    </div>
</div>-->

<script>

    function confirmation_vote(league_id)
    {
        $("#league_id").val(league_id);
        $("#confirmModal").modal("show");
    }
    function post_vote()
    {
        var league_id = $("#league_id").val();
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>' + "asdasd/application/xstreambanter/post_vote",
                dataType: 'json',
                data: {
                    league_id: league_id
                },
                success: function(data) {
                    location.reload();
                }
            });
    }
</script>
