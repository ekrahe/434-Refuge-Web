<?php
//include statements for Google API


require_once (dirname(__FILE__).'/google-api-php-client/src/Google/Auth/OAuth2.php');
//require_once ('/var/www/html/google-api-php-client/src/Google/Auth/OAuth2.php');


require_once (dirname(__FILE__).'/google-api-php-client/src/Google/Client.php');
require_once (dirname(__FILE__).'/google-api-php-client/src/Google/Config.php');
require_once (dirname(__FILE__).'/google-api-php-client/src/Google/Utils.php');


require_once (dirname(__FILE__).'/google-api-php-client/src/Google/Utils/URITemplate.php');
require_once (dirname(__FILE__).'/google-api-php-client/src/Google/Logger/Abstract.php');
require_once (dirname(__FILE__).'/google-api-php-client/src/Google/Logger/Null.php');


require_once (dirname(__FILE__).'/google-api-php-client/src/Google/Service.php');
require_once (dirname(__FILE__).'/google-api-php-client/src/Google/Service/Resource.php');
require_once (dirname(__FILE__).'/google-api-php-client/src/Google/Model.php');
require_once (dirname(__FILE__).'/google-api-php-client/src/Google/Collection.php');
require_once (dirname(__FILE__).'/google-api-php-client/src/Google/Service/Calendar.php');
require_once (dirname(__FILE__).'/google-api-php-client/src/Google/Http/REST.php');
require_once (dirname(__FILE__).'/google-api-php-client/src/Google/Http/Request.php');

?>