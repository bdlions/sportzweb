<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=geometry"></script>
<script>

    $(function() {
        var services = Array();
        services = <?php echo json_encode($service_info);?>;
//        var town_code = '<?php echo $service_info['address'].", ".$service_info['city'].", ".$service_info['country_name'].", ".$service_info['post_code'] ?>';
        var town_code = '<?php echo $service_info['post_code'] ?>';
        var map_canvas = document.getElementById('map_canvas');
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': town_code}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK)
            {
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
                var lat_long = new google.maps.LatLng(latitude, longitude);
                var map_options = {
                    center: lat_long,
                    zoom: 12,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(map_canvas, map_options);
                        $.ajax({
                            url: 'http://maps.googleapis.com/maps/api/geocode/json?address=' + town_code + '&sensor=false',
                            dataType: 'json',
                            async: false,
                            data: null,
                            success: function() {
                                var markers = new google.maps.Marker({
                                    position: lat_long,
                                    map: map
                                });
                                var infowindows = new google.maps.InfoWindow({
                                    content: "<span style='color: limegreen'><h4>" + services['title'] + "</h4></span><h4>Address:</h4>" + services['address'] + "<h4>Phone:</h4>" + services['telephone']
                                });infowindows.open(map, markers);
                            }
                        });
            }
            else
            {
                alert("Location is not found");
            }
        }
        );
    });

</script>
<div class="panel panel-default">
    <div class="panel-heading"><?php echo $service_info['title']; ?></div>
    <div class="panel-body">
        <div class="row col-md-12">
            <div class="row">
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">&nbsp;</div></label>
                        <div class="col-sm-6"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">Name : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['title']; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">Address : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['address']; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">City : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['city']; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">Country : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['country_name']; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">Post Code : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['post_code']; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">Openning Hours : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['opening_hours']; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">Telephone : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['telephone']; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">Website : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['website']; ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-6"><div class="pull-right">Sportzweb Profile : </div></label>
                        <div class="col-sm-6"><?php echo $service_info['business_name']; ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row col-md-12" style="padding: 24px">
            <div id="map_canvas" style="width:100%; height: 450px;"></div>
        </div>
        <div class="btn-group" style="padding-left: 10px;">
                <input type="button" style="width:120px;" value="Back" id="back_button" onclick="javascript:history.back();" class="form-control btn button-custom">
        </div>
    </div>
</div>