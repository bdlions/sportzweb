<script type="text/javascript">
    $(function() {
        $("#button_create_blog_category").on("click", function() {
            $('#modal_create_blog_category').modal('show');
        });
    });
</script>  
<script type="text/x-tmpl" id="tmpl_blog_category_list">
    {% var i=0, blog_category_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(blog_category_info){ %}
    <tr>
    <td><a href="<?php echo base_url() . "admin/applications_blogs/blog_list/{%= blog_category_info.id%}"; ?>">{%= blog_category_info.id%}</td>
    <td><div id="blog_desc_{%= blog_category_info.id%}">{%= blog_category_info.title%}</div></td>
    <td><button id="button_edit_blog_category_{%= blog_category_info.id%}" onclick="openModal('button_edit_blog_category_{%= blog_category_info.id%}','{%= blog_category_info.id%}')" value="" class="form-control btn pull-right">Edit</button></td>
    <td><button id="button_delete_blog_category_{%= blog_category_info.id%}" onclick="openDeleteModal('button_delete_blog_category_{%= blog_category_info.id%}','{%= blog_category_info.id%}')" value="" class="form-control btn pull-right">Delete</button></td>
    </tr>
    {% blog_category_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>

<!--Written By Omar for remove selected category -->
<script type="text/javascript">
    $(function() {
        /*$("#tbody_blog_category_list").on("click", "button", function(e) {
         alert('here');
         //console.log(this.id);
         var target = e.target;
         //console.log(target);
         $(target).closest('tr').remove();
         });*/
    });
</script>

<div class="panel panel-default">
    <div class="panel-heading">Blog Categories</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row form-group">
                <?php if ($allow_write) { ?>
                    <div class ="col-sm-3">
                        <a href="<?php echo base_url(); ?>admin/applications_blogs/page_import_blogs">
                            <button class="btn button-custom pull-right">Import Blogs</button>
                        </a>
                    </div>
                <?php } ?>
                <?php if ($allow_approve) { ?>
                    <div class ="col-sm-3">
                        <a href="<?php echo base_url(); ?>admin/applications_blogs/approve_blog">
                            <button id="" value="" class="btn button-custom pull-right">Approve Blogs</button>  
                        </a>
                    </div>
                <?php } ?>
                <?php if ($allow_configuration) { ?>
                    <div class ="col-sm-3">
                        <a href="<?php echo base_url(); ?>admin/applications_blogs/config_blog">
                            <button id="" value="" class="btn button-custom">Manage Blog Home Page</button>  
                        </a>
                    </div>
                <?php } ?>
                <?php if ($allow_write) { ?>
                    <div class ="col-sm-3">
                        <button id="button_create_blog_category" value="" class="btn button-custom">Create Blog Category</button>  
                    </div>
                <?php } ?>
            </div>

            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered" style="text-align: center;">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Id</th>
                                <th style="text-align: center;">Name</th>
                                <?php if ($allow_edit) { ?>
                                    <th style="text-align: center;">Edit</th> 
                                <?php } ?>
                                <?php if ($allow_delete) { ?>
                                    <th style="text-align: center;">Delete</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="tbody_blog_category_list">
                            <?php foreach ($category_list as $row): ?>
                                <tr>
                                    <td><a href="<?php echo base_url() . 'admin/applications_blogs/blog_list/' . $row['id'] ?>"><?php echo $row['id']; ?></a></td>
                                    <td><div id="blog_desc_<?php echo $row['id']; ?>"><?php echo $row['title']; ?></div></td>
                                    <?php if ($allow_edit) { ?>
                                        <td>                                            
                                            <button id="button_edit_blog_category_<?php echo $row['id']; ?>" onclick="openModal('button_edit_blog_category_<?php echo $row["id"]; ?>', '<?php echo $row['id']; ?>')" value="" class="form-control btn pull-right">
                                                Edit
                                            </button>                                            
                                        </td>
                                    <?php } ?>
                                    <?php if ($allow_delete) { ?>
                                        <td>                                            
                                            <button id="button_delete_blog_category_<?php echo $row['id']; ?>" onclick="openDeleteModal('button_delete_blog_category_<?php echo $row["id"]; ?>', '<?php echo $row['id']; ?>')" value="" class="form-control btn pull-right">
                                                Delete
                                            </button>                                            
                                        </td>                                        
                                    <?php } ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <table class="table table-bordered" style="text-align: center;"> 
                        <tbody id="tbody_custom_blog_category_list">
                            <?php foreach ($custom_category_list as $row): ?>
                                <tr>
                                    <td><a href="<?php echo base_url() . 'admin/applications_blogs/blog_list/' . $row['id'] ?>"><?php echo $row['id']; ?></a></td>
                                    <td><div id="custom_blog_desc_<?php echo $row['id']; ?>"><?php echo $row['title']; ?></div></td>
                                    <?php if ($allow_edit) { ?>
                                        <td>                                            
                                            <button id="button_edit_custom_blog_category_<?php echo $row['id']; ?>" onclick="openCustomModal('button_edit_custom_blog_category_<?php echo $row["id"]; ?>', '<?php echo $row['id']; ?>')" value="" class="form-control btn pull-right">
                                                Edit
                                            </button>                                            
                                        </td>
                                    <?php } ?>
                                    <?php if ($allow_delete) { ?>
                                        <td>                                            
                                            <button id="button_delete_custom_blog_category_<?php echo $row['id']; ?>" onclick="openDeleteModal('button_delete_blog_custom_category_<?php echo $row["id"]; ?>', '<?php echo $row['id']; ?>')" value="" class="form-control btn pull-right">
                                                Delete
                                            </button>                                            
                                        </td>                                        
                                    <?php } ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="btn-group" style="padding-left: 25px;">
                    <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
                </div>
            </div>            
        </div>
    </div>
</div>
<?php $this->load->view("admin/applications/blog_app/modal_create_blog_category"); ?>
<?php $this->load->view("admin/applications/blog_app/modal_edit_blog_category"); ?>
<?php $this->load->view("admin/applications/blog_app/modal_delete_blog_category"); ?>

<?php $this->load->view("admin/applications/blog_app/modal_edit_custom_blog_category"); ?>
