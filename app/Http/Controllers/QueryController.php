<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Exceptions\HttpResponseException;

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

        // Load welcome view
        return view('welcome', [
            'teams' => $teams,
            'leagues' => $leagues,
            'seasons' => $seasons,
            'title' => 'Search NBA Game Data'
        ]);
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
        if(!isset(json_decode($response, true)['response'])) throw new HttpResponseException(redirect('/error')->with('error', 'API connection error. Please verify your credentials are correct or try again later.'));

        return $response;
        } catch(\Exception $e) {
            // Connection fail handler
            throw new HttpResponseException(redirect('/error')->with('error', 'API connection error. Please verify your credentials are correct or try again later.'));
        }
    }
}
