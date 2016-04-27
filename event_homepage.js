jQuery(document).ready(function($){
  $('.eventButton').on('click', function(e){
  	console.log("got to onclick");
    e.preventDefault();
    $(this).siblings('.eventInfo').toggle();
  });

});