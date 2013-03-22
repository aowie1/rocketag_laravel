<div class="form">
    {{ Form::open('tag', 'POST', array('class' => 'add-tag-form')) }}

    <div class="msg"></div>

    {{ Form::label('tag_name', 'Name') }}
    {{ Form::text('tag_name', Input::old('tag_name'), array('class' => 'add-tag-name-field')) }}

    @include('spectrum.widget')
    <br />
    {{ Form::submit('Create', array('class' => 'button')) }}

    {{ Form::close() }}
</div>
