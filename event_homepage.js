jQuery(document).ready(function($){
  $('.eventButton').css('textDecoration', 'none');
  $('.eventButton').on('click', function(e){
  	console.log("got to onclick");
    e.preventDefault();
    $(this).siblings('.eventInfo').toggle();
  });
  $('.eventInfo').on('click', function(e){
  	console.log("got to eventInfo onclick");
    e.preventDefault();
    $(this).siblings('.eventInfo').hide();
  });

});