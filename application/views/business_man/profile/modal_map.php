<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">

$(function(){
   
   /*var geocoder = new google.maps.Geocoder();

    var map_canvas = document.getElementById('map_canvas');


    var address = '<?php echo $profile->post_code . ", " . $profile->business_city . ", ". $profile->country_name?>';
    geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                //map.setCenter(results[0].geometry.location);
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();

                var map_options = {
                  center: new google.maps.LatLng(latitude, longitude),
                  zoom: 8,
                  mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                var map = new google.maps.Map(map_canvas, map_options);
            } 
            else {
                alert("Location is not found");
            }
        });*/
        var services = Array();
        services = <?php echo json_encode($service_info);?>;
        var town_code = '<?php echo $profile->post_code ?>';
        var map_canvas = document.getElementById('map_canvas');
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': town_code}, function(results, status) {
            if (status === google.maps.GeocoderStatus.OK)
            {
                var latitude = <?php echo $profile->latitude ?>;
                var longitude = <?php echo $profile->longitude ?>;
                var lat_long = new google.maps.LatLng(latitude, longitude);
                var map_options = {
                    center: lat_long,
                    zoom: 17,
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
                                    content: "<span style='color: limegreen'><h4>" + '<?php echo $profile->business_name ?>' + "</h4></span><h4>City:</h4>" + '<?php echo $profile->business_city ?>'
                                });//infowindows.open(map, markers);
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

<!-- Modal -->
<div id="map_canvas" class="google_map_canvas" style="height:300px;margin-top:-10000px"></div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Map</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->