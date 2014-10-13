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
    <div class="col-md-12" style="margin-top: 20px; margin-bottom: 20px;">
<!--        
        <div style="width: 100%; border: 2px dashed darkslateblue; text-align: center; padding: 40px; background-color: lightcyan">
            carousal here            
        </div>-->
    <div style="height: 300px" id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <?php 
                $counter = 1;
                foreach ($app_data as $key => $value){?>
                    <div class="item <?php if($counter == 1) echo 'active';?>">
                        <img onclick="showmodal('<?php echo $key;?>')" style="height: 300px; width: 100%" src="<?php echo base_url().APPLICATION_DIRECTORY_IMAGE_PATH.$value['img2'];?>" alt="...">
                        <div class="carousel-caption">
                            <?php echo $value['title'];?>
                        </div>
                    </div>
                <?php 
                $counter++;
                } 
                ?>
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
<div class="col-md-12">
    <?php
    $counter = 0;
    foreach($app_data as $application)
    {
        if($counter/2 == 0)
        {
            //echo '<div class="row col-md-12">';
        }
        ?>
        <div class="col-md-6" style="padding-left: 0px; padding-right: 0px;">
            <div class="col-md-12" style="background-color: white; border: 1px solid lightgray; border-radius: 3px; padding: 20px;">
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
        $counter++;
        if($counter/2 == 1)
        {
            //echo '</div>';
        }        
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
    