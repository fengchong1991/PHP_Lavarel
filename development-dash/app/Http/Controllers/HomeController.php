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
    

    public function index(){

        $configurator = new Configs;
        $configs = $configurator->readConfigs();

        // Two arrays for clock blocks and dash blocks
        $clocks = array();
        $blocks = array();

        // Push blocks to either block arrays 
        foreach($configs as $config){
            if($config['provider'] == 'clock'){
                array_push($clocks, $config);
            }else{
                array_push($blocks,$config);
            }
        }

    	return view('home',[
    		'clocks' => $clocks,
            'blocks' => $blocks
            ]);

    }
}
