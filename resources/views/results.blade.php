<!-- Search results pages will use this view -->

@php
/**
 * Build search query strings
**/
   $searchQuery = '';
   $noTeamSearchQuery = '';
   $season ? $searchQuery = $searchQuery . '&season=' . $season : $searchquery = $searchQuery;
   $league ? $searchQuery = $searchQuery .'&league=' . $league : $searchquery = $searchQuery;
   $team ? $searchQuery = $searchQuery . '&team=' . $team : $searchquery = $searchQuery;
   $initialSearchTeam = $team ? $team : false; 

   $season ? $noTeamSearchQuery = $noTeamSearchQuery . '&season=' . $season : $noTeamSearchQuery = $noTeamSearchQuery;
   $league ? $noTeamSearchQuery = $noTeamSearchQuery .'&league=' . $league : $noTeamSearchQuery = $noTeamSearchQuery;

@endphp

<!-- Send page title to layout component -->
<x-layout :title="$title">

<!-- Build results table from data passed by ResultsController -->
<body>
  <a href="/" class="btn btn-primary">Home</a>
  <h2 class="my-3">Search Results</h2>
    <table class="table table-striped">
        <thead>
        <!-- Table headers -->
        <tr>
            <th>Id</th>
            <th>Date</th>
            <th>Visitors</th>
            <th>Home</th>
            <th>Status</th>
            <th>Arena</th>
        </tr>
        </thead>
        <tbody>
        <!-- Table body -->
            @if (!$games)
            <!-- No results returned from API -->
                <tr>
                    <td>No games found</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
            @endif
            @foreach ($games as $game)
            <!-- Loop through results set and build table rows -->
            <tr>
                <!-- Game Id -->
                <td>{{$game['id']}}</td>
                @if($date)
                <!-- Date field with unfilter logic (table is filtered) -->
                    @if($initSearchTeam)
                        <td><a class="link-info" href="/results/?page=1{{$searchQuery}}&team={{$initSearchTeam}}">{{$game['date']}}</a></td>
                    @else
                        <td><a class="link-info" href="/results/?page=1{{$searchQuery}}">{{$game['date']}}</a></td>
                    @endif
                @else
                <!-- Date field with filter logic (table is unfiltered) -->
                    @if(!$team || $team == 'All')
                        <td><a class="link-info" href="/results/?date={{$game['date']}}{{$searchQuery}}">{{$game['date']}}</a></td>
                    @else
                        <td><a class="link-info" href="/results/?date={{$game['date']}}{{$noTeamSearchQuery}}&initialSearchTeam={{$initialSearchTeam}}">{{$game['date']}}</a></td>
                    @endif
                @endif
                <!-- Remaining fields -->
                <td>{{$game['visitors']}} {{$game['visitorScore']}}</td>
                <td>{{$game['home']}} {{$game['homeScore']}}</td>
                <td>{{$game['status']}}</td>
                <td>{{$game['arena'] ? $game['arena'] : 'Arena info unavailable'}}</td>
            </tr>  
            @endforeach
        <tbody>
    </table>
<div class="pagination my-3">
    <!-- Pagination links -->
    @if (count($links) > 3)
        @foreach($links as $link)
            @if($link['url'])
                <a class="{{$link['active'] ? 'active' : ''}}" href="/results{{$link['url']}}{{$searchQuery}}">{{$link['label']}}</a>
            @endif
        @endforeach  
    @endif
</div>
</x-layout>
