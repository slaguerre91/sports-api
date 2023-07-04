<!-- Error page if user does not specify a season in search query -->

<x-layout :title="$title">
    <div class="alert alert-warning" role="alert">
        Please make sure your query includes a valid season!
    </div>
    <a href="/" class="btn btn-primary">Homepage</a>
</x-layout>