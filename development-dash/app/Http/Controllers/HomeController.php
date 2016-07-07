<?php
/*

@Author: Chong Feng
*/


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use GuzzleHttp\Client;
use App\Configs;


class HomeController extends Controller
{
    


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

   



    public function index(){

        $configurator = new Configs;
        $configs = $configurator->readConfigs();

        $clocks = array();
        $blocks = array();


        foreach($configs as $config){
            if($config['provider'] == 'clock'){
                array_push($clocks, $config);
            }else{
                array_push($blocks,$config);
            }
        }
        
      
        $GH_stats = $this->GH_parseResponse();
    	return view('home',[
    		'GH_OpenPullRequest' => $GH_stats['GH_OpenPullRequest'],
    		'clocks' => $clocks,
            'blocks' => $blocks
            ]);

    }
}
