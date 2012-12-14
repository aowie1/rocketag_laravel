This thing is not yet in our system, but feel free to add it!
<?php
echo @$login_block;
?>
{{ Form::open('thing', 'POST') }}
{{ Form::text('name', @$thing) }}
{{ Form::submit('add') }}