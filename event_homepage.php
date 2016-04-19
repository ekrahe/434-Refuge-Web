<?php

//bring in all the dependencies for google api
include ('includes.php');
define('APPLICATION_NAME', 'Google Calendar API PHP Quickstart');
define('CREDENTIALS_PATH', dirname(__FILE__).'/calendar-php-quickstart.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/calendar-php-quickstart.json
define('SCOPES', implode(' ', array(
	Google_Service_Calendar::CALENDAR)
						));


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


////////////////////////

$client = getClient();


$service= new Google_Service_Calendar($client);

//////////Moses's added code
//This only occurs when save button is clicked

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
	
	  
   
	//printf('Event created: %s\n', $event->htmlLink);

}





//////////////////////////AKIVA"S CODE

echo '<div class="events">';
$optParams = array(
  'orderBy' => 'startTime',
  'singleEvents' => TRUE,
);


$events = $service->events->listEvents('f2prj9o0uq3cju3sh9hs67mhik@group.calendar.google.com', $optParams); //long string is calandarID
$i=0;
foreach ($events->getItems() as $event) {
	echo '<div class="event">';
			echo '<h4><u>';
			echo $event->summary;
			echo '</u></h4>';
				
			echo '<div class="event_content">';
			echo '<b>Where:</b>'.$event->location;
			echo "<br>";

			echo '<b>When:</b>'.substr($event->getStart()->dateTime, -8).'-'.substr($event->getEnd()->dateTime, -8).PHP_EOL;

			//echo 'time'.PHP_EOL;
			//$fulltime=$event->getStart();
			

  			//echo substr($fulltime->dateTime, -8);
			echo '</div>';
	echo '</div>';


	//echo $event->description;
	

	$i++;
	//if($i==2){
	//	break;
	//}
	
        
}


echo '</div>';



echo '<a href="event_creationpage.html"><button class="create_event">Create Event</button></a>';
echo '</div>';


function getClient() {
	//client ID: 438774563994-g1dcqfjr0ok77qmhjb7375b3dfg4ngdo.apps.googleusercontent.com
	//client secret: P93nCmxfsy-okUJ_Kz7q-LG5


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
		//$authUrl = $client->createAuthUrl();
		//printf("Open the following link in your browser:\n%s\n", $authUrl);
		//print 'Enter verification code: ';
		//$authCode = trim(fgets(STDIN));

		// Exchange authorization code for an access token.
		//$accessToken = $client->authenticate('4/2LVocn1mAVoJH-24BWH0nk8_d5_J0d8K79RlZjzLozg');
		//$accessToken='4/2LVocn1mAVoJH-24BWH0nk8_d5_J0d8K79RlZjzLozg';
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
function expandHomeDirectory($path) {
	$homeDirectory = getenv('HOME');
	if (empty($homeDirectory)) {
		$homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
	}
	return str_replace('~', realpath($homeDirectory), $path);
}

?>