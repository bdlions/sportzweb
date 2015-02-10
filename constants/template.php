<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
define('PUBLISHER', 'publisher');
define('MEMBER', 'members');
define('BUSINESSMAN', 'businessman');
define('ADMIN', 'admin');
define('ADMIN_TITLE', 'Super Administrator');
define('NON_MEMBER', 'non_member');

define('LOGIN_URI', 'auth');
define('LOGIN_TEMPLATE', 'templates/tmpl');
define('LOGIN_VIEW', 'nonmember/templates/main');

define('PUBLISHER_LOGIN_SUCCESS_TEMPLATE', 'publisher/templates/tmpl');
define('PUBLISHER_DASHBOARD_TEMPLATE', 'publisher/templates/dashboard_tmpl');

define('USER_DASHBOARD_TEMPLATE', 'admin/templates/user_tmpl');

define('ADMIN_LOGIN_SUCCESS_URI', 'admin/auth/login');
define('ADMIN_LOGIN_SUCCESS_TEMPLATE', 'admin/templates/tmpl');
define('ADMIN_DASHBOARD_TEMPLATE', 'admin/templates/dashboard_tmpl');
define('ADMIN_LOGIN_SUCCESS_VIEW', 'auth/index');

define('MEMBER_LOGIN_SUCCESS_URI', 'auth');
define('MEMBER_LOGIN_SUCCESS_TEMPLATE', 'templates/member_tmpl');
define('MEMBER_LOGIN_SUCCESS_VIEW', 'member/index');

define('BUSINESSMAN_LOGIN_SUCCESS_URI', 'auth');
define('BUSINESSMAN_LOGIN_SUCCESS_TEMPLATE', 'templates/member_tmpl');
define('BUSINESSMAN_LOGIN_SUCCESS_VIEW', 'business_man/index');

define('NON_MEMBER_TEMPLATE', 'templates/home_tmpl');
define('WRONG_ATTEMPT_TEMPLATE', 'templates/wrong_attempt_tmpl');
define('WRONG_ATTEMPT_VIEW', 'nonmember/wrong_attempt');
?>
