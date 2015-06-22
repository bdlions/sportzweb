<style type="text/css">
    .slice text {
        font-size: 12pt;
        fill: #ffffff;
    }
</style>
<script type="text/javascript" src="<?php echo base_url() ?>resources/bootstrap3/js/d3.v2.js"></script>
<script type="text/javascript">
    var special_interests = <?php echo $special_interests; ?>;
    $(function() {
        $("#collapseThree").removeClass("collapse").addClass("in");
        $('#submit_special_interest').on('click', function() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>settings/interests',
                dataType: 'text',
                data: $("#form-interests").serialize(),
                success: function(data) {
                    if (data === '1') {
                        window.location = window.location;
                    }
                    else {
                       // alert("Error");
                        var message = "Error";
                    print_common_message(message);
                    }
                }
            });
            return false;
        });
        
        var html_text = "";
        for(var i = 0; i < special_interests.length; i ++){
            var selected_special_interest = special_interests[i];
            var special_subcategory_interest = selected_special_interest.sub_interest;
            var selected_special_interests = <?php echo $selected_special_interest; ?>;
            var interest_html_text = "<div id='special_interest_" + selected_special_interest.id + "'>";
            for (var j = 0; j < special_subcategory_interest.length; j++) {
                var id = selected_special_interest.id+"_" + special_subcategory_interest[j].id;
                var checked = $.inArray(id, selected_special_interests) > -1 == true?"checked":"";
                
                interest_html_text += "<div class='checkbox'><label><input type='checkbox'"+ checked +" name='interest_"+ id + "'>" +special_subcategory_interest[j].description + "</label></div>";
            }
            interest_html_text += "</div>";
            html_text += interest_html_text;
        }
        $("#interest").html(html_text);
        for(var i = 0; i < special_interests.length; i ++){
            var selected_special_interest = special_interests[i];
            $("#special_interest_"+selected_special_interest.id).hide();
        }
        
        var w = 320, //width
        h = 320, //height
        r = 160, //radius
        color = ['#DC3812', '#3266CC', '#FE9900'];
        var data = Array();
        for (var i = 0; i < special_interests.length; i++) {
            data.push({"label": special_interests[i].value, "value": 1});
        }
        //data = [{"label": "one", "value": 1},
        //    {"label": "two", "value": 1},
        //    {"label": "three", "value": 1}];
        var vis = d3.select("#chart")
                .append("svg:svg") //create the SVG element inside the <body>
                .data([data]) //associate our data with the document
                .attr("width", w) //set the width and height of our visualization (these will be attributes of the <svg> tag
                .attr("height", h)
                .append("svg:g") //make a group to hold our pie chart
                .attr("transform", "translate(" + r + "," + r + ")") //move the center of the pie chart from 0, 0 to radius, radius

        var arc = d3.svg.arc() //this will create <path> elements for us using arc data
                .outerRadius(r).startAngle(function(d) { return d.startAngle + Math.PI/2; })
            .endAngle(function(d) { return d.endAngle + Math.PI/2; });;

        var pie = d3.layout.pie() //this will create arc data for us given a list of values
                .value(function(d) {
                    return d.value;
                }); //we must tell it out to access the value of each element in our data array

        var arcs = vis.selectAll("g.slice") //this selects all <g> elements with class slice (there aren't any yet)
                .data(pie) //associate the generated pie data (an array of arcs, each having startAngle, endAngle and value properties)
                .enter() //this will create <g> elements for every "extra" data element that should be associated with a selection. The result is creating a <g> for every object in the data array
                .append("svg:g") //create a group to hold each slice (we will have a <path> and a <text> element associated with each slice)
                .attr("class", "slice"); //allow us to style things in the slices (like text)
