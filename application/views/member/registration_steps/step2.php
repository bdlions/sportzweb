<script type="text/javascript">
    $(function() {
        $("#profile_information_back").on("click", function() {
            $("#member_profile_step2").removeClass("registration_steps_header_text");
            $("#member_profile_step3").removeClass("registration_steps_header_text");
            $("#member_profile_step1").addClass("registration_steps_header_text");
            kmrSimpleTabs.setStep(0);
        });

        // Setup form validation on the #register-form element
        $("#form-step2").validate({
            // Specify the validation rules
            rules: {
                birthday_month: {
                    required: true
                },
                birthday_day: {
                    required: true
                },
                birthday_year: {
                    required: true
                },
                gender_list: {
                    required: true
                },
                country_list: {
                    required: true
             },
            },
            // Specify the validation error messages
            messages: {
                birthday_month: {
                    required: "required"
                },
                birthday_day: {
                    required: "required"
                },
                birthday_year: {
                    required: "required"
                },
                gender_list: {
                    required: "required"
                },
                country_list: {
                    required: "required"               
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() ?>register/step2',
                    dataType: 'json',
                    data: $("#form-step2").serialize(),
                    success: function(data) {
                        if (data === 1) {
                            $("#infoMessageProfile").text('Profile is updated.');
                            $("#member_profile_step1").removeClass("registration_steps_header_text");
                            $("#member_profile_step2").removeClass("registration_steps_header_text");
                            $("#member_profile_step3").addClass("registration_steps_header_text");
                            kmrSimpleTabs.setStep(2);
                        }
                        else {
                            $("#infoMessageProfile").text('Profile has not been updated.');
                        }
                    }
                });
                return false;
            }
        });

        //set the date of birth to 3 dropdown
        var dob = '<?php echo $dob ?>';
        if (dob) {
            var d = dob.split("-");
            $('#birthday_month').val(parseInt(d[1]));
            $('#birthday_day').val(parseInt(d[0]));
            $('#birthday_year').val(parseInt(d[2]));
        }

    });
</script>

<?php echo form_open("register/step2", array('id' => 'form-step2', 'role' => 'form', 'class' => 'form-horizontal')); ?>
<div class="row">
    <div class="col-md-7">
        <div class="row">
            <div class="form-group">
                <label for="gender_list" class="col-sm-4 control-label requiredField">Gender:</label>
                <div class="col-sm-8">
                    <?php echo form_dropdown("gender_list", (array('' => 'Select gender') + $gender_list), $gender_id, "class='form-control'") ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label requiredField">Country:</label>
                <div class="col-sm-8">
                    <?php echo form_dropdown("country_list", (array('' => 'Select country') + $country_list), $country_id, 'class="form-control"') ?>
                </div>
            </div>
            <div class="form-group">
                <label for="country_list" class="col-sm-4 control-label   requiredField">Date Of Birth:</label>
                <div class="col-sm-8" >
                    <div class="col-sm-4 disable_padding_left">
                        
                        <?php echo form_dropdown('birthday_month', $month_list, '01', 'class=form-control id=birthday_month'); ?>
                        <!--                        <select id="birthday_month" name="birthday_month" class="form-control"><option value="">Month:</option><option value="1">Jan</option><option value="2">Feb</option><option value="3">Mar</option><option value="4">Apr</option><option value="5">May</option><option value="6">Jun</option><option value="7">Jul</option><option value="8">Aug</option><option value="9">Sep</option><option value="10">Oct</option><option value="11">Nov</option><option value="12">Dec</option></select> -->
                    </div>
                    <div class="col-sm-4 disable_padding_left">
                        <?php echo form_dropdown('birthday_day', $date_list, '', 'class=form-control id=birthday_day'); ?>
                        <!--<select id="birthday_day" name="birthday_day" class="form-control"><option value="">Day:</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select>--> 
                    </div>
                    <div class="col-sm-4">
                        <?php echo form_dropdown('birthday_year', $year_list, '', 'class=form-control id=birthday_year'); ?>
                        <!--<select id="birthday_year" name="birthday_year" class="form-control"><option value="">Year:</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option><option value="1946">1946</option><option value="1945">1945</option><option value="1944">1944</option><option value="1943">1943</option><option value="1942">1942</option><option value="1941">1941</option><option value="1940">1940</option><option value="1939">1939</option><option value="1938">1938</option><option value="1937">1937</option><option value="1936">1936</option><option value="1935">1935</option><option value="1934">1934</option><option value="1933">1933</option><option value="1932">1932</option><option value="1931">1931</option><option value="1930">1930</option><option value="1929">1929</option><option value="1928">1928</option><option value="1927">1927</option><option value="1926">1926</option><option value="1925">1925</option><option value="1924">1924</option><option value="1923">1923</option><option value="1922">1922</option><option value="1921">1921</option><option value="1920">1920</option><option value="1919">1919</option><option value="1918">1918</option><option value="1917">1917</option><option value="1916">1916</option><option value="1915">1915</option><option value="1914">1914</option><option value="1913">1913</option><option value="1912">1912</option><option value="1911">1911</option><option value="1910">1910</option><option value="1909">1909</option><option value="1908">1908</option><option value="1907">1907</option><option value="1906">1906</option><option value="1905">1905</option></select>-->
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Home Town:</label>
                <div class="col-sm-8">
                    <?php echo form_input(array('name' => 'home_town', 'id' => 'home_town', 'value' => $home_town, 'class' => 'form-control', 'type' => 'text')); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">School/College/University:</label>
                <div class="col-sm-8">
                    <?php echo form_input(array('name' => 'college', 'id' => 'college', 'value' => $college, 'class' => 'form-control', 'type' => 'text')); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Employer:</label>
                <div class="col-sm-8">
                    <?php echo form_input(array('name' => 'employer', 'id' => 'employer', 'value' => $employer, 'class' => 'form-control', 'type' => 'text')); ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label">Occupation:</label>
                <div class="col-sm-8">
                    <?php echo form_input(array('name' => 'occupation', 'id' => 'occupation', 'value' => $occupation, 'class' => 'form-control', 'type' => 'text')); ?>
                </div>
            </div>

        </div>
        <div class="row">
            <img src="resources/images/back.png">
            <a href="" id="profile_information_back">Back</a>
            <?php echo form_submit(array('id' => 'submit_profile', 'name' => 'submit_profile', 'value' => 'Save & Continue', 'type' => 'submit', 'class' => 'btn button-custom pull-right spacer')); ?>
        </div>
        <div class="row">
            <div id="message"></div>
        </div>
    </div>

</div>

<?php echo form_close(); ?>
