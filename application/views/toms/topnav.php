<link rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/toms.css">

<div id='mega_nav'>
    <ul>
        <li><a href='<?php echo base_url() ?>test/run_toms_page'><span>HOME</span></a></li>
        <li onmouseout="document.getElementById('tray_women').style.display = 'none';" onmouseover="document.getElementById('tray_women').style.display = 'block';" ><a href='#'>WOMEN</a></li>
        <li onmouseout="document.getElementById('tray_men').style.display = 'none';" onmouseover="document.getElementById('tray_men').style.display = 'block';" ><a href='#'>MEN</a></li>
        <li onmouseout="document.getElementById('tray_kids').style.display = 'none';" onmouseover="document.getElementById('tray_kids').style.display = 'block';" ><a href='#'>KIDS</a></li>
        <li><a href='#'>STORIES</a></li>
        <li><a href='#'>ONE FOR ONE</a></li>
    </ul>
</div>

<div style="position: relative">
    
    <!--WOMEN TRAY-->
    <div class="mega_nav_tray container-fluid"  id="tray_women"  onmouseout="document.getElementById('tray_women').style.display = 'none';" onmouseover="document.getElementById('tray_women').style.display = 'block';" >
        <div class="row white_back">
            <div class="col-md-2 menu_featured">
                <a href='<?php echo base_url() ?>test/run_toms_page'>View All</a>
                <a href='#'>New Arrival</a>
                <a href='#'>Gift Card</a>
            </div>
            <div class="col-md-10">
                <div class="col-md-2 item_card" style="background-color: red">
                    <div>
                        <img class="img-responsive" src="<?php echo base_url() ?>resources/images/video.jpg" />
                    </div>
                    <div>
                        BEST SELLERS
                        BEST SELLERS
                        BEST SELLERS
                        BEST SELLERS
                        BEST SELLERS
                    </div>
                </div>
            </div>
        </div>
        <div class="row brwn_back">
            <div class="col-md-2">1 asdasd</div>
            <div class="col-md-2">2 sacas2</div>
            <div class="col-md-2">3 sadcsdf</div>
            <div class="col-md-2">4 sddvdvsd</div>
            <div class="col-md-2">5 fvdfbdf</div>
            <div class="col-md-2">6 sdfvfv</div>
        </div>
    </div>
    
    <!--MEN TRAY-->
    <div class="mega_nav_tray container-fluid"  id="tray_men" onmouseout="document.getElementById('tray_men').style.display = 'none';" onmouseover="document.getElementById('tray_men').style.display = 'block';" >
        <div class="row">
            <div>
                <div class="col-md-2">success uhasdhoasd </div>
                <div class="col-md-10">bog colums</div>
            </div>
        </div>
        <div style="height: 50px; background: red"></div>
    </div>
</div>