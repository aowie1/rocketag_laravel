@foreach ($tags_results as $tag)
    <a href="{{ $tag->build_link() }}">{{ $tag->name }}</a>
@endforeach