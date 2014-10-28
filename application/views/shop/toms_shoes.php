<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/blog_app.css" />
<div id="testnavmenu">
    <div id='mega_nav'>
        <ul>
            <li><a href='<?php echo base_url()?>test/shop_home'><span>HOME</span></a></li>
            <li class="has-sub"><a href='#'><span>WOMEN</span></a>
                <ul>
                    <li>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-2">
                                    asdasd
                                </div>
                                <div class="col-md-10">
                                    bic c
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="has-sub"><a href='#'><span>MEN</span></a>
                <ul>
                    <li>
                        <div >
                            kjaghsdas
                        </div>
                    </li>
                </ul>
            </li>
            <li class="has-sub"><a href='#'><span>KIDS</span></a>
                <ul>
                    <li>
                        <div >
                            kjaghsdas
                        </div>
                    </li>
                </ul>
            </li>
            <li><a href='#'><span>About</span></a></li>
            <li><a href='<?php echo base_url()?>test/toms_shoes'><span>SHOES</span></a></li>
            
            <li class='has-sub'><a href='#'><span>Products</span></a>
                <ul>
                    <li class='has-sub'><a href='#'><span>Product 1</span></a>
                        <ul>
                            <li><a href='#'><span>Sub Product</span></a></li>
                            <li class='last'><a href='#'><span>Sub Product</span></a></li>
                        </ul>
                    </li>
                    <li class='has-sub'><a href='#'><span>Product 2</span></a>
                        <ul>
                            <li><a href='#'><span>Sub Product</span></a></li>
                            <li class='last'><a href='#'><span>Sub Product</span></a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class='last'><a href='#'><span>Contact</span></a></li>
        </ul>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div style="height: 222px">
            
        </div>
    </div>
</div>

<style>
    #mega_nav ul,
    #mega_nav li,
    #mega_nav span,
    #mega_nav a {
      margin: 0;
      padding: 0;
      position: relative;
    }
    #mega_nav {
      line-height: 1;
      background: #5A534C;
      width: auto;
    }
    #mega_nav:after,
    #mega_nav ul:after {
      content: '';
      display: block;
      clear: both;
    }
    #mega_nav a {
      background: #5A534C;
      color: #ffffff;
      display: block;
      font-weight: bolder;
      font-family: Helvetica, Arial, Verdana, sans-serif;
      padding: 19px 20px;
      text-decoration: none;
    }
    #mega_nav ul {
      list-style: none;
    }
    #mega_nav > ul > li {
      display: inline-block;
      float: left;
      margin: 0;
    }
    #mega_nav.align-center {
      text-align: center;
    }
    #mega_nav.align-center > ul > li {
      float: none;
    }
    #mega_nav.align-center ul ul {
      text-align: left;
    }
    #mega_nav.align-right > ul {
      float: right;
    }
    #mega_nav.align-right ul ul {
      text-align: right;
    }
    #mega_nav > ul > li > a {
      color: #ffffff;
      font-size: 12px;
    }
    #mega_nav > ul > li:hover:after {
      content: '';
      display: block;
      width: 0;
      height: 0;
      position: absolute;
      left: 50%;
      bottom: 0;
      border-left: 10px solid transparent;
      border-right: 10px solid transparent;
      border-bottom: 10px solid white;
      margin-left: -10px;
    }
    #mega_nav > ul > li:first-child > a {
      border-radius: 5px 0 0 0;
      -moz-border-radius: 5px 0 0 0;
      -webkit-border-radius: 5px 0 0 0;
    }
    #mega_nav.align-right > ul > li:first-child > a,
    #mega_nav.align-center > ul > li:first-child > a {
      border-radius: 0;
      -moz-border-radius: 0;
      -webkit-border-radius: 0;
    }
    #mega_nav.align-right > ul > li:last-child > a {
      border-radius: 0 5px 0 0;
      -moz-border-radius: 0 5px 0 0;
      -webkit-border-radius: 0 5px 0 0;
    }
    #mega_nav > ul > li.active > a,
    #mega_nav > ul > li:hover > a {
      color: greenyellow;
    }
    #mega_nav .has-sub {
      z-index: 1;
    }
    #mega_nav .has-sub:hover > ul {
      display: block;
    }
    #mega_nav .has-sub ul {
      display: none;
      position: absolute;
      /*width: 200px;*/
      top: 100%;
      left: 0;
    }
    #mega_nav.align-right .has-sub ul {
      left: auto;
      right: 0;
    }
    #mega_nav .has-sub ul li {
      *margin-bottom: -1px;
    }
    #mega_nav > ul > li > ul > li > div
    {
        filter: none;
        display: block;
        line-height: 120%;
        padding: 10px;
        color: black;
        border-radius: 2px;
        box-shadow: 0 0 3px #000000;
        -moz-box-shadow: inset 0 0 3px #000000;
        -webkit-box-shadow: inset 0 0 3px #000000;
    }
    #mega_nav .has-sub ul li a {
      background: #0fa1e0;
      border-bottom: 1px dotted #31b7f1;
      font-size: 11px;
      filter: none;
      display: block;
      line-height: 120%;
      padding: 10px;
      color: #ffffff;
    }
    #mega_nav .has-sub ul li:hover a {
      background: #0c7fb0;
    }
    #mega_nav ul ul li:hover > a {
      color: #ffffff;
    }
    #mega_nav .has-sub .has-sub:hover > ul {
      display: block;
    }
    #mega_nav .has-sub .has-sub ul {
      display: none;
      position: absolute;
      left: 100%;
      top: 0;
    }
    #mega_nav.align-right .has-sub .has-sub ul,
    #mega_nav.align-right ul ul ul {
      left: auto;
      right: 100%;
    }
    #mega_nav .has-sub .has-sub ul li a {
      background: #0c7fb0;
      border-bottom: 1px dotted #31b7f1;
    }
    #mega_nav .has-sub .has-sub ul li a:hover {
      background: #0a6d98;
    }
    #mega_nav ul ul li.last > a,
    #mega_nav ul ul li:last-child > a,
    #mega_nav ul ul ul li.last > a,
    #mega_nav ul ul ul li:last-child > a,
    #mega_nav .has-sub ul li:last-child > a,
    #mega_nav .has-sub ul li.last > a {
      border-bottom: 0;
    }

</style>

<script>
    function confirmation_vote(league_id)
    {
        $("#league_id").val(league_id);
        $("#confirmModal").modal("show");
    }
    function post_vote()
    {
        var league_id = $("#league_id").val();
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>' + "asdasd/application/xstreambanter/post_vote",
                dataType: 'json',
                data: {
                    league_id: league_id
                },
                success: function(data) {
                    location.reload();
                }
            });
    }
</script>
<style>
    .blue_banner
    {
        color: white;
        background-color:#3F48CC;
    }
    .title{
        font-size: 20px;
        text-align: center;
    }
    .heading{
        padding: 15px;
        font-size: 25px;
        text-align: center;
    }
    .lr_image
    {
        height: 18px;
        padding: 4px 0px 0px;
    }
</style>



<!--<div class="col-md-6">
    <?php echo 'echo error: ';?>
    <?php echo $error;?>
    <?php var_dump($error);?>

    <?php echo form_open_multipart('test/upload_crop');?>

        <input type="file" name="userfile" size="20" />
        <br /><br />
        <input type="submit" value="upload" />

    <?php echo form_close();?>
        
        
        
</div>-->