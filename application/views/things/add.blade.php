@layout('layouts.master')

@section('content')
    {{ Form::open('thing', 'POST', array('class' => 'add-thing-form')) }}
    <div class="form">
        <h1>Add a thing</h1>

        {{ Form::label('thing', 'Thing') }}
        {{ Form::open('thing', 'POST') }}
        <div class="msg"></div>

        {{ Form::text('name', Input::old('name'), array('autocomplete' => 'off')) }}
        <br />
        @include('tags.attacher')

        {{ Form::submit('add', array('class' => 'button')) }}
    </div>
    {{ Form::close() }}

    @include('tags.addModal')
@endsection