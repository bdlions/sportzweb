<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>resources/bootstrap3/css/bmi_calculator.css" />
<style>
    .btn-default
    {
        background-color: gray;
    }
    .btn-default:hover
    {
        background-color: gray;
    }
</style>
<div class="col-md-9">
    <div class="col-md-12">
        <div class="col-md-5">
            <div class="form-group">
                <label style="width: 159px; text-align: right" for="btn-group">Select your gender: </label>
                <div class="btn-group" style="padding-left: 1px" > 
                    <button class="btn btn-success active" id="button_male" style="border-radius:0 !important; border: 2px solid #22b14c;" >&nbsp;Male&nbsp;</button>
                    <button class="btn" id="button_female" style="margin-left: 12px; border-radius:0 !important; border: 2px solid #22b14c;" >&nbsp;Female&nbsp;</button>
                </div>
            </div>
            <div class="form-group">
                
                <label style="width: 159px; text-align: right" for="btn-group">Choose unit of measurements: </label>
                <div class="btn-group" style="padding-left: 1px"> 
                    <button class="btn btn-success active" id="button_metric" style="border-radius:0 !important; border: 2px solid #22b14c;">Metric</button>
                    <button class="btn" id="button_imperial" style="margin-left: 10px;  border-radius:0 !important; border: 2px solid #22b14c;">Imperial</button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <span class="grey_title ">BMI Calculator</span>
        </div>
    </div>
    <div class="row col-md-12">
<!--        <svg id="human" x="0px" y="0px" width="64px" height="400" viewBox="0 0 64 220" enable-background="new 0 0 64 220" xml:space="preserve">
            <g id="human_point">
                <polyline display="inline" fill="#FF0000" stroke="#FFFFFF" stroke-miterlimit="10" points="11.875,51.25 11.875,53.875 11.875,60.938 13.25,74.313 14.188,78.25 38.063,112.625 38.063,120.688 29.188,120.688 29.625,114.063 7.25,83.438 5.625,74.625 1,53 1,44.063 18.188,33.313 18.188,22.188 16,19.938 15.438,14.563 14.875,7 17.063,4.688 20.938,2.125 25.688,1.125 31,1.125 34.5,2.188 37,3.375 37.188,6.938 37.375,20 36,21 35.125,27.313 34.063,28.75 29.75,29 30.188,36.313 43,43.188 43.5,67.813 45.188,68.188 49.75,83.25 52.063,106.313 60.375,113.938 60.375,115.063 57.313,114.875 58.063,123.75 54.438,124.063 51.688,123.688 49.688,121.688 49.813,116.25 48,114.75 48.063,107.813 46.875,104.5 42.313,89.375 41.375,79.5 40.563,79.813 40.625,85.188 41.625,94.938 42.563,97.375 43,130 42.188,131.188 42,149.625 40.625,149.625 40.5,163.188 39,179.625 36.875,204.625 37.563,205.438 46,213.063 45.938,214.625 37.625,215.188 35.25,213 30.188,212.875 29.875,208.125 29.688,186.5 29.063,186.375 29.438,159.438 30.188,159.313 28.938,136.375 28.063,121.938 27.063,121.938 26.625,123.625 25.688,129.875 24.25,143.875 22.438,161 20.5,177.625 19.25,190.625 20.563,207.25 29.938,214.688 32,217.063 30.688,217.563 28.875,218.25 17.938,217.313 15,215.375 13.125,214.625 11.75,212.813 11.813,192.75 10.563,180.688 9.938,173.125 10.375,163.813 12.688,151.938 12.75,139.438 11.875,124.875 10.75,114 10,107.625 9.875,90.813 9.625,88"/>
            </g>
        </svg>-->
        <div class="col-md-2" style="padding-top: 30px;">
        <img id="show_img" class="image-responsive" height="100" width="100" src="<?php echo base_url()?>resources/images/male-icon.png">
        </div>
        <div class="col-md-10">
        <canvas id="myCanvas" width="750" height="320"></canvas>
        </div>
    </div>
    <div class="row col-md-12">
        <div class="row col-md-offset-3 col-md-8 result_box" style="font-size:17px;">
            <div class="col-md-5">Your BMI is: <span style="color: green" id="bmi_value">123</span></div>
            <div class="col-md-7">Your BMI catagory is: <span style="color: green" id="bmi_status">Healthy</span></div>
        </div>
    </div>
