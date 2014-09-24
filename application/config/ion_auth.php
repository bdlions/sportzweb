<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Database Type
| -------------------------------------------------------------------------
| If set to TRUE, Ion Auth will use MongoDB as its database backend.
|
| If you use MongoDB there are two external dependencies that have to be
| integrated with your project:
|   CodeIgniter MongoDB Active Record Library - http://github.com/alexbilbie/codeigniter-mongodb-library/tree/v2
|   CodeIgniter MongoDB Session Library - http://github.com/sepehr/ci-mongodb-session
*/
$config['use_mongodb'] = FALSE;

/*
| -------------------------------------------------------------------------
| MongoDB Collection.
| -------------------------------------------------------------------------
| Setup the mongodb docs using the following command:
| $ mongorestore sql/mongo
|
*/

$config['account_status']['active_id']      = '1';
$config['account_status']['inactive_id']    = '2';
$config['account_status']['suspended_id']   = '3';
$config['account_status']['deactivated_id'] = '4';
$config['account_status']['blocked_id']     = '5';

$config['collections']['users']          = 'users';
$config['collections']['groups']         = 'groups';
$config['collections']['login_attempts'] = 'login_attempts';

/*
| -------------------------------------------------------------------------
| Tables.
| -------------------------------------------------------------------------
| Database table names.
*/
$config['tables']['users']                                  = 'users';
$config['tables']['groups']                                 = 'groups';
$config['tables']['users_groups']                           = 'users_groups';
$config['tables']['login_attempts']                         = 'login_attempts';
$config['tables']['users_access']                           = 'users_access';
$config['tables']['gender']                                 = 'gender';
$config['tables']['countries']                              = 'countries';
$config['tables']['basic_profile']                          = 'basic_profile';
$config['tables']['business_profile']                       = 'business_profile';
$config['tables']['business_profile_connection']            = 'business_profile_connection';
$config['tables']['business_profile_type']                  = 'business_profile_type';
$config['tables']['security_questions']                     = 'security_questions';
$config['tables']['special_interests_types']                = 'special_interests_types';
$config['tables']['collaborator_types']                     = 'collaborator_types';
$config['tables']['notification_types']                     = 'notification_types';
$config['tables']['notification_media_types']               = 'notification_media_types';
$config['tables']['collaborate_permission_types']           = 'collaborate_permission_types';
$config['tables']['collaborate_permission']                 = 'collaborate_permission';
$config['tables']['users_notifications']                    = 'users_notifications';
$config['tables']['following_acceptance_types']             = 'following_acceptance_types';
$config['tables']['usres_mutual_relations']                 = 'usres_mutual_relations';
$config['tables']['users_statuses']                         = 'users_statuses';
$config['tables']['usres_following_acceptance']             = 'usres_following_acceptance';
$config['tables']['users_comments']                         = 'users_comments';
$config['tables']['users_statuses_share']                   = 'users_statuses_share';
$config['tables']['statuses']                               = 'statuses';
$config['tables']['user_log']                               = 'user_log';
$config['tables']['album_photos']                           = 'album_photos';
$config['tables']['users_albums']                           = 'users_albums';
$config['tables']['users_messages']                         = 'users_messages';
$config['tables']['user_profile_photos']                    = 'user_profile_photos';
//photo module
$config['tables']['albums_categories']                      = 'albums_categories';
$config['tables']['albums_types']                           = 'albums_types';
$config['tables']['albums']                                 = 'albums';
$config['tables']['albums_photos']                          = 'albums_photos';
//footer
$config['tables']['footer_about_us']                        = 'footer_about_us';

/*
 * Applications
 */
