var windowFocus = true;
var username;
var chatHeartbeatCount = 0;
var minChatHeartbeat = 1000;
var maxChatHeartbeat = 33000;
var chatHeartbeatTime = minChatHeartbeat;
var originalTitle;
var blinkOrder = 0;
var chatBoxWidth = 300;
var leftMostPos = 200;

var chatboxFocus = new Array();
var newMessages = new Array();
var newMessagesWin = new Array();
var chatBoxes = new Array();

$(document).ready(function() {
    originalTitle = document.title;
    startChatSession();
    followersHeartbeat();

    $([window, document]).blur(function() {
        windowFocus = false;
    }).focus(function() {
        windowFocus = true;
        document.title = originalTitle;
    });
});

function restructureChatBoxes() {
    align = 0;
    for (x in chatBoxes) {
        chatboxtitle = chatBoxes[x];

        if ($("#chatbox_" + chatboxtitle).css('display') != 'none') {
            if (align == 0) {
                $("#chatbox_" + chatboxtitle).css('right', leftMostPos + 'px');
            } else {
                width = (align) * (chatBoxWidth + 7) + 20;
                $("#chatbox_" + chatboxtitle).css('right', width + 'px');
            }
            align++;
        }
    }
}

function chatWith(chatuser, user_id) {
    createChatBox(chatuser, user_id);
    $("#chatbox_" + user_id + " #chatInput").focus();
}

function createChatBox(chatboxtitle, user_id ,minimizeChatBox) {
    if ($("#chatbox_" + user_id).length > 0) {
        if ($("#chatbox_" + user_id).css('display') == 'none') {
            $("#chatbox_" + user_id).css('display', 'block');
            restructureChatBoxes();
        }
        $("#chatbox_" + user_id + " #chatInput").focus();
        return;
    }

    $(" <div />").attr("id", "chatbox_" + user_id)
            //.html('<div class="chatboxhead"><div class="chatboxtitle">' + chatboxtitle + '</div><div class="chatboxoptions"><a href="javascript:void(0)" onclick="javascript:toggleChatBoxGrowth(\'' + chatboxtitle + '\')">-</a> <a href="javascript:void(0)" onclick="javascript:closeChatBox(\'' + chatboxtitle + '\')">X</a></div><br clear="all"/></div><div class="chatboxcontent"></div><div class="chatboxinput"><textarea class="chatboxtextarea" onkeydown="javascript:return checkChatBoxInputKey(event,this,\'' + chatboxtitle + '\');"></textarea></div>')
            .html(tmpl("tmpl-chatbox", {'title':chatboxtitle, 'user_id':user_id}))
            .appendTo($("#chatBoxesArea"));

    $("#chatbox_" + user_id).attr('style', 'width: '+chatBoxWidth+'px; right:20px; bottom: -20px;position: fixed;');

    chatBoxeslength = chatBoxes.length;

    if (chatBoxeslength == 0) {
        $("#chatbox_" + user_id).css('right', leftMostPos + 'px');
    } else {
        width = (chatBoxeslength) * (chatBoxWidth + 7) + 20;
        $("#chatbox_" + user_id).css('right', width + 'px');
    }

    chatBoxes.push(user_id);

    if (minimizeChatBox == 1) {
        minimizedChatBoxes = new Array();

        if ($.cookie('chatbox_minimized')) {
            minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
        }
        minimize = 0;
        for (j = 0; j < minimizedChatBoxes.length; j++) {
            if (minimizedChatBoxes[j] == user_id) {
                minimize = 1;
            }
        }

        if (minimize == 1) {
            $('#chatbox_' + user_id + ' #chatContent').css('display', 'none');
            $('#chatbox_' + user_id + ' #chatInput').css('display', 'none');
        }
    }

    chatboxFocus[user_id] = false;

    $("#chatbox_" + user_id + " #chatInput").blur(function() {
        chatboxFocus[user_id] = false;
        $("#chatbox_" + user_id + " #chatInput").removeClass('chatboxtextareaselected');
    }).focus(function() {
        chatboxFocus[user_id] = true;
        newMessages[user_id] = false;
        $('#chatbox_' + user_id + ' .chatboxhead').removeClass('chatboxblink');
    });

    $("#chatbox_" + user_id).click(function() {
        if ($('#chatbox_' + user_id + ' .chatboxcontent').css('display') != 'none') {
            $("#chatbox_" + user_id + " .chatboxtextarea").focus();
        }
    });

    $("#chatbox_" + user_id).show();
}

function followersHeartbeat(){
    $.ajax({
        url: config.base + "chat/get_followers_heartbeat.html",
        cache: false,
        dataType: "json",
        success: function(followers) {
            $("#chatFollowers").html(tmpl("tmpl-followers", followers))
            .appendTo($("#chatBoxesArea"));
        }
    });
    setTimeout('followersHeartbeat();', minChatHeartbeat * 6 );
}

