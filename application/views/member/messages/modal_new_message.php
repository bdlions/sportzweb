<link rel="stylesheet" href="<?php echo base_url()?>resources/bootstrap3/css/user_selection.css"/>
<script type="text/javascript">
    $(function() {
        $("#chat_friends").typeahead([{
                name: "chat_friends",
                prefetch: {
                    url: '<?php echo base_url() ?>search/get_followers/',
                    ttl: 0
                },
                template: [
                    '<div class="col-md-3"><img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-ash3/c5.5.65.65/s56x56/65686_10201374763675922_1110161127_t.jpg"/></div>',
                    '<div class="col-md-9">{{first_name}} {{last_name}}</div>'
                ].join(''),
                engine: Hogan
            }]).on('typeahead:selected', function(obj, datum) {
                $("#chat_friends").val("");
                $("#selected_friends").html('<span class="badge user-token"><input name="participant" type ="hidden" value="' + datum.user_id +'"/>'+ datum.first_name + ' '+ datum.last_name + '<span class="remove" onclick="removeSelectedUser(this)">&times;</span></span>');
        });
        $("#buttonOk").on("click", function(event){
            $("input[name=participant]").each(function(){
                window.location = "<?php echo base_url()?>" + "messages/user/" + $(this).val();
                $("#new_message").modal("hide");
            });
        });
        
    });
    function removeSelectedUser(span){
        span.parentNode.parentNode.removeChild(span.parentNode);
        $("#chat_friends").val("");
    }
</script>
<div class="modal fade" id="new_message" tabindex="-1" role="dialog" aria-labelledby="new_message" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Start New Messages</h4>
            </div>
            
            <!-- Body of the modal -->
            <div class="modal-body">
                <div class="form-control search-user-area">
                    <table width="100%">
                        <tr>
                            <td>
                                <div id="selected_friends"></div>
                            </td>
                            <td width="100%">
                                <input id="chat_friends" class="form-control typeahead search-user" type="text" placeholder="User Name" />
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="buttonOk">Ok</button>
            </div>
        </div>
    </div>
</div>