</div>
<div class="col-md-3" style="padding-left: 0px; padding-right: 0px;" id="question_panel">
    <?php foreach($questions_list as $question):?>
    <div class="row col-md-12">
        
        <span class="heading_medium" style="color: #4E8C03;"><?php echo $question['question'];?></span>
        <p></p>
        <span class="content_text"><?php echo $question['answer']?></span>
        <p></p><p></p>
    </div>
        
    <?php endforeach;?>
    
</div>




<script>
//    $('.btn-toggle').click(function() {
//        
//        $(this).find('.btn').toggleClass('active');  
//        
//        if ($(this).find('.btn-primary').size()>0) {
//            $(this).find('.btn').toggleClass('btn-primary');
//        }
//        if ($(this).find('.btn-danger').size()>0) {
//            $(this).find('.btn').toggleClass('btn-danger');
//        }
//        if ($(this).find('.btn-success').size()>0) {
//            $(this).find('.btn').toggleClass('btn-success');
//        }
//        if ($(this).find('.btn-info').size()>0) {
//            $(this).find('.btn').toggleClass('btn-info');
//        }
//
//        $(this).find('.btn').toggleClass('');
//
//    });

    $('form').submit(function(){
            alert($(this["options"]).val());
        return false;
    });
    
    var adv = <?php echo $show_advertise?>;
    if(adv == 1) $('#question_panel').hide();
    
</script>

