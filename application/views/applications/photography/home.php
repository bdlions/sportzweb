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
.carousel {
width:100%; 
margin:0 auto; /* center your carousel if other than 100% */ 
}
#imgbuttonb{ height: 32px; width: 32px; position: absolute; right: 64px; top: 30px;}
#imgbuttonf{ height: 32px; width: 32px; position: absolute; right: 32px; top: 30px;}
</style>



<div class="row col-md-12">
        <div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
            <div class="carousel-inner">
                <?php if(!empty($image_list)): ?>
                    <?php $i=1; ?>
                    <?php foreach ($image_list as $image_info): ?>
                        <div class="item <?php echo ($i == 1) ? 'active' : ''; ?>">
                            <div  id="div_slider" class="slider-size" style="background-image: url('<?php echo base_url().PHOTOGRAPHY_IMAGE_PATH.$image_info['img'];?>');" >
                               
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
