<script type="text/javascript">
    $(function() {
        $("#button_create_sports").on("click", function() {
            $('#modal_create_sports').modal('show');
        });
    });
</script>
<script type="text/x-tmpl" id="tmpl_sports_list">
    {% var i=0, sports_info = ((o instanceof Array) ? o[i++] : o); %}
    {% while(sports_info){ %}
    <tr>
        <td><a href="<?php echo base_url()."admin/applications_xstreambanter/xstream_banter_sports/{%= sports_info.id%}"; ?>">{%= sports_info.title%}</a></td>
        <td>{%= sports_info.total_tournaments%}</td>
    </tr>
    {% sports_info = ((o instanceof Array) ? o[i++] : null); %}
    {% } %}
</script>
                            
<div class="panel panel-default">
    <div class="panel-heading">Sports</div>
    <div class="panel-body">
        <div class="row col-md-12">
            <?php if($allow_access){ ?>
            <div class="row form-group">
                <div class ="col-sm-2 pull-left">
                    <button id="button_create_sports" value="" class="form-control btn button-custom pull-right">Create Sports</button>  
                </div>
                <div class ="col-sm-2 pull-right">
                    <a href="<?php echo base_url();?>admin/applications_xstreambanter/page_import_xstream">
                        <button class="form-control btn button-custom">Import Matches</button>
                    </a>
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div class="table-responsive table-left-padding">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Total tournaments</th>                
                            </tr>
                        </thead>
                        <tbody id="tbody_sports_list">                
                            <?php foreach($sports_list as $sports){?>
                            <tr>
                                <td><a href="<?php echo base_url()."admin/applications_xstreambanter/xstream_banter_sports/".$sports['id']; ?>"><?php echo $sports['title']?></a></td>
                                <td><?php echo $sports['total_tournaments']?></td>
                            </tr>
                            <?php } ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="btn-group" style="padding-left: 10px;">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="goBackByURL('<?php echo base_url();?>admin/overview_show')" class="form-control btn button-custom">
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("admin/applications/xstream_banter/modal_create_sports"); ?>

