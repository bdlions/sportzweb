<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/bootstrap.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>resources/js/jquery.js"></script>
<style type="text/css">
    #lowerimg { border: 1px solid red; height: 100%; width: 100%; background-repeat: no-repeat; background-size: 100%}
    #upperimg { border: 1px solid #006dcc; height: 100%; width: 100%; position: absolute; background: url(<?php echo base_url();?>resources/images/applications/news_app/news/<?php echo $bg_image[0];?>); background-repeat: no-repeat; background-size: 100%}
    #imgbuttonf { height: 32px; width: 32px; position: absolute; bottom: 30; right: 30}
    #imgbuttonb { height: 32px; width: 32px; position: absolute; bottom: 30; right: 70}
</style>
<!--<div class="row col-md-12" style="border: 2px solid #aaa">-->
    <div class="col-md-6" style="border: 2px solid #d0d">
        <div id="lowerimg">
        </div>
        <div id="upperimg">
        </div>
        <img id="imgbuttonb" src="<?php echo base_url(); ?>resources/images/imageNavLeft.gif" onclick="changeBackgroundBack()"/>
        <img id="imgbuttonf" src="<?php echo base_url(); ?>resources/images/imageNavRight.gif" onclick="changeBackground()"/>
    </div>
<!--</div>-->
    


<script type="text/javascript">
    var images = <?php echo '["' . implode('", "', $bg_image) . '"]' ?>;
    var cur_image = 0;

    function changeBackground() {
        cur_image++;
        if(cur_image >= images.length){
            cur_image--; 
            return;
        }  
        
        // change images
        $( '#lowerimg' ).css({
            backgroundImage: 'url(<?php echo base_url();?>resources/images/applications/news_app/news/' + images[ cur_image ] + ')'
        });
        $( '#upperimg' ).fadeOut( 'slow', function(){
            $( '#lowerimg' ).css({
                backgroundImage: 'url(<?php echo base_url();?>resources/images/applications/news_app/news/' + images[ cur_image ] + ')'
            }).show();
        } );
    }
    
    function changeBackgroundBack() {
        cur_image--;
        if (cur_image <= 0){
            cur_image++;
            return;  
        }
        
        // change images
        $( '#container' ).css({
            backgroundImage: 'url(<?php echo base_url();?>resources/images/applications/news_app/news/' + images[ cur_image ] + ')'
        });
        $( '#container .slide' ).fadeOut( 'slow', function(){
            $( this ).css({
                backgroundImage: 'url(<?php echo base_url();?>resources/images/applications/news_app/news/' + images[ cur_image ] + ')'
            }).show();
        } );
    }

//    setInterval( changeBackground, 2600 );
</script>

