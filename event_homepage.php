<?php

//bring in all the dependencies for google api
include ('includes.php');
define('APPLICATION_NAME', 'Google Calendar API PHP Quickstart');
define('CREDENTIALS_PATH',dirname(dirname(__FILE__)).'/calendar-php-quickstart.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/calendar-php-quickstart.json
define('SCOPES', implode(' ', array(
	Google_Service_Calendar::CALENDAR)
						));

//web page stuff
echo '<!DOCTYPE html>';
echo '<head>';
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">';
echo '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>';
echo '<script type="text/javascript" src="event_homepage.js"></script>';
echo '<link href="event_homepage.css" rel="stylesheet">';
echo '<html xmlns="http://www.w3.org/1999/xhtml">';

echo '</head>';
echo '<a href="event_homepage.php"><img class="logo" src="Refuge_web_logo_full.png"></a>';
echo '<h1 class="header">Home</h1>';

echo '<div class="taskLinks">';

echo '<a href="event_creationpage.html" type="button" class="btn btn-primary buttons" style="margin-right:20px;"><span class="buttonText">Create Event</span></a>    
<a href="pushnotification.html" type="button" class="btn btn-primary buttons"><span class="buttonText">Push Notification</span></a> ';

echo '</div>';





echo '<div class="center">';
echo '<iframe class="cal" src="https://calendar.google.com/calendar/embed?src=f2prj9o0uq3cju3sh9hs67mhik%40group.calendar.google.com&amp;bgcolor=%23FFFFFF&amp;ctz=America/New_York" style="scrolling="no"></iframe>';
echo '</div>';
echo '<div class="event_creator">';
echo'<h3 class="events_header">Upcoming Events</h3>';






////////////////////////SETUP CONNECTION TO GOOGLE API

$client = getClient(); //see below 


$service= new Google_Service_Calendar($client);

//////////


//This code only runs occurs when save button is clicked on create_event page


if(isset($_POST['submit'])) {
	
	$title = htmlspecialchars($_POST['title']);
	$start_date = htmlspecialchars($_POST['start_date']);
	$start_time = htmlspecialchars($_POST['start_time']);
	$end_date = htmlspecialchars($_POST['end_date']);
	$end_time = htmlspecialchars($_POST['end_time']);
	$location = htmlspecialchars($_POST['location']);
	$description = htmlspecialchars($_POST['description']);
	$documents =$_POST['documents'];	
	$aid = $_POST['aid'];
	
	  
	

	$descript = $description."\r\n";

	if(!empty($documents)) {
		$descript.='DOCUMENTS:';
		$doc ="";	    
		foreach ($documents as $docs) {
			$doc.=$docs.',' ;
		}

		$descript .=$doc."\r\n";
	}

	if(!empty($aid)) {
		$descript.= 'AID:';		  
		$help ="";
		foreach ($aid as $ad) {
			$help.=$ad.',' ;
		}

		$descript .= $help."\r\n";

	}
    	
	//Make post to calender to create event
	// Refer to the PHP quickstart on how to setup the environment:
	// https://developers.google.com/google-apps/calendar/quickstart/php
	// Change the scope to Google_Service_Calendar::CALENDAR and delete any stored
	// credentials.
	

	$event = new Google_Service_Calendar_Event(array(
		'summary' => $title,
		'location' => $location,
		'description' =>$descript,
		'start' => array(
			'dateTime' => $start_date.'T'.$start_time.':11Z',
			'timeZone' => 'America/Los_Angeles',
		),
		'end' => array(
			'dateTime' => $end_date.'T'.$end_time.':11Z',
			'timeZone' => 'America/Los_Angeles',
		),
	));

	$calendarId = 'f2prj9o0uq3cju3sh9hs67mhik@group.calendar.google.com';
	$event = $service->events->insert($calendarId, $event);
	
	  
   
	

}





//////////////////////////

echo '<div class="events">';

//setup formatting for GET call to Google API
$optParams = array(
  'orderBy' => 'startTime',
  'singleEvents' => TRUE,
);

//Get the events from the Calendar
$events = $service->events->listEvents('f2prj9o0uq3cju3sh9hs67mhik@group.calendar.google.com', $optParams); //long string is calandarID


date_default_timezone_set('America/Los_Angeles');
$date = new DateTime('now');
$date-> format ("Y-m-d\TH:i:sP");

//iterate over events and format to display 
foreach ($events->getItems() as $event) {
	//only display future events 
	if((new DateTime($event->getStart()->dateTime))->getTimestamp()-$date->getTimestamp() > 0){

		//setup Regex's to capture info from Google API

		//dateTime formatting
		$dateTimePattern= '/(\d*-\d*-\d*)T(\d*:\d*):(\d*)-(\d*:\d*)/';
		

		/*the IF block below is to get event description, documents and aid. Since not all three are 
			always going to be provided, each permutation is accounted for in creating the regex
		*/

		if(strpos($event->description, 'DOCUMENTS') && strpos($event->description, 'AID')){
			$eventDescriptionPattern='/(.*)DOCUMENTS:(.*)AID:(.*)/';
		}else if (strpos($event->description, 'DOCUMENTS')){
			$eventDescriptionPattern='/(.*)DOCUMENTS:(.*)/';
		}else if(strpos($event->description, 'AID')){
			$eventDescriptionPattern='/(.*)AID:(.*)/';
		}else{
			$eventDescriptionPattern='/(.*)/';
		}	


		$eventDescription=trim(preg_replace("/\r\n/",  ' ' , $event->description));


		//regex on event object to get values
		preg_match($dateTimePattern, $event->getStart()->dateTime, $startMatch);
		preg_match($dateTimePattern, $event->getEnd()->dateTime, $endMatch);
		preg_match($eventDescriptionPattern, $eventDescription, $descriptionMatch);

	
	

	
		//build event to be outputted to sidebar on page, class IDs are linked to javascript
		echo '<a class="eventButton" href="#">';
		echo '<div class="event">';
		echo '<div class="event_content">';
				echo '<h4>';
				echo '<u>'.$event->summary.'</u>';
				echo '</h4>';
				
				
				echo '<b>Where:</b>'.$event->location;
				echo "<br>";


				echo '<b>Start:</b>'.$startMatch[2]. ' ('. $startMatch[1]. ')';


				echo "<br>";
				
				echo '<b>End:</b>'.$endMatch[2]. ' ('. $endMatch[1]. ')';


				//section only displays when event is clicked on 
				echo '<div class="eventInfo">';
					
					echo ' <a href="#" class="closeButton"></a>';
					echo '<b>What:</b>';
					echo '<br>';
					echo $descriptionMatch[1];
					echo '<br>';
					echo '<b>Documents:</b>';
					echo '<br>';
					echo substr($descriptionMatch[2],0,-2);
					echo '<br>';
					echo '<b>Aid:</b>';
					echo '<br>';
					echo substr($descriptionMatch[3],0,-1);
					
				echo '</div>';
			
				


				echo '</div>';



			
		echo '</div>';
	echo '</a>';


	}
        
}


echo '</div>';




echo '</div>';


//code to get link to google API
function getClient() {

	$client = new Google_Client();
	$client->setApplicationName(APPLICATION_NAME);
	$client->setScopes(SCOPES);
	$client->setAuthConfigFile(CLIENT_SECRET_PATH);
	$client->setAccessType('offline');
	$client->setDeveloperKey('AIzaSyBXmWg-rhhg61IDkj5u6BT7ME1APbHe8-g'); //key API
	//$client->setAuthConfigFile('client_secrets.json');

	$client->setRedirectUri('//' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php');

	// Load previously authorized credentials from a file.
	$credentialsPath = CREDENTIALS_PATH;
	if (file_exists($credentialsPath)) {
		$accessToken = file_get_contents($credentialsPath);
	} else {
		// Request authorization from the user.
		// Exchange authorization code for an access token.
		// Store the credentials to disk.
		$accessToken = $client->authenticate('4/2LVocn1mAVoJH-24BWH0nk8_d5_J0d8K79RlZjzLozg'); //JSON token

		// Store the credentials to disk.
		if(!file_exists(dirname($credentialsPath))) {
			mkdir(dirname($credentialsPath), 0700, true);
		}
		file_put_contents($credentialsPath, $accessToken);
	}
	$client->setAccessToken($accessToken);

	// Refresh the token if it's expired.
	if ($client->isAccessTokenExpired()) {
		$client->refreshToken($client->getRefreshToken());
		file_put_contents($credentialsPath, $client->getAccessToken());
	}
	return $client;
}

//used in building file paths
function expandHomeDirectory($path) {
	$homeDirectory = getenv('HOME');
	if (empty($homeDirectory)) {
		$homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
	}
	return str_replace('~', realpath($homeDirectory), $path);
}

?>