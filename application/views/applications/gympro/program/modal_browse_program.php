<script type="text/javascript">

    function subcategry_select()
    {
        $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>' + "applications/gympro/subcategory_get",
                data: {
                    category_id: $("#exercise_category_list").val()
                },
                success: function(data) {
                    
                    //todo database info plm
//                   $("#tbody_subcategory_list").html(tmpl("tmpl_subcategory_list", subcategory_info));
                }
            });
    }
    function open_modal_browse_exercise() {
        $("#modal_exercise").modal('show');
    }
    
</script>
<script type="text/x-tmpl" id="tmpl_subcategory_list">
    {% var i=0, subcategory_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(subcategory_info){ %}
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-4">image="<?php echo '{%= subcategory_info.picture%}'; ?>"</div>
            <div class="col-md-8">name="<?php echo '{%= subcategory_info.name%}'; ?>"</div>
        </div>
    </div>
    

    {% subcategory_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>

<div class="modal fade" id="modal_exercise" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Browse Exercise</h4>
            </div>
            <div class="modal-body">

                <div class="row form-group">
                    <div class="col-md-4">
                        <?php echo form_dropdown('exercise_category_list', $exercise_category_list, '', 'class=form-control id=exercise_category_list onchange=subcategry_select()'); ?>
                    </div>
                    <div class="col-md-8">
                        <span>right side</span>
                    </div>

                </div>
                <div class="row form-group">
                    <div class="col-md-4">
                        first 
                    </div>
                    <div class="col-md-4">
                        second
                    </div>
                    <div class="col-md-4">
                        3rd
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class ="col-md-9">

                </div>
                <div class ="col-md-3">
                    <button style="width:100%" type="button" class="btn button-custom" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->