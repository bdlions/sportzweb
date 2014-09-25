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
                <div class="item active">
                    <img style="height: 300px; width: 100%; overflow: hidden" src="<?php echo base_url(); ?>resources/images/photo.png" alt="...">
                    <div class="carousel-caption">
                        cap a
                    </div>
                </div>
                <div class="item">
                    <img style="height: 300px; width: 100%; overflow: hidden" src="<?php echo base_url(); ?>resources/images/index.jpg" alt="...">
                    <div class="carousel-caption">
                        cap b
                    </div>
                </div>
                <div class="item">
                    <img style="height: 300px; width: 100%; overflow: hidden" src="<?php echo base_url(); ?>resources/images/video.jpg" alt="...">
                    <div class="carousel-caption">
                        cap b
                    </div>
                </div>
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
                <span style="font-size: 24px;">
                    Featured Apps
                </span>
                
                <?php foreach ($app_data1 as $app):?>
                    <div class="col-md-12" style="padding: 5px 0px 5px;">
                        <div class="col-md-2" style="padding: 0px;">
                            <img width="100%" class="image-responsive" src="<?php echo base_url();?>resources/images/face.jpg"/>
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
                <span style="font-size: 24px;">
                    Featured Apps
                </span>
                
                <?php foreach ($app_data2 as $app):?>
                    <div class="col-md-12" style="padding: 5px 0px 5px;">
                        <div class="col-md-2" style="padding: 0px;">
                            <img width="100%" class="image-responsive" src="<?php echo base_url();?>resources/images/face.jpg"/>
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
    
    
    
    <!--old code-->