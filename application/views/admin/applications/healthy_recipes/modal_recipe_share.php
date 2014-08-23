<script type="text/javascript">
    $(function share()
    {

    }
    );

</script>
<div class="modal fade" id="modal_recipe_share" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h2 class="modal-title" id="myModalLabel">Share this Recipe</h2>
            </div>
            <div class="modal-body">
                <div class="col-md-5">
                    <img src="<?php echo base_url() . HEALTHY_RECIPES_IMAGE_PATH . $recipe_item['main_picture']; ?>" class="img-responsive"/>
                </div>
                <div class="col-md-7">
                    <h4>Share "<?php echo $recipe_item['title']; ?>" with your friends...</h4>
                </div> 

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="share()">Share</button>
                <button type="button" class="btn btn-danger " data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
