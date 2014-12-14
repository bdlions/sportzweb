<script type="text/javascript">
    $(function() {
        $("#button_create_recipe_category").on("click", function() {
            $('#modal_create_recipe_category').modal('show');
        });
    });
</script>  
<script type="text/x-tmpl" id="tmpl_recipes_category_list">
    {% var i=0, recipe_category_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(recipe_category_info){ %}
    <tr>
        <td><a href="<?php echo base_url()."admin/applications_healthyrecipes/recipe_category/{%= recipe_category_info.id%}"; ?>">{%= recipe_category_info.id%}</td>
        <td><div id="recipe_desc_{%= recipe_category_info.id%}">{%= recipe_category_info.description%}</div></td>
        <td><button id="button_edit_recipe_category_{%= recipe_category_info.id%}" onclick="openModal('button_edit_recipe_category_{%= recipe_category_info.id%}','{%= recipe_category_info.id%}')" value="" class="form-control btn pull-right">Edit</button></td>
    </tr>
    {% recipe_category_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>

<script type="text/javascript">
    $(function() {
        $("#button_create_recipe").on("click", function() {
            $('#modal_create_recipe').modal('show');
        });
    });
</script>
                            
<div class="panel panel-default">
    <div class="panel-heading">Healthy Recipes</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <?php if($allow_configuration){ ?>
            <div class="row form-group">
                <div class ="col-sm-5">
                    <a href="<?php echo base_url();?>admin/applications_healthyrecipes/page_import_recipe">
                        <button class="btn button-custom pull-right">Import Recipes
                        </button>
                    </a>
                </div>
                <div class =" col-sm-4">
                    <a href="<?php echo base_url().'admin/applications_healthyrecipes/all_recipe_list' ?>">
                        <button id="button_manage_recipe_for_home_page" value="" class="btn button-custom " style="margin-left: -10px;">
                            Manage Recipes for Home Page
                        </button>
                    </a>
                </div>
                <div class ="col-sm-3" style="padding-right: 0px;">
                    <button id="button_create_recipe_category" value="" class="btn button-custom " style="margin-left: -10px;">Create Recipe Category</button>  
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered" style="text-align: center;">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Id</th>
                                <th style="text-align: center;">Name</th>
                                <?php if($allow_edit){ ?>
                                <th style="text-align: center;">Edit</th> 
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="tbody_recipes_category_list">
                            <?php foreach($recipes_category_list as $recipes_category):?>
                            <tr>
                                <td><a href="<?php echo base_url().'admin/applications_healthyrecipes/recipe_category/'.$recipes_category['id']?>"><?php echo $recipes_category['id']; ?></a></td>
                                <td><div id="recipe_desc_<?php echo $recipes_category['id'];?>"><?php echo $recipes_category['description']?></div></td>
                                <?php if($allow_edit){ ?>
                                <td> <button id="button_edit_recipe_category_<?php echo $recipes_category['id'];?>" onclick="openModal('button_edit_recipe_category_<?php echo $recipes_category["id"];?>','<?php echo $recipes_category['id'];?>')" value="" class="form-control btn pull-right">Edit</button></td>
                                <?php } ?>
                            </tr>
                            <?php endforeach; ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="btn-group" style="padding-left: 10px;">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="goBackByURL('<?php echo base_url();?>admin/application/application_manage')" class="form-control btn button-custom">
            </div>
        </div>        
    </div>
</div>
<?php $this->load->view("admin/applications/healthy_recipes/modal_create_recipe_category"); ?>
<?php $this->load->view("admin/applications/healthy_recipes/modal_edit_recipe_category"); ?>
