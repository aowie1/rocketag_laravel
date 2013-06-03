<div class="tag radius label left result-item" id="id-{{ $tag->id }}" data-rel="{{ $tag->id }}" data-type="tag">
    {{ $tag->name }}

    @if (!empty($tag->pivot->id))
        <a href="/comment/{{ $tag->pivot->id }}">comment</a>
    @endif

    <span class="attached-remove">x</span>

    @if (!Request::ajax())
        {{ Form::hidden('tags[]', $tag->id) }}
    @endif
</div>