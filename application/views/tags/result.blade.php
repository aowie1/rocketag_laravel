<span class="label" id="id-{{ $tag->id }}" rel="{{ $tag->id }}">
    {{ $tag->name }}
    @if (!empty($tag->pivot->id))
        <a href="/comment/{{ $tag->pivot->id }}">comment</a>
    @endif
</span>
{{ Form::hidden('tags['. $tag->id .']', $tag->name) }}
