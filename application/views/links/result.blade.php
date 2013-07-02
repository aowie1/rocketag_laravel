<div class="link radius label left result-item" id="id-{{ $link->id }}" data-rel="{{ $link->id }}" data-type="link">
    {{ $link->link }}

    @if (!empty($link->pivot->id))
        <a href="/comment/{{ $link->pivot->id }}">comment</a>
    @endif

    <span class="attached-remove">x</span>

    @if (!Request::ajax())
        {{ Form::hidden('links[]', $link->id) }}
    @endif
</div>