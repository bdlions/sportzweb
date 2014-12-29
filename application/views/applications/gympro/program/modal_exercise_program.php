<script type="text/javascript">

    function subcategry_select()
    {
        if ($("#exercise_category_list").val()==0)
        {
            $("#subcategory_view").html("");
            return;
        }
          
        $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "applications/gympro/program_subcategory_list",
                data: {
                    category_id: $("#exercise_category_list").val()
                },
                success: function(data) {
                    $("#subcategory_view").html(tmpl("tmpl_subcategory_list", data.subcategory_list));
                }
            });
    }
    function open_modal_browse_exercise(number) {
        $("#hf_numb").val(number);
        $("#modal_exercise").modal('show');
    }
    function set_subcategory_name(value){
        var position = $("#hf_numb").val();
        $( "input[name='name_" + position + "']" ).val(value);
        $("#modal_exercise").modal('hide');
    }
    
</script>
<img onclick="set_subcategory_name(<?php echo '{%= subcategory_list.title%}'; ?>)">
<script type="text/x-tmpl" id="tmpl_subcategory_list">
    {% var i=0, subcategory_list = ((o instanceof Array) ? o[i++] : o); %}
    {% var count=0;  %}
    <div class="row">
    {% while(subcategory_list){ %}
    {% if( count%3 == 0 ){ %}
    </div>
    <div class="row">
    {% } %}
    <div class="col-md-4">
        <div class="row form-group">
            <div class="col-md-4">
                <img onclick="set_subcategory_name('<?php echo "{%= subcategory_list.title%}"; ?>')" src="<?php echo base_url().PROGRAM_EXERCISE_SUBCATEGORY_PICTURE_PATH_W50_H50.'{%= subcategory_list.picture%}';?>">
            </div>
            <div class="col-md-8">
                <?php echo '{%= subcategory_list.title%}'; ?>
            </div>
        </div>
    </div>
    {%  count++;  %}
    {% subcategory_list = ((o instanceof Array) ? o[i++] : null); %}
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
                        <?php echo form_dropdown('exercise_category_list', $exercise_category_list, '0', 'class=form-control id=exercise_category_list onchange=subcategry_select()'); ?>
                    </div>
                    <div class="col-md-8">
                        <span>Click on an exercise below to add it to the programme</span>
                    </div>
                    <input type=hidden id="hf_numb" >

                </div>
                <div class="form-group">
                    
                    <div id="subcategory_view">
                        
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