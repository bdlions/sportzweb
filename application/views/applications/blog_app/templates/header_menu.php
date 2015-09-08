<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/blog_app.css" />
<script type="text/javascript">
    //    active a particular menu item
    $(function() {
        $('.nav a').filter(function() {
            return this.href == location.href
        }).parent().addClass('active_blog_item').siblings().removeClass('active_blog_item')
        $('.nav a').click(function() {
            $(this).parent().addClass('active_blog_item').siblings().removeClass('active_blog_item')
        });
    });
</script>
<nav class="navbar navbar-default blog_home_header_menu app_header_bg">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#blog_header_menu_item" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse blog_header_collapse_margin_adjustment" id="blog_header_menu_item">
            <ul class="nav navbar-nav blog_app_navbar_custom">
                <?php if (!empty($custom_blog_category_menu) && ($custom_blog_category_menu[0]['id'] == HOME)): ?>
                    <li><a href="<?php echo base_url() . 'applications/blog_app' ?>"><?php echo $custom_blog_category_menu[0]['title']; ?></a></li>
                <?php endif; ?>
                <?php if (count($blog_category_menu) > 0) : ?>

                    <?php foreach ($blog_category_menu as $menu): ?>
                        <li><a style="padding-left: 10px;" href="<?php echo base_url() . 'applications/blog_app/blog_category/' . $menu['id']; ?>"><?php echo $menu['title']; ?></a></li> 
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (!empty($custom_blog_category_menu) && ($custom_blog_category_menu[1]['id'] == WRITE_BLOG)): ?>
                    <li><a href="<?php echo base_url() . 'applications/blog_app/create_blog_by_user/' ?>" style="padding-left: 15px;">
                            <?php echo $custom_blog_category_menu[1]['title']; ?>
                        </a></li>
                <?php endif; ?>

                <?php if (($have_my_blogs) > 0 && !empty($custom_blog_category_menu) && ($custom_blog_category_menu[2]['id'] == MY_BLOG)): ?>
                    <li><a href="<?php echo base_url() . 'applications/blog_app/users_blog/' ?>" style="padding-left: 15px;">
                            <?php echo $custom_blog_category_menu[2]['title']; ?>
                        </a></li>
                <?php endif; ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>


