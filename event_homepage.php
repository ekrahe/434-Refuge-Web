<?php

//bring in all the dependencies for google api
include ('includes.php');



echo '<link href="event_homepage.css" rel="stylesheet">';
echo '<h1 class="header">REFUGE</h1	>';
echo '<div class="sidebar">';     
echo '<p>text</p>';


echo '</div>';
echo '<div class="center">';
	echo "<iframe class=\"cal\" src=\"https://calendar.google.com/calendar/embed?src=f2prj9o0uq3cju3sh9hs67mhik%40group.calendar.google.com&ctz=America/New_York\" style=\"border: 0\"  frameborder=\"0\" scrolling=\"no\"></iframe>";
echo '</div>';
echo '<div class="event_creator">';
echo'<h3 class="events_header"><u> Events </u> </h3>';

$client = new Google_Client();
$client->setApplicationName("Refuge434");
$client->setDeveloperKey("AIzaSyAdjCPZQhG9uVC_R4H_IvMYYFaHHA7VPuc");
$client->setAuthConfigFile(dirname(__FILE__).'/Refuge434-8a0ccdc73ec0.json');
//$calendarList = $service->calendarList->listCalendarList();

$service= new Google_Service_Calendar($client);

//line below this one throws the error
$calendarListEntry = $service->calendarList->get('calendarId');

echo $calendarListEntry->getSummary();

echo '</div>';


?>