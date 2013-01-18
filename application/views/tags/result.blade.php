<div id="id-{{ $tag_id }}" rel="{{ $tag_id }}">{{ $tag_name }}</div>
{{ Form::hidden('tags['. $tag_id .']', $tag_name) }}