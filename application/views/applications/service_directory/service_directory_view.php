<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/css/customStyles.css" />
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=geometry"></script>
<script>
    
//GOOGLE MAP CODE START    
    $(function() {
        var result_arr = [];
        var services = Array();
        var filtered_services = Array();
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
                $.each(services, function(index, service) {
                    var serviceLat = parseFloat(service.latitude);
                    var serviceLon = parseFloat(service.longitude);
                    var hi = google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(serviceLat, serviceLon), new google.maps.LatLng(townLat, townLon));
                    hi = hi / 1000;
                    hi = hi / 1.61;
                    if(hi <= '<?php echo SERVICE_SEARCH_REGION_ML;?>')
                    {
                        var service_text = "<p><h3>" + service.title + "</h3><b>Address</b><br/>" + service.address + "<br>" + service.city + ", " + service.post_code + ".<br><b>Phone:</b> " + service.telephone + "</br><b>Distance: </b>" + Number(hi.toString().match(/^\d+(?:\.\d{0,2})?/)) + " miles<br/><a style= 'font-size:16px;' href='<?php echo base_url(); ?>applications/service_directory/show_service_detail/" + service.id + "'>Details</a></p>";
                        result_arr.push([[service_text], [hi]]);
                        filtered_services.push(service);
                    }                    
                });
                result_arr.sort(function(a, b) {
                    return a[1] - b[1]
                });
                $.each(result_arr, function(index, service_text) {
                    $("#services_displayer").append(service_text[0]);
                });
                
                var map_canvas = document.getElementById('map_canvas');
                var map_options = {
                    center: new google.maps.LatLng(townLat, townLon),
                    zoom: 12,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                var map = new google.maps.Map(map_canvas, map_options);
                $.each(filtered_services, function(index, filtered_service) {
                        var markers = new google.maps.Marker({
                        position: new google.maps.LatLng(filtered_service['latitude'], filtered_service['longitude']),
                        icon: '<?php echo base_url(). SERVICE_DIRECTORY_CATEGORY_IMAGE_PATH ?>'+filtered_service['picture'],
                        map: map
                    });
                    var infowindows = new google.maps.InfoWindow({

                        content: "<a href='"+"<?php echo base_url()?>"+"applications/service_directory/show_service_detail/" + filtered_service['id'] +"'><h4 style='color: limegreen'>" + filtered_service['title'] + "</h4></a><h4>Address:</h4>" + filtered_service['address'] + "<h4>Phone:</h4>" + filtered_service['telephone']
                    });
                    google.maps.event.addListener(markers, 'mouseover', function(event) {
                        infowindows.open(map, markers);
                    });
                    google.maps.event.addListener(markers, 'mouseout', function(event) {
                        setTimeout(function(){
                            infowindows.close();
                        }, <?php echo SERVICE_INFOWINDOW_TIMEOUT; ?>);
                    });
                });
            }
        });
		
        /*var map_canvas = document.getElementById('map_canvas');
        geocoder.geocode({'address': another_town}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK){
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
                console.log("lat2:"+latitude);
                console.log("lng2:"+longitude);
                var map_options = {
                    center: new google.maps.LatLng(latitude, longitude),
                    zoom: 12,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                var map = new google.maps.Map(map_canvas, map_options);
                if (town_code != "london_") {
                    $.each(services, function(index, service) {
                        var reference = 'http://maps.googleapis.com/maps/api/geocode/json?address=' + service['post_code'].replace(/ /g, "+") + '&sensor=false';
                        $.ajax({
                            url: reference,
                            dataType: 'json',
                            async: false,
                            data: null,
                            success: function(data) {
                                if (data.results != undefined && data.results.length > 0) {
                                    var latlng = new google.maps.LatLng(service['latitude'], service['longitude']);
                                    console.log("latlng"+latlng);
                                    var markers = new google.maps.Marker({
                                        position: latlng,
                                        icon: '<?php echo base_url(). SERVICE_DIRECTORY_CATEGORY_IMAGE_PATH ?>'+service['picture'],
                                        map: map
                                    });
                                    var infowindows = new google.maps.InfoWindow({

                                        content: "<a href='"+"<?php echo base_url()?>"+"applications/service_directory/show_service_detail/" + service['id'] +"'><h4 style='color: limegreen'>" + service['title'] + "</h4></a><h4>Address:</h4>" + service['address'] + "<h4>Phone:</h4>" + service['telephone']
                                    });
                                    google.maps.event.addListener(markers, 'mouseover', function(event) {
                                        infowindows.open(map, markers);
                                    });
                                    google.maps.event.addListener(markers, 'mouseout', function(event) {
                                        setTimeout(function(){
                                            infowindows.close();
                                        }, <?php echo SERVICE_INFOWINDOW_TIMEOUT; ?>);
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
        });*/
        
        $('#services_displayer').height($('#services_and_maps').height()-15);
        
        if (town_code != "london_"){
            $("#services_disp").append(
            '<span style="color: royalblue" class="heading_medium_thin">Services near: ' + '<?php echo $selected_services; ?></span>'
            );
        }
    });
//GOOGLE MAP CODE END
</script>

<style type="text/css">
    .selector{
        font-weight: bold;
    }
    .selector img{
        margin-bottom: 8px;
    }
    #services_displayer{
        border: 1px solid #bbb;
        padding: 12px;
        height: 500px;
        overflow: scroll;
    }
    .sd_home_submit{
        border-radius: 0; 
        background-color: #FFC90E;
        color: red;
        font-size: 16px;
        padding: 5px;
        width: 100px;
        height: 41px;
    }
    .sd_home_input{
        border: 3px solid #888888;
        padding: 10px;
        width: 100%;
        font-size: 16px;
        line-height: 16px;
    }
</style>
<div class="col-md-9">
    <?php echo form_open("applications/service_directory/service_directory_map", array('id' => 'form_service_directory', 'class' => 'form-vertical')); ?>
    <div class="row">
        <div class="col-sm-4">
            <div class="row">
                <img class="img-responsive" src="<?php echo base_url().SERVICE_HOME_LOGO_PATH?>" style="width: 100%">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <input placeholder="Enter your location here" class="sd_home_input" name="towncode" id="towncode" value="<?php echo $towncode;?>">
            </div>
        </div>
        <div class="col-sm-2">
            <input class="sd_home_submit btn pull-right" name="submit_service_directory" type="submit" value="Find" id="submit_service_directory">
        </div>
    </div>
    <div class="row form-group" id="services_disp">
        
    </div>
    <div class="row">
        <div class="col-md-3" id="services_displayer">
            <!-- addtess show -->
        </div>
        <div class="col-md-9" id="services_and_maps">
            <div class="row">
                <div class="col-md-12" id="servicesTable">
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
                                        <input id="service_category_<?php echo $service_category_list[$counter]['id']; ?>" 
                                               type="checkbox" name="service[]" 
                                               <?php if (in_array($service_category_list[$counter]['id'], $selected_services_id) ) {
                                                    echo ' checked ';
                                                }?>
                                               value="<?php echo $service_category_list[$counter]['id']; ?>">
                                        <img height="13" width="13" src="<?php echo base_url() . SERVICE_DIRECTORY_CATEGORY_IMAGE_PATH . $service_category_list[$counter]['picture'] ?>" />
                                        <span><?php echo $service_category_list[$counter]['description']; ?></span>
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
            </div>
            <?php echo form_close(); ?>
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