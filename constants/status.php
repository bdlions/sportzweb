<?php 
    define("STATUS_POST_SUCCESS",                                   1);
    define("STATUS_POST_EMPTY_ERROR",                               2);
    define("STATUS_POST_REFRESH",                                   3);
    define("STATUS_POST_INSERTION_ERROR",                           4);
    define("STATUS_SHARE_PHOTO_SUCCESS",                            5);
    define("STATUS_SHARE_PHOTO_ERROR",                              6);
    
    define("STATUS_TYPE_GENERAL",                                   1);
    define("STATUS_TYPE_PROFILE_PIC_CHANGE",                        2);
    define("STATUS_TYPE_IMAGE_ATTACHMENT",                          3);
    
    define("STATUS_CATEGORY_USER_NEWSFEED",                         1);
    define("STATUS_CATEGORY_USER_PROFILE",                          2);
    define("STATUS_CATEGORY_USER_BUSINESS_PROFILE",                 3);
    define("STATUS_CATEGORY_FOLLOWER_PROFILE",                      4);
    define("STATUS_CATEGORY_FOLLOWER_BUSINESS_PROFILE",             5);
    
    define("STATUS_LIMIT_PER_REQUEST",                              10);
    
    define("STATUS_LIST_NEWSFEED",                                  1);
    define("STATUS_LIST_USER_PROFILE",                              2);
    define("STATUS_LIST_BUSINESS_PROFILE",                          3);
    define("STATUS_LIST_HASHTAG",                                   4);
    
    define("STATUS_LIKE_FOLLOWER",                                  1);
    define("STATUS_LIKE_NON_FOLLOWER",                              2);
    define("STATUS_LIKE_SELF",                                      3);
    
    define("STATUS_IMAGE_UPLOAD_MAX_SIZE",                          "30000");
    define("STATUS_IMAGE_UPLOAD_TEMP_PATH",                         "resources/uploads/temp/status/");
    define("STATUS_IMAGE_UPLOAD_PATH",                              "resources/uploads/status/");
    
    define("STATUS_ATTACHMENT_IMAGE",                               "image");
    
    define("STATUS_SHARE_OTHER_STATUS",                             1);
    define("STATUS_SHARE_HEALTHY_RECIPE",                           2);
    define("STATUS_SHARE_SERVICE_DIRECTORY",                        3);
    define("STATUS_SHARE_NEWS",                                     4);
    define("STATUS_SHARE_BLOG",                                     5);
    define("STATUS_SHARE_PHOTO",                                    6);
?>