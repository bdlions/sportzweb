$(function($){
    $.fn.typeahead = function(options){
      //$(this).text($(this).attr("id"));
      var settings = $.extend({
          color:"black"
      },options);
      $(this).text($(this).attr("id"));
      $(this).css({color:settings.color});
  
      return this;
    };
    
});