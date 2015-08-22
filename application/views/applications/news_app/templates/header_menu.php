<script>
    (function($, window, undefined) {
        // outside the scope of the jQuery plugin to
        // keep track of all dropdowns
        var $allDropdowns = $();

        // if instantlyCloseOthers is true, then it will instantly
        // shut other nav items when a new one is hovered over
        $.fn.dropdownHover = function(options) {
            // don't do anything if touch is supported
            // (plugin causes some issues on mobile)
            if ('ontouchstart' in document)
                return this; // don't want to affect chaining

            // the element we really care about
            // is the dropdown-toggle's parent
            $allDropdowns = $allDropdowns.add(this.parent());

            return this.each(function() {
                var $this = $(this),
                        $parent = $this.parent(),
                        defaults = {
                            delay: 500,
                            instantlyCloseOthers: true
                        },
                data = {
                    delay: $(this).data('delay'),
                    instantlyCloseOthers: $(this).data('close-others')
                },
                showEvent = 'show.bs.dropdown',
                        hideEvent = 'hide.bs.dropdown',
                        // shownEvent  = 'shown.bs.dropdown',
                        // hiddenEvent = 'hidden.bs.dropdown',
                        settings = $.extend(true, {}, defaults, options, data),
                        timeout;

                $parent.hover(function(event) {
                    // so a neighbor can't open the dropdown
                    if (!$parent.hasClass('open') && !$this.is(event.target)) {
                        // stop this event, stop executing any code 
                        // in this callback but continue to propagate
                        return true;
                    }

                    $allDropdowns.find(':focus').blur();

                    if (settings.instantlyCloseOthers === true)
                        $allDropdowns.removeClass('open');

                    window.clearTimeout(timeout);
                    $parent.addClass('open');
                    $this.trigger(showEvent);
                }, function() {
                    timeout = window.setTimeout(function() {
                        $parent.removeClass('open');
                        $this.trigger(hideEvent);
                    }, settings.delay);
                });

                // this helps with button groups!
                $this.hover(function() {
                    $allDropdowns.find(':focus').blur();

                    if (settings.instantlyCloseOthers === true)
                        $allDropdowns.removeClass('open');

                    window.clearTimeout(timeout);
                    $parent.addClass('open');
                    $this.trigger(showEvent);
                });

                // handle submenus
                $parent.find('.dropdown-submenu').each(function() {
                    var $this = $(this);
                    var subTimeout;
                    $this.hover(function() {
                        window.clearTimeout(subTimeout);
                        $this.children('.dropdown-menu').show();
                        // always close submenu siblings instantly
                        $this.siblings().children('.dropdown-menu').hide();
                    }, function() {
                        var $submenu = $this.children('.dropdown-menu');
                        subTimeout = window.setTimeout(function() {
                            $submenu.hide();
                        }, settings.delay);
                    });
                });
            });
        };
        //$('[data-hover="dropdown"]').dropdownHover();
        $(document).ready(function() {
            // apply dropdownHover to all elements with the data-hover="dropdown" attribute
            $('[data-hover="dropdown"]').dropdownHover();
        });
    })(jQuery, this);

//    active a particular menu item
    $(function() {
        $('.nav a').filter(function() {
            return this.href == location.href
        }).parent().addClass('active_news_item').siblings().removeClass('active_news_item')
    });
</script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/news_app.css" />

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
            <ul class="nav navbar-nav news_app_navbar_custom">
                <li class="dropdown">
                    <a style="padding-left:0px;" href="<?php echo base_url() . 'applications/news_app' ?>" class="dropdown-toggle" data-hover="dropdown">Home</a>
                </li> 
                <?php foreach ($news_header_menu as $news_category_id => $menu_item) : ?>
                    <li class="dropdown">
                        <a href="<?php echo base_url() . 'applications/news_app/news_category/' . $news_category_id; ?>" class="dropdown-toggle" data-hover="dropdown"><?php echo $menu_item['news_category_title']; ?></a>
                        <?php if (!empty($menu_item['sub_category_list'])): ?>
                            <ul class="dropdown-menu dropdown-menu-news" style="background-color: #75B3E6;">
                                <?php foreach ($menu_item['sub_category_list'] as $sub_category_info): ?>
                                    <li><a href="<?php echo base_url() . 'applications/news_app/sub_category/' . $sub_category_info['news_sub_category_id']; ?>"><?php echo $sub_category_info['news_sub_category_title']; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li> 
                <?php endforeach; ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>