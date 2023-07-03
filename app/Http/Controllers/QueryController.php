<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class QueryController extends Controller
{
    //Loads search query criteria to the welcome view
    public function loadQueryOptions(){
        // Sport API 
        $host = config('services.sports');
        // Grab data from endpoints to populate dropdown menus
        $seasons = self::loadSeasons($host);
        $leagues = self::loadLeagues($host);
        $teams = self::loadTeams($host);

        return view('welcome', [
            'teams' => $teams,
            'leagues' => $leagues,
            'seasons' => $seasons
        ]);
        // var_dump($teams);
    }

    /**
    * Fetch seasons
    */
    protected static function loadSeasons($host){
        $response = self::fetchData($host, 'seasons')['response'];
        return $response;
    }
    /**
    * Fetch leagues
    */
    protected static function loadleagues($host){
        $response = self::fetchData($host, 'leagues')['response'];
        return $response;
    }

    /**
     * Fetch teams
     */
    protected static function loadTeams($host){
        $response = self::fetchData($host, 'teams');
        return self::cleanupTeamsJson($response);
    }

    /**
     * Clean up teams Json data
     */
    protected static function cleanupTeamsJson($json){
        $teams = json_decode($json, true)['response'];
        $sanitizedData = [];
        foreach($teams as $team){
            array_push($sanitizedData, [
            'id' => $team['id'],
            'name' => $team['name']
            ]);
        }
        return $sanitizedData;
    }

    /**
     * Fetch data from sports API
     */
    protected static function fetchData($host, $endPoint){
        try{
        $response = Http::withHeaders($host)->get('https://' . $host['x-rapidapi-host'] . '/' . $endPoint);
        
        // Invalid credentials handler
        if(!isset(json_decode($response, true)['response'])) exit('Invalid credentials');

        return $response;
        } catch(\Exception $e) {
            // Connection fail handler
            exit('Connection failed. try again later.');
        }
    }
}
