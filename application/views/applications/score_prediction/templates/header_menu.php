<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/score_predict.css" />
<script type="text/javascript">
    //    active a particular menu item
    $(function() {
        $('.nav a').filter(function() {
            return this.href == location.href
        }).parent().addClass('active_score_prediction_item').siblings().removeClass('active_score_prediction_item')
    });
</script>
<nav style="padding-left: -10px;"  class="navbar navbar-default navbar-menu-news news-menu navbar_default_custom scroe_pretiction_navbar_default_custom" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#news_header_menu_blue">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse score_prediction_header_collapse_margin_adjustment" id="news_header_menu_blue">
            <ul class="nav navbar-nav ">
                <li>
                    <a href="<?php echo base_url() . 'applications/score_prediction' ?>" >Home</a>
                </li>
                <?php
                foreach ($sports_list as $sports_info) {
                    ?>
                    <li>
                        <a href="<?php echo base_url() . 'applications/score_prediction/sports/' . $sports_info['sports_id']; ?>"><?php echo $sports_info['title'] ?></a>
                    </li> 
                    <?php
                }
                ?>                
            </ul>
        </div>
    </div>
</nav>

<!--
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">Dropdown</a>
    <ul class="dropdown-menu" style="background-color: #00A2E8;">
        <li><a href="#">Action</a></li>
        <li><a href="#">Another action</a></li>
        <li><a href="#">Something else here</a></li>
        <li class="divider"></li>
        <li><a href="#">Separated link</a></li>
        <li class="divider"></li>
        <li><a href="#">One more separated link</a></li>
    </ul>
</li>
-->