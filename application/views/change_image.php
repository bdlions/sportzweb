<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<style type="text/css">
h2{
    margin: 0;     
    color: #666;
    padding-top: 90px;
    font-size: 52px;
    font-family: "trebuchet ms", sans-serif;    
}
.item{
  
    text-align: center;
    height: 600px !important;
}
.carousel{
    margin-top: 20px;
}
.bs-example{
	margin: 20px;
}
.slider-size {
height: 600px; /* This is your slider height */
}
.carousel {
width:100%; 
margin:0 auto; /* center your carousel if other than 100% */ 
}
</style>



<div class="col-md-6">
<div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
    <!-- Carousel indicators -->
    <!--<ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="1" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
        <li data-target="#myCarousel" data-slide-to="4"></li>
    </ol>   
    <!-- Carousel items -->
    <div class="carousel-inner" style="height: 50%">
        <div class="item active">
            <div style="background:url(<?php echo base_url() ?>resources/images/applications/news_app/news/1.jpg); background-size:cover;" class="slider-size">
                <h2>Slide 1</h2>
                <div class="carousel-caption">
                  <h3>First slide label</h3>
                  <p>Lorem ipsum dolor sit amet consectetur…</p>
                </div>
            </div>
        </div>
        <div class="item">
            <div style="background:url(<?php echo base_url() ?>resources/images/applications/news_app/news/2.jpg); background-size:cover;" class="slider-size">
                <h2>Slide 2</h2>
                <div class="carousel-caption">
                  <h3>Second slide label</h3>
                  <p>Aliquam sit amet gravida nibh, facilisis gravida…</p>
                </div>
            </div>
        </div>
        <div class="item">
            <div style="background:url(<?php echo base_url() ?>resources/images/applications/news_app/news/3.jpg) ; background-size:cover;" class="slider-size">
                <h2>Slide 3</h2>
                <div class="carousel-caption">
                  <h3>Third slide label</h3>
                  <p>Praesent commodo cursus magna vel…</p>
                </div>
            </div>
        </div>
        <div class="item">
            <div style="background:url(<?php echo base_url() ?>resources/images/applications/news_app/news/4.jpg); background-size:cover;" class="slider-size">
                <h2>Slide 4</h2>
                <div class="carousel-caption">
                  <h3>Third slide label</h3>
                  <p>Praesent commodo cursus magna vel…</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel nav -->
    <a class="carousel-control left" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="carousel-control right" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
     $("#myCarousel").carousel({
         interval : false,
         pause: false
     });
});
</script>