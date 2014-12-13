<script type="text/javascript">
    
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
                            <select class="form-control">
                                <option class="form-control">
                                    name
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