<script>
    var allappdata = <?php echo json_encode($app_data)?>;
    function showmodal(appid)
    {
        var img1 = allappdata[appid]['img1'];
        var img2 = allappdata[appid]['img2'];
        var gal_img1 = allappdata[appid]['gal_img1'];
        var gal_img2 = allappdata[appid]['gal_img2'];
        var gal_img3 = allappdata[appid]['gal_img3'];
        var gal_img4 = allappdata[appid]['gal_img4'];
        var appname = allappdata[appid]['app_name'];
        var appdesc = allappdata[appid]['desc'];
        var appdesc = allappdata[appid]['desc'];
//        alert(appname);
//        $("#tbody_product_list").html()
        $('#am_img1').html('<img width="100%" src="'+img1+'" class="img-responsive"/>');
        $('#am_title').text(appname);
        $('#am_desc').text(appdesc);
        $('#am_details').text('added text mu ha ha ah hahah ah ah ah a a haa appdesc');
//        $('#am_desc').html('<img width="100%" height="100px" src="'+gal_img1+'" class="img-responsive"/>');
        $('#app_gimg1big').html('<img width="100%" src="'+gal_img1+'" class="img-responsive"/>');
        $('#app_gimg1').html('<img width="100%" src="'+gal_img1+'" class="img-responsive"/>');
        $('#app_gimg2').html('<img width="100%" src="'+gal_img2+'" class="img-responsive"/>');
        $('#app_gimg3').html('<img width="100%" src="'+gal_img3+'" class="img-responsive"/>');
        $('#app_gimg4').html('<img width="100%" src="'+gal_img4+'" class="img-responsive"/>');
        
        $('#modal_viewapp').modal('show');
    }
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
            <!-- Indicators -->
<!--            
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol>-->

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
    <div class="col-md-12">
        
        <!--Left column-->
        <div class="col-md-6" style="padding-left: 0px; padding-right: 8px;">
            <div class="col-md-12" style="background-color: white; border: 1px solid lightgray; border-radius: 3px; padding: 20px;">
                <?php $length = sizeof($app_data);?>
                <?php $app_data1 = array_slice($app_data, 0, $length/2);?>
                <?php $app_data2 = array_slice($app_data, $length/2, $length);?>
                <?php foreach ($app_data1 as $app):?>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3" >
                                <div id="am_img1"></div>
                                <!--<img style="width: 100%" src="<?php echo base_url(); ?>resources/images/face.jpg" class="img-responsive" alt="<?php echo "alt texxt for img"; ?>" />-->
                            </div>
                            <div class="col-md-8" >
                                <h3 id="am_title"></h3>
                                <span id="am_desc"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <span id="am_details"></span>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    
                                    <div class="col-md-12" style="padding-bottom: 15px;">
                                        <div id="app_gimg1big"></div>
                                        <!--<img width="100%" src="<?php echo base_url(); ?>resources/images/golf.jpg" class="img-responsive" alt="<?php echo "alt texxt for img"; ?>" />-->
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div id="app_gimg1"></div>
                                        <!--<img width="100%" height="64px" src="<?php echo base_url(); ?>resources/images/golf.jpg" alt="<?php echo "alt texxt for img"; ?>" />-->
                                    </div>
                                    <div class="col-md-3">
                                        <div id="app_gimg2"></div>
                                        <!--<img width="100%" height="64px" src="<?php echo base_url(); ?>resources/images/Fitness.jpg" alt="<?php echo "alt texxt for img"; ?>" />-->
                                    </div>
                                    <div class="col-md-3">
                                        <div id="app_gimg3"></div>
                                        <!--<img width="100%" height="64px" src="<?php echo base_url(); ?>resources/images/face.jpg" alt="<?php echo "alt texxt for img"; ?>" />-->
                                    </div>
                                    <div class="col-md-3">
                                        <div id="app_gimg4"></div>
                                        <!--<img width="100%" height="64px" src="<?php echo base_url(); ?>resources/images/Cricket.jpg" alt="<?php echo "alt texxt for img"; ?>" />-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!--                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" id="button_share_service" name="button_share_service" class="btn btn-primary" data-dismiss="modal"><b>Share</b></button>
                </div>-->
            </div>
        </div>
    </div>
    