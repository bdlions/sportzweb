<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Lang - English
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Author: Daniel Davis
*         @ourmaninjapan
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.09.2013
*
* Description:  English language file for Ion Auth example views
*
*/

// Errors
$lang['error_csrf'] = 'This form post did not pass our security checks.';
//Admin login
$lang['login_admin_heading']         = 'Login';
$lang['login_admin_subheading']      = 'Please login with your email and password below.';

// Login
$lang['login_heading']         = 'Login';
$lang['login_subheading']      = 'Please login with your email/username and password below.';
$lang['login_identity_label']  = 'Email';
$lang['login_password_label']  = 'Password';
$lang['login_remember_label']  = 'Remember Me:';
$lang['login_submit_btn']      = 'Login';
$lang['login_forgot_password'] = 'Forgot your password?';

// Index
$lang['index_heading']           = 'Users';
$lang['index_subheading']        = 'Below is a list of the users.';
$lang['index_fname_th']          = 'First Name';
$lang['index_lname_th']          = 'Last Name';
$lang['index_email_th']          = 'Email';
$lang['index_groups_th']         = 'Groups';
$lang['index_status_th']         = 'Status';
$lang['index_action_th']         = 'Action';
$lang['index_active_link']       = 'Active';
$lang['index_inactive_link']     = 'Inactive';
$lang['index_create_user_link']  = 'Create a new user';
$lang['index_create_group_link'] = 'Create a new group';

// Deactivate User
$lang['deactivate_heading']                  = 'Deactivate User';
$lang['deactivate_subheading']               = 'Are you sure you want to deactivate the user \'%s\'';
$lang['deactivate_confirm_y_label']          = 'Yes:';
$lang['deactivate_confirm_n_label']          = 'No:';
$lang['deactivate_submit_btn']               = 'Submit';
$lang['deactivate_validation_confirm_label'] = 'confirmation';
$lang['deactivate_validation_user_id_label'] = 'user ID';

// Create User
$lang['create_user_heading']                           = 'Create User';
$lang['create_user_subheading']                        = 'Please enter the users information below.';

$lang['create_user_fname_label']                       = 'First Name';
$lang['create_user_fname_required_tooltip_label']      = 'First Name is required';

$lang['create_user_lname_label']                       = 'Last Name';
$lang['create_user_lname_required_tooltip_label']      = 'Last Name is required';

$lang['create_user_company_label']                     = 'Company Name:';

$lang['create_user_email_label']                       = 'Email';
$lang['create_user_email_required_tooltip_label']      = 'Email is required';
$lang['create_user_email_invalid_tooltip_label']       = 'Provided email is incorrect';

$lang['create_user_confirm_email_label']               = 'Confirm Email';
$lang['create_user_confirm_email_match_tooltip_label'] = 'Confirm email doesn\'t match wtih email';

$lang['create_user_phone_label']                       = 'Phone:';

$lang['create_user_password_label']                    = 'Enter Password';
$lang['create_user_password_required_tooltip_label']   = 'Password is required';
$lang['create_user_password_invalid_tooltip_label']    = 'Password is invalid. min length 5';

$lang['create_user_password_confirm_label']            = 'Confirm Password:';
$lang['create_user_submit_btn']                        = 'Create User';
$lang['create_user_validation_fname_label']            = 'First Name';
$lang['create_user_validation_lname_label']            = 'Last Name';
$lang['create_user_validation_email_label']            = 'Email Address';
$lang['create_user_validation_phone1_label']           = 'First Part of Phone';
$lang['create_user_validation_phone2_label']           = 'Second Part of Phone';
$lang['create_user_validation_phone3_label']           = 'Third Part of Phone';
$lang['create_user_validation_company_label']          = 'Company Name';
$lang['create_user_validation_password_label']         = 'Password';
$lang['create_user_validation_password_confirm_label'] = 'Password Confirmation';
$lang['security_check_label']                          = 'Security Check';
$lang['please_enter_the_characters_below_label']       = 'Please enter the characters below. (NOT case sensitive)';
$lang['captcha_error_msg']                             = 'The characters you entered did not match. Please re-enter.';


// Edit User
$lang['edit_user_heading']                           = 'Edit User';
$lang['edit_user_subheading']                        = 'Please enter the users information below.';
$lang['edit_user_fname_label']                       = 'First Name:';
$lang['edit_user_lname_label']                       = 'Last Name:';
$lang['edit_user_company_label']                     = 'Company Name:';
$lang['edit_user_email_label']                       = 'Email:';
$lang['edit_user_phone_label']                       = 'Phone:';
$lang['edit_user_password_label']                    = 'Password: (if changing password)';
$lang['edit_user_password_confirm_label']            = 'Confirm Password: (if changing password)';
$lang['edit_user_groups_heading']                    = 'Member of groups';
$lang['edit_user_submit_btn']                        = 'Save User';
$lang['edit_user_validation_fname_label']            = 'First Name';
$lang['edit_user_validation_lname_label']            = 'Last Name';
$lang['edit_user_validation_email_label']            = 'Email Address';
$lang['edit_user_validation_phone1_label']           = 'First Part of Phone';
$lang['edit_user_validation_phone2_label']           = 'Second Part of Phone';
$lang['edit_user_validation_phone3_label']           = 'Third Part of Phone';
$lang['edit_user_validation_company_label']          = 'Company Name';
$lang['edit_user_validation_groups_label']           = 'Groups';
$lang['edit_user_validation_password_label']         = 'Password';
$lang['edit_user_validation_password_confirm_label'] = 'Password Confirmation';

