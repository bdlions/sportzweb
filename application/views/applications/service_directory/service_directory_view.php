<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=geometry"></script>
<script>
    $(function() {
        var result_arr = [];
        var services = Array();
        var town_code = '<?php echo $towncode == "" ? "london_" : $towncode ?>';
        if (town_code != "london_") {
            services = <?php echo json_encode($services); ?>;
        }
        var another_town = '<?php echo $another_town ?>';
        var townLat;
        var townLon;
		
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': town_code}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK){
                townLat = results[0].geometry.location.lat();
                townLon = results[0].geometry.location.lng();
                if (town_code != "london_"){
                    $("#services_displayer").append('<span style="color: limegreen">Services near: ' + '<?php echo $selected_services; ?></span>');
                }
                $.each(services, function(index, service) {
                    var serviceLat = parseFloat(service.latitude);
                    var serviceLon = parseFloat(service.longitude);
                    var hi = google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(serviceLat, serviceLon), new google.maps.LatLng(townLat, townLon));
                    hi = hi / 1000;
                    hi = hi / 1.61;

                    var service_text = "<p><h3>" + service.title + "</h3><b>Address</b><br/>" + service.address + "<br>" + service.post_code + "," + service.city + "<br><b>Phone:</b> " + service.telephone + "</br><b>Distance: </b>" + Number(hi.toString().match(/^\d+(?:\.\d{0,2})?/)) + " miles<br/><a style= 'font-size:16px;' href='<?php echo base_url(); ?>applications/service_directory/show_service_detail/" + service.id + "'>Details</a></p>";
//                            $("#services_displayer").append(service_text);
                    result_arr.push([[service_text], [hi]]);
                });
                result_arr.sort(function(a, b) {
                    return a[1] - b[1]
                });
                $.each(result_arr, function(index, service_text) {
                    $("#services_displayer").append(service_text[0]);
                });
            }
        });
		
        var map_canvas = document.getElementById('map_canvas');
        geocoder.geocode({'address': another_town}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK){
                //map.setCenter(results[0].geometry.location);
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
                var map_options = {
                    center: new google.maps.LatLng(latitude, longitude),
                    zoom: 12,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                var map = new google.maps.Map(map_canvas, map_options);
                if (town_code != "london_") {
                    $.each(services, function(index, service) {
                        var reference = 'http://maps.googleapis.com/maps/api/geocode/json?address=' + service['address'].replace(/ /g, "+") + '&sensor=false';
                        $.ajax({
                            url: reference,
                            dataType: 'json',
                            async: false,
                            data: null,
                            success: function(data) {
                                if (data.results != undefined && data.results.length > 0) {
                                    var latlng = new google.maps.LatLng(service['latitude'], service['longitude']);

//                                    var pinColor = "cc5533";
//                                    var pinImage =  new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
//                                                    new google.maps.Size(21, 34),
//                                                    new google.maps.Point(0,0),
//                                                    new google.maps.Point(10, 34));
                                    var markers = new google.maps.Marker({
                                        position: latlng,
//                                        icon: pinImage,
//                                        icon: 'images/beachflag.png',
                                        icon: '<?php echo base_url(). SERVICE_DIRECTORY_CATEGORY_IMAGE_PATH ?>'+service['picture'],
                                        map: map
                                    });
                                    var infowindows = new google.maps.InfoWindow({

                                        content: "<a href='"+"<?php echo base_url()?>"+"applications/service_directory/show_service_detail/" + service['id'] +"'><h4 style='color: limegreen'>" + service['title'] + "</h4></a><h4>Address:</h4>" + service['address'] + "<h4>Phone:</h4>" + service['telephone']
                                    });
                                    google.maps.event.addListener(markers, 'mouseover', function(event) {
                                        infowindows.open(map, markers);
                                    });
                                }
                            }
                        });
                    });
                }
            }
            else {
                alert("Location is not found");
            }
        });
    });

</script>

<style type="text/css">
    .selector{
        font-weight: bold;
    }
    .selector img{
        margin-bottom: 8px;
    }
</style>
<script>
    $(function() {
        $("#div_more a").click(function()
        {
            $(this).hide();
        });
    });
    $(function() {
        var divh = document.getElementById('servicesTable').offsetHeight;
        document.getElementById('destin').style.height = divh + 'px';
    });

    $(window).bind("load", function() {
        var divh = document.getElementById('servicesTable').offsetHeight;
        document.getElementById('destin').style.height = divh + 'px';
    });
</script>
<div class="col-md-9">
    <div class="row">
        <div class="col-md-12">
            <span class="heading_small" style="font-size: 16px;">FIND SPORTS HEALTH AND FITNESS SERVICES</span>
            <?php echo form_open("applications/service_directory", array('id' => 'form_service_directory', 'class' => 'form-vertical')); ?>
            <div class="form-group" style="padding-top: 16px">
                <span class="content_text">Enter your town or postcode: </span> <?php echo form_input('towncode'); ?>
            </div>
        </div>
    </div>
    <div class="row" style="padding-top: 16px;"><!--work here-->
        <div class="col-md-3" style="border-left: 1px solid #777777; padding: 12px; height: 700px; overflow: scroll;" id="services_displayer">
            <!-- addtess show -->
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-10" id="servicesTable">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody id="tbody_service_category_list">
                                <?php
                                    $column = 1;
                                    $nos_services = count($service_category_list);
                                    for ($counter = 0; $counter < $nos_services; $counter++) {
                                        if (($counter % 3) == 0) {
                                            $column = 1;
                                            echo '<tr>';
                                        }
                                ?>
                                <td style="border: none;padding-bottom:0px;padding-top:0px;">
                                    <div class="input-group selector">
                                        <input id="<?php echo $service_category_list[$counter]['id']; ?>" type="checkbox" name="service[]" value="<?php echo $service_category_list[$counter]['id']; ?>">
                                        <img src="<?php echo base_url() . SERVICE_DIRECTORY_CATEGORY_IMAGE_PATH . $service_category_list[$counter]['picture'] ?>" /> <?php echo $service_category_list[$counter]['description']; ?>
                                    </div>
                                </td>
                                <?php
                                    if ($counter % 3 == 0 && $column == 3) {
                                        echo '</tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-2" style="position: relative;" id="destin">
                    <div class="form-group" style="position: absolute; bottom: 2px; width: 70px;">
                    <?php echo form_input(array('name' => 'submit_service_directory', 'id' => 'submit_service_directory', 'type' => 'submit', 'style' => 'width:100%', 'class' => 'btn btn-success', 'value' => 'Find')); ?>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="map_canvas" style="width:100%; height: 450px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-3">

</div>