<!-- Error page if user does not specify a season in search query -->

@php 
    $title = 'Error';
@endphp
<x-layout :title="$title">
    <div class="alert alert-warning" role="alert">
         {{session('error')}}
    </div>
    <a href="/" class="btn btn-primary">Homepage</a>
</x-layout>