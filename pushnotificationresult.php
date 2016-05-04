<?php
echo '<!DOCTYPE html>';
echo '<head>';
echo '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>';
echo '<script type="text/javascript" src="event_homepage.js"></script>';
echo '<link href="pushnotificationresult.css" rel="stylesheet">';
echo '</head>';
echo '<h1 class="header">REFUGE</h1	>';
echo '<div class="center">';
echo '<h2 class="thanks"> Thank You! Your message has been sent!</h2>';
echo '<h3 class="message"> MESSAGE TEXT HERE </h3>';
echo '</div>';

//ONLY UNCOMMENT WHEN READY TO SEND
//mail(file_get_contents(dirname(dirname(__FILE__)).'/phone.txt'),"AID!!",$msg, $headers);


?>