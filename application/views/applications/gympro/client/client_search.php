<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>resources/bootstrap3/css/gympro.css">
<script type="text/javascript">
    $(function(){   
        $("#search_client").typeahead([
            {
                name:"search_user",
                prefetch:{
                            url: '<?php echo base_url()?>search/get_users',
                            ttl: 0
                        },
                header: '<div class="col-md-12" style="font-size: 15px; font-weight:bold">People</div>',
                template: [
                    '<div class="row">'+
                        '<div class="col-md-3">'+
                            '<div>'+
                                '<img alt="{{signature}}" src="<?php echo base_url().PROFILE_PICTURE_DISPLAY_PATH?>{{photo}}" class="img-responsive profile-photo" onError="this.style.display = \'none\'; this.parentNode.className=\'profile-background\'; this.parentNode.getElementsByTagName(\'div\')[0].style.visibility=\'visible\'; "/>'+
                                '<div style="visibility:hidden;height:0px">{{signature}}</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-9">'+
                            '<div class="row col-md-12 profile-name">'+
                                '{{first_name}} {{last_name}}'+
                            '</div>'+  
                            '<div class="row col-md-12">'+
                                '{{country_name}} {{home_town}}'+
                            '</div>'+
                        '</div>'+
                    '</div>'
                  ].join(''),
                engine: Hogan
            }        
    ]).on('typeahead:selected', function (obj, datum) {
                if(datum.username)
                {
                    window.location = "<?php echo base_url()?>applications/gympro/create_client/" + datum.user_id;
                }
            });
        
    });
</script>
<div class="container-fluid">
    <div class="row top_margin">
        <div class="col-md-2">
            <!--left nav custom for this page-->
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="#">Personal details</a>
            </div>
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="#">Contact details</a>
            </div>
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="#">Health details</a>
            </div>
            <div class="ln_item content_text" >
                <img class="img-responsive" src="<?php echo base_url() ?>resources/images/applications/gympro/programmes.png">
                <a onclick="#">Notes</a>
            </div>
        </div>
        <!--ADDING CLIENT-->
        <div class="col-md-7">
            <div class="pad_title">
                ADDING CLIENT
            </div>
            <div style="border-top: 2px solid lightgray; margin-left: 20px"></div>
            <div class="pad_body">
                <?php if (isset($message) && ($message != NULL)){?>
                    <div class="alert alert-danger alert-dismissible"><?php echo $message; ?></div>
                <?php } ?>
                <div class="col-md-6" style="border:1px solid lightgray">
                    <div class=" input-group search-box">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                        <input id="search_client" class="form-control" type="text" placeholder="Search for people" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>