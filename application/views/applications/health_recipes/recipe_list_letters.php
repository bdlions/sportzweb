<style>
    *li{
        line-height: 150%;
    }
    *li a {
        color: #999999;
    }
    *h3{
        color: #000000;
    }
</style>
<?php $this->load->view("applications/health_recipes/templates/header_row"); ?>
<div class="col-md-9" style="border: 2px solid #E7E7E7; border-top: 0px; padding-bottom: 24px;">
    <div class="row">
        <ul class="cate" style="width: 100%; list-style-type: none;margin: 0;">
            <li class="avtion"><a href="<?php echo base_url() . 'applications/healthy_recipes/recipe_category_letters' ?>">All</a></li>
            <?php $alphas = range('A', 'Z'); ?>
            <?php foreach ($alphas as $value): ?>
                <li><a href="<?php echo base_url() . 'applications/healthy_recipes/get_recipe_by_alphabet?value=' . $value; ?>"><?php echo $value; ?></a></li>
            <?php endforeach; ?>
        </ul>  
    </div>
    <div class="row">
        <div class="col-md-6">
            <ul style="list-style-type: none;">
                <?php $length1 = count($final_array)/2;$add=0;$i='A';?>
                
                <?php for(;$i<='Z';$i++): ?>
                    <?php if(!empty($final_array[$i])):?>
                        <?php if($add == $length1) break;?>
                        <h3 class="heading_medium_thin"><?php echo $i; $add++;?></h3>
                        <?php foreach ($final_array[$i] as $recipe): ?>
                            <li>
                                <a class="content_text recipe_description" href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $recipe['id']; ?>"><?php echo $recipe['title']; ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endfor;?>
            </ul> 
        </div>
        
        <div class="col-md-6">
            <ul style="list-style-type: none;">               
                <?php for(;$i<='Z';$i++): ?>
                    <?php if(!empty($final_array[$i])): ?>
                        <h3 class="heading_medium_thin"><?php echo $i;?></h3>
                        <?php foreach ($final_array[$i] as $recipe): ?>
                            <li>
                                <a class="content_text recipe_description"  href="<?php echo base_url() . 'applications/healthy_recipes/recipe/' . $recipe['id']; ?>"><?php echo $recipe['title']; ?></a>   
                            </li>
                        <?php endforeach; ?>
                    <?php endif;?>
                <?php endfor;?>
            </ul> 
        </div>
    </div>

</div>
<div class="col-md-3">

</div>