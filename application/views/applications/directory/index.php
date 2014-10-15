<script>
    var allappdata = <?php echo json_encode($app_data)?>;
    function showmodal(app_id)
    {
        $("#sample").html(tmpl("tmpl_display_app_data", allappdata[app_id]));
        $('#modal_viewapp').modal('show');
    }
    
    function add_application_to_user(app_id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url();?>applications/application_directory/add_application_to_user',
            data: {
                app_id: app_id
            },
            success: function(data) {
                alert(data.message);
                window.location = '<?php echo base_url();?>applications/application_directory';
            }
        });
    }
    
    function remove_application_from_user(app_id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url();?>applications/application_directory/remove_application_from_user',
            data: {
                app_id: app_id
            },
            success: function(data) {
                alert(data.message);
                window.location = '<?php echo base_url();?>applications/application_directory';
            }
        });
    }
</script>

<script type="text/x-tmpl" id="tmpl_display_app_data">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 col-sm-2 col-xs-2" >
                <div><img width="100%" src="<?php echo base_url().APPLICATION_DIRECTORY_IMAGE_PATH.'{%= o["img1"]%}'; ?>" class="img-responsive"/></div>
            </div>
            <div class="col-md-9 col-sm-9 col-xs-9" >
                <h3>{%= o['title']%}</h3>
            </div>
        </div>
    </div>
</div>

<div class="modal-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5 col-sm-5 col-xs-5">
                {%=o['summary']%}
            </div>
            {% if(o['gallery_image_list'].length>0){ %}
            <div class="col-md-7 col-sm-7 col-xs-7">
                <div class="row">                    
                    <div class="col-md-12" style="padding-bottom: 15px;">
                        <img id="app_gimgbig" height="300px" width="100%" src="<?php echo base_url().APPLICATION_DIRECTORY_GALLERY_LARGE_IMAGE_PATH.'{%= o["gallery_image_list"][0]%}'; ?>" alt="<?php echo "alt texxt for img"; ?>" />
                    </div>
                    {% for (var i=0; i<o['gallery_image_list'].length; i++) { %}
                       <div class="col-md-3 col-sm-3 col-xs-3">
                            <img onclick='document.getElementById("app_gimgbig").src="<?php echo base_url().APPLICATION_DIRECTORY_GALLERY_LARGE_IMAGE_PATH.'{%= o["gallery_image_list"][i]%}'; ?>"' width="100%" height="64px" src="<?php echo base_url().APPLICATION_DIRECTORY_GALLERY_SMALL_IMAGE_PATH.'{%= o["gallery_image_list"][i]%}'; ?>" />
                        </div>
                    {% } %}                    
                </div>
            </div>
            {% } %}
        </div>
    </div>
</div>
</script>


    <div class="col-md-12">
        <h2>App directory</h2>
        <div>Be more productive with applications.</div>
    </div>
    


<script type="text/javascript" src="<?php echo base_url()?>resources/js/jssor.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>resources/js/jssor.slider.mini.js"></script>
<script>

    jQuery(document).ready(function ($) {
        var options = {
            $AutoPlay: true,

            $PauseOnHover: true,                               //[Optional] Whether to pause when mouse over if a slideshow is auto playing, default value is false

            $ArrowKeyNavigation: true,   			            //Allows arrow key to navigate or not
            $SlideWidth: 800,                                   //[Optional] Width of every slide in pixels, the default is width of 'slides' container
            //$SlideHeight: 300,                                  //[Optional] Height of every slide in pixels, the default is width of 'slides' container
            $SlideSpacing: 0, 					                //Space between each slide in pixels
            $DisplayPieces: 2,                                  //Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
            $ParkingPosition: 170,                                //The offset position to park slide (this options applys only when slideshow disabled).

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
                jssor_slider1.$ScaleWidth(Math.min(parentWidth, 1140));
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


<!--NEW CAROUSEL-->
<div class="col-md-12" style="margin-bottom: 25px">

<!--<div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 800px; height: 300px; overflow: hidden;">-->
<div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 1140px; height: 300px; overflow: hidden;">
        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1140px; height: 300px;
            overflow: hidden;">
  
            <?php foreach ($app_data as $key => $value):?>
                    <div>
                        <img u="image" onclick="showmodal('<?php echo $key;?>')" style="height: 300px; width: 100%" src="<?php echo base_url().APPLICATION_DIRECTORY_IMAGE_PATH.$value['img2'];?>" alt="...">
                        <div class="carousel-caption">
                            <?php echo $value['title'];?>
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










<!--APPLICATIONS-->
<div class="col-md-12">
    <?php
    $total_apps = count($app_data);
    $counter = 0;
    foreach($app_data as $application)
    {
        if($counter%2 == 0)
        {
            echo '<div class="row" style="padding:0px;margin:5px;">';
        }
        if($counter%2 == 0)
        {
            echo '<div class="col-md-6" style="padding-left: 0px; padding-right: 0px; margin-right: -1px">';
        }
        else
        {
            echo '<div class="col-md-6" style="padding-left: 10px; padding-right: 0px; margin-right: -1px">';
        }
        ?>
        
            <div class="col-md-12" style="background-color: white; border: 1px solid lightgray; box-sizing: border-box; margin: -1px; padding: 20px;">
                <div class="col-md-12" style="padding: 5px 0px 5px;">
                    <div class="col-md-2" style="padding: 0px;">
                        <img width="100%" class="image-responsive" src="<?php echo base_url().APPLICATION_DIRECTORY_IMAGE_PATH.$application['img1'];?>"/>
                    </div>
                    <div class="col-md-8">
                        <div>
                            <a href="#"><span style="font-size: 15px;"><?php echo $application['title'];?></span></a>
                        </div>
                        <div>
                            <span style="font-size: 12px;"><?php echo $application['description'];?></span>
                        </div>
                    </div>
                    <div class="col-md-2" style="padding: 0px;">
                        <?php
                        if($application['is_removed'] == 1){
                        ?>
                        <button onclick="remove_application_from_user('<?php echo $application['id'];?>')" class="btn btn-default pull-right" style="color: white; background-color: #0072C3;">Remove</button>
                        <?php
                        }else{
                        ?>
                        <button onclick="add_application_to_user('<?php echo $application['id'];?>')" class="btn btn-default pull-right" style="color: white; background-color: #0072C3;">Try it</button>
                        <?php    
                        }
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
        <?php
        
        if($counter%2 == 1 || $counter == $total_apps)
        {
            echo '</div>';
        }  
        $counter++;
    }
    ?>
</div>    
    <!-- Modal -->
    <div class="modal fade" id="modal_viewapp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 70%">
            <div class="modal-content" id="sample">
              
            </div>
        </div>
    </div>
    