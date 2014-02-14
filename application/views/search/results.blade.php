@if (!empty($tags_results))
    <h2>Tags</h2>
    @include('tags.search_results')
@endif

@if (!empty($things_results))
    <h2>Things</h2>
    @include('things.search_results')
@endif