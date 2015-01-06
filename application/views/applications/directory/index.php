<script>
    var allappdata = <?php echo json_encode($app_data)?>;
    function showmodal(app_id)
    {
        $("#sample").html(tmpl("tmpl_display_app_data", allappdata[app_id]));
        $("#div_summary").html(allappdata[app_id]['summary']);
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
            <div class="col-md-5 col-sm-5 col-xs-5" id="div_summary">
                
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
        
    </div>
<script type="text/javascript" src="<?php echo base_url()?>resources/js/jquery.featureCarousel.js" charset="utf-8"></script>
<script type="text/javascript">
      $(document).ready(function() {
        var carousel = $("#carousel").featureCarousel({
          // include options like this:
          // (use quotes only for string values, and no trailing comma after last option)
          // option: value,
          // option: value
        });

        $("#but_prev").click(function () {
          carousel.prev();
        });
        $("#but_pause").click(function () {
          carousel.pause();
        });
        $("#but_start").click(function () {
          carousel.start();
        });
        $("#but_next").click(function () {
          carousel.next();
        });
      });
    </script>
    <style>
/********************
 * FEATURE CAROUSEL *
********************/
.carousel-container {
  position:relative;
  width:960px;
}
#carousel {
  height:260px;
  /*background-color:#CCC;*/
  position:relative;
  margin-bottom:0.5em;
  font-size:12px;
  font-family: Arial;
}
.carousel-image {
    height: 250px;
    width: 500px;
  /*border:0;*/
  display:block;
}
.carousel-feature {
  position:absolute;
  top:-1000px;
  left:-1000px;
  /*border:2px solid #5d5d5d;*/
  cursor:pointer;
}
.carousel-feature .carousel-caption {
  position:absolute;
  bottom:0;
  width:100%;
  background-color:#000;
}
.carousel-feature .carousel-caption p {
  /*margin:0;*/
  padding:5px;
  font-weight:bold;
  font-size:12px;
  color:white;
}
.tracker-summation-container {
  position:absolute;
  color:transparent;
  right:48px;
  top:230px;
  padding:3px;
  margin:3px;
  background-color:transparent;
}
.tracker-individual-container {
  position:absolute;
  color:transparent;
  right:48px;
  top:210px;
  padding:0;
  margin:0;
}
.tracker-individual-container li {
  list-style:none;
}
.tracker-individual-container .tracker-individual-blip {
  margin:0 3px;
  padding:0 3px;
  color:transparent;
  text-align:center;
  background-color:transparent;
}
.tracker-individual-container .tracker-individual-blip-selected {
  color:transparent;
  font-weight:bold;
  background-color:transparent;
}
#carousel-left {
  position:absolute;
  bottom:33px;
  left:220px;
  cursor:pointer;
}
#carousel-right img,  
#carousel-left img 
{
    height: 30px;
}
#carousel-right {
  position:absolute;
  bottom:33px;
  right:220px;
  cursor:pointer;
}
.carousel-feature .carousel-caption p {
    padding: 0px;
}
.carousel-caption{
    left:0px;
    height: 20px;
    padding-bottom: 40px;
}
    </style>

<!--NEW CAROUSEL-->
<div class="col-md-12" style="margin-bottom: 25px">
    <div class="carousel-container" style="width: 100%">
        <div id="carousel" style="width: 100%">
<!--            <div class="carousel-feature">
                <a href="#">
                    <img class="carousel-image" alt="Image Caption" src="<?php echo base_url()?>/resources/images/face.jpg">
                </a>
            </div>-->
            <?php foreach ($app_data as $application):?>
            <div class="carousel-feature">
                <img class="carousel-image" onclick="showmodal('<?php echo $application["id"];?>')" src="<?php echo base_url().APPLICATION_DIRECTORY_IMAGE_PATH.$application['img2'];?>" alt="image not found">
                <div class="carousel-caption">
                    <p>
                      Caption here Caption here Caption here Caption here Caption here 
                    </p>
              </div>
            </div>
            <?php endforeach;?>
        </div>
        <div id="carousel-left"><img src="<?php echo base_url()?>/resources/images/backArrow.png" /></div>
        <div id="carousel-right"><img src="<?php echo base_url()?>/resources/images/frontArrow.png" /></div>
    </div>
    
</div>









<div class='col-md-12'>
    <h3>Featured apps</h3>
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
            echo '<div class="row" style="padding:0px;margin:0px;">';
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
    <style>
        .hover_color
        {
            background-color: white;
        }
        .hover_color:hover
        {
            background-color: #EFEFEF;
        }
    </style>
            <div class="col-md-12 hover_color" style="border: 1px solid lightgray; box-sizing: border-box; margin: -1px; padding: 20px;">
                <div class="col-md-12" style="padding: 5px 0px 5px;" onclick="showmodal('<?php echo $application["id"];?>')">
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
    