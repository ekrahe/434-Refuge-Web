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

jQuery(document).ready(function($){
	//im 1280, large screen is 1600 moses has 1920
	var width = $(window).width(), height = $(window).height();
	console.log("width", width, "hegiht", height);
	if(width>=1900){
		 $('.header').css('margin-right', '30%');
	}
	if(width>=1600){
		  $('.header').css('margin-right', '28%');
	}else if(width>1000 && width<1600){
		console.log("got to right block");
		$('.header').css('margin-right', '24.25%');
	}



});