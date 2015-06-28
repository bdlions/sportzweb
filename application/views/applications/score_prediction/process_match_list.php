<script type="text/javascript">
    $(function () {
        sports_id = '<?php echo $sports_id?>';
        date = '2015-06-28';
        get_match_list(date, sports_id);
    });
    function get_match_list(date, sports_id)
    {
        //retrieving matches of all types of sports
        $.ajax({
            dataType: 'json',
            type: "POST",
            url: "<?php echo base_url() . 'applications/score_prediction/get_match_list'; ?>",
            data: {
                date: date,
                sports_id:sports_id
            },
            success: function(data) {
                //generate the leader board content based on the ajax response using template
            }
        });
    }
</script>
