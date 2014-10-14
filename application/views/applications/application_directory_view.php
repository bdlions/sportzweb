<script>
    var allappdata = <?php echo json_encode($app_data)?>;
    function showmodal(appid)
    {
        $("#sample").html(tmpl("tmpl_display_app_data", allappdata[appid]));
        $('#modal_viewapp').modal('show');
    }
</script>

<script type="text/x-tmpl" id="tmpl_display_app_data">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2" >
                <div><img width="100%" src="{%= o['img1']%}" class="img-responsive"/></div>
            </div>
            <div class="col-md-9 col-sm-9 col-xs-9" >
                <h3>{%= o['app_name']%}</h3>
                <span>{%= o['app_desc']%}</span>
            </div>
        </div>
    </div>
</div>

<div class="modal-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5 col-sm-5 col-xs-5">
                <span>{%=o['desc']%}</span>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-7">
                <div class="row">

                    <div class="col-md-12" style="padding-bottom: 15px;">
                        <img id="app_gimgbig" height="300px" width="100%" src="{%=o['gal_img1']%}" alt="<?php echo "alt texxt for img"; ?>" />
                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <img onclick='document.getElementById("app_gimgbig").src="{%=o['gal_img1']%}"' width="100%" height="64px" src="{%=o['gal_img1']%}" />
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <img onclick='document.getElementById("app_gimgbig").src="{%=o['gal_img2']%}"' width="100%" height="64px" src="{%=o['gal_img2']%}" />
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <img onclick='document.getElementById("app_gimgbig").src="{%=o['gal_img3']%}"' width="100%" height="64px" src="{%=o['gal_img3']%}" />
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <img onclick='document.getElementById("app_gimgbig").src="{%=o['gal_img4']%}"' width="100%" height="64px" src="{%=o['gal_img4']%}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</script>

<!-- use jssor.slider.mini.js (40KB) or jssor.sliderc.mini.js (32KB, with caption, no slideshow) or jssor.sliders.mini.js (28KB, no caption, no slideshow) instead for release -->
<!-- jssor.slider.mini.js = jssor.sliderc.mini.js = jssor.sliders.mini.js = (jssor.js + jssor.slider.js) -->
<script type="text/javascript" src="<?php echo base_url()?>resources/js/jssor.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>resources/js/jssor.slider.mini.js"></script>
<script>

    jQuery(document).ready(function ($) {
        var options = {
            $AutoPlay: true,

            $PauseOnHover: true,                               //[Optional] Whether to pause when mouse over if a slideshow is auto playing, default value is false

            $ArrowKeyNavigation: true,   			            //Allows arrow key to navigate or not
            $SlideWidth: 600,                                   //[Optional] Width of every slide in pixels, the default is width of 'slides' container
            //$SlideHeight: 300,                                  //[Optional] Height of every slide in pixels, the default is width of 'slides' container
            $SlideSpacing: 0, 					                //Space between each slide in pixels
            $DisplayPieces: 2,                                  //Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
            $ParkingPosition: 100,                                //The offset position to park slide (this options applys only when slideshow disabled).

            $ArrowNavigatorOptions: {                       //[Optional] Options to specify and enable arrow navigator or not
                $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
            }
        };

        var jssor_slider1 = new $JssorSlider$("slider1_container", options);

        //responsive code begin
        //you can remove responsive code if you don't want the slider scales while window resizes
        function ScaleSlider() {
            var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
            if (parentWidth)
                jssor_slider1.$ScaleWidth(Math.min(parentWidth, 800));
            else
                window.setTimeout(ScaleSlider, 30);
        }

        ScaleSlider();

        if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
            $(window).bind('resize', ScaleSlider);
        }


        //if (navigator.userAgent.match(/(iPhone|iPod|iPad)/)) {
        //    $(window).bind("orientationchange", ScaleSlider);
        //}
        //responsive code end
    });
</script>


    <div class="col-md-12">
        <h2>App directory</h2>
        <div>Be more productive with applications.</div>
    </div>
    <div class="col-md-12" style="margin-top: 20px; margin-bottom: 20px;">
<!--        
        <div style="width: 100%; border: 2px dashed darkslateblue; text-align: center; padding: 40px; background-color: lightcyan">
            carousal here            
        </div>-->
        <div style="height: 300px" id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <?php foreach ($app_data as $key => $value):?>
                    <div class="item <?php if($key=='0') echo 'active';?>">
                        <img onclick="showmodal('<?php echo $key;?>')" style="height: 300px; width: 100%" src="<?php echo $value['img1'];?>" alt="...">
                        <div class="carousel-caption">
                            cap a, <?php echo $value['app_name'];?>, <?php echo $key;?>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div>



<div class="col-md-9 col-md-offset-2" style="margin-bottom: 25px">

<!--NEW CAROUSEL-->
<!--<div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 800px; height: 300px; overflow: hidden;">-->
<div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 800px; height: 300px; overflow: hidden;">
        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 800px; height: 300px;
            overflow: hidden;">
