<style type="text/css">
   .td_text_color {color: #428bca;}
</style>
<div class="col-md-12">    
    <div class="panel panel-default">
        <div class="panel-heading">
            <?php echo $user_info['first_name'].' '.$user_info['last_name'].' - '.$user_info['description']; ?>
        </div>

        <div class="panel-body">
            <?php echo form_open("admin/access_level", array('id' => 'form_create_user', 'class' => 'form-horizontal')); ?>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="first_name" class="col-md-4 control-label requiredField">
                            First Name
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input($first_name+array('class'=>'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="col-md-4 control-label requiredField">
                            Last Name
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input($last_name+array('class'=>'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="access_level" class="col-md-4 control-label requiredField">
                            Access Level
                        </label>
                        <div class ="col-md-8" id="unit_dropdown">
                            <?php echo form_dropdown('user_type_list', $user_type_list, '', 'class=form-control id=user_type_list'); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-md-4 control-label requiredField">
                            Email
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input($email+array('class'=>'form-control')); ?>
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label requiredField">
                            Password
                        </label>
                        <div class ="col-md-8">
                            <?php echo form_input($password+array('class'=>'form-control')); ?>
                        </div> 
                    </div>                    
                </div>
                <div class="col-md-8 pull-right">
                    <table class="table table-responsive">
                        <thead>
                            <td></td>
                            <td><div class="form-group">View</div></td>
                            <td><div class="form-group">Write</div></td>
                            <td><div class="form-group">Approve</div></td>
                            <td><div class="form-group">Edit</div></td>
                            <td><div class="form-group">Delete</div></td>
                            <td><div class="form-group">Configuration</div></td>
                        </thead>

                        <tbody>
                            <tr class="success">
                                <td>
                                    Overview
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($overview_view); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($overview_write); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($overview_approve); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($overview_edit); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($overview_delete); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($overview_configuration); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="success">
                                <td>
                                    Users
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    Overview
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($user_overview_view); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($user_overview_write); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($user_overview_approve); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($user_overview_edit); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($user_overview_delete); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($user_overview_configuration); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    User manage
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($user_manage_view); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($user_manage_write); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($user_manage_approve); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($user_manage_edit); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($user_manage_delete); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($user_manage_configuration); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="success">
                                <td>
                                    Applications
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="td_text_color">
                                    Xstream Banter
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($xstream_banter_view); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($xstream_banter_write); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($xstream_banter_approve); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($xstream_banter_edit); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($xstream_banter_delete); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($xstream_banter_configuration); ?>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="td_text_color">
                                    Healthy Recipes
                                </td>
                                 <td>
                                    <div class="form-group">
                                       <?php echo form_input($healthy_recipes_view); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($healthy_recipes_write); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($healthy_recipes_approve); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($healthy_recipes_edit); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($healthy_recipes_delete); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($healthy_recipes_configuration); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_text_color">
                                    Service Directory
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($service_directory_view); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($service_directory_write); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($service_directory_approve); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($service_directory_edit); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($service_directory_delete); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($service_directory_configuration); ?>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="td_text_color">
                                    News
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($news_view); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($news_write); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($news_approve); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($news_edit); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($news_delete); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($news_configuration); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_text_color">
                                    Blogs
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($blogs_view); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($blogs_write); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($blogs_approve); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($blogs_edit); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($blogs_delete); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($blogs_configuration); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_text_color">
                                    BMI Calculator
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($bmi_calculator_view); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($bmi_calculator_write); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($bmi_calculator_approve); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($bmi_calculator_edit); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($bmi_calculator_delete); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($bmi_calculator_configuration); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="td_text_color">
                                    Photography
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($photography_view); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($photography_write); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($photography_approve); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($photography_edit); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($photography_delete); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($photography_configuration); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="success">
                                <td>
                                    Business profile
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($business_profile_view); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($business_profile_write); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($business_profile_approve); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($business_profile_edit); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($business_profile_delete); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($business_profile_configuration); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="success">
                                <td>
                                    Visitors
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    Pages
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_page_view); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_page_write); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_page_approve); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_page_edit); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_page_delete); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_page_configuration); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Applications
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_applications_view); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_applications_write); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_applications_approve); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_applications_edit); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_applications_delete); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_applications_configuration); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Business profile
                                </td>
                               <td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_business_profile_view); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_business_profile_write); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_business_profile_approve); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_business_profile_edit); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_business_profile_delete); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($visitor_business_profile_configuration); ?>
                                    </div>
                                </td>
                            </tr>
                            <tr class="success">
                                <td>
                                    Log
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($log_view); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($log_write); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($log_approve); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($log_edit); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($log_delete); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($log_configuration); ?>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr class="success">
                                <td>
                                    Footer
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="td_text_color">
                                    About Us
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($about_us_view); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($about_us_write); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($about_us_approve); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($about_us_edit); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($about_us_delete); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($about_us_configuration); ?>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="td_text_color">
                                    Contact Us
                                </td>
                                 <td>
                                    <div class="form-group">
                                       <?php echo form_input($contact_us_view); ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                       <?php echo form_input($contact_us_write); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($contact_us_approve); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($contact_us_edit); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($contact_us_delete); ?>
                                    </div>
                                </td>
				<td>
                                    <div class="form-group">
                                       <?php echo form_input($contact_us_configuration); ?>
                                    </div>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                    <div class="form-group">
                        <label for="submit_create_user" class="col-md-6 control-label requiredField">

                        </label>
                        <div class ="col-md-3 col-md-offset-3">
                            <?php echo form_input($submit_create_user+array('class'=>'form-control btn button-custom')); ?>
                        </div> 
                    </div>
                </div> 
            <?php echo form_close(); ?>
        </div>
    </div>
</div>