function chatHeartbeat() {

    var itemsfound = 0;

    if (windowFocus == false) {

        var blinkNumber = 0;
        var titleChanged = 0;
        for (x in newMessagesWin) {
            if (newMessagesWin[x] == true) {
                ++blinkNumber;
                if (blinkNumber >= blinkOrder) {
                    document.title = x + ' says...';
                    titleChanged = 1;
                    break;
                }
            }
        }

        if (titleChanged == 0) {
            document.title = originalTitle;
            blinkOrder = 0;
        } else {
            ++blinkOrder;
        }

    } else {
        for (x in newMessagesWin) {
            newMessagesWin[x] = false;
        }
    }

    for (x in newMessages) {
        if (newMessages[x] == true) {
            if (chatboxFocus[x] == false) {
                //FIXME: add toggle all or none policy, otherwise it looks funny
                $('#chatbox_' + x + ' .chatboxhead').toggleClass('chatboxblink');
            }
        }
    }
    $.ajax({
        url: config.base + "chat/chat_heartbeat.html",
        cache: false,
        dataType: "json",
        success: function(users) {

        $.each(users, function(i, messages){
            
            if(messages && i > 0){
                var name = messages[0].first_name + " " + messages[0].last_name;
                if ($("#chatbox_" + i).length <= 0) {
                    createChatBox(messages[0].first_name + " " + messages[0].last_name, i);
                }
                if ($("#chatbox_" + i).css('display') == 'none') {
                    $("#chatbox_" + i).css('display', 'block');
                    restructureChatBoxes();
                }
            
                $.each(messages, function(j, message){
                    $("#chatbox_" + i + " #chatContent").append("<div class='row'><div class='col-md-12'><font style='color:green; padding-right:10px;'>"+name+"</font>"+message.message+"</div></div>");
                });
                $("#chatbox_" + i + " #chatContent").scrollTop($("#chatbox_" + i + " #chatContent")[0].scrollHeight);
            }
        });
        chatHeartbeatCount++;

        if (itemsfound > 0) {
            chatHeartbeatTime = minChatHeartbeat;
            chatHeartbeatCount = 1;
        } else if (chatHeartbeatCount >= 10) {
            chatHeartbeatTime *= 2;
            chatHeartbeatCount = 1;
            if (chatHeartbeatTime > maxChatHeartbeat) {
                chatHeartbeatTime = maxChatHeartbeat;
            }
        }

        setTimeout('chatHeartbeat();', chatHeartbeatTime);
    }});
}

function closeChatBox(chatboxtitle) {
    $('#chatbox_' + chatboxtitle).css('display', 'none');
    restructureChatBoxes();

    //$.post("chat.php?action=closechat", {chatbox: chatboxtitle}, function(data) {});

}

function toggleChatBoxGrowth(chatboxtitle) {
    if ($('#chatbox_' + chatboxtitle + ' .chatboxcontent').css('display') == 'none') {

        var minimizedChatBoxes = new Array();

        if ($.cookie('chatbox_minimized')) {
            minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
        }

        var newCookie = '';

        for (i = 0; i < minimizedChatBoxes.length; i++) {
            if (minimizedChatBoxes[i] != chatboxtitle) {
                newCookie += chatboxtitle + '|';
            }
        }

        newCookie = newCookie.slice(0, -1)


        $.cookie('chatbox_minimized', newCookie);
        $('#chatbox_' + chatboxtitle + ' .chatboxcontent').css('display', 'block');
        $('#chatbox_' + chatboxtitle + ' .chatboxinput').css('display', 'block');
        $("#chatbox_" + chatboxtitle + " .chatboxcontent").scrollTop($("#chatbox_" + chatboxtitle + " .chatboxcontent")[0].scrollHeight);
    } else {

        var newCookie = chatboxtitle;

        if ($.cookie('chatbox_minimized')) {
            newCookie += '|' + $.cookie('chatbox_minimized');
        }


        $.cookie('chatbox_minimized', newCookie);
        $('#chatbox_' + chatboxtitle + ' .chatboxcontent').css('display', 'none');
        $('#chatbox_' + chatboxtitle + ' .chatboxinput').css('display', 'none');
    }

}

function checkChatBoxInputKey(event, chatboxtextarea, user_id) {

    if (event.keyCode == 13 && event.shiftKey == 0) {
        message = $(chatboxtextarea).val();
        message = message.replace(/^\s+|\s+$/g, "");

        $(chatboxtextarea).val('');
        $(chatboxtextarea).focus();
        //$(chatboxtextarea).css('height', '44px');
        if (message != '') {
            $.post("chat/send_message.html", {to: user_id, message: message}, function(data) {
                $("#chatbox_" + user_id + " #chatContent").append("<div class='row'><div class='col-md-12'><font style='color:green; padding-right:10px;'>Me:</font>"+message+"</div></div>");
                $("#chatbox_" + user_id + " #chatContent").scrollTop($("#chatbox_" + user_id + " #chatContent")[0].scrollHeight);
            });
        }
        chatHeartbeatTime = minChatHeartbeat;
        chatHeartbeatCount = 1;

        return false;
    }

    var adjustedHeight = chatboxtextarea.clientHeight;
    var maxHeight = 94;

    if (maxHeight > adjustedHeight) {
        adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
        if (maxHeight)
            adjustedHeight = Math.min(maxHeight, adjustedHeight);
        if (adjustedHeight > chatboxtextarea.clientHeight)
            $(chatboxtextarea).css('height', adjustedHeight + 8 + 'px');
    } else {
        $(chatboxtextarea).css('overflow', 'auto');
    }

}

function startChatSession() {
    $.ajax({
        url: config.base + "chat/startChatSession.html",
        cache: false,
        dataType: "json",
        success: function(data) {
            //console.log(data.username);
            $.each(data, function(i, usersChatHistory) {
                if (usersChatHistory) { 
                    createChatBox(usersChatHistory.user_name, usersChatHistory.user_id);
                    $.each(usersChatHistory.messages, function(i, usersMessages){
                        $("#chatbox_" + usersChatHistory.user_id + " #chatContent").append("<div class='row'><div class='col-md-12'>"+usersMessages+"</div></div>");
                    });
                    $("#chatbox_" + usersChatHistory.user_id + " #chatContent").scrollTop($("#chatbox_" + usersChatHistory.user_id + " #chatContent")[0].scrollHeight);
                }

            });

            setTimeout('chatHeartbeat();', chatHeartbeatTime);

        }});
}

jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString();
        }

        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};