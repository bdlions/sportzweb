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
    