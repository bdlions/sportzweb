<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=geometry"></script>
<script>
    var services = JSON.parse('<?php echo json_encode($services)?>');
    
    for( var prop in services ){
        lat_long(services[prop].id, services[prop].post_code);
    }
    var all_retrived_latlong = [];
    var num_completed = 0;
    function lat_long(id, post_code)
    {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': post_code}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK)
            {
                var serviceLat = results[0].geometry.location.lat();
                var serviceLon = results[0].geometry.location.lng();
                all_retrived_latlong.push([id, serviceLat, serviceLon]);
                num_completed++;
                if (num_completed == '<?php echo sizeof($services);?>')
                {
                    submit_latlong();
                }
            }
        });
    }
    function submit_latlong()
    {
        jQuery.each(all_retrived_latlong, function (i, retrived_latlong) {

            $.ajax({
                dataType: 'json',
                type: "POST",
                url: '<?php echo base_url(); ?>' + "admin/applications_servicedirectory/auto_retrive_and_store_latlong",
                data: {
                    id: retrived_latlong[0],
                    lat: retrived_latlong[1],
                    long: retrived_latlong[2]
                },
                success: function (data) {
                    alert(data['message']);
                    window.history.back();
                }
            });
        });
        $('#text_place').html('<div class="alert alert-success alert-dismissible">'+num_completed+' entrie(s) updated successfully.</div>');
    }
</script>
<div class="panel panel-default">
    <div class="panel-heading">Auto retrieve and store latitude and longitude</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div id="text_place"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <button class="button-custom btn form-control" onclick="window.history.back();">Back</button>
            </div>
        </div>
    </div>
</div>




