<nav class="navbar navbar-default navbar-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#open-collapse"> 
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button> 
    </div>

    <div class="collapse navbar-collapse" id="open-collapse">
        <div class="container">
            <div class="row">
                <div class="col-md-4 logo-text">
                    <a href="<?php echo base_url(); ?>" ><img class="logo" src="<?php echo base_url() ?>/resources/images/logo1.png" />Sonuto</a>
                </div>
                <div class="col-md-8">
                    <div class="row" style="padding-top:35px; padding-left: 130px; text-align: justify; color: #FFFFFF;font-size: 16px; font-family: serif; font-style: italic;">
                        <?php echo $region_text_map[NAVIGATION_HEADER_ID]?>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</nav>
