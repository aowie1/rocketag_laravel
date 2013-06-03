<div class="form">
    {{ Form::open('tag', 'POST', array('data-type' =>'tag')) }}

    <div class="msg"></div>

    {{ Form::label('tag_name', 'Name') }}
    {{ Form::text('tag_name', Input::old('tag_name'), array('class' => 'js-field-add')) }}

    @include('spectrum.widget')
    <br />
    {{ Form::submit('Create', array('class' => 'button')) }}

    {{ Form::close() }}
</div>
