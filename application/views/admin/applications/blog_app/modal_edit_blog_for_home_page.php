<script type="text/javascript">
    $(function() {
        $("#button_save_blog").on("click", function() {
            var selected_array = Array();
            var blog_id;
            $("#tbody_blog_list tr").each(function() {
                $("td:first input:checkbox", $(this)).each(function() {
                    if (this.checked == true)
                    {
                        selected_array.push(this.id);
                        blog_id = this.id;
                    }
                });
            });

            if(selected_array.length == 1) {
                var present_value = $('#get_selected_id').val();
                var id = '#position_of_blog_'+present_value;  
                var position = $(id+"").val(blog_id);
                
                var position_0 = $('#position_of_blog_0').val();
                var position_1 = $('#position_of_blog_1').val();
                var position_2 = $('#position_of_blog_2').val();
                var position_3 = $('#position_of_blog_3').val();
                var position_4 = $('#position_of_blog_4').val();
                var position_5 = $('#position_of_blog_5').val();
                var position_6 = $('#position_of_blog_6').val();
                var position_7 = $('#position_of_blog_7').val();
                
                //alert(position_0 +"<>"+ position_1 +"<>"+position_2+"<>"+position_3+"<>"+position_4+"<>"+position_5);
                
                if(present_value == 0 &&( blog_id == position_1 || blog_id == position_2 || blog_id == position_3 || blog_id == position_4 || blog_id == position_5 || blog_id == position_6 || blog_id == position_7)) {
                 //   alert('This blog is already selected in one position');
                var message = "This blog is already selected in one position";
                 print_common_message(message);
                    return;
                } else if(present_value ==1 && (blog_id == position_0 || blog_id == position_2 || blog_id == position_3 || blog_id == position_4 || blog_id == position_5 || blog_id == position_6 || blog_id == position_7)) {
                  // alert('This blog is already selected in one position');
                  var message = "This blog is already selected in one position";
                 print_common_message(message);
                   return;
                }else if(present_value ==2 && (blog_id == position_0 || blog_id == position_1 || blog_id == position_3 || blog_id == position_4 || blog_id == position_5  || blog_id == position_6 || blog_id == position_7)) {
                   // alert('This blog is already selected in one position');
                   var message = "This blog is already selected in one position";
                 print_common_message(message);
                    return;
                }else if(present_value ==3 && (blog_id == position_0 || blog_id == position_1 || blog_id == position_2 || blog_id == position_4 || blog_id == position_5  || blog_id == position_6 || blog_id == position_7)){
                  //  alert('This blog is already selected in one position');
                  var message = "This blog is already selected in one position";
                 print_common_message(message);
                    return;
                }
                else if(present_value ==4 && (blog_id == position_0 || blog_id == position_1 || blog_id == position_2 || blog_id == position_3 || blog_id == position_5  || blog_id == position_6 || blog_id == position_7)){
                   // alert('This blog is already selected in one position');
                   var message = "This blog is already selected in one position";
                 print_common_message(message);
                    return;
                }
                else if(present_value ==5 && (blog_id == position_0 || blog_id == position_1 || blog_id == position_2 || blog_id == position_3 || blog_id == position_4  || blog_id == position_6 || blog_id == position_7)){
//                    alert('This blog is already selected in one position');
                        var message = "This blog is already selected in one position";
                 print_common_message(message);
                    return;
                }else if(present_value ==6 && (blog_id == position_0 || blog_id == position_1 || blog_id == position_2 || blog_id == position_3 || blog_id == position_4  || blog_id == position_5 || blog_id == position_7)){
                    //alert('This blog is already selected in one position');
                    var message = "This blog is already selected in one position";
                 print_common_message(message);
                    return;
                }else if(present_value ==7 && (blog_id == position_0 || blog_id == position_1 || blog_id == position_2 || blog_id == position_3 || blog_id == position_4  || blog_id == position_6 || blog_id == position_5)){
                   // alert('This blog is already selected in one position');
                   var message = "This blog is already selected in one position";
                 print_common_message(message);
                    return;
                }
                
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo base_url(); ?>' + "admin/applications_blogs/get_selected_blog_data",
                    data: {
                        blog_id: blog_id
                    },
                    success: function(data) {
                        var img_position = $("#image_position_" + present_value);
                        if(img_position != undefined){
                            img_position.attr("src", "<?php echo base_url().BLOG_POST_IMAGE_PATH;?>" + data.picture.replace(/(\r\n|\n|\r)/gm,""));
                        }
                        
                        var title = $("#title_" + present_value);
                        if(title != undefined){
                            var start_anchor = '<a href="<?php echo base_url()?>admin/applications_blogs/blog_detail/'+data.blog_id+'">';
                            var end_anchor = "</a>";
                            title.text($("<div/>").html($("<div/>").html(data.title).text()).text().replace(/(<([^>]+)>)/ig, ""));
                            title.html(start_anchor+title.text()+end_anchor);
                        }
                        
                        var description_ = $("#description_" + present_value);
                        if(description_ != undefined){
                            //description_.text(data.description);
                            var str = data.description;
                            var res = str.substring(0, 256);
                            description_.text($("<div/>").html($("<div/>").html(res).text()).text().replace(/(<([^>]+)>)/ig, ""));
                        }
                    }
                });
                
                $('#modal_edit_blog_home_page').modal('hide');
            } else {
                //alert('You can only select one blog for this position');
                var message = "You can only select one blog for this position";
                 print_common_message(message);
                return ;
            }
           
        //Clear input of modal when modal close
        $('#modal_edit_blog_home_page').on('hidden.bs.modal', function (e) {
            $(this).find("input,textarea,select").val('').end()
              .find("input[type=checkbox], input[type=radio]")
                 .prop("checked", "")
                 .end();
          });
           
        });
    });
</script>
<div class="modal fade" id="modal_edit_blog_home_page" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Blog List</h4>
            </div>
            <div class="modal-body" style="max-height: 300px; overflow-y: auto;">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Check box</th>
                                    <th>Blog Title</th>
                                    <th>Details</th>
                                </tr>
                            </thead>

                            <tbody id="tbody_blog_list">
                            <?php foreach ($blog_list as $key => $blog) :?>
                                <tr>
                                    <td><input id="<?php echo $blog['id'] ?>" name="checkbox[]" class="" type="checkbox" /></td>
                                    <td id="<?php echo $blog['id'] ?>"><?php echo html_entity_decode(html_entity_decode($blog['title'])) ?></td>
                                    <td id="<?php echo $blog['id'] ?>"><?php echo html_entity_decode(html_entity_decode($blog['description'])); ?></td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row form-group">

                    </div>
                </div>                
            </div>
            <div class="modal-footer">
                <button id="button_save_blog" name="button_save_blog" value="" class="btn button-custom">Save</button>

                <button type="button" class="btn button-custom" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
