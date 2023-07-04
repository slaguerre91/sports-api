<!-- Homepage -->

<x-layout :title="$title">
<h2 class="text-center"><i class="fa-solid fa-basketball"></i> Search Games Data</h2>
<div class="row d-flex justify-content-center">

<form action="/results" class="col col-lg-6">
  <!-- Form that gathers user inputs and submits to the /results route -->
  @csrf
  <div>
    <!-- Season dropdown menu populated with API call made in QueryController  -->
    <label for="season">Choose a season:</label>
    <select class="form-select" id="season" name="season">
    @foreach($seasons as $season)
        <option value="{{$season}}">{{$season}}</option>
    @endforeach
    </select>
  </div>

  <div>
    <!-- League dropdown menu populated with API call made in QueryController  -->
    <label for="league">Choose a league:</label>
    <select id="league" class="form-select" name="league">
    <option value="All">All</option>
    @foreach($leagues as $league)
        <option value="{{$league}}">{{$league}}</option>
    @endforeach
    </select>
  </div>

  <div>
    <!-- Team dropdown menu populated with API call made in QueryController  -->
    <label for="team">Choose a team:</label>
    <select id="team" class="form-select" name="team">
    <option value="All">All</option>
    @foreach ($teams as $team)
        @if($team['name'])
            <option value="{{$team['id']}}">{{$team['name']}}</option> 
        @endif
    @endforeach
    </select>
  </div>

  <input type="submit" class="btn btn-primary my-3">
</form>
</x-layout>

