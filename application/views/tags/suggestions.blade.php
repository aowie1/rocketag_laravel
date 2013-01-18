@if (!empty($tags))
    @foreach ($tags as $tag_id => $tag_name)
        <div class="suggestion-result-row">
            @include('tags.result')
        </div>
    @endforeach
@endif