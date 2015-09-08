<?php $this->load->view("applications/health_recipes/templates/header_row"); ?>
<div class="col-md-9">
    
    <div class="row">
        <ul class="cate" style="width: 100%; list-style-type: none;margin: 0;">
            <li><a href="<?php echo base_url() . 'applications/healthy_recipes/recipe_category_letters' ?>">All</a></li>
            <?php $alphas = range('A', 'Z'); ?>
            <?php foreach ($alphas as $value): ?>
                <?php if($value == $alphabet_value): ?>
                    <li class="avtion"><a href="<?php echo base_url() . 'applications/healthy_recipes/get_recipe_by_alphabet?value=' . $value; ?>"><?php echo $value; ?></a></li>
                <?php else : ?>
                    <li><a href="<?php echo base_url() . 'applications/healthy_recipes/get_recipe_by_alphabet?value=' . $value; ?>"><?php echo $value; ?></a></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>  
    </div>
    
    <div class="row graybordertop grayborderbottom grayborderleft grayborderright" >
        <h3><?php echo $alphabet_value; ?></h3>
    </div>
    <?php if (count($results) > 0) : ?>
        <?php foreach ($results as $result) : ?>
            <div class="row graybordertop grayborderbottom grayborderleft grayborderright">        
                <!--Dynamic contents-->
                <div class="col-md-3 grayborderright">
                    <img style="width: 180px;height: 100px;" src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $result['main_picture']; ?>" class="img-responsive" alt="<?php echo $result['title']; ?>"/>
                </div>
                <div class="col-md-9">
                    <a style="font-size:16px;color:#B97A57;text-decoration:underline;" href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $result['id']; ?>">
                        <?php echo $result['title']; ?>
                    </a>

                    <div style="margin-top:10px;font-size:14px;line-height:120%;">
                        <?php echo $result['description']; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="col-md-3">
</div>