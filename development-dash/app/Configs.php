<?php
/*
The model that stores dev dash configs.
@Author: Chong Feng
*/

namespace App;

use GuzzleHttp\Client;
use DateTimeZone;
use DateTime;

class Configs
{
    
	private $configurations = array();

	// Read configs from dash config xml file
	function readConfigs(){
		$configFile = file_get_contents('../dashconfig');
		$xmlConfig = simplexml_load_string($configFile);

		foreach($xmlConfig->children() as $block){
			$blockConfig = array();

			if(strtolower($block->provider) == 'clock'){
				$blockConfig['provider'] = $block->provider;
				$blockConfig['name'] = $block->name;
				$blockConfig['timezone'] = $this->Clock_getTimeOffset($block->timezone);

				array_push($this->configurations,$blockConfig);
			}

			if(strtolower($block->provider) == 'easyemployer'){
				if(strtolower($block->feature) == 'deploy time'){
					$blockConfig['name'] = 'Deploy Time';
					$blockConfig['version']=$this->EE_GetDeployTime($block->server);
					
				}elseif(strtolower($block->feature) == 'status'){
					$blockConfig['name'] = 'Server Status';

					$blockConfig['status'] = $this->EE_GetServerStatus($block->server);


				}
				
				$serverName = explode('.',$block->server)[0].'.'.explode('.',$block->server)[1];
				
				$blockConfig['server']=$serverName;
				$blockConfig['provider'] = 'easyEmployer';
				array_push($this->configurations,$blockConfig);

			}
		}

		return $this->configurations;
	}

	// Get time offset between destination time and UTC time
    function Clock_getTimeOffset($dest){
		$destTimezone = new DateTimeZone($dest);
		$UTCTimezone = new DateTimeZone("UTC");

		$destTime = new DateTime("now",$destTimezone);
		$UTCTime = new DateTime("now",$UTCTimezone);

		$UTCOffset = $UTCTimezone->getOffset($UTCTime);
		$destOffset = $destTimezone->getOffset($destTime);

		$diff = $destOffset - $UTCOffset;    

		return $diff/3600;
	}


	function EE_GetDeployTime($serverAddress){
		
		$address = 'https://'.$serverAddress.'/version.json';
		$client = new Client();
    	$request = $client->get($address,['verify' => false]);

    	$versionJson = json_decode($request->getBody());

    	$timezone = new DateTimeZone('Australia/Canberra');
    	$date = new DateTime("now",$timezone);
    	$date->setTimestamp($versionJson->version);

    	return $date->format('Y-m-d H:i:s');
	}



	function EE_GetServerStatus($serverAddress){
		$address = $serverAddress.'/status/index.php';
		$client = new Client();
		$request = $client->get($address,['verify' => false]);

		$words = preg_split('/\s+/', trim($request->getBody()));

		return end($words);
	}

	function getJiraStats(){
    	// TODO
    }

    function getGitlabStats(){
    	// TODO
    }


}