//console.log(arcs[0][0]);
//console.log(vis.selectAll("g.slice")[0][0])
        for (var counter = 0; counter < special_interests.length; counter++) {
            arcs[0][counter].setAttribute("onclick", "display_interest_list("+counter+")");
        }


        arcs.append("svg:path")
                .attr("fill", function(d, i) {
                    return color[i];
                }) //set the color for each slice to be chosen from the color function defined above
                .attr("d", arc); //this creates the actual SVG path using the associated data (pie) with the arc drawing function

        arcs.append("svg:text") //add a label to each slice
                .attr("transform", function(d) { //set the label's origin to the center of the arc
//we have to make sure to set these before calling arc.centroid
                    d.innerRadius = 0;
                    d.outerRadius = r;
                    return "translate(" + arc.centroid(d) + ")"; //this gives us a pair of coordinates like [50, 50]
                })
                .attr("text-anchor", "middle") //center the text on it's origin
                .text(function(d, i) {
                    return data[i].label;
                }); //get the label from our original data array        
    });
    function display_interest_list(selected_index)
    {
        for(var i = 0; i < special_interests.length; i ++){
            var selected_special_interest = special_interests[i];
            $("#special_interest_"+selected_special_interest.id).hide();
        }
        var selected_special_interest = special_interests[selected_index]
        $("#special_interest_"+selected_special_interest.id).show();
    }
</script>
<div class="col-md-2 column">
    <?php $this->load->view("templates/sections/member_profile_left_pane"); ?>
</div>

<div class="col-md-7 column">
    <h3>Basics</h3>
    <div class="row">
        <label class="col-sm-4">First Name:</label>
        <div class="col-sm-8">
            <?php echo $first_name; ?>
        </div>
    </div>
    <div class="row">
        <label class="col-sm-4">Last Name:</label>
        <div class="col-sm-8">
            <?php echo $last_name; ?>
        </div>
    </div>
    <div class="row">
        <label for="gender_list" class="col-sm-4">Gender:</label>
        <div class="col-sm-8">
            <?php echo $gender_list[$gender_id]; ?>
        </div>
    </div>
    <div class="row">
        <label for="country_list" class="col-sm-4">Date Of Birth:</label>
        <div class="col-sm-8" >
            <?php echo date("d F Y" ,strtotime($dob."")) ?>
        </div>
    </div>
    <div class="row">
        <label class="col-sm-4">Country:</label>
        <div class="col-sm-8">
            <?php echo $country_list[$country_id]; ?>
        </div>
    </div>


    <div class="row">
        <label class="col-sm-4">Home Town:</label>
        <div class="col-sm-8">
            <?php echo $home_town; ?>
        </div>
    </div>


    <h3>Info</h3>
    <div class="row">
        <label class="col-sm-4 control-label">About Me:</label>
        <div class="col-sm-8">
            <?php echo $about_me; ?>
        </div>
    </div>
    <div class="row">
        <label class="col-sm-4 control-label">School/College/University:</label>
        <div class="col-sm-8">
            <?php echo $college; ?>
        </div>
    </div>

    <div class="row">
        <label class="col-sm-4 control-label">Employer:</label>
        <div class="col-sm-8">
            <?php echo $employer; ?>
        </div>
    </div>

    <div class="row">
        <label class="col-sm-4 control-label">Occupation:</label>
        <div class="col-sm-8">
            <?php echo $occupation; ?>
        </div>
    </div>
    
    <h3>Contact</h3>
    <div class="row">
        <label class="col-sm-4 control-label">Telephone:</label>
        <div class="col-sm-8">
            <?php echo $telephone; ?>
        </div>
    </div>
    <div class="row">
        <label class="col-sm-4 control-label">Email:</label>
        <div class="col-sm-8">
            <?php echo $email; ?>
        </div>
    </div>
    <div class="row">
        <label class="col-sm-4 control-label">Skype Name:</label>
        <div class="col-sm-8">
            <?php echo $skype_name; ?>
        </div>
    </div>
    <div class="row">
        <label class="col-sm-4 control-label">Twitter:</label>
        <div class="col-sm-8">
            <?php echo $twitter_name; ?>
        </div>
    </div>
    <div class="row">
        <label class="col-sm-4 control-label">Facebook:</label>
        <div class="col-sm-8">
            <?php echo $facebook_name; ?>
        </div>
    </div>
    <div class="row">
        <label class="col-sm-4 control-label">LinkedIn:</label>
        <div class="col-sm-8">
            <?php echo $linkedin; ?>
        </div>
    </div>
    
    
    <!-- Interests -->
    <h3>Interests</h3>
    <div class="row">
        <div id="chart" class="col-md-8" ></div>
        <div id="interest" class="col-md-4"></div>
    </div>
    <!-- Interests -->
</div>