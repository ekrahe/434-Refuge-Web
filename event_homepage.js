/*function to control the toggeling of the events. When clicked the first time more information is shown
	when clicked a second time less info is shown
*/
jQuery(document).ready(function($){
	//overwrite css formatting so dont have any lingering hyperlink underlines
  $('.eventButton').css('textDecoration', 'none');
  $('.eventButton').on('click', function(e){
    e.preventDefault();
    $(this).siblings('.eventInfo').toggle();
  });

  //hide the extra info on secoond click
  $('.eventInfo').on('click', function(e){
  	console.log("got to eventInfo onclick");
    e.preventDefault();
    $(this).siblings('.eventInfo').hide();
  });

});


//use this code to format location of buttons based on screen size to ensure proper formatting
jQuery(document).ready(function($){
	//im 1280, large screen is 1600 moses has 1920
	var width = $(window).width(), height = $(window).height();
	console.log("width", width, "hegiht", height);
	if(width>=1900){
		 $('.header').css('margin-right', '30%');
	}
	else if(width>=1600){
		  $('.header').css('margin-right', '28%');
	}else if(width>1000 && width<1600){
		console.log("got to right block");
		$('.header').css('margin-right', '24.25%');
	}else{
		$('.header').css('margin-right', '22.5%');
	}



});