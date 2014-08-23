<script type="text/javascript">
    $(function(){
        var business_profile_types = <?php echo json_encode($business_profile_types) ?>;
        var sub_type_list = <?php echo json_encode($sub_type_list) ?>;
        var first_profile_type_id = Object.keys(business_profile_types)[0];
        $("#business_profile_types").change(function() {
            $("#sub_type_list").empty();
            $.each(sub_type_list[$(this).val()], function(key, value) {
                $("#sub_type_list").append("<option value=\"" + key + "\">" + value + "</option>");
            });
        });

        $.each(sub_type_list[first_profile_type_id], function(key, value) {
            $("#sub_type_list").append("<option value=\"" + key + "\">" + value + "</option>");
        });
        $('a[href="#update_business_name"]').on("click", function(){
            collapse_all_form();
            $("#update_business_name_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_business_profile_type"]').on("click", function(){
            collapse_all_form();
            $("#update_business_profile_type_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_street_name"]').on("click", function(){
            collapse_all_form();
            $("#update_street_name_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_business_description"]').on("click", function(){
            collapse_all_form();
            $("#update_business_description_form").removeClass("hidden");
            return false;
        });
        $('a[href="#update_telephone"]').on("click", function(){
            collapse_all_form();
            $("#update_telephone_form").removeClass("hidden");
            return false;
        });
        
        $('a[href="#update_business_email"]').on("click", function(){
            collapse_all_form();
            $("#update_business_email_form").removeClass("hidden");
            return false;
        });
        
        $('a[href="#update_registered_company_number"]').on("click", function(){
            collapse_all_form();
            $("#update_registered_company_number_form").removeClass("hidden");
            return false;
        });
        
        $('a[href="#update_business_website"]').on("click", function(){
            collapse_all_form();
            $("#update_business_website_form").removeClass("hidden");
            return false;
        });
        
        $('a[href="#update_business_hour"]').on("click", function(){
            collapse_all_form();
            $("#update_business_hour_form").removeClass("hidden");
            return false;
        });
        
        function collapse_all_form(){
            $("#update_business_name_form").addClass("hidden");
            $("#update_street_name_form").addClass("hidden");
            $("#update_business_description_form").addClass("hidden");
            $("#update_telephone_form").addClass("hidden");
            $("#update_business_email_form").addClass("hidden");
            $("#update_registered_company_number_form").addClass("hidden");
            $("#update_business_website_form").addClass("hidden");
            $("#update_business_hour_form").addClass("hidden");
            $("#update_business_profile_type_form").addClass("hidden");
        }
        
        /*$("#update_business_name_form").validate({
            // Specify the validation rules
            rules: {
                business_name: {
                    required: true
                },
                password: {
                    required: true
                }
            
            },
            // Specify the validation error messages
            messages: {
                business_name: {
                    required: "required"
                },
                password: {
                    required: "required"
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() ?>settings?menu=business&section=business_name',
                    dataType: 'text',
                    data: $("#update_name_form").serialize(),
                    success: function(data) {
                        if (data === '1') {
                            window.location = window.location;
                        }
                        else {
                            alert("Error");
                        }
                    }
            });
                return false;
            }
        });*/
    });
