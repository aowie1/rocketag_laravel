@if (!empty($tags))
    @foreach ($tags as $tag)
        <div class="suggestion-result-row">
            @include('tags.result')
        </div>
    @endforeach
@endif