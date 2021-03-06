<?php
/*
The model that stores dev dash configs.
@Author: Chong Feng
*/

namespace App;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use DateTimeZone;
use DateTime;
use Exception;

class Configs
{
    
	private $configurations = array();

	// Read configs from dash config xml file
	function readConfigs(){
		$configFile = file_get_contents('../dashconfig');
		$xmlConfig = simplexml_load_string($configFile);

		foreach($xmlConfig->children() as $block){
			$blockConfig = array();

			// Handle clock blocks
			if(strtolower($block->provider) == 'clock'){
				$blockConfig['provider'] = $block->provider;
				$blockConfig['name'] = $block->name;
				$blockConfig['timezone'] = $this->Clock_getTimeOffset($block->timezone);
				array_push($this->configurations,$blockConfig);
			}


			// Handle easyEmployer blocks
			if(strtolower($block->provider) == 'easyemployer'){
				if(strtolower($block->feature) == 'deploy time'){
					$blockConfig['feature'] = 'Deploy Time';
					$blockConfig['version']=$this->EE_GetDeployTime($block->server);
				}elseif(strtolower($block->feature) == 'status'){
					$blockConfig['feature'] = 'Server Status';
					$blockConfig['status'] = $this->EE_GetServerStatus($block->server);
				}
				
				
				$blockConfig['name']=$block->name;
				$blockConfig['provider'] = 'easyEmployer';
				array_push($this->configurations,$blockConfig);

			}


			// Handle Gitlab blocks
			if(strtolower($block->provider) == 'gitlab'){
				
			}

		}

		return $this->configurations;
	}

	// Get time offset between destination time and UTC time
    function Clock_getTimeOffset($dest){
    	try{
    		$destTimezone = new DateTimeZone($dest);
    	}catch (Exception $e){
    		return "Unkown or bad timezone!";
    	}

    		$UTCTimezone = new DateTimeZone("UTC");
			
			$destTime = new DateTime("now",$destTimezone);
			$UTCTime = new DateTime("now",$UTCTimezone);

			$UTCOffset = $UTCTimezone->getOffset($UTCTime);
			$destOffset = $destTimezone->getOffset($destTime);

			$diff = $destOffset - $UTCOffset;    

			return $diff/3600;
    	
	}


	// Get last deployed time for servers
	function EE_GetDeployTime($serverAddress){
		$address = 'https://'.$serverAddress.'/version.json';
		$client = new Client();

		try{
	    	$request = $client->get($address,['verify' => false]);
	    	$versionJson = json_decode($request->getBody());
	    	$timezone = new DateTimeZone('Australia/Canberra');
	    	$date = new DateTime("now",$timezone);
	    	$date->setTimestamp($versionJson->version);
	    	return $date->format('Y-m-d H:i:s');
    	}catch (RequestException $e){
    		return "Something wrong with this configuration!";
    	}
	}


	// Get server test suite status 
	function EE_GetServerStatus($serverAddress){
		$address = $serverAddress.'/status/index.php';
		$client = new Client();

		try{
			$request = $client->get($address,['verify' => false]);
			$words = preg_split('/\s+/', trim($request->getBody()));
			return end($words);
		}catch (RequestException $e){
			return "Something wrong with this configuration!";
 		}
	}


    /*
	Show number of open pull requests.
	Maybe show some daily / weekly / monthly commit stats (good for team visibility that devs actually do stuff).
    */    
	function GH_getPullsNumber($pageNumber = 1){
		$client = new Client();
    	$requset = $client->get('https://api.github.com/repos/twbs/bootstrap/pulls?page='.$pageNumber.'&per_page=100',[
    		'auth' =>[
    		'fengchong1991@gmail.com',
    		'fc19911013'
    		]]);

    	$pagePullsCount = count(json_decode($requset->getBody()));
    	return $pagePullsCount;
	}


    function GH_parseResponse(){
    	
    	// The asssociative array that stores all the stats returned by Github.
    	$stats = array();

    	$totalCount = 0;
   		// $pageNumber = 2;
    	// $pagePullsCount = $this->GH_getPullsNumber();
    	// while($pagePullsCount != 0){
    	// 	$totalCount += $pagePullsCount;
    	// 	$pagePullsCount = $this->GH_getPullsNumber($pageNumber);
    	// 	$pageNumber ++;
    	// }

    	$stats['GH_OpenPullRequest'] = $totalCount;

       	return $stats;
    }



   

}