$config['tables']['application_directory']                  = 'application_directory';
$config['tables']['applications']                           = 'applications';
$config['tables']['sports']                                 = 'sports';
$config['tables']['tournaments']                            = 'tournaments';
$config['tables']['teams']                                  = 'teams';
$config['tables']['teams_tournaments']                      = 'teams_tournaments';
$config['tables']['matches']                                = 'matches';
$config['tables']['xb_chat_rooms']                          = 'xb_chat_rooms';
$config['tables']['xb_chat_rooms_map']                      = 'xb_chat_rooms_map';
$config['tables']['xb_chat_messages']                       = 'xb_chat_messages';
$config['tables']['recipe_category']                        = 'recipe_category';
$config['tables']['recipes']                                = 'recipes';
$config['tables']['recipe_selection']                       = 'recipe_selection';
$config['tables']['recipe_comments']                        = 'recipe_comments';
$config['tables']['service_category']                       = 'service_category';
$config['tables']['services']                               = 'services';
$config['tables']['service_comments']                       = 'service_comments';
$config['tables']['news_category']                          = 'news_category';
$config['tables']['news_category_configuration']            = 'news_category_configuration';
$config['tables']['news_sub_category']                      = 'news_sub_category';
$config['tables']['news_sub_category_configuration']        = 'news_sub_category_configuration';
$config['tables']['news']                                   = 'news';
$config['tables']['news_home_page_configuration']           = 'news_home_page_configuration';
$config['tables']['news_comments']                          = 'news_comments';
$config['tables']['latest_news']                            = 'latest_news';
$config['tables']['breaking_news']                          = 'breaking_news';
$config['tables']['news_home_page']                         = 'news_home_page';
$config['tables']['blog_category']                          = 'blog_category';
$config['tables']['blog_custom_category']                   = 'blog_custom_category';
$config['tables']['blogs']                                  = 'blogs';
$config['tables']['blog_status']                            = 'blog_status';
$config['tables']['blog_comments']                          = 'blog_comments';
$config['tables']['blog_configure_homepage']                = 'blog_configure_homepage';
$config['tables']['bmi_questions']                          = 'bmi_questions';
$config['tables']['bmi_home_page_configuration']            = 'bmi_home_page_configuration';
$config['tables']['photography']                            = 'photography';
// visitors
$config['tables']['pages']                                  = 'pages';
$config['tables']['page_visitor']                           = 'page_visitor';
$config['tables']['application_visitor']                    = 'application_visitor';
$config['tables']['business_profile_visitor']               = 'business_profile_visitor';
//login page
$config['tables']['configure_login_page']                   = 'configure_login_page';
//logout page
$config['tables']['configure_logout_page']                  = 'configure_logout_page';
//trending feature
$config['tables']['hashtags']                               = 'hashtags';

/*
 | Users table column and Group table column you want to join WITH.
 |
 | Joins from users.id
 | Joins from groups.id
 */
$config['join']['users']        = 'user_id';
$config['join']['groups']       = 'group_id';
$config['join']['gender']       = 'gender_id';
$config['join']['countries']    = 'country_id';

$config['group_identity_column']                        = 'name';
$config['sports_identity_column']                       = 'title';
$config['tournament_identity_column']                   = 'title';
$config['team_identity_column']                         = 'title';
$config['recipe_category_identity_column']              = 'description';
$config['recipe_identity_column']                       = 'title';
$config['service_category_identity_column']             = 'description';
$config['service_identity_column']                      = 'title';
$config['news_category_identity_column']                = 'title';
$config['news_sub_category_identity_column']            = 'title';
$config['blog_category_identity_column']                = 'title';

$config['application_title_identity_column']            = 'title';

/*
 | -------------------------------------------------------------------------
 | Hash Method (sha1 or bcrypt)
 | -------------------------------------------------------------------------
 | Bcrypt is available in PHP 5.3+
 |
 | IMPORTANT: Based on the recommendation by many professionals, it is highly recommended to use
 | bcrypt instead of sha1.
 |
 | NOTE: If you use bcrypt you will need to increase your password column character limit to (80)
 |
 | Below there is "default_rounds" setting.  This defines how strong the encryption will be,
 | but remember the more rounds you set the longer it will take to hash (CPU usage) So adjust
 | this based on your server hardware.
 |
 | If you are using Bcrypt the Admin password field also needs to be changed in order login as admin:
 | $2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36
 |
 | Becareful how high you set max_rounds, I would do your own testing on how long it takes
 | to encrypt with x rounds.
 */
$config['hash_method']    = 'sha1';	// IMPORTANT: Make sure this is set to either sha1 or bcrypt
$config['default_rounds'] = 8;		// This does not apply if random_rounds is set to true
$config['random_rounds']  = FALSE;
$config['min_rounds']     = 5;
$config['max_rounds']     = 9;

