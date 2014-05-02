@if (!empty($tags))
    <div id="top-tags" class="rt">
        <h2>Top Tags</h2>
        <ul>
            @foreach ($tags as $tag)
                <li><a href="{{ $tag->internal_link }}">{{ $tag->name }}</a></li>
            @endforeach
        </ul>
    </div>
@endif