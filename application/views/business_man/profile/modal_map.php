<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">

$(function(){
   
   var geocoder = new google.maps.Geocoder();

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
        });
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