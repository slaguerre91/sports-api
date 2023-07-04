<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResultsController extends Controller
{
    /**
    * Get results from sports api
    */ 
    public function showResults(Request $request){
        // Load error page when season not provided by user
        if(self::validateInput($request)) return self::validateInput($request);

        // Build the search query array from the provided request
        $searchQuery = self::buildSearchQuery($request);

        // Fetch data from sports API
        $host = config('services.sports');
        $data = self::fetchData($searchQuery, $host);
        
        // Paginate
        $data = self::paginateData($request, $data);

        // Prep game data before loading to view
        $games = self::prepDataForView($data['games']);
        return view('results', [
            'games' => $games,
            'links' => $data['links'],
            'team' => $request->input('team'),
            'season' => $request->input('season'),
            'league' => $request->input('league'),
            'date' => $request->input('date'),
            'initSearchTeam' => $request->input('initialSearchTeam'),
            'title' => 'Search Results'
        ]);
    }

    
    /**
     * Loads error page if user doesn't provide a season in query
     */
    protected static function validateInput($request){
        if(!$request->input('season')) return view('error', ['title' => 'Error']);
        return;
    }

    /**
     * Build the search query array from the provided request
     */
    protected static function buildSearchQuery($request){
        $searchQuery = [];
        $searchQuery['season'] = $request->input('season');
        if($request->input('league')!='All') $searchQuery['league'] = $request->input('league');
        if($request->input('team')!='All') $searchQuery['team'] = $request->input('team');
        if($request->input('date')) $searchQuery['date'] = $request->input('date');
        return $searchQuery;
    }

    /**
     * Fetch data from sports API
     */
    protected static function fetchData($searchQuery, $host){
        try{
            $response = Http::withHeaders($host)->get('https://' . $host['x-rapidapi-host'] .'/games', $searchQuery);

            // Invalid credentials handler
            if(!isset(json_decode($response, true)['response'])) throw new HttpResponseException(redirect('/error')->with('error', 'API connection error. Please verify your credentials are correct or try again later.'));
;

            $responseArray = json_decode($response, true)['response'];
            return $responseArray;
        } catch(\Exception $e) {
            // Connection fail handler
           throw new HttpResponseException(redirect('/error')->with('error', 'API connection error. Please verify your credentials are correct or try again later.'));
        }
    }

    /**
     * Paginate data
     */
    protected static function paginateData($request, $data){
        $page = $request->input('page') ? $request->input('page') : 1;
        $paginatedRes = new LengthAwarePaginator(array_slice($data, ($page - 1) * 20, 20), count($data), 20, $page);
        $games = $paginatedRes -> toArray()['data'];
        $paginationLinks = $paginatedRes -> toArray()['links'];
        $paginationLinks[0]['label'] = 'previous';
        $paginationLinks[count($paginationLinks) - 1]['label'] = 'next';
        return [
            'games' => $games,
            'links' => $paginationLinks
        ];
    }

    /**
     * Prep game data before loading to view
     */
    protected static function prepDataForView($games){
        $preppedData = []; 
        foreach($games as $game){
            array_push($preppedData, [
                'id' => $game['id'],
                'date' => implode('', array_slice(str_split($game['date']['start'], 1), 0, 10)),
                'visitors' => $game['teams']['visitors']['name'] ? $game['teams']['visitors']['name'] : 'No team name',
                'visitorsLogo' => $game['teams']['visitors']['logo'],
                'home' => $game['teams']['home']['name'] ? $game['teams']['home']['name'] : 'No team name',
                'homeLogo' => $game['teams']['home']['logo'],
                'status' => $game['status']['long'],
                'visitorScore' => $game['scores']['visitors']['points'],
                'homeScore' => $game['scores']['home']['points'],
                'arena' => $game['arena']['name']
            ]);
        }
        return $preppedData;
    }
}
