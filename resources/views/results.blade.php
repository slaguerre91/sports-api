@php
/**
 * Build search query for pagination links
**/
   $searchQuery = '';
   $season ? $searchQuery = $searchQuery . '&season=' . $season : $searchquery = $searchQuery;
   $league ? $searchQuery = $searchQuery .'&league=' . $league : $searchquery = $searchQuery;
   $team ? $searchQuery = $searchQuery . '&team=' . $team : $searchquery = $searchQuery;
@endphp

<x-layout>
<body>
  <h2>Responsive Table</h2>
<div class="table-wrapper">
    <table class="fl-table">
        <thead>
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
            @if (!$games)
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
            <tr>
                <td>{{$game['id']}}</td>
                @if(!$team || $team == 'All')
                    <td><a href="/results/?date={{$game['date']}}{{$searchQuery}}">{{$game['date']}}</a></td>
                @else
                    <td>{{$game['date']}}</td>
                @endif
                <td>{{$game['visitors']}} {{$game['visitorScore']}}</td>
                <td>{{$game['home']}} {{$game['homeScore']}}</td>
                <td>{{$game['status']}}</td>
                <td>{{$game['arena']}}</td>
            </tr>  
            @endforeach
        <tbody>
    </table>
</div>  
<div>
    @if (count($links) > 3)
        @foreach($links as $link)
            @if($link['url'])
                <a href="/results{{$link['url']}}{{$searchQuery}}" style="color:{{$link['active'] ? "purple" : "blue"}}">{{$link['label']}}</a>
            @endif
        @endforeach  
    @endif
</div>
</x-layout>
