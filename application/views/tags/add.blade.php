This tag is not yet in our system, but feel free to add it!
<?php
echo @$login_block;
?>
{{ Form::open('/tag/add', 'POST', array('class' => 'awesome')) }}
{{ Form::text('name', @$tag) }}
{{ Form::submit('add') }}