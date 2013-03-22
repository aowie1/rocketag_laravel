@if (!empty($tags))
    @foreach ($tags as $tag)
            @include('tags.result')
    @endforeach
@endif