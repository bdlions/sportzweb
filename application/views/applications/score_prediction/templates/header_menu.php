

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/score_predict.css" />

<nav class="navbar navbar-menu-news navbar-default cus_news_header news-menu" role="navigation">
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
        <div class="row collapse navbar-collapse" id="news_header_menu_blue">
            <ul class="nav navbar-nav">
                <li>
                    <a style="padding-left:2px;" href="<?php echo base_url() . 'applications/score_prediction' ?>" >Home</a>
                </li> 
                <?php // foreach ( as $key => $menu_item) : ?>
                <li>
                    <a href="<?php // echo base_url() . 'applications/' . $menu_item[''];  ?>">Baseball</a>
                </li> 
                <li>
                    <a href="<?php // echo base_url() . 'applications/' . $menu_item[''];  ?>">Baseball</a>
                </li> 
                <li>
                    <a href="<?php // echo base_url() . 'applications/' . $menu_item[''];  ?>">Baseball</a>
                </li> 
                <?php // endforeach; ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
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