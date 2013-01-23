<div class="form">
    {{ Form::open('tag', 'POST', array('class' => 'add-tag-form')) }}

    <div class="msg"></div>

    {{ Form::label('name', 'Name') }}<br />
    {{ Form::text('name', Input::old('name'), array('class' => 'add-tag-name-field')) }}

    @include('spectrum.widget')

    {{ Form::submit('add') }}

    {{ Form::close() }}
</div>
