/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function() {

    $.fn.twitterSlideshow = function(options) {
        var settings = $.extend({
        }, options);

        var rootElement = $(this);
        rootElement.append("<ul class='cb-slideshow bg_landing_ul'></ul>");
        var ul = rootElement.find("ul");

        var totalAnimationTime = settings.imageList.length * settings.interval;
        var j = 0;
        
        for (var i = 0; i < settings.imageList.length; i++) {
            var fullImagePath = settings.imagePath + settings.imageList[ i ];
            var interval = settings.interval * i;
            if (i == 0) {
                ul.append("<li><span style='-webkit-animation: imageAnimation " + totalAnimationTime + "s linear infinite " + j + "s;  -moz-animation: imageAnimation " + totalAnimationTime + "s linear infinite " + j + "s; -o-animation: imageAnimation " + totalAnimationTime + "s linear infinite " + j + "s; -ms-animation: imageAnimation " + totalAnimationTime + "s linear infinite " + j + "s; animation: imageAnimation " + totalAnimationTime + "s linear infinite " + j + "s; background-image:url(" + fullImagePath + ");'>Image " + (i + 1) + "</span></li>");
            }
            else {
                ul.append("<li ><span style='-webkit-animation: imageAnimation " + totalAnimationTime + "s linear infinite " + j + "s;  -moz-animation: imageAnimation " + totalAnimationTime + "s linear infinite " + j + "s; -o-animation: imageAnimation " + totalAnimationTime + "s linear infinite " + j + "s; -ms-animation: imageAnimation " + totalAnimationTime + "s linear infinite " + j + "s; animation: imageAnimation " + totalAnimationTime + "s linear infinite " + j + "s; background-image:url(" + fullImagePath + "); -webkit-animation-delay: " + interval + "s; -moz-animation-delay: " + interval + "s; -o-animation-delay: " + interval + "s; -ms-animation-delay: " + interval + "s; animation-delay: " + interval + "s;'>Image " + (i + 1) + "</span></li>");
            }
        }
    };
});

