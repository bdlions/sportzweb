    <div class="col-md-12">
        <h2>App directory</h2>
        <div>Be more productive with applications.</div>
    </div>
    <div class="col-md-12" style="margin-top: 20px; margin-bottom: 20px;">
        <div style="width: 100%; border: 2px dashed darkslateblue; text-align: center; padding: 40px; background-color: lightcyan">
            carousal here            
        </div>
    </div>
    <div class="col-md-12">
        
        <!--Left column-->
        <div class="col-md-6" style="padding-left: 0px; padding-right: 8px;">
            <div class="col-md-12" style="background-color: white; border: 1px solid lightgray; border-radius: 3px; padding: 20px;">
                <span style="font-size: 24px;">
                    Featured Apps
                </span>
                
                <?php foreach ($app_data as $app):?>
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
        
        <!--copy codes of left column here-->
        <!--copy codes of left column here-->
        <!--copy codes of left column here-->
        
    </div>
    
    
    
    <!--old code-->

<div class="col-md-2 column">
    <?php //$this->load->view("templates/sections/member_left_pane");?>
</div>
<div class="col-md-7 column">
    <h3>Featured Apps</h3>
    <div class="col-md-5 column">
        <ul class="list-inline list-unstyled">
            <li id="" class="">
                <div class="col-md-12">
                    <div class="col-md-8">
                        <a class="pull-left" aria-hidden="true" tabindex="-1" data-app-id="50057" href="">
                            <img width="75" height="75" alt="" src="<?php echo base_url(); ?>resources/images/photo.png">
                         </a>
                    </div>
                    <div class="col-md-4">
                        <a class="" href="">
                            <button class="button button-custom">Try It</button>
                        </a>
                    </div>
                </div>

                <div class="col-md-12">
                  <h4>
                    <a href="">Xtream bunters</a>
                  </h4>
                  <p class="text-expands">See the different type spores match time</p>
                </div>
            </li>
            <li id="" class="">
                <div class="col-md-12">
                    <div class="col-md-7">
                        <a class="pull-left" aria-hidden="true" tabindex="-1" data-app-id="50057" href="">
                            <img width="75" height="75" alt="" src="<?php echo base_url(); ?>resources/images/user_female.png">
                         </a>
                    </div>
                    <div class="col-md-5">
                        <a href="">
                            <button class="button button-custom">Remove</button>
                        </a>
                    </div>
                </div>

                <div class="col-md-12">
                  <h4>
                    <a href="">Blog directory</a>
                  </h4>
                  <p class="text-expands">Read the different type of Blog</p>
                </div>
            </li>
        </ul>
    </div>
    <div class="col-md-2 column">
      
    </div>
    <div class="col-md-5 column">
        <ul class="list-inline list-unstyled">
            <li id="" class="">
                <div class="col-md-12">
                    <div class="col-md-8">
                        <a class="pull-left" aria-hidden="true" tabindex="-1" data-app-id="50057" href="">
                            <img width="75" height="75" alt="" src="<?php echo base_url(); ?>resources/images/video.jpg">
                         </a>
                    </div>
                    <div class="col-md-4">
                        <a class="" href="">
                            <button class="button button-custom">Remove</button>
                        </a>
                    </div>
                </div>

                <div class="col-md-12">
                  <h4>
                    <a href=""> News Directory</a>
                  </h4>
                  <p class="text-expands">Read the different type of news</p>
                </div>
            </li>
            <li id="" class="">
                <div class="col-md-12">
                    <div class="col-md-7">
                        <a class="pull-left" aria-hidden="true" tabindex="-1" data-app-id="50057" href="">
                            <img width="75" height="75" alt="" src="<?php echo base_url(); ?>resources/images/user_male.png">
                         </a>
                    </div>
                    <div class="col-md-5">
                        <a class="" href="">
                            <button class="button button-custom">Try It</button>
                        </a>
                    </div>
                </div>

                <div class="col-md-12">
                  <h4>
                    <a href="">Healthy recipes</a>
                  </h4>
                  <p class="text-expands">Read the different type of food making recipes</p>
                </div>
            </li>
        </ul>
    </div>
</div>
<div class="col-md-3 column">
    <?php //$this->load->view("templates/sections/member_right_pane");?>
</div>