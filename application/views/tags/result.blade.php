<div id="id-{{ $tag->id }}" rel="{{ $tag->id }}">
    {{ $tag->name }}
    <a href="/tag/{{ $tag->id }}/comment">comment</a>
</div>
{{ Form::hidden('tags['. $tag->id .']', $tag->name) }}
