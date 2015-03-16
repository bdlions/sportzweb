<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages: ["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var special_interests = <?php echo $special_interests; ?>;
        
        var options = {
            legend: 'none',
            pieSliceText: 'label',
            pieStartAngle: 90,
            enableInteractivity: true,
            colors: ['#DC3812', '#3266CC', '#FE9900'],
            'tooltip': {
                trigger: 'none'
            }
        };
        
        //assign data from the special interests with google format 
        //and assing into the google table
        //and drawing the piechart
        var data = Array();
        data.push(['Category', 'unit']);
        for (var i = 0; i < special_interests.length; i++) {
            data.push([special_interests[i].value, 1]);
        }
        var google_data = google.visualization.arrayToDataTable(data);
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(google_data, options);
        
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
        //google pie chart portion selection
        google.visualization.events.addListener(chart, 'select', function() {
            var selection = chart.getSelection();
            if (selection[0] !== undefined) {
                for(var i = 0; i < special_interests.length; i ++){
                    var selected_special_interest = special_interests[i];
                    $("#special_interest_"+selected_special_interest.id).hide();
                }
                var selected_special_interest = special_interests[selection[0].row]
                $("#special_interest_"+selected_special_interest.id).show();
            }

        });
    }
    $(function(){
        $('a[href="#update_country"]').on("click", function(){
            collapse_all_form();
            $("#update_country_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_home_town"]').on("click", function(){
            collapse_all_form();
            $("#update_home_town_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_email"]').on("click", function(){
            collapse_all_form();
            $("#update_email_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_about_me"]').on("click", function(){
            collapse_all_form();
            $("#update_about_me_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_college"]').on("click", function(){
            collapse_all_form();
            $("#update_college_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_emplyoer"]').on("click", function(){
            collapse_all_form();
            $("#update_employer_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_occupation"]').on("click", function(){
            collapse_all_form();
            $("#update_occupation_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_telephone"]').on("click", function(){
            collapse_all_form();
            $("#update_telephone_form").removeClass("hidden");
            return false;
        });
        $('a[href="#pdate_email"]').on("click", function(){
            collapse_all_form();
            $("#update_email_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_skype_name"]').on("click", function(){
            collapse_all_form();
            $("#update_skype_name_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_twitter_name"]').on("click", function(){
            collapse_all_form();
            $("#update_twitter_name_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_facebook_name"]').on("click", function(){
            collapse_all_form();
            $("#update_facebook_name_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_linkedin_name"]').on("click", function(){
            collapse_all_form();
            $("#update_linkedin_name_form").removeClass("hidden");
            return false;
        });
    });
    
    
    function collapse_all_form(){
        $("#update_country_form").addClass("hidden");
        $("#update_home_town_form").addClass("hidden");
        $("#update_about_me_form").addClass("hidden");
        $("#update_college_form").addClass("hidden");
        $("#update_employer_form").addClass("hidden");
        $("#update_occupation_form").addClass("hidden");
        $("#update_telephone_form").addClass("hidden");
        $("#update_email_form").addClass("hidden");
        $("#update_skype_name_form").addClass("hidden");
        $("#update_twitter_name_form").addClass("hidden");
        $("#update_facebook_name_form").addClass("hidden");
        $("#update_linkedin_name_form").addClass("hidden");
        
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
            <div class="pull-right"><a href="#update_country">Edit</a></div>
        </div>
        
        <!-- Edit information -->
        <?php echo form_open("member_profile/update_basic_profile", array('id' => 'update_country_form', 'role' => 'form', 'class' => 'form-horizontal hidden'))?>
        <div class="col-sm-8 pull-right">
            <div class="row col-md-12" style="padding-top: 12px; padding-bottom: 12px;">
                <?php echo form_dropdown("country_id", (array('' => 'Select country') + $country_list), $basic_profile->country_id, 'class="form-control"') ?>
                <div class="form-group row">
                    <div class="col-md-12" style="padding-top: 4px; padding-bottom: 4px;">To save these settings please enter your <?php echo WEBSITE_TITLE; ?> password</div>
                    <label class="col-md-4">Password:</label>
                    <div class="col-md-8">
                        <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close();?>
        
    </div>


    <div class="row">
        <label class="col-sm-4">Home Town:</label>
        <div class="col-sm-8">
            <?php echo $home_town; ?>
            <div class="pull-right"><a href="#update_home_town">Edit</a></div>
        </div>
        
        <!-- Edit information -->
        <?php echo form_open("member_profile/update_basic_profile", array('id' => 'update_home_town_form', 'role' => 'form', 'class' => 'form-horizontal hidden'))?>
        <div class="col-sm-8 pull-right">
            <div class="row col-md-12" style="padding-top: 12px; padding-bottom: 12px;">
                <?php echo form_input(array('name' => 'home_town', 'id' => 'home_town', 'class' => 'form-control', 'type' => 'text')); ?>
                <div class="form-group row">
                    <div class="col-md-12" style="padding-top: 4px; padding-bottom: 4px;">To save these settings please enter your <?php echo WEBSITE_TITLE; ?> password</div>
                    <label class="col-md-4">Password:</label>
                    <div class="col-md-8">
                        <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <?php echo form_submit(array( 'value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close()?>
    </div>


    <h3>Info</h3>
    <div class="row">
        <label class="col-sm-4 control-label">About Me:</label>
        <div class="col-sm-8">
            <?php echo $about_me; ?>
            <div class="pull-right"><a href="#update_about_me">Edit</a></div>
        </div>
        
        <!-- Edit information -->
        <?php echo form_open("member_profile/update_basic_profile", array('id' => 'update_about_me_form', 'role' => 'form', 'class' => 'form-horizontal hidden'))?>
        <div class="col-sm-8 pull-right">
            <div class="row col-md-12" style="padding-top: 12px; padding-bottom: 12px;">
                <?php echo form_textarea(array('name' => 'about_me', 'rows' => '4', 'class' => 'form-control', 'type' => 'text')); ?>
                <div class="form-group row">
                    <div class="col-md-12" style="padding-top: 4px; padding-bottom: 4px;">To save these settings please enter your <?php echo WEBSITE_TITLE; ?> password</div>
                    <label class="col-md-4">Password:</label>
                    <div class="col-md-8">
                        <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close();?>
    </div>
    <div class="row">
        <label class="col-sm-4 control-label">School/College/University:</label>
        <div class="col-sm-8">
            <?php echo $college; ?>
            <div class="pull-right"><a href="#update_college">Edit</a></div>
        </div>
        
        <!-- Edit information -->
        <?php echo form_open("member_profile/update_basic_profile", array('id' => 'update_college_form', 'role' => 'form', 'class' => 'form-horizontal hidden'))?>
        <div class="col-sm-8 pull-right">
            <div class="row col-md-12" style="padding-top: 12px; padding-bottom: 12px;">
                <?php echo form_input(array('name' => 'clg_or_uni', 'id' => 'clg_or_uni', 'class' => 'form-control', 'type' => 'text')); ?>
                <div class="form-group row">
                    <div class="col-md-12" style="padding-top: 4px; padding-bottom: 4px;">To save these settings please enter your <?php echo WEBSITE_TITLE; ?> password</div>
                    <label class="col-md-4">Password:</label>
                    <div class="col-md-8">
                        <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close();?>         
    </div>

    <div class="row">
        <label class="col-sm-4 control-label">Employer:</label>
        <div class="col-sm-8">
            <?php echo $employer; ?>
            <div class="pull-right"><a href="#update_emplyoer">Edit</a></div>
        </div>
        
        <!-- Edit information -->
        <?php echo form_open("member_profile/update_basic_profile", array('id' => 'update_employer_form', 'role' => 'form', 'class' => 'form-horizontal hidden'))?>
        <div class="col-sm-8 pull-right">
            <div class="row col-md-12" style="padding-top: 12px; padding-bottom: 12px;">
                <?php echo form_input(array('name' => 'employer', 'id' => 'employer', 'class' => 'form-control', 'type' => 'text')); ?>
                <div class="form-group row">
                    <div class="col-md-12" style="padding-top: 4px; padding-bottom: 4px;">To save these settings please enter your <?php echo WEBSITE_TITLE; ?> password</div>
                    <label class="col-md-4">Password:</label>
                    <div class="col-md-8">
                        <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close();?>        
                
    </div>

    <div class="row">
        <label class="col-sm-4 control-label">Occupation:</label>
        <div class="col-sm-8">
            <?php echo $occupation; ?>
            <div class="pull-right"><a href="#update_occupation">Edit</a></div>
        </div>
        
        <!-- Edit information -->
        <?php echo form_open("member_profile/update_basic_profile", array('id' => 'update_occupation_form', 'role' => 'form', 'class' => 'form-horizontal hidden'))?>
        <div class="col-sm-8 pull-right">
            <div class="row col-md-12" style="padding-top: 12px; padding-bottom: 12px;">
                <?php echo form_input(array('name' => 'occupation', 'id' => 'occupation', 'class' => 'form-control', 'type' => 'text')); ?>
                <div class="form-group row">
                    <div class="col-md-12" style="padding-top: 4px; padding-bottom: 4px;">To save these settings please enter your <?php echo WEBSITE_TITLE; ?> password</div>
                    <label class="col-md-4">Password:</label>
                    <div class="col-md-8">
                        <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close();?>        
                
    </div>
    
    <h3>Contact</h3>
    <div class="row">
        <label class="col-sm-4 control-label">Telephone:</label>
        <div class="col-sm-8">
            <?php echo $telephone; ?>
            <div class="pull-right"><a href="#update_telephone">Edit</a></div>
        </div>
        
        <!-- Edit information -->
        <?php echo form_open("member_profile/update_basic_profile", array('id' => 'update_telephone_form', 'role' => 'form', 'class' => 'form-horizontal hidden'))?>
        <div class="col-sm-8 pull-right">
            <div class="row col-md-12" style="padding-top: 12px; padding-bottom: 12px;">
                <?php echo form_input(array('name' => 'telephone', 'id' => 'telephone', 'class' => 'form-control', 'type' => 'text')); ?>
                <div class="form-group row">
                    <div class="col-md-12" style="padding-top: 4px; padding-bottom: 4px;">To save these settings please enter your <?php echo WEBSITE_TITLE; ?> password</div>
                    <label class="col-md-4">Password:</label>
                    <div class="col-md-8">
                        <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close();?>
    </div>
    <div class="row">
        <label class="col-sm-4 control-label">Email:</label>
        <div class="col-sm-8">
            <?php echo $email; ?>
            <div class="pull-right"><a href="#update_email">Edit</a></div>
        </div>  
        
                
        <!-- Edit information -->
        <?php echo form_open("member_profile/update_basic_profile", array('id' => 'update_email_form', 'role' => 'form', 'class' => 'form-horizontal hidden'))?>
        <div class="col-sm-8 pull-right">
            <div class="row col-md-12" style="padding-top: 12px; padding-bottom: 12px;">
                <?php echo form_input(array('name' => 'email', 'id' => 'email', 'class' => 'form-control', 'type' => 'text')); ?>
                <div class="form-group row">
                    <div class="col-md-12" style="padding-top: 4px; padding-bottom: 4px;">To save these settings please enter your <?php echo WEBSITE_TITLE; ?> password</div>
                    <label class="col-md-4">Password:</label>
                    <div class="col-md-8">
                        <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close();?>
    </div>
    <div class="row">
        <label class="col-sm-4 control-label">Skype Name:</label>
        <div class="col-sm-8">
            <?php echo $skype_name; ?>
            <div class="pull-right"><a href="#update_skype_name">Edit</a></div>
        </div>
        <!-- Edit information -->
        <?php echo form_open("member_profile/update_basic_profile", array('id' => 'update_skype_name_form', 'role' => 'form', 'class' => 'form-horizontal hidden'))?>
        <div class="col-sm-8 pull-right">
            <div class="row col-md-12" style="padding-top: 12px; padding-bottom: 12px;">
                <?php echo form_input(array('name' => 'skype_name', 'id' => 'skype_name', 'class' => 'form-control', 'type' => 'text')); ?>
                <div class="form-group row">
                    <div class="col-md-12" style="padding-top: 4px; padding-bottom: 4px;">To save these settings please enter your <?php echo WEBSITE_TITLE; ?> password</div>
                    <label class="col-md-4">Password:</label>
                    <div class="col-md-8">
                        <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close();?>        
    </div>
    <div class="row">
        <label class="col-sm-4 control-label">Twitter:</label>
        <div class="col-sm-8">
            <?php echo $twitter_name; ?>
            <div class="pull-right"><a href="#update_twitter_name">Edit</a></div>
        </div>
        
        <!-- Edit information -->
        <?php echo form_open("member_profile/update_basic_profile", array('id' => 'update_twitter_name_form', 'role' => 'form', 'class' => 'form-horizontal hidden'))?>
        <div class="col-sm-8 pull-right">
            <div class="row col-md-12" style="padding-top: 12px; padding-bottom: 12px;">
                <?php echo form_input(array('name' => 'twitter_name', 'id' => 'twitter_name', 'class' => 'form-control', 'type' => 'text')); ?>
                <div class="form-group row">
                    <div class="col-md-12" style="padding-top: 4px; padding-bottom: 4px;">To save these settings please enter your <?php echo WEBSITE_TITLE; ?> password</div>
                    <label class="col-md-4">Password:</label>
                    <div class="col-md-8">
                        <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <?php echo form_submit(array( 'value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close();?>        
    </div>
    <div class="row">
        <label class="col-sm-4 control-label">Facebook:</label>
        <div class="col-sm-8">
            <?php echo $facebook_name; ?>
            <div class="pull-right"><a href="#update_facebook_name">Edit</a></div>
        </div>
        
        <!-- Edit information -->
        <?php echo form_open("member_profile/update_basic_profile", array('id' => 'update_facebook_name_form', 'role' => 'form', 'class' => 'form-horizontal hidden'))?>
        <div class="col-sm-8 pull-right">
            <div class="row col-md-12" style="padding-top: 12px; padding-bottom: 12px;">
                <?php echo form_input(array('name' => 'facebook_name', 'id' => 'facebook_name', 'class' => 'form-control', 'type' => 'text')); ?>
                <div class="form-group row">
                    <div class="col-md-12" style="padding-top: 4px; padding-bottom: 4px;">To save these settings please enter your <?php echo WEBSITE_TITLE; ?> password</div>
                    <label class="col-md-4">Password:</label>
                    <div class="col-md-8">
                        <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close();?>        
    </div>
    <div class="row">
        <label class="col-sm-4 control-label">LinkedIn:</label>
        <div class="col-sm-8">
            <?php echo $linkedin_name; ?>
            <div class="pull-right"><a href="#update_linkedin_name">Edit</a></div>
        </div>
        
        <!-- Edit information -->
        <?php echo form_open("member_profile/update_basic_profile", array('id' => 'update_linkedin_name_form', 'role' => 'form', 'class' => 'form-horizontal hidden'))?>
        <div class="col-sm-8 pull-right">
            <div class="row col-md-12" style="padding-top: 12px; padding-bottom: 12px;">
                <?php echo form_input(array('name' => 'linkedin_name', 'id' => 'linkedin_name', 'class' => 'form-control', 'type' => 'text')); ?>
                <div class="form-group row">
                    <div class="col-md-12" style="padding-top: 4px; padding-bottom: 4px;">To save these settings please enter your <?php echo WEBSITE_TITLE; ?> password</div>
                    <label class="col-md-4">Password:</label>
                    <div class="col-md-8">
                        <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <?php echo form_submit(array('value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close();?>        
    </div>
    
    
    <!-- Interests -->
    <h3>Interests</h3>
    <div class="row">
        <?php echo form_open("member_profile/update_interests", array('id' => 'update_interest_form', 'role' => 'form', 'class' => 'form-horizontal'))?>
        <div id="piechart" class="col-md-6" style="width:450px; height: 450px"></div>
        <div id="interest" class="col-md-4"></div>
        <div class="col-sm-8 pull-right">
            <div class="row col-md-12" >
                <div class="form-group row">
                    <div class="col-md-12">
                        <?php echo form_submit(array( 'value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close();?>
    </div>
    
    <!-- Interests -->
</div>