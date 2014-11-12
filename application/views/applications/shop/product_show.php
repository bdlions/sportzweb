<script src='<?php echo base_url(); ?>resources/js/jquery.zoom.min.js'></script>

<?php $this->load->view("applications/shop/templates/topnav"); ?>
<?php //$this->load->view("shop/breadcrumb"); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-7">
            <div class="zoom" id="ex1">
                <img style="max-height: 400px; width: 100%" id="itm_img_big" src="<?php echo base_url()?>resources/images/index1375310938.jpg" />
            </div>
            <div class="row" style="margin-top: 20px">
                <div class="col-md-2"><img width="100%" onclick='clicked_img1()' class="img-responsive" src="<?php echo base_url()?>resources/images/index1375310938.jpg" /></div>
                <div class="col-md-2"><img width="100%" onclick='clicked_img2()' class="img-responsive" src="<?php echo base_url()?>resources/images/video.jpg" /></div>
            </div>
        </div>
        <div class="col-md-4 pull-right">
            <div class="page_section_heading" style="margin-top: 50px">
                Brown Chambray Men's Brogues
            </div>
            <div style="display: inline-block; width: 100%">
                <span style="color: #5ACB89; font-size: 25px; font-weight: bolder;" class="pull-left">
                    £39.99
                </span>
                <div style="display: inline-block; padding-top: 7px; float: right">
                    <img style="margin: 2px;"src="<?php echo base_url()?>resources/images/vote_star_gray_32.png"/>
                    <img style="margin: 2px;"src="<?php echo base_url()?>resources/images/vote_star_gray_32.png"/>
                    <img style="margin: 2px;"src="<?php echo base_url()?>resources/images/vote_star_gray_32.png"/>
                </div>
            </div>
            <div class="cart_dropdown">
                <select>
                    <option value="">asdasc</option>
                    <option value="">zxczxc</option>
                    <option value="">qweqwe</option>
                    <option value="">cazscz</option>
                    <option value="">zxczxc</option>
                </select>
            </div>
            <div class="cart_dropdown">
                <select>
                    <option value="">asdasc</option>
                    <option value="">zxczxc</option>
                    <option value="">qweqwe</option>
                    <option value="">cazscz</option>
                    <option value="">zxczxc</option>
                </select>
            </div>
            <div class="cart_dropdown">
                <select style="width: 20%; border: 2px solid #5ACB89; float: left">
                    <option value="">1</option>
                    <option value="">zxczxc</option>
                    <option value="">qweqwe</option>
                    <option value="">cazscz</option>
                    <option value="">zxczxc</option>
                </select>
                <div class="add_to_cart">
                    Add to cart
                </div>                
            </div>
        </div>
    </div>
    <div class="page_section"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="page_section_subheading">
                    DETAILS
                </div>
                e stitching
                Denser EVA rubber outsole for traction
                Perforated insole for breathability
                Leather TOMS flag tongue logo
            </div>
            <div class="col-md-6">
                <div class="page_section_subheading">
                    Sizing
                </div>
                e stitching
                Denser EVA rubber outsole for traction
                Perforated insole for breathability
                Leather TOMS flag tongue logoe stitching
                Denser EVA rubber outsole for traction
                Perforated insole for breathability
                Leather TOMS flag tongue logo
            </div>
        </div>
    </div>
    <div class="page_section"></div>

    <div class="row">
        <div class="page_section_heading">
            You might also like
            <div class="row" style="padding-top: 30px">
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
<script>
    $(document).ready(function(){
            $('#ex1').zoom();
    });
    function clicked_img1()
    {
        document.getElementById("itm_img_big").src="<?php echo base_url()?>resources/images/index1375310938.jpg";
        $('#ex1').zoom();
    }
    function clicked_img2()
    {
        document.getElementById("itm_img_big").src="<?php echo base_url()?>resources/images/video.jpg";
        $('#ex1').zoom();
    }
</script>