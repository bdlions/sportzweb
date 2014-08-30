<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/blog_app.css" />
<div class="row">
    <div class="col-md-12 blog_home_header_menu">
        <a href="<?php echo base_url() . 'applications/blog_app' ?>">Home</a>
        <?php if (count($blog_category_menu) > 0) : ?>
            <?php foreach ($blog_category_menu as $menu): ?>
                <a style="padding-left: 10px;" href="<?php echo base_url() . 'applications/blog_app/blog_category/' . $menu['id']; ?>"><?php echo $menu['title']; ?></a> 
            <?php endforeach; ?>
        <?php endif; ?>
        <a href="<?php echo base_url() . 'applications/blog_app/create_blog_by_user/' ?>" style="padding-left: 15px;">Write Blog</a>
        <?php if ($have_my_blogs > 0): ?>
            <a href="<?php echo base_url() . 'applications/blog_app/users_blog/' ?>" style="padding-left: 15px;">My Blogs</a>
        <?php endif; ?>
    </div>
</div>