<script type="text/javascript">
            var male = true;
            
            var metric_flag = true;
            $(function() {

                
                /*some constant vaules for initialize the graph*/
                var X_POS_UPPER_LIMIT = 559,X_POS_LOWER_LIMIT = 138;
                var Y_POS_UPPER_LIMIT = 232,Y_POS_LOWER_LIMIT = 8;
                var GRAPH_X_POS = 100, GRAPH_Y_POS = 36, GRAPH_WIDTH = 490, GRAPH_HEIGHT = 270;
                var XMARKER_WIDTH = 113, XMARKER_HEIGHT = 59;
                var YMARKER_WIDTH = 71, YMARKER_HEIGHT = 74;
                var XMARKER_Y_POS = 216;
                var YMARKER_X_POS = 30;
                
//                var male = true;
                
                var xmarker_x_pos = 200;
                var ymarker_y_pos = 50;
//                var initMalePointsString =      "11.875,51.25 11.875,53.875 11.875,60.938 13.25,74.313 14.188,78.25 38.063,112.625 38.063,120.688 29.188,120.688 29.625,114.063 7.25,83.438 5.625,74.625 1,53 1,44.063 18.188,33.313 18.188,22.188 16,19.938 15.438,14.563 14.875,7 17.063,4.688 20.938,2.125 25.688,1.125 31,1.125 34.5,2.188 37,3.375 37.188,6.938 37.375,20 36,21 35.125,27.313 34.063,28.75 29.75,29 30.188,36.313 43,43.188 43.5,67.813 45.188,68.188 49.75,83.25 52.063,106.313 60.375,113.938 60.375,115.063 57.313,114.875 58.063,123.75 54.438,124.063 51.688,123.688 49.688,121.688 49.813,116.25 48,114.75 48.063,107.813 46.875,104.5 42.313,89.375 41.375,79.5 40.563,79.813 40.625,85.188 41.625,94.938 42.563,97.375 43,130 42.188,131.188 42,149.625 40.625,149.625 40.5,163.188 39,179.625 36.875,204.625 37.563,205.438 46,213.063 45.938,214.625 37.625,215.188 35.25,213 30.188,212.875 29.875,208.125 29.688,186.5 29.063,186.375 29.438,159.438 30.188,159.313 28.938,136.375 28.063,121.938 27.063,121.938 26.625,123.625 25.688,129.875 24.25,143.875 22.438,161 20.5,177.625 19.25,190.625 20.563,207.25 29.938,214.688 32,217.063 30.688,217.563 28.875,218.25 17.938,217.313 15,215.375 13.125,214.625 11.75,212.813 11.813,192.75 10.563,180.688 9.938,173.125 10.375,163.813 12.688,151.938 12.75,139.438 11.875,124.875 10.75,114 10,107.625 9.875,90.813 9.625,88";
//                var targetMalePointString = "15.875,52.25 16.563,54.063 17.688,59.813 19,72.063 21.375,78.875 41.25,111.438 41.188,121.313 30.75,120.063 30,113.813 7.25,83.438 3.938,74.813 1,53 1,44.063 18.188,33.313 19.375,21.938 18,19.125 16.938,14.375 16.438,7.375 17.063,4.688 20.938,2.125 25.188,0.438 31.875,0.375 36.875,1.313 38.063,3.25 38.938,7.25 38.875,20 38.477,23.406 36.625,28.063 34.063,28.75 33.561,28.779 36,34.438 44.875,42.375 52.938,63.875 54.875,71.75 62.75,87.625 57.567,106.171 60.938,113.313 62.063,115 58.688,115.25 60.188,124 55.125,123.563 53.313,122.625 51.813,121.438 52.811,116.959 53.875,114.875 54.461,109.313 55.5,104.5 62.063,93.5 62.063,86 62.063,86 62.625,93 57.752,100.725 55.5,104.5 50.063,129.688 49.563,137.125 48.125,152.313 46.5,155.75 45.125,165.188 43.563,181.75 40.063,204.563 40.813,205.875 48.375,213.938 47.75,216.125 37.625,215.188 35.25,213 30.188,212.875 31.25,208.125 29.688,186.5 29.063,186.375 28.188,159.5 29.438,158.313 25.875,136.625 26.313,122.188 27.063,121.938 27.438,123.938 27.313,129.813 28.5,143.813 26.563,162.125 25.25,178.5 24.438,191.75 25.125,207.625 31.875,214.75 33.688,217.313 32,218.25 28.875,218.25 18.125,216.938 15,215.375 14.063,214.563 13.5,212.938 12.125,192.625 8.813,180.25 8.813,172.75 8.563,163.438 9.938,151.75 8.125,138.688 6.875,124.438 6.875,113.438 1.125,107.25 1.625,91.25 5.813,83.375";
//                
//                var initFemalePointsString =      "11.884,68 10.545,72 10.545,75.333 11.214,81 11.884,84.667 13.223,92.333 15.632,101.333 18.042,109 20.72,118 23.13,127 24.737,134.667 26.344,140.667 29.557,146.75 31.164,154 31.164,157.667 25.809,162.333 23.398,162.333 19.382,157 19.382,155 20.854,154 22.327,153.667 22.327,150.333 20.854,150.333 20.854,141.333 19.114,135.333 16.972,131 14.829,123.333 12.151,115.167 8.938,107 7.332,99.333 5.992,92 3.85,82.333 1.172,70 -0.167,66 -0.167,60 3.85,54.333 8.67,51 17.507,44.667 18.042,37 17.507,33 15.499,31.333 12.687,31.333 11.348,37.333 10.277,41.333 11.616,45.333 14.293,44.667 15.499,42 17.768,34.946 18.102,30.353 10.336,32.353 9.474,29 10.009,25.333 9.742,17.333 11.08,10.667 15.499,6.667 20.185,3 27.683,3 32.57,6.333 31.833,10.976 28.218,16.333 18.177,25.333 16.972,28.333 20.72,38 27.415,41 31.164,40 33.842,34.667 35.448,26.333 35.448,23.333 34.109,22.667 34.109,21 35.448,20.667 36.52,16.333 33.842,8 28.218,16.333 22.327,21.333 18.177,25.333 16.972,28.333 18.177,32 22.873,38.964 27.415,41 29.022,45 29.557,48 34.645,47.333 34.109,37.667 34.645,47.333 38.93,50.667 41.34,55.333 41.34,65.333 44.82,72 46.16,76.667 43.75,80.667 48.57,99.667 52.318,116.667 55.8,133.667 57.139,138.667 60.62,142.333 62.762,148.333 63.834,152.667 62.762,154 61.155,150.333 59.816,154.333 56.871,159.667 53.657,160.667 50.712,156.667 51.515,152 52.854,142 53.925,138.333 50.98,129.667 45.356,115.333 40.804,100.333 42.679,96 42.946,84 42.144,82.667 41.071,95 38.93,102 40.001,111.667 41.34,119 43.214,128.333 44.82,143 44.554,157.667 44.82,176 45.088,191.333 44.82,205 44.285,219 44.285,238 43.75,253.667 44.285,268.333 44.82,273.333 46.428,276.667 48.838,279.333 50.712,281.333 53.122,283.667 54.997,285.333 54.997,287 43.481,287 42.946,284.333 39.197,284 39.465,274.667 38.394,259 36.52,241.667 34.109,227 32.57,220 32.57,208.667 32.57,203 32.57,187.667 31.833,173.333 29.825,167 29.557,162 23.398,165 23.398,174 20.988,193 20.185,209.667 18.311,225.667 16.704,243 15.632,262.667 15.365,275.667 16.972,278.667 20.185,282 24.469,287 27.147,287 26.076,290.333 15.365,290.333 9.742,287.333 8.402,284.667 9.474,280 8.938,254.333 8.135,240 7.332,223.667 8.938,212 9.742,201.667 9.474,170.333 8.135,144.333 10.813,116";
//                var targetFemalePointString = "15.667,68.333 17.351,77.667 17.351,82.667 18.193,90.667 19.035,98 21,105 23.526,111.667 25.21,117 26.333,125 28.298,133 29.702,140.333 30.965,147 31.526,149.667 32.053,156 30.965,161 27.587,164.345 24.402,162.948 22.965,160 22.123,157.333 21.813,155.675 22.123,157.333 22.965,151 21.842,147 21.842,144.333 17.632,136.333 15.386,132 12.018,126 10.333,116.167 9.492,108.333 5.281,100.333 3.877,93 1.632,83.333 2.193,71 2.193,67.333 2.474,61 4.897,53.179 6.685,52 17.07,46.667 18.754,41 17.527,33.043 12.86,38 12.018,41.667 13.982,46.333 17.537,45.097 18.754,41 18.167,37.189 17.754,34.518 14.447,36.037 10.895,35.667 10.053,33 12.018,28.333 11.456,23.667 12.298,15.333 13.14,10.667 21,4 31.526,4 32.053,6 33.07,9 31.983,12.304 28.298,17.667 21.281,22.333 17.351,28.667 16.44,32.834 19.035,33.333 24.369,41.667 31.526,44.333 34.754,42 37,36.333 37,31 37.145,25.672 35.878,22.667 36.438,17.667 35.035,13 33.07,9 30.528,16.133 24.417,20.248 19.312,25.506 17.351,28.667 19.035,33.333 20.85,38.362 24.369,41.667 26.369,43.391 28.879,43.85 33.912,46.667 37.562,49.333 42.963,52.006 44.859,54.667 45.701,62 46.825,68.667 49.912,73 52.438,77 53.28,81.333 51.315,86.667 50.474,91.333 53,96.667 53.905,101.858 56.93,107 58.192,114.775 58.842,119.805 59.248,124.288 58.053,132.667 57.772,138.667 59.496,142 62.263,146.5 63.667,154.333 61.705,152.25 60.226,149.728 59.456,153.333 58.895,156.333 58.333,159.333 56.088,160.667 56.648,152.667 54.965,156 55.246,174 53.651,185.147 53.805,190.162 51.776,194.81 50.221,202.443 49.069,207 49.632,212.406 49.182,219.69 49.443,226.649 49.309,234.968 48.91,245.623 48.563,253.671 47.957,265.637 48.118,269.886 47.386,274.667 49.351,277.667 51.315,280.667 51.315,280.667 54.403,282.333 56.368,284.333 58.333,287 44.886,287.887 42.614,285.333 38.685,285 37.562,275.333 34.754,260.333 32.088,248 29.982,235 28.86,224 28.86,215.333 29.982,205 29.982,198 29.702,190.333 28.086,190.34 27.77,194.844 27.176,197.667 26.333,206.667 25.491,220.667 24.232,230.226 23.242,239.332 22.05,250.159 20.948,260.382 19.035,277 22.136,281.318 25.712,285.885 28.86,289 14.825,289 9.492,288.667 9.21,282.667 9.772,271.333 8.088,255.333 5.208,236.693 4.439,222 5.281,209 7.246,196.333 4.158,179.333 -0.333,157.333 -0.333,136.667 1.632,118.333 1.913,90.667";

               
                /*Initialize the canvas*/
                var canvas = document.getElementById('myCanvas');
                /*get the canvas context*/
                var context = canvas.getContext('2d');

                var images = {};
                /*all images to load in the context of the canvas*/
                var sources = {
                    graph: '<?php echo base_url()?>resources/images/graph_metric.png',
                    imperial_graph: '<?php echo base_url()?>resources/images/graph_imperial.png',
                    xmarker: '<?php echo base_url()?>resources/images/xmarker.png',
                    ymarker: '<?php echo base_url()?>resources/images/ymarker.png'
                };

                /*Load all images and set in the context*/
                loadImages(sources, function(images) {
                    drawImages();
                });
                /*Redraw window after 100 miliseconds*/
                setInterval(function(){
                    context.clearRect(0, 0, canvas.width, canvas.height);
                    drawImages();
                    drawHuman();
                    drawPointer();   
                    drawText();
                    
                }, 10);
                
                
                $(canvas).on("mousedown", function(event){
                    //var startX = event.clientX;
                    //var startY = event.clientY;
                    var mousePos = getMousePos(canvas, event);
                    var startX = mousePos.x;
                    var startY = mousePos.y;
                    
                    //console.log("x = " + startX);
                    //console.log("y = " + startY);
                    $(canvas).bind("mousemove", function(event){
                        /*Change x or y marker according to thery draggability*/
                         mousePos = getMousePos(canvas, event);
                         if(isXMarkerDragable(startX, startY)){
                            xmarker_x_pos += (mousePos.x - startX);
                            //console.log("X = " + xmarker_x_pos);
                         }
                         else if(isYMarkerDragable(startX, startY)){
                            ymarker_y_pos += (mousePos.y - startY);
                            //console.log("Y = " + ymarker_y_pos);
                         }

                        /*Update start position*/
                        startX = mousePos.x;
                        startY = mousePos.y;
                        
                    });
                    
                });
                
                $(canvas).on("mouseup", function(event){
                    $(canvas).unbind("mousemove");
                });
                $(window).on("mouseup", function(event){
                    $(canvas).unbind("mousemove");
                });
                function getMousePos(canvas, evt) {
                    var rect = canvas.getBoundingClientRect();
                    return {
                      x: evt.clientX - rect.left,
                      y: evt.clientY - rect.top
                    };
                }
                function isXMarkerDragable(x, y){
                    if(xmarker_x_pos > X_POS_UPPER_LIMIT || xmarker_x_pos <= GRAPH_X_POS || xmarker_x_pos < X_POS_LOWER_LIMIT){
                        if(xmarker_x_pos < X_POS_LOWER_LIMIT) xmarker_x_pos  = X_POS_LOWER_LIMIT; 
                        else if(xmarker_x_pos > X_POS_UPPER_LIMIT) xmarker_x_pos = X_POS_UPPER_LIMIT;
                        return false;
                    }
                    if((x >= xmarker_x_pos && x <= xmarker_x_pos + XMARKER_WIDTH) && (y >= XMARKER_Y_POS && y <= XMARKER_Y_POS + XMARKER_HEIGHT))
                        return true;
                }
                
                function isYMarkerDragable(x, y){
                    if(ymarker_y_pos > GRAPH_HEIGHT || ymarker_y_pos < Y_POS_LOWER_LIMIT || ymarker_y_pos > Y_POS_UPPER_LIMIT){
                        if(ymarker_y_pos > Y_POS_UPPER_LIMIT) ymarker_y_pos  = Y_POS_UPPER_LIMIT;
                        else if(ymarker_y_pos < Y_POS_LOWER_LIMIT) ymarker_y_pos = Y_POS_LOWER_LIMIT;
                        return false;
                    }
                    if((x >= YMARKER_X_POS && x <= (YMARKER_X_POS + YMARKER_WIDTH)) && (y >= ymarker_y_pos && y <= ymarker_y_pos + YMARKER_HEIGHT))
                        return true;
                }
                
                /*Draw images*/
                function drawImages(){
                    if(metric_flag){
                        context.drawImage(images.graph, GRAPH_X_POS, GRAPH_Y_POS, GRAPH_WIDTH, GRAPH_HEIGHT);
                    }
                    else{
                        context.drawImage(images.imperial_graph, GRAPH_X_POS, GRAPH_Y_POS, GRAPH_WIDTH, GRAPH_HEIGHT);
                    }
                    context.drawImage(images.xmarker, xmarker_x_pos, XMARKER_Y_POS, XMARKER_WIDTH, XMARKER_HEIGHT);
                    context.drawImage(images.ymarker, YMARKER_X_POS, ymarker_y_pos, YMARKER_WIDTH, YMARKER_HEIGHT);
                }
                
                function drawHuman(){
//                    var maxVal = GRAPH_X_POS + GRAPH_WIDTH;
//                    
//                    var points ;
//                    var targetPoints ;
//                    
//                    if(male){
//                        points = initMalePointsString.split(" ");
//                        targetPoints = targetMalePointString.split(" ");
//                    }
//                    else{
//                        points = initFemalePointsString.split(" ");
//                        targetPoints = targetFemalePointString.split(" ");
//                    }
//
//                    var resultPointsString = "";
//
//                    for(var i = 0; i < points.length; i ++){
//
//                            var point = points [ i ].split(",");
//                            var targetPoint = targetPoints [ i ].split(",");
//
//                            var x2 = parseFloat(targetPoint [ 0 ]);
//                            var y2 = parseFloat(targetPoint [ 1 ]);
//
//                            var x1 = parseFloat(point [ 0 ]);
//                            var y1 = parseFloat(point [ 1 ]);
//
//                            var x = x1 + ((x2 - x1) / maxVal)* (xmarker_x_pos + (ymarker_y_pos - Y_POS_LOWER_LIMIT)/2);
//                            var y = y1 + ((y2 - y1) /maxVal) * (xmarker_x_pos + (ymarker_y_pos - Y_POS_LOWER_LIMIT)/2);
//
//                            points [ i ] = x + "," + y;
//
//                            resultPointsString += points [ i ] + " ";
//                    }
//                    $("#human_point polyline").attr("points", resultPointsString);
                }
                
                function drawPointer(){
                    var centerX = xmarker_x_pos + 17;
                    var centerY = ymarker_y_pos + YMARKER_HEIGHT / 2;
                    var radius = 5;

                    context.beginPath();
                    context.arc(centerX, centerY, radius, 0, 2 * Math.PI, false);
                    context.fillStyle = '#00acea';
                    context.fill();
                    context.lineWidth = 1;
                    context.strokeStyle = '#00acea';
                    context.stroke();
                }
                
                function drawText(){
                    context.font = "12px Arial";
                    context.fillStyle = '#00acea';
                    
                    var weight_kg = 0;
                    var height_inch = 0;
                    var height_meter = 0;
                    var weight_pound = 0;
                    if(xmarker_x_pos <= 138){
                        weight = 25;
                        weight_kg = 25;
                    }
                    else{
                        /*Say start from 25Kg and here pixel is 138
                         * so initial point 138 and initial weight 25
                         * if we want to get the differenece from 25 kg to 50 kg the difference of pixel is 60
                         * so for every pixel we will get .4166666 kg
                         * */
                        weight = ((xmarker_x_pos - 138) * .4148888) + 25;
                        weight = Math.round(weight * 10) / 10;
                        weight_kg = Math.round(weight * 10) / 10;
                    }
                    //console.log(xmarker_x_pos);
                    if(metric_flag){
                        context.fillText(weight + " kg", xmarker_x_pos + 52, XMARKER_Y_POS + XMARKER_HEIGHT / 2);
                        
                    }
                    else
                    {
                        var pound = weight * 2.2;
                        var weight_pound = weight * 2.2;
                        var stone = Math.floor(pound /14);
                        pound = Math.round(pound - stone*14);
                        
                        context.fillText(stone +" st "+ pound +" lb", xmarker_x_pos + 52, XMARKER_Y_POS + XMARKER_HEIGHT / 2);
                    }
                    /**
                     *for every pixel we have .0026666 m
                     *initial point is 269 and and initial height is 1.4
                     * */
                    //console.log(ymarker_y_pos + YMARKER_HEIGHT / 2);
                    
                    var ymarkerPosition = ymarker_y_pos + YMARKER_HEIGHT / 2;
                    var height = 1.4;
                    var height_meter = 1.4;
                    if(ymarkerPosition >= 269){
                        height = 1.4;
                        height_meter = 1.4;
                    }
                    else{
                        height = ((269 - ymarkerPosition) * .0026666) + 1.4;
                        height = Math.round( height * 100 ) / 100;
                        height_meter = height;
                    }
                    //var height = Math.round(((200 - ymarkerPosition) * .00133333 + 1.4) * 100 ) / 100;
                    if(metric_flag){

                        context.fillText(height + " m", YMARKER_X_POS + 5, ymarker_y_pos + YMARKER_HEIGHT - 10);
                    }
                    else{
                        var inch = height *39.370;
                        height_inch = inch;
                        var feet = Math.floor(inch / 12);
                        inch = Math.floor(inch - feet*12);
                        context.fillText(feet + " '"+inch+" ''", YMARKER_X_POS + 5, ymarker_y_pos + YMARKER_HEIGHT - 10);
                    }
                    
                    if(metric_flag)
                    {
                        var bmi = weight_kg/((height_meter)*(height_meter));
                        bmi = Math.round(bmi * 100) / 100;
                        $('#bmi_value').text(bmi);
                        
                        if(bmi <=18.5) $("#bmi_status").text('Underweight');
                        else if(bmi <=25) $("#bmi_status").text('Healthy');
                        else if(bmi <=30) $("#bmi_status").text('Overweight');
                        else if(bmi >30) $("#bmi_status").text('Very Overweight');
                    }
                    else
                    {
                        var bmi = Math.round(weight_pound/((height_inch)*(height_inch))*703);
                        $('#bmi_value').text(bmi);
                        
                        if(bmi <=18.5) $("#bmi_status").text('Underweight');
                        else if(bmi <=25) $("#bmi_status").text('Healthy');
                        else if(bmi <=30) $("#bmi_status").text('Overweight');
                        else if(bmi >30) $("#bmi_status").text('Very Overweight');
                    }
                }
                
                /*Loading images from the server*/
                function loadImages(sources, callback) {
                    
                    var loadedImages = 0;
                    var numImages = 0;
                    // get num of sources
                    for (var src in sources) {
                        numImages++;
                    }
                    for (var src in sources) {
                        loadedImages++;
                        images[src] = new Image();
                        images[src].onload = function() {
                            if (loadedImages >= numImages) {
                                callback(images);
                            }
                        };
                        images[src].src = sources[src];
                    }
                }
                
            });
</script>

<script>
    $(function(){
        $('#button_male').on('click',function(){
            var src = '<?php echo base_url()?>resources/images/male-icon.png';
            $('#show_img').attr('src',src);
            $("#button_female").removeClass('active');
            $("#button_female").removeClass('btn-success');
            $("#button_male").addClass('active');
            $("#button_male").addClass('btn-success');
            
        });
        
        $('#button_female').on('click',function(){
           var src = '<?php echo base_url()?>resources/images/female-icon.png';
            $('#show_img').attr('src',src);
            $("#button_male").removeClass('active');
            $("#button_male").removeClass('btn-success');
            $("#button_female").addClass('active');
            $("#button_female").addClass('btn-success');
            
        });
        
        $('#button_metric').on('click',function(){
           metric_flag = true;
           $("#button_imperial").removeClass('active');
           $("#button_imperial").removeClass('btn-success');
            $("#button_metric").addClass('active');
            $("#button_metric").addClass('btn-success');
        });
        $('#button_imperial').on('click',function(){
           metric_flag = false;
           $("#button_metric").removeClass('active');
           $("#button_metric").removeClass('btn-success');
            $("#button_imperial").addClass('active');
            $("#button_imperial").addClass('btn-success');
        });
    });
</script>