/*
 | -------------------------------------------------------------------------
 | Authentication options.
 | -------------------------------------------------------------------------
 | maximum_login_attempts: This maximum is not enforced by the library, but is
 | used by $this->ion_auth->is_max_login_attempts_exceeded().
 | The controller should check this function and act
 | appropriately. If this variable set to 0, there is no maximum.
 */
$config['site_title']                 = "Example.com";       // Site Title, example.com
$config['admin_email']                = "admin@example.com"; // Admin Email, admin@example.com
$config['default_group']              = 'members';           // Default group, use name
$config['admin_group']                = 'admin';             // Default administrators group, use name
$config['identity']                   = 'email';             // A database column which is used to login with
$config['min_password_length']        = 8;                   // Minimum Required Length of Password
$config['max_password_length']        = 20;                  // Maximum Allowed Length of Password
$config['email_activation']           = FALSE;               // Email Activation for registration
$config['manual_activation']          = FALSE;               // Manual Activation for registration
$config['remember_users']             = TRUE;                // Allow users to be remembered and enable auto-login
$config['user_expire']                = 86500;               // How long to remember the user (seconds). Set to zero for no expiration
$config['user_extend_on_login']       = FALSE;               // Extend the users cookies everytime they auto-login
$config['track_login_attempts']       = TRUE;               // Track the number of failed login attempts for each user or ip.
$config['maximum_login_attempts']     = 3;                   // The maximum number of failed login attempts.
$config['lockout_time']               = 600;                 // The number of seconds to lockout an account due to exceeded attempts
$config['forgot_password_expiration'] = 0;                   // The number of miliseconds after which a forgot password request will expire. If set to 0, forgot password requests will not expire.


/*
 | -------------------------------------------------------------------------
 | Email options.
 | -------------------------------------------------------------------------
 | email_config:
 | 	  'file' = Use the default CI config or use from a config file
 | 	  array  = Manually set your email config settings
 */
$config['use_ci_email'] = FALSE; // Send Email using the builtin CI email class, if false it will return the code and the identity
$config['email_config'] = array(
	'mailtype' => 'html',
);

/*
 | -------------------------------------------------------------------------
 | Email templates.
 | -------------------------------------------------------------------------
 | Folder where email templates are stored.
 | Default: auth/
 */
$config['email_templates'] = 'auth/email/';

/*
 | -------------------------------------------------------------------------
 | Activate Account Email Template
 | -------------------------------------------------------------------------
 | Default: activate.tpl.php
 */
$config['email_activate'] = 'activate.tpl.php';

/*
 | -------------------------------------------------------------------------
 | Forgot Password Email Template
 | -------------------------------------------------------------------------
 | Default: forgot_password.tpl.php
 */
$config['email_forgot_password'] = 'forgot_password.tpl.php';

/*
 | -------------------------------------------------------------------------
 | Forgot Password Complete Email Template
 | -------------------------------------------------------------------------
 | Default: new_password.tpl.php
 */
$config['email_forgot_password_complete'] = 'new_password.tpl.php';

/*
 | -------------------------------------------------------------------------
 | Salt options
 | -------------------------------------------------------------------------
 | salt_length Default: 10
 |
 | store_salt: Should the salt be stored in the database?
 | This will change your password encryption algorithm,
 | default password, 'password', changes to
 | fbaa5e216d163a02ae630ab1a43372635dd374c0 with default salt.
 */
$config['salt_length'] = 10;
$config['store_salt']  = FALSE;

/*
 | -------------------------------------------------------------------------
 | Message Delimiters.
 | -------------------------------------------------------------------------
 */
$config['message_start_delimiter'] = '<p>'; 	// Message start delimiter
$config['message_end_delimiter']   = '</p>'; 	// Message end delimiter
$config['error_start_delimiter']   = '<p>';		// Error mesage start delimiter
$config['error_end_delimiter']     = '</p>';	// Error mesage end delimiter

/* End of file ion_auth.php */
/* Location: ./application/config/ion_auth.php */