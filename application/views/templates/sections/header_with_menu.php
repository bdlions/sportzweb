<script type="text/javascript">
    $(function(){   
        $("#search_box").typeahead([
            {
                name:"search_user",
                remote:'<?php echo base_url()?>search/get_users?query=%QUERY',
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
            },
            {
                name:"search_business_names",
                remote:'<?php echo base_url()?>search/get_business_names?query=%QUERY',
                header: '<div class="col-md-12" style="font-size: 15px; font-weight:bold">Businesses</div>',
                template: [
                    '<div class="row">'+
                        '<div class="col-md-3">'+
                            '<div>'+
                                '<img alt="{{signature}}" src="<?php echo base_url()?>resources/uploads/business/{{logo}}" class="img-responsive profile-photo" onError="this.style.display = \'none\'; this.parentNode.className=\'profile-background\'; this.parentNode.getElementsByTagName(\'div\')[0].style.visibility=\'visible\'; "/>'+
                                '<div style="visibility:hidden;height:0px">{{signature}}</div>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-9 profile-name">{{business_name}}</div>'+
                    '</div>'                    
                  ].join(''),
                engine: Hogan
            },
            {
                name:"search_healthy_recipe",
                remote:'<?php echo base_url()?>search/get_healthy_recipes?query=%QUERY',
                header: '<div class="col-md-12" style="font-size: 15px; font-weight:bold">Healthy Recipe</div>',
                template: [
                    '<div class="row">'+
                        '<div class="col-md-3">'+
                            '<div>'+
                                '<img style="width:50px;height:50px" src="{{picture}}" class="img-responsive"/>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-9 profile-name">{{title}}</div>'+
                    '</div>'
                  ].join(''),
                engine: Hogan
            },

            {
                name:"search_news",
                remote:'<?php echo base_url()?>search/get_news?query=%QUERY',
                header: '<div class="col-md-12" style="font-size: 15px; font-weight:bold">News</div>',
                template: [
                    '<div class="row">'+
                        '<div class="col-md-3">'+
                            '<div>'+
                                '<img style="width:50px;height:50px" src="{{picture}}" class="img-responsive"/>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-9 profile-name">{{title}}</div>'+
                    '</div>'
                  ].join(''),
                engine: Hogan
            },
            {
                name:"search_blogs",
                remote:'<?php echo base_url()?>search/get_blogs?query=%QUERY',
                header: '<div class="col-md-12" style="font-size: 15px; font-weight:bold">Blogs</div>',
                template: [
                    '<div class="row">'+
                        '<div class="col-md-3">'+
                            '<div>'+
                                '<img style="width:50px;height:50px" src="{{picture}}" class="img-responsive"/>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-9 profile-name">{{title}}</div>'+
                    '</div>'
                  ].join(''),
                engine: Hogan
            }
        
    ]).on('typeahead:selected', function (obj, datum) {
                if(datum.business_name)
                {
                    window.location = "<?php echo base_url()?>business_profile/show/" + datum.id;
                }
                else if(datum.username)
                {
                    window.location = "<?php echo base_url()?>member_profile/show/" + datum.user_id;
                }
                else if(datum.type == 'page')
                {
                    window.location = datum.url;
                }
            });
        
    });
</script>

<nav class="navbar navbar-default navbar-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">

        </a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <div class="container">
            <div class="row">
                <div class="col-md-4 logo-text">
                    <a href="<?php echo base_url(); ?>" ><img class="logo" src="<?php echo base_url() ?>/resources/images/logo1.png" /><?php echo WEBSITE_TITLE; ?></a>
                </div>

                <div class="col-md-8">
                    <div class="header-menu-row">
                        <div class="col-md-offset-2 col-md-6" >
                            <div class=" input-group search-box">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                <input id="search_box" class="form-control" type="text" placeholder="Search for people and interests" />
                            </div>
                        </div>
                        <div class="col-md-2 pull-right right-menu">
                            <div>
                                <a href="#">
                                    <img src="<?php echo base_url(); ?>resources/images/bell.png">
                                </a>
                                <a href="<?php echo base_url().'messages'?>">
                                    <img src="<?php echo base_url(); ?>resources/images/inbox.png">
                                </a>
                                <a href="#" data-toggle="dropdown" id="dropdownMenuRight">
                                    <img src="<?php echo base_url(); ?>resources/images/menu.png">
                                </a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenuRight">
                                    <?php if ($business_profile_info == FALSE) { ?>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>register/business_profile">Create my business profile</a>
                                        </li>
                                    <?php } else { ?>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>business_profile/show"><?php echo $business_profile_info->business_name?></a>
                                        </li>
                                        <li role="presentation">
                                            <a role="menuitem" tabindex="-1" href="#">Advertise</a>
                                        </li>
                                    <?php } ?>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>settings/">Account settings</a>
                                    </li>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>settings.html?menu=privacy&section=tag_photo">Privacy settings</a>
                                    </li>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>settings/applications">Application settings</a>
                                    </li>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>member_general/contact_us">Support</a>
                                    </li>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo base_url() ?>auth/logout">Log out</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(isset($application_id) && $application_id == APPLICATION_GYMPRO_ID):?>
    <?php $this->load->view("applications/gympro/template/sections/top_banner"); ?>
    <?php endif;?>
</nav>