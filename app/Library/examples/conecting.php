<?php
define('DEBUG', true);
define('PS_SHOP_PATH', 'http://pe.tiens.com/');
define('PS_WS_AUTH_KEY', 'PAWYM4VX4KS8LB57AEA8MMBF3PQ8HZ28');
define('COOKIE_KEY', 'UKfsBZ0zdgGXHBqP0irdENV08NEck3hNyXusr58Hf7kjTbZFLMJXecB9');
require_once('../PSWebServiceLibrary.php');

//http://PAWYM4VX4KS8LB57AEA8MMBF3PQ8HZ28@pe.tiens.com/api

$resources=null;

$mail = "jefesistemas@tiensco.com";
$pwd = "colombia2016";

//employees
//customers

try
{
	$webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, DEBUG);	
	
	$opt = array(
	     'resource'=>'employees',
	     'filter[email]'=>'['.$mail.']',
	     'filter[passwd]'  =>'['.md5(COOKIE_KEY.$pwd).']',
	     'display' =>'[firstname,lastname]'
	);

	$xml = $webService->get($opt);

	$resources = $xml->children()->children();
}
catch (PrestaShopWebserviceException $e)
{
	$resources=null;
	// Here we are dealing with errors
	$trace = $e->getTrace();
	if ($trace[0]['args'][0] == 404) echo 'Bad ID';
	else if ($trace[0]['args'][0] == 401) echo 'Bad auth key';
	else echo 'Other error<br />'.$e->getMessage();
}

print_r($resources);

?>