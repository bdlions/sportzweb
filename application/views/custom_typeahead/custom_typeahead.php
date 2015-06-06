<script type="text/javascript">
            $(function () {
                var typingTimer;
                var doneTypingInterval = 1000;
                var timeElapsed = 0;
                var timeoutfn;
                var waitForResult = false;
                $("#typeahead").on("keyup", function () {

                    waitForResult = true;
                    timeElapsed = 0;
                });
                $("#typeahead").on("keydown", function () {
                    waitForResult = false;
                });
                setInterval(function () {
                    if (waitForResult == true && timeElapsed >= doneTypingInterval) {
                        waitForResult = false;
                        var inputvalue = $("#typeahead").val();
                        console.log(inputvalue)
                        $.ajax({
                            dataType: 'json',
                            type: "POST",
                            url: '<?php echo base_url();?>search/get_search_result',
                            data: {
                                input_value: inputvalue
                            },
                            success: function (data) {
                                var news_dropdown_div = $("#type_ahead_news #dropdown_news");
                                $(news_dropdown_div).remove();
                                var users_dropdown_div = $("#type_ahead_user #dropdown_user");
                                $(users_dropdown_div).remove();
                                var recipes_dropdown_div = $("#type_ahead_recipes #dropdown_recipes");
                                $(recipes_dropdown_div).remove();
                                var blogs_dropdown_div = $("#type_ahead_blogs #dropdown_blogs");
                                $(blogs_dropdown_div).remove();
                                var b_users_dropdown_div = $("#type_ahead_b_users #dropdown_b_users");
                                $(b_users_dropdown_div).remove();
                                $("#user_image_id").hide();

                                var noOfUsers = 0;
                                var noOfNews = 0;
                                var noOfRecipes = 0;
                                var noOfbBlogs = 0;
                                var noOfbBUser = 0;
                                
                                if (typeof data.users != 'undefined') {
                                    noOfUsers = data.users.length;
                                }
                                if (typeof data.news != 'undefined') {
                                    noOfNews = data.news.length;
                                }
                                if (typeof data.recipes != 'undefined') {
                                    noOfRecipes = data.recipes.length;
                                }
                                if (typeof data.blogs != 'undefined') {
                                    noOfbBlogs = data.blogs.length;
                                }
                                if (typeof data.business_user != 'undefined') {
                                    noOfbBUser = data.business_user.length;
                                }

                                if (noOfUsers > 0 || noOfNews > 0 || noOfRecipes > 0 || noOfbBlogs > 0 || noOfbBUser > 0) {
                                    $("#page_late_id").show();
                                } else {
                                    $("#page_late_id").hide();
                                }
                                
                                if (noOfUsers > 0) {
                                    $("#user_image_id").show();
                                    $("#type_ahead_user").append("<div id='dropdown_user'></div>");
                                    var user_temp_div = $("#type_ahead_user #dropdown_design_user");
                                    var users_dropdown_div = $("#type_ahead_user #dropdown_user");
                                    $(user_temp_div).find(".row").each(function () {
//                                    var noOfCols = $(this).find(".col").size();
                                        for (var i = 0; i < noOfUsers; i++) {
                                            $(users_dropdown_div).append($(this).clone());
                                        }
                                    });
                                    $(user_temp_div).hide();
                                    var count = 0;
                                    while (noOfUsers > count) {
                                        $(users_dropdown_div).find(".row ").each(function () {
                                            var user_name = $(this).find(".user_name");
                                            var user_anchor = $(this).find(".user_anchor");
                                            var user_image = $(this).find(".user_image");
                                            var home_town = $(this).find(".home_town");
                                            var country_name = $(this).find(".country_name");
                                            var signature_id = $(this).find(".signature_id");
                                            $(user_anchor).attr('href', data.users[count].url);
                                            $(user_image).attr('alt',data.users[count].signature);
                                            $(user_image).attr('src',data.users[count].user_image);
                                            $(signature_id).html(data.users[count].signature);
                                            $(user_name).html(data.users[count].username);
                                            $(home_town).html(data.users[count].home_town);
                                            $(country_name).html(data.users[count].country_name);
                                            count++;
                                        });
                                    }
                                }
                                if (noOfNews > 0) {
                                    $(".news_image").show();
                                    $("#type_ahead_news").append("<div id='dropdown_news'></div>");
                                    var news_temp_div = $("#type_ahead_news #dropdown_design_news");
                                    var news_dropdown_div = $("#type_ahead_news #dropdown_news");
                                    $(news_temp_div).find(".row").each(function () {
//                                    var noOfCols = $(this).find(".col").size();
                                        for (var i = 0; i < noOfNews; i++) {
                                            $(news_dropdown_div).append($(this).clone());
                                        }
                                    });
                                    $(news_temp_div).hide();
                                    var count_news = 0;
                                    while (noOfNews > count_news) {
                                        $(news_dropdown_div).find(".row ").each(function () {
                                            var news_image = $(this).find(".news_image");
                                            var news_title = $(this).find(".news_title");
                                            var news_anchor = $(this).find(".news_anchor");
                                            $(news_anchor).attr('href', data.news[count_news].url);
                                            $(news_image).attr('src', data.news[count_news].picture);
                                            $(news_title).html(data.news[count_news].title);
                                            count_news++;
                                        });
                                    }
                                }
                                if (noOfRecipes > 0) {
                                    $(".recipes_image").show();
                                    $("#type_ahead_recipes").append("<div id='dropdown_recipes'></div>");
                                    var recipes_temp_div = $("#type_ahead_recipes #dropdown_design_recipes");
                                    var recipes_dropdown_div = $("#type_ahead_recipes #dropdown_recipes");
                                    $(recipes_temp_div).find(".row").each(function () {
//                                    var noOfCols = $(this).find(".col").size();
                                        for (var i = 0; i < noOfRecipes; i++) {
                                            $(recipes_dropdown_div).append($(this).clone());
                                        }
                                    });
                                    $(recipes_temp_div).hide();
                                    var count_recipes = 0;
                                    while (noOfRecipes > count_recipes) {
                                        $(recipes_dropdown_div).find(".row ").each(function () {
                                            var recipes_image = $(this).find(".recipes_image");
                                            var recipes_title = $(this).find(".recipes_title");
                                            var recipes_anchor = $(this).find(".recipes_anchor");
                                            $(recipes_image).attr('src', data.recipes[count_recipes].picture);
                                            $(recipes_anchor).attr('href', data.recipes[count_recipes].url);
                                            $(recipes_title).html(data.recipes[count_recipes].title);
                                            count_recipes++;
                                        });
                                    }
                                }
                                if (noOfbBlogs > 0) {
                                    $(".blogs_image").show();
                                    $("#type_ahead_blogs").append("<div id='dropdown_blogs'></div>");
                                    var blogs_temp_div = $("#type_ahead_blogs #dropdown_design_blogs");
                                    var blogs_dropdown_div = $("#type_ahead_blogs #dropdown_blogs");
                                    $(blogs_temp_div).find(".row").each(function () {
//                                    var noOfCols = $(this).find(".col").size();
                                        for (var i = 0; i < noOfbBlogs; i++) {
                                            $(blogs_dropdown_div).append($(this).clone());
                                        }
                                    });
                                    $(blogs_temp_div).hide();
                                    var count_blogs = 0;
                                    while (noOfbBlogs > count_blogs) {
                                        $(blogs_dropdown_div).find(".row ").each(function () {
                                            var blogs_image = $(this).find(".blogs_image");
                                            var blogs_title = $(this).find(".blogs_title");
                                            var blogs_anchor = $(this).find(".blogs_anchor");
                                            $(blogs_image).attr('src', data.blogs[count_blogs].picture);
                                            $(blogs_anchor).attr('href', data.blogs[count_blogs].url);
                                            $(blogs_title).html(data.blogs[count_blogs].title);
                                            count_blogs++;
                                        });
                                    }
                                }
                                if (noOfbBUser > 0) {
                                    $("#type_ahead_b_users").append("<div id='dropdown_b_users'></div>");
                                    var b_users_temp_div = $("#type_ahead_b_users #dropdown_design_b_users");
                                    var b_users_dropdown_div = $("#type_ahead_b_users #dropdown_b_users");
                                    $(b_users_temp_div).find(".row").each(function () {
//                                    var noOfCols = $(this).find(".col").size();
                                        for (var i = 0; i < noOfbBUser; i++) {
                                            $(b_users_dropdown_div).append($(this).clone());
                                        }
                                    });
                                    $(b_users_temp_div).hide();
                                    var count_b_users = 0;
                                    while (noOfbBUser > count_b_users) {
                                        $(b_users_dropdown_div).find(".row ").each(function () {
                                            var b_users_image = $(this).find(".b_users_image");
                                            var business_name = $(this).find(".business_name");
                                            var b_user_anchor = $(this).find(".b_user_anchor");
                                            var b_signature_id = $(this).find(".b_signature_id");
//                                            $(b_users_image).attr('src', data.business_user[count_b_users].signature);
                                            $(b_user_anchor).attr('href', data.business_user[count_b_users].url);
                                            $(b_users_image).attr('art',data.business_user[count_b_users].signature);
                                            $(b_users_image).attr('src',data.business_user[count_b_users].logo);
                                            $(business_name).html(data.business_user[count_b_users].business_name);
                                            $(b_signature_id).html(data.business_user[count_b_users].signature);
                                            count_b_users++;
                                        });
                                    }
                                }
                            }
                        });
                    }
                    timeElapsed += 100;
                }, 100);

            });

        </script>