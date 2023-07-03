<x-layout>
<h2>The select Element</h2>

<form action="/results">
    @csrf
  <label for="season">Choose a season:</label>
  <select id="season" name="season">
    @foreach($seasons as $season)
        <option value="{{$season}}">{{$season}}</option>
    @endforeach
  </select>
  <label for="league">Choose a league:</label>
  <select id="league" name="league">
    <option value="All">All</option>
    @foreach($leagues as $league)
        <option value="{{$league}}">{{$league}}</option>
    @endforeach
  </select>
  <label for="team">Choose a team:</label>
  <select id="team" name="team">
    <option value="All">All</option>
    @foreach ($teams as $team)
        @if($team['name'])
            <option value="{{$team['id']}}">{{$team['name']}}</option> 
        @endif
    @endforeach
  <input type="submit">
</form>
</x-layout>

