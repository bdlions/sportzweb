<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - English
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.14.2010
*
* Description:  English language file for Ion Auth messages and errors
*
*/

// Account Creation
$lang['account_creation_successful'] 	  	 = 'Please click the link within your email account to complete your registration';
$lang['account_creation_unsuccessful'] 	 	 = 'Unable to Create Account';
$lang['account_creation_duplicate_email'] 	 = 'Email Already Used or Invalid';
$lang['account_creation_duplicate_username'] = 'Username Already Used or Invalid';

// Password
$lang['password_change_successful'] 	 	 = 'Password Successfully Changed';
$lang['password_change_unsuccessful'] 	  	 = 'Unable to Change Password';
$lang['forgot_password_successful'] 	 	 = 'Password Reset Email Sent';
$lang['forgot_password_unsuccessful'] 	 	 = 'Unable to Reset Password';

// Activation
$lang['activate_successful'] 		  	     = 'Account Activated';
$lang['activate_unsuccessful'] 		 	     = 'Unable to Activate Account';
$lang['deactivate_successful'] 		  	     = 'Account De-Activated';
$lang['deactivate_unsuccessful'] 	  	     = 'Unable to De-Activate Account';
$lang['activation_email_successful'] 	  	 = 'Activation Email Sent';
$lang['activation_email_unsuccessful']   	 = 'Unable to Send Activation Email';

// Login / Logout
$lang['login_successful'] 		  	         = 'Logged In Successfully';
$lang['login_unsuccessful'] 		  	     = 'Incorrect Login';
$lang['login_unsuccessful_not_active'] 		 = 'Account is inactive';
$lang['login_timeout']                       = 'Temporarily Locked Out.  Try again later.';
$lang['logout_successful'] 		 	         = 'Logged Out Successfully';

// Account Changes
$lang['update_successful'] 		 	         = 'Account Information Successfully Updated';
$lang['update_unsuccessful'] 		 	     = 'Unable to Update Account Information';
$lang['delete_successful']               = 'User Deleted';
$lang['delete_unsuccessful']           = 'Unable to Delete User';

// Groups
$lang['group_creation_successful']  = 'Group created Successfully';
$lang['group_already_exists']       = 'Group name already taken';
$lang['group_update_successful']    = 'Group details updated';
$lang['group_delete_successful']    = 'Group deleted';
$lang['group_delete_unsuccessful'] 	= 'Unable to delete group';
$lang['group_name_required'] 		= 'Group name is a required field';

// Email Subjects
$lang['email_forgotten_password_subject']    = 'Forgotten Password Verification';
$lang['email_new_password_subject']          = 'New Password';
$lang['email_activation_subject']            = 'Account Activation';

$lang['incorrect_security_answer']            = 'Security quesstion\'s answer is incorrect';
$lang['invalid_email_address']              = "Your provided email address is invalid.";

$lang['group_creation_duplicate_group_name']   = 'Group Name Already Used or Invalid.';
$lang['group_creation_success_message']   = 'Group is created successfully.';

//Score Prediction Application
$lang['create_sports_successful']              = "Sports is created successfully";
$lang['update_sports_duplicate_title']         = "Sports Name Already used or invalid";
$lang['update_sports_unsuccessful']            = "Unable to update sports info";
$lang['update_sports_successful']              = "Sports is updated successfully";
$lang['delete_sports_unsuccessful']            = "Unable to delete sports info";
$lang['delete_sports_successful']              = "Sports is deleted successfully";

$lang['create_team_successful']              = "Team is created successfully";
$lang['update_team_duplicate_title']         = "Team Name Already used or invalid";
$lang['update_team_unsuccessful']            = "Unable to update team info";
$lang['update_team_successful']              = "Team is updated successfully";
$lang['delete_team_unsuccessful']            = "Unable to delete team info";
$lang['delete_team_successful']              = "Team is deleted successfully";

$lang['create_tournament_successful']        = "Tournament is created successfully";
$lang['update_tournament_duplicate_title']   = "Tournament Name and season already used or invalid";
$lang['update_tournament_duplicate_season']  = "Tournament Name and season already used or invalid";
$lang['update_tournament_unsuccessful']      = "Unable to update tournament info";
$lang['update_tournament_successful']        = "Tournament is updated successfully";
$lang['delete_tournament_unsuccessful']      = "Unable to delete tournament info";
$lang['delete_tournament_successful']        = "Tournament is deleted successfully";

$lang['create_match_successful']             = "Match is created successfully.";
$lang['create_match_unsuccessful']           = "Unable to create a match.";
$lang['update_match_successful']             = "Match is updated successfully.";
$lang['update_match_unsuccessful']           = "Unable to update this match.";
$lang['delete_match_successful']             = "Match is deleted successfully.";
$lang['delete_match_unsuccessful']           = "Unable to delete a match.";

$lang['configure_homepage_successful']        = "Homepage is configured successfully";
