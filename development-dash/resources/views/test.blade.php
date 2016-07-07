<?php

use GuzzleHttp\Client;



	function a(){

$address = 'app1.aws2.easyemployer.com/status/index.php';
		$client = new Client();
		$request = $client->get($address,['verify' => false]);

		$words = preg_split('/\s+/', trim($request->getBody()));

		echo end($words);


	}
    	
    
    	a();