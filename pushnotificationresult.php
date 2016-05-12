<?php
echo '<!DOCTYPE html>';
echo '<html>';
echo '<head>';
echo '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>';
echo '<script type="text/javascript" src="event_homepage.js"></script>';
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">';
echo '<link href="pushnotificationresult.css" rel="stylesheet">';
echo '</head>';
echo '<body>';
echo '<h1 class="header">REFUGE</h1	>';
echo '<div class="center">';
echo '<h2 class="thanks"> Thank You! Your message has been sent!</h2>';

	

	$msg;


	if(isset($_POST['submit'])) {
	
	$title = htmlspecialchars($_POST['title']);
	$radius = htmlspecialchars($_POST['radius']);
	$type = htmlspecialchars($_POST['type']);	
	$location = htmlspecialchars($_POST['location']);
	$description = htmlspecialchars($_POST['description']);
	$documents =$_POST['documents'];	
	

	$descript = 'TITLE:'.$title.', LOCATION:'.$location.', TYPE '.$type.',MESSAGE:'.$description."\r\n";


	if(!empty($documents)) {
		$descript.='DOCUMENTS:';
		$doc ="";	    
		foreach ($documents as $docs) {
			$doc.=$docs.',' ;
		}

		$descript .=$doc."\r\n";
	}
	

		
		//The message to be sent out.
		$msg = $descript;
			
}
//build confirmation message to print
echo '<h3 class="message"><b>Title: </b>'.$title .'</h3>';
echo '<h3 class="message"><b>Location: </b>'.$location .'</h3>';
echo '<h3 class="message"><b>Type: </b>'.$type .'</h3>';
	//build documents list
	if(!empty($documents)) {
		foreach ($documents as $docs) {
			$doc.=$docs.',' ;
		}
		echo '<h3 class="message"><b>Documents: </b>'.$doc .'</h3>';
	}
echo '<h3 class="message"><b>Message: </b>'.$description .'</h3>';


//return to home page button
echo '<a href="event_homepage.php" type="button" class=" message btn btn-success text-center col-md-offset-5" id="back">HOME PAGE</a>';
echo '</div>';
echo '</body>';
echo '</html>';



/*ONLY UNCOMMENT WHEN READY TO SEND. This method sends a text message to the user in question by loading the text from a file with their phone number
	The phone number is formatted specifically to the service provider such that when we send them an email, the user receives it as a text message. 
	For privacy reasons, the text file with the phone number is not in the GitRepo and is in a parent directory
*/
mail(file_get_contents(dirname(dirname(__FILE__)).'/phone.txt'),"AID!!",$msg, $headers);


?>