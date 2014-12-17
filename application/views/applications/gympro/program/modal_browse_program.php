<script type="text/javascript">

    function subcategry_select()
    {
        $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>' + "applications/gympro/create_program",
                data: {
                    category_id: $("#subcategry_select").val()
                },
                success: function(data) {
                    alert(data['message']);
                    $("#modal_delete_confirm").modal('hide');
                    window.location.reload();
                }
            });
    }
    function open_modal_browse_exercise() {
        $("#modal_exercise").modal('show');
    }
    
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
                        <?php // echo form_dropdown('exercise_category_list', $exercise_category_list, '', 'class=form-control id=exercise_category_list'); ?>
                        <select onchange="subcategry_select()" name="category_list" class="" id="subcategry_select">
                            <option value="blue">
                                blueback
                            </option>
                            <option value="light">
                                lighted
                            </option>
                        </select>
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