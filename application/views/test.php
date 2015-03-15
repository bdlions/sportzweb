<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/blog_app.css" />
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <input id="input_area" class="form-control">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <input id="regex" class="form-control">
        </div>
        <div class="col-md-1"><button onclick="firett()">Filter</button></div>
    </div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <input id="output_area" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <?php var_dump($arrFULL);?>
            <?php foreach ($arrFULL as $value) {
                var_dump($value);
            };?>
            <?php var_dump('----------break-----------');?>
            <?php var_dump($arrEMPTY);?>
            <?php foreach ($arrEMPTY as $value) {
                var_dump($value);
                var_dump('---entered----');
            };?>
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal fade" id="confirmModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Confirm Vote...</h4>
            </div>
            <div class="modal-body">
                <h3>Are you sure you want to vote?</h3>
            </div>
            <div class="modal-footer">
                <button onclick="post_vote()" type="button" class="btn btn-primary">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <input id="league_id" name="league_id" type="hidden" value="">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>

function firett(){
    var regex = null;
    var intext = $('#input_area').val();
    regex = $('#regex').val();
//    regex = '<(?!\/?(p)|(img)|(a)(?=>|\s.*>))\/?.*?>';
    regex = new RegExp(regex, 'gi');
    $('#output_area').val( null );
    $('#output_area').val( intext.replace( regex, '_' ) );
}



</script>
<script>
    function confirmation_vote(league_id)
    {
        $("#league_id").val(league_id);
        $("#confirmModal").modal("show");
    }
    function post_vote()
    {
        var league_id = $("#league_id").val();
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>' + "asdasd/application/xstreambanter/post_vote",
                dataType: 'json',
                data: {
                    league_id: league_id
                },
                success: function(data) {
                    location.reload();
                }
            });
    }
</script>
<style>
    .blue_banner
    {
        color: white;
        background-color:#3F48CC;
    }
    .title{
        font-size: 20px;
        text-align: center;
    }
    .heading{
        padding: 15px;
        font-size: 25px;
        text-align: center;
    }
    .lr_image
    {
        height: 18px;
        padding: 4px 0px 0px;
    }
</style>



<!--<div class="col-md-6">
    <?php echo 'echo error: ';?>
    <?php echo $error;?>
    <?php var_dump($error);?>

    <?php echo form_open_multipart('test/upload_crop');?>

        <input type="file" name="userfile" size="20" />
        <br /><br />
        <input type="submit" value="upload" />

    <?php echo form_close();?>
        
        
        
</div>-->