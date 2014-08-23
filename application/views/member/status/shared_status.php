<link rel="stylesheet" href="<?php echo base_url()?>resources/bootstrap3/css/user_selection.css"/>
<script type="text/javascript">
    function click_comment(status_id)
    {
        $("#text_input_comment_"+status_id).focus();
    }
    function click_like_feed_post(status_id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "like/store_status_like",
            data: {
                status_id: status_id
            },
            success: function(data) {
                 window.location.reload();                     
            }
        });
    }
    
    function click_unlike_feed_post(status_id)
    {
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "like/remove_status_like",
            data: {
                status_id: status_id
            },
            success: function(data) {
                 window.location.reload();                    
            }
        });
    }
    
    function show_liked_user_list(status_id)
    {       
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "like/get_status_liked_user_list",
            data: {
                status_id: status_id
            },
            success: function(data) {
                $('#modal_liked_user_list').modal('show');     
                $("#liked_user_list").html(tmpl("tmpl_liked_user_list",  data));                      
            }
        });
    }
    
    function click_share_feed_post(status_id)
    {
        $('#modal_status_share').modal('show');
        $('#share_status_id').val(status_id);
        /*$.ajax({
            dataType: 'json',
            type: "POST",
            url: '<?php echo base_url(); ?>' + "share/share_status",
            data: {
                status_id: status_id
            },
            success: function(data) {
                 //window.location.reload();                    
            }
        });*/
    }
</script>
<?php 
    $this->data['newsfeed'] = $newsfeed;  
    $this->load->view("member/newsfeed/status", $this->data); 
?>
<?php $this->load->view("member/newsfeed/modal_liked_user_list"); ?>
<?php $this->load->view("member/newsfeed/modal_status_share"); ?>