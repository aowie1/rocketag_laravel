<div class="tag radius label left result-item" id="id-{{ $tag->id }}" rel="{{ $tag->id }}">
    {{ $tag->name }}

    @if (!empty($tag->pivot->id))
        <a href="/comment/{{ $tag->pivot->id }}">comment</a>
    @endif

    <span class="attached-remove">x</span>

    {{ Form::hidden('tags[]', $tag->id) }}
</div>