</script>
<div class="panel panel-default">
    <div class="panel-heading">Business Account Settings</div>
    <div class="panel-body">
        <div class="col-md-12">
            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">Business profile type:</label>
                    <div class="col-md-7">
                        <?php echo form_open(base_url()."settings?menu=business&section=business_profile_type", array('id' => 'update_business_profile_type_form', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                        <div class="form-group">
                            <label class="col-md-4">Business Name:</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                    <?php echo form_dropdown('business_profile_type', $business_profile_types, $profile_info->business_profile_type, 'id="business_profile_types", class="form-control new_line"'); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                    <?php echo form_dropdown('business_profile_sub_type', array(), $profile_info->business_profile_sub_type, 'id="sub_type_list", class="form-control new_line"'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                To save these settings please enter your sportzweb password
                            </div>                        
                            <div class="form-group">
                                <label class="col-md-4">Password:</label>
                                <div class="col-md-8">
                                    <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-12">
                                <?php echo form_submit(array('id' => 'button_business_profile_type', 'name' => 'button_business_profile_type', 'value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-2">
                        <a href="#update_business_profile_type">Edit</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">Business Name:</label>
                    <div class="col-md-7">
                        <?php echo $profile_info->business_name ?>
                        <?php echo form_open(base_url()."settings?menu=business&section=business_name", array('id' => 'update_business_name_form', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                        <div class="form-group">
                            <label class="col-md-4">Business Name:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'business_name', 'value' => $profile_info->business_name, 'class' => 'form-control', 'type' => 'text')); ?>
                            </div>
                        </div>
                        To save these settings please enter your sportzweb password
                        <div class="form-group">
                            <label class="col-md-4">Password:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <?php echo form_submit(array('id' => 'button_business_name', 'name' => 'button_business_name', 'value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-2">
                        <a href="#update_business_name">Edit</a>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">Full Address:</label>
                    <div class="col-md-7">
                        <?php echo $profile_info->street_name. " ".  $profile_info->address. " ". $profile_info->business_city. " ". $profile_info->country_name. " ". $profile_info->post_code?>
                        <?php echo form_open(base_url()."settings?menu=business&section=street_name", array('id' => 'update_street_name_form', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                        <div class="form-group">
                            <label class="col-md-4">Street Name:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'street_name', 'value' => $profile_info->street_name, 'class' => 'form-control', 'type' => 'text')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4">Address:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'address', 'value' => $profile_info->address, 'class' => 'form-control', 'type' => 'text')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4">City/Town:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'business_city', 'value' => $profile_info->business_city, 'class' => 'form-control', 'type' => 'text')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4">Country:</label>
                            <div class="col-md-8">
                                <?php echo form_dropdown('business_country', array("" => "Select country") + $country_list, $profile_info->country_id, 'class="form-control new_line"'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4">Post Code:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'post_code', 'value' => $profile_info->post_code, 'class' => 'form-control', 'type' => 'text')); ?>
                            </div>
                        </div>
                        To save these settings please enter your sportzweb password
                        <div class="form-group">
                            <label class="col-md-4">Password:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <?php echo form_submit(array('id' => 'button_street_name', 'name' => 'button_street_name', 'value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-2">
                        <a href="#update_street_name">Edit</a>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">Business Description:</label>
                    <div class="col-md-7">
                        <?php echo $profile_info->business_description ?>
                        <?php echo form_open(base_url()."settings?menu=business&section=business_description", array('id' => 'update_business_description_form', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                        <div class="form-group">
                            <label class="col-md-4">Business Description:</label>
                            <div class="col-md-8">
                                <?php echo form_textarea(array('name' => 'business_description', 'value' => $profile_info->business_description, 'class' => 'form-control', 'rows' => '4')); ?>
                            </div>
                        </div>
                        To save these settings please enter your sportzweb password
                        <div class="form-group">
                            <label class="col-md-4">Password:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <?php echo form_submit(array('id' => 'button_business_description', 'name' => 'button_business_description', 'value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-2">
                        <a href="#update_business_description">Edit</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">Telephone:</label>
                    <div class="col-md-7">
                        <?php echo $profile_info->telephone ?>
                        <?php echo form_open(base_url()."settings?menu=business&section=business_telephone", array('id' => 'update_telephone_form', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                        <div class="form-group">
                            <label class="col-md-4">Post Code:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'telephone', 'value' => $profile_info->telephone, 'class' => 'form-control', 'type' => 'text')); ?>
                            </div>
                        </div>
                        To save these settings please enter your sportzweb password
                        <div class="form-group">
                            <label class="col-md-4">Password:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <?php echo form_submit(array('id' => 'button_telephone', 'name' => 'button_post_code', 'value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-2">
                        <a href="#update_telephone">Edit</a>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">Email:</label>
                    <div class="col-md-7">
                        <?php echo $profile_info->business_email ?>
                        <?php echo form_open(base_url()."settings?menu=business&section=business_email", array('id' => 'update_business_email_form', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                        <div class="form-group">
                            <label class="col-md-4">Post Code:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'business_email', 'value' => $profile_info->business_email, 'class' => 'form-control', 'type' => 'text')); ?>
                            </div>
                        </div>
                        To save these settings please enter your sportzweb password
                        <div class="form-group">
                            <label class="col-md-4">Password:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <?php echo form_submit(array('id' => 'button_business_email', 'name' => 'button_business_email', 'value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-2">
                        <a href="#update_business_email">Edit</a>
                    </div>
                </div>
            </div>
            
            
            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">Registered Company No:</label>
                    <div class="col-md-7">
                        <?php echo $profile_info->registered_company_number ?>
                        <?php echo form_open(base_url()."settings?menu=business&section=business_company_no", array('id' => 'update_registered_company_number_form', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                        <div class="form-group">
                            <label class="col-md-4">Post Code:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'registered_company_number', 'value' => $profile_info->registered_company_number, 'class' => 'form-control', 'type' => 'text')); ?>
                            </div>
                        </div>
                        To save these settings please enter your sportzweb password
                        <div class="form-group">
                            <label class="col-md-4">Password:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <?php echo form_submit(array('id' => 'button_registered_company_number', 'name' => 'button_registered_company_number', 'value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-2">
                        <a href="#update_registered_company_number">Edit</a>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">Business Website Address:</label>
                    <div class="col-md-7">
                        <?php echo $profile_info->website_address ?>
                        <?php echo form_open(base_url()."settings?menu=business&section=business_website", array('id' => 'update_business_website_form', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                        <div class="form-group">
                            <label class="col-md-4">Post Code:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'website_address', 'value' => $profile_info->website_address, 'class' => 'form-control', 'type' => 'text')); ?>
                            </div>
                        </div>
                        To save these settings please enter your sportzweb password
                        <div class="form-group">
                            <label class="col-md-4">Password:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <?php echo form_submit(array('id' => 'button_business_website_form', 'name' => 'button_business_website_form', 'value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-2">
                        <a href="#update_business_website">Edit</a>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <label class="col-md-3 control-label">Business Hour:</label>
                    <div class="col-md-7">
                        <?php echo $profile_info->business_hour ?>
                        <?php echo form_open(base_url()."settings?menu=business&section=business_hour", array('id' => 'update_business_hour_form', 'role' => 'form', 'class' => 'form-horizontal hidden')) ?>
                        <div class="form-group">
                            <label class="col-md-4">Post Code:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'business_hour', 'value' => $profile_info->business_hour, 'class' => 'form-control', 'type' => 'text')); ?>
                            </div>
                        </div>
                        To save these settings please enter your sportzweb password
                        <div class="form-group">
                            <label class="col-md-4">Password:</label>
                            <div class="col-md-8">
                                <?php echo form_input(array('name' => 'password', 'class' => 'form-control', 'type' => 'password')); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <?php echo form_submit(array('id' => 'button_business_hour_form', 'name' => 'button_business_hour_form', 'value' => 'Save Changes', 'type' => 'submit', 'class' => 'btn button-custom pull-right')); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-2">
                        <a href="#update_business_hour">Edit</a>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div id="message"></div>
            </div>
        </div>
    </div>
</div>