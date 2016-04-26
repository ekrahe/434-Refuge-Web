function seeDetails(startDate, startTime, endDate, endTime, location, descriptionHeader, documents, aid){
	console.log(startDate+"  "+startTime+"  "+endDate+"  "+endTime+ "  "+location+"  "+descriptionHeader+"  "+documents+"  "+aid)

}
jQuery(document).ready(function($){
  $('.eventButton').on('click', function(e){
  	console.log("got to onclick");
    e.preventDefault();
    $(this).siblings('.eventInfo').toggle();
  });

});