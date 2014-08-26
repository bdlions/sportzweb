<style type="text/css">

.item{
  
    text-align: center;
    height: 100% !important;
}
.carousel{
    margin-top: 20px;
}
.bs-example{
	margin: 20px;
}
.slider-size {
    //min-height: 200px;
    background-size: 100% 100%;
    background-repeat: no-repeat;
    
}
.overimgtext2
{
    position: absolute;
    bottom: 5%; 
    /*border: 2px solid #75B3E6;*/
    background:rgba(100,100,111,0.6); 
    width: 97%;
    color: white;
    font-size: larger; 
    text-align: center;
    padding: 12px;
}
.overimgtext
{
    position: absolute;
    top: 85%; 
    background:rgba(100,100,111,0.6); 
    width: 100%;
    color: white;
    font-size: larger; 
    text-align: center;
    padding: 12px;
}
.carousel {
width:100%; 
margin:0 auto; /* center your carousel if other than 100% */ 
}
#imgbuttonb{ height: 32px; width: 32px; position: absolute; right: 64px; top: 30px;}
#imgbuttonf{ height: 32px; width: 32px; position: absolute; right: 32px; top: 30px;}
.overimgtext{
        position: absolute;
        bottom: 5%; 
        /*border: 2px solid #75B3E6;*/
        background:rgba(100,100,111,0.6); 
        width: 100%;
        color: white;
        font-size: larger; 
        text-align: center;
        padding: 12px;
    }
</style>

<div class="row col-md-12">
    <div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
        <div class="carousel-inner">
            <?php if (!empty($image_list)): ?>
                <?php $i = 1; ?>
                <?php foreach ($image_list as $image_info): ?>
                    <div class="item <?php echo ($i == 1) ? 'active' : ''; ?>">
                        <div  id="div_slider" class="slider-size" style="background-image: url('<?php echo base_url() . PHOTOGRAPHY_IMAGE_PATH . $image_info['img']; ?>');" >
                            <div class="col-md-12 col-sm-12 col-xs-12 overimgtext">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <span><?php echo $image_info['text1']; ?></br><?php echo $image_info['text2']; ?></span>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <span><?php echo $image_info['text3']; ?></br><?php echo $image_info['text4']; ?></span>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <span><?php echo $image_info['text5']; ?></br><?php echo $image_info['text6']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $i++; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div> 
        <a href="#myCarousel" data-slide="next">
            <!--<span class="glyphicon glyphicon-chevron-left"></span>-->
            <img id="imgbuttonf" src="<?php echo base_url(); ?>resources/images/frontArrow.png" onclick=""/>
        </a>
        <a  href="#myCarousel" data-slide="prev">
            <!--<span class="glyphicon glyphicon-chevron-right"></span>-->
            <img id="imgbuttonb" src="<?php echo base_url(); ?>resources/images/backArrow.png" onclick=""/>
        </a>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
     $("div.item").each(function(){
        $(this).find('div').height($(window).height()-$("body nav").height()-20);
     });
     $("#myCarousel").carousel({
         interval : false,
         pause: false
     });
});
</script>