// Create Group
$lang['create_group_title']                  = 'Create Group';
$lang['create_group_heading']                = 'Create Group';
$lang['create_group_subheading']             = 'Please enter the group information below.';
$lang['create_group_name_label']             = 'Group Name:';
$lang['create_group_desc_label']             = 'Description:';
$lang['create_group_submit_btn']             = 'Create Group';
$lang['create_group_validation_name_label']  = 'Group Name';
$lang['create_group_validation_desc_label']  = 'Description';

// Edit Group
$lang['edit_group_title']                  = 'Edit Group';
$lang['edit_group_saved']                  = 'Group Saved';
$lang['edit_group_heading']                = 'Edit Group';
$lang['edit_group_subheading']             = 'Please enter the group information below.';
$lang['edit_group_name_label']             = 'Group Name:';
$lang['edit_group_desc_label']             = 'Description:';
$lang['edit_group_submit_btn']             = 'Save Group';
$lang['edit_group_validation_name_label']  = 'Group Name';
$lang['edit_group_validation_desc_label']  = 'Description';

// Change Password
$lang['change_password_heading']                               = 'Change Password';
$lang['change_password_old_password_label']                    = 'Old Password:';
$lang['change_password_new_password_label']                    = 'New Password:';
$lang['change_password_new_password_confirm_label']            = 'Confirm New Password:';
$lang['change_password_submit_btn']                            = 'Change';
$lang['change_password_validation_old_password_label']         = 'Old Password';
$lang['change_password_validation_new_password_label']         = 'New Password';
$lang['change_password_validation_new_password_confirm_label'] = 'Confirm New Password';

// Forgot Password
$lang['forgot_password_heading']                 = 'Forgot Password';
$lang['forgot_password_subheading']              = 'Please enter your %s so we can send you an email to reset your password.';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'Submit';
$lang['forgot_password_validation_email_label']  = 'Email Address';
$lang['forgot_password_username_identity_label'] = 'Username';
$lang['forgot_password_email_identity_label']    = 'Email';


// Reset Password
$lang['reset_password_heading']                               = 'Change Password';
$lang['reset_password_new_password_label']                    = 'New Password:';
$lang['reset_password_new_password_confirm_label']            = 'Confirm New Password:';
$lang['reset_password_submit_btn']                            = 'Change';
$lang['reset_password_validation_new_password_label']         = 'New Password';
$lang['reset_password_validation_new_password_confirm_label'] = 'Confirm New Password';

// Activation Email
$lang['email_activate_heading']    = 'Activate account for %s';
$lang['email_activate_subheading'] = 'Please click this link to %s.';
$lang['email_activate_link']       = 'Activate Your Account';

// Forgot Password Email
$lang['email_forgot_password_heading']    = 'Reset Password for %s';
$lang['email_forgot_password_subheading'] = 'Please click this link to %s.';
$lang['email_forgot_password_link']       = 'Reset Your Password';

// New Password Email
$lang['email_new_password_heading']                         = 'New Password for %s';
$lang['email_new_password_subheading']                      = 'Your password has been reset to: %s';
$lang['business_profile_insert_unsuccessful']               = 'Business profile creation unsuccessful.';
$lang['update_profile_successful']                          = "Profile update successful.";
$lang['update_profile_unsuccessful']                        = "Profile update unsuccessful.";
$lang['create_profile_unsuccessful']                        = "Profile creation unsuccessful.";
$lang['sports_creation_duplicate_sports_name']              = "Sports name already used or invalid.";
$lang['tournament_creation_duplicate_tournament_name']      = "Tournament name already used or invalid.";
$lang['team_creation_duplicate_team_name']                  = "Team name already used or invalid.";

// for recipe
$lang['recipe_category_creation_duplicate_recipe_category_name']    = "Recipe category name already used or invalid.";
$lang['recipe_creation_duplicate_recipe_name']                      = "Recipe title is duplicate";
$lang['recipe_update_duplicate_recipe']                             = "Recipe title is duplicate";
$lang['recipe_category_update_duplicate_category']                  = "Recipe category name is duplicate";
$lang['recipe_delete_fail']                                         = "Recipe delete failed.";
$lang['recipe_delete_success']                                      = "Recipe delete successful.";

// for recipe
$lang['service_category_creation_duplicate_service_category_name']      = "Service category name already used or invalid.";
$lang['service_category_duplicate']                                     = "Service category title is duplicate";
$lang['service_category_update_successful']                             = "Service category title is Update successfully";
$lang['recipe_category_update_duplicate_category']                      = "Recipe category name is duplicate";

// for news
$lang['news_category_creation_duplicate_news_category_name']            = "News category name already used or invalid.";
$lang['news_category_duplicate']                                        = "News category title is duplicate";
$lang['news_category_update_successful']                                = "News category title is Update successfully";
$lang['news_category_update_duplicate_category']                        = "News category name is duplicate";
$lang['latest_news_configuration_successful']                           = "Latest news configured successfully.";
$lang['latest_news_configuration_fail']                                 = "Error while configuring latest news.";
$lang['breaking_news_configuration_successful']                         = "Breaking news configured successfully.";
$lang['breaking_news_configuration_fail']                               = "Error while configuring breaking news.";

// for blog
$lang['blog_category_creation_duplicate_blog_category_name']            = "Blog category name is duplicate";
$lang['blog_category_duplicate']                                        = "Blog categeory title is duplicate"; 
$lang['blog_category_can_not_delete']                                   = "Blog categeory can not be deleted"; 
$lang['blog_category_delete_successful']                                = "Blog categeory is deleted successfully"; 

//for application directory
$lang['application_name_duplicate']            = "Application title is duplicate";

