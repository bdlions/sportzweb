<script src='<?php echo base_url(); ?>resources/js/jquery.zoom.min.js'></script>

<?php $this->load->view("shop/topnav"); ?>

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
            <div>
                <span style="color: limegreen; font-size: 25px; font-weight: bolder;" class="pull-left">
                    content price
                </span>
                <div style="display: inline-block; padding-top: 7px; float: right">
                    <img style="margin: 2px;"src="<?php echo base_url()?>resources/images/vote_star_gray_32.png"/>
                    <img style="margin: 2px;"src="<?php echo base_url()?>resources/images/vote_star_gray_32.png"/>
                    <img style="margin: 2px;"src="<?php echo base_url()?>resources/images/vote_star_gray_32.png"/>
                </div>
            </div>
            <div>
                test
            </div>
            
            <div style="border: 2px solid #5A534C; border-radius: 5px">
                <select>
                    <option value="">asdasc</option>
                    <option value="">zxczxc</option>
                    <option value="">qweqwe</option>
                    <option value="">cazscz</option>
                    <option value="">zxczxc</option>
                </select>
            </div>
        </div>
    </div>
    <div style="margin-top: 15px; border-top: 2px solid #5A534C; padding-top: 15px;">
        <div class="col-md-6">
                        e stitching
            Denser EVA rubber outsole for traction
            Perforated insole for breathability
            Leather TOMS flag tongue logo
        </div>
        <div class="col-md-6">
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