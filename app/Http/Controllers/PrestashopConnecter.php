<?php 

namespace tiens\Http\Controllers;

define('PS_SHOP_PATH', 'http://pe.tiens.com/');
define('PS_WS_AUTH_KEY', 'PAWYM4VX4KS8LB57AEA8MMBF3PQ8HZ28');
define('COOKIE_KEY', 'UKfsBZ0zdgGXHBqP0irdENV08NEck3hNyXusr58Hf7kjTbZFLMJXecB9');

class PrestashopConnecter {	

    public function is_ok() {
        return 'myFunction is OK';
    }

    public function auth_ps($mail,$pwd,$type)
    {

    	$DEBUG = false;
    	try
			{
				switch ($type) {
					case 1:
						$resource = 'customers';
						$resource_name = 'customer';
						break;
					case 2:
						$resource = 'employees';
						$resource_name = 'employee';
						break;
					default:
						return false;
						break;
				}			

				$webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, $DEBUG);	
				
				$opt = array(
				     'resource'=>$resource,
				     'filter[email]'=>'['.$mail.']',
				     'filter[passwd]'  =>'['.md5(COOKIE_KEY.$pwd).']',
				     'display' =>'[firstname,lastname]'
				);

				if($type==3)
					echo dd($opt);

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

				$data['exist?']=false;
				$data['error']=true;
				return $data;
			}

			if(count($resources->$resource_name)==1)
			{
				$data['exist?']=true;
				$data['firstname']=$resources->customer->firstname;
				$data['lastname']=$resources->customer->lastname;
			}else{
				$data['exist?']=false;
			}

			return $data;
    }
}

?>