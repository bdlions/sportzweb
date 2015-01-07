<script type="text/javascript">
    $(function () {
        $("#button_create_recipe_category").on("click", function () {
            $('#modal_create_recipe_category').modal('show');
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_recipes_category_list">
    {% var i=0, recipe_category_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(recipe_category_info){ %}
    <tr>
    <td>{%= recipe_category_info.description%}</a></td>
    <td><a href="<?php echo base_url() . "admin/application/healthy_recipes_category/{%= recipe_category_info.id%}"; ?>">Edit</td>
    </tr>
    {% recipe_category_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>

<script type="text/javascript">
    $(function () {
        $("#button_create_recipe").on("click", function () {
            $('#modal_create_recipe').modal('show');
        });
    });
</script>

<div class="panel panel-default">
    <div class="panel-heading">Recipes List</div>
    <div class="panel-body">
        <?php if ($allow_configuration) { ?>
            <div class="row form-group">
                <div class ="col-sm-2">
                    <a href="<?php echo base_url() . "admin/applications_healthyrecipes/create_recipe/" . $recipe_category_id ?>" >
                        <button id="" value="" class="btn button-custom" style="width: 100%">
                            Create Recipe 
                        </button>
                    </a> 
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Recipe Category</th>
                            <th>Recipe Title</th>
                            <th>Created On</th>
                            <?php if ($allow_edit) { ?>
                                <th>Edit</th>
                                <th>Delete</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody id="tbody_recipe_list">
                        <?php $i = 1; ?>
                        <?php foreach ($recipes_list as $recipes) { ?>
                            <tr>
                                <td><a href="<?php echo base_url() . "admin/applications_healthyrecipes/recipes/" . $recipes['id'] ?>"><?php echo $recipes['id']; ?></a></td>
                                <td><?php echo $recipes['categoty_description'] ?></td>
                                <td><?php echo $recipes['title'] ?></td>
                                <td><?php echo unix_to_human($recipes['created_on']); ?></td>
                                <?php if ($allow_edit) { ?>
                                    <td><a href="<?php echo base_url() . "admin/applications_healthyrecipes/edit_recipe/" . $recipes['id'] ?>">Edit</a></td>
                                    <td><a href="javascript:void(0)" onclick="open_modal_delete_recipe(<?php echo $recipes['id'] ?>)">Delete</a></td>
                                <?php } ?>
                            </tr>
                        <?php } ?> 
                    </tbody>
                </table>
            </div>
        </div>
        <div>
            <input type="button" style="width:120px;" value="Back" id="back_button" onclick="goBackByURL('<?php echo base_url(); ?>admin/applications_healthyrecipes')" class="form-control btn button-custom">
        </div>
    </div>
</div>

<?php $this->load->view("admin/applications/healthy_recipes/modal_delete_recipe"); ?>
