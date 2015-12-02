<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**Collaborators types*/
define("COLLABORATOR_TYPE_FOLLOWERS",                                   1);
define("COLLABORATOR_TYPE_ANYONE",                                      2);
define("COLLABORATOR_TYPE_SELECTED_GROUPS",                             3);

/**Time to notify users**/
define("NOTIFICATION_WHILE_START_FOLLOWING",                            1);
define("NOTIFICATION_WHILE_MENTIONS_POST",                              2);
define("NOTIFICATION_WHILE_COMMENTS_ON_CREATED_POST",                   3);
define("NOTIFICATION_WHILE_SHARES_CREATED_POST",                        4);
define("NOTIFICATION_WHILE_ADDS_IN_GROUP",                              5);
define("NOTIFICATION_WHILE_SHARES_POST_IN_ASSOCIATED_WITH_GROUP",       6);
define("NOTIFICATION_WHILE_PHOTO_TAG",                                  7);
define("NOTIFICATION_WHILE_COMMENTS_ON_ADDED_PHOTO",                    8);
define("NOTIFICATION_WHILE_LIKE_ON_CREATED_POST",                       9);
define("NOTIFICATION_WHILE_PREDICT_MATCH",                              10);

define("NOTIFICATION_WHILE_CREATE_GYMPRO_ASSESSMENT",                   11);
define("NOTIFICATION_TYPE_ID_GYMPRO_ASSESSMENT_REASSESS",               18);
define("NOTIFICATION_WHILE_CREATE_GYMPRO_PROGRAM",                      12);
define("NOTIFICATION_WHILE_CREATE_GYMPRO_PROGRAM_REVIEW",               17);
define("NOTIFICATION_WHILE_CREATE_GYMPRO_MISSION",                      13);
define("NOTIFICATION_WHILE_CREATE_GYMPRO_EXERCISE",                     14);
define("NOTIFICATION_WHILE_CREATE_GYMPRO_NUTRITION",                    15);
define("NOTIFICATION_WHILE_CREATE_GYMPRO_SESSION",                      16);


/**Ability or permission for a resources**/
define("COLLABORATE_PERMISSION_VIEW_POST",                              1);
define("COLLABORATE_PERMISSION_COMMENT_ON_POST",                        2);
define("COLLABORATE_PERMISSION_POST_ON_PROFILE",                        3);
define("COLLABORATE_PERMISSION_CONTACT",                                4);
define("COLLABORATE_PERMISSION_TAG_ME_IN_PHOTOS",                       5);
define("COLLABORATE_PERMISSION_SEARCH_FOR_ME",                          6);
define("COLLABORATE_PERMISSION_FOLLOWING",                              7);

/**Attachments that are attached with comemtn, status, feedback**/
define("ATTACHMENT_TYPE_IMAGE",                                         1);
define("ATTACHMENT_TYPE_AUDIO",                                         2);
define("ATTACHMENT_TYPE_VIDEO",                                         3);
define("ATTACHMENT_TYPE_DOC",                                           4);

/*Status posted in*/
define("STATUS_POSTED_IN_BASIC_PROFILE",                                1);
define("STATUS_POSTED_IN_BUSINESS_PROFILE",                             2);
define("STATUS_POSTED_IN_WALL",                                         3);

define("FOLLOWER_ACCEPTANCE_TYPE_AUTO",                                 1);
define("FOLLOWER_ACCEPTANCE_TYPE_MANUAL",                               2);

define("ALBUM_TYPE_BUSINESS_PROFILE",                                   1);
define("ALBUM_TYPE_USER_PROFILE",                                       2);
define("ALBUM_TYPE_USER_STATUS",                                        3); 

/* read and unread Notification **/
define("UNREAD_NOTIFICATION",                                           1);
define("READ_NOTIFICATION",                                             2);
define("NOTIFICATIONS",                                                 1);
define("FOLLOWERS",                                                     2);

?>