<!--            <div><img u="image" src="../img/photography/002.jpg" /></div>
            <div><img u="image" src="../img/photography/003.jpg" /></div>
            <div><img u="image" src="../img/photography/004.jpg" /></div>
            <div><img u="image" src="../img/photography/005.jpg" /></div>
            <div><img u="image" src="../img/photography/006.jpg" /></div>
            <div><img u="image" src="../img/photography/007.jpg" /></div>
            <div><img u="image" src="../img/photography/008.jpg" /></div>
            <div><img u="image" src="../img/photography/009.jpg" /></div>-->
            
            
            <?php foreach ($app_data as $key => $value):?>
                    <div>
                        <img u="image" onclick="showmodal('<?php echo $key;?>')" style="height: 300px; width: 100%" src="<?php echo $value['img1'];?>" alt="...">
                        <div class="carousel-caption">
                            cap a, <?php echo $value['app_name'];?>, <?php echo $key;?>
                        </div>
                    </div>
                <?php endforeach;?>
            
            
        </div>

        <!-- Arrow Navigator Skin Begin -->
        <style>
            /* jssor slider arrow navigator skin 13 css */
            /*
            .jssora13l              (normal)
            .jssora13r              (normal)
            .jssora13l:hover        (normal mouseover)
            .jssora13r:hover        (normal mouseover)
            .jssora13ldn            (mousedown)
            .jssora13rdn            (mousedown)
            */
            .jssora13l, .jssora13r, .jssora13ldn, .jssora13rdn {
                position: absolute;
                cursor: pointer;
                display: block;
                background: url(<?php echo base_url()?>/resources/images/a13.png) no-repeat ;
                overflow: hidden;
            }

            .jssora13l {
                background-position: -10px -35px;
            }

            .jssora13r {
                background-position: -70px -35px;
            }

            .jssora13l:hover {
                background-position: -130px -35px;
            }

            .jssora13r:hover {
                background-position: -190px -35px;
            }

            .jssora13ldn {
                background-position: -250px -35px;
            }

            .jssora13rdn {
                background-position: -310px -35px;
            }
        </style>
        <!-- Arrow Left -->
        <span u="arrowleft" class="jssora13l" style="width: 40px; height: 50px; top: 123px; left: 30px;">
        </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora13r" style="width: 40px; height: 50px; top: 123px; right: 30px">
        </span>
        <!-- Arrow Navigator Skin End -->
        <a style="display: none" href="http://www.jssor.com">jquery slider example</a>
    </div>
</div>







    <div class="col-md-12">
        
        <!--Left column-->
        <div class="col-md-6" style="padding-left: 0px; padding-right: 8px;">
            <div class="col-md-12" style="background-color: white; border: 1px solid lightgray; border-radius: 3px; padding: 20px;">
                <?php $length = sizeof($app_data);?>
                <?php $mid = (int)($length/2)+1;?>
                <?php $app_data1 = array_slice($app_data, 0, $mid);?>
                <?php $app_data2 = array_slice($app_data, $mid);?>
                <?php foreach ($app_data1 as $app1):?>
                    <div class="col-md-12" style="padding: 5px 0px 5px;">
                        <div class="col-md-2" style="padding: 0px;">
                            <img width="100%" class="image-responsive" src="<?php echo $app1['img1'];?>"/>
                        </div>
                        <div class="col-md-8">
                            <div>
                                <a href="#"><span style="font-size: 15px;"><?php echo $app1['app_name'];?></span></a>
                            </div>
                            <div>
                                <span style="font-size: 12px;"><?php echo $app1['desc'];?></span>
                            </div>
                        </div>
                        <div class="col-md-2" style="padding: 0px;">
                            <button class="btn btn-default pull-right" style="color: white; background-color: #0072C3;"><?php echo $app1['btn_state'];?></button>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
        
        <!--Right column-->
        <div class="col-md-6" style="padding-left: 0px; padding-right: 8px;">
            <div class="col-md-12" style="background-color: white; border: 1px solid lightgray; border-radius: 3px; padding: 20px;">
                                
                <?php foreach ($app_data2 as $app):?>
                    <div class="col-md-12" style="padding: 5px 0px 5px;">
                        <div class="col-md-2" style="padding: 0px;">
                            <img width="100%" class="image-responsive" src="<?php echo $app['img1'];?>"/>
                        </div>
                        <div class="col-md-8">
                            <div>
                                <a href="#"><span style="font-size: 15px;"><?php echo $app['app_name'];?></span></a>
                            </div>
                            <div>
                                <span style="font-size: 12px;"><?php echo $app['desc'];?></span>
                            </div>
                        </div>
                        <div class="col-md-2" style="padding: 0px;">
                            <button class="btn btn-default pull-right" style="color: white; background-color: #0072C3;"><?php echo $app['btn_state'];?></button>
                        </div>
                    </div>
                <?php endforeach;?>
                
            </div>
        </div>
    </div>
    
    
    <!-- Modal -->
    <div class="modal fade" id="modal_viewapp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 70%">
            <div class="modal-content" id="sample">
              
            </div>
        </div>
    </div>
    