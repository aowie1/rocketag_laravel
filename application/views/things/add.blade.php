@layout('layouts.master')

@section('content')
    {{ Form::open('thing', 'POST', array('class' => 'add-thing-form')) }}
    <div class="form">
        <h1>Add a thing</h1>

        @include('success_handler')

        {{ Form::label('thing_name', 'Thing') }}
        <div class="msg"></div>

        {{ Form::text('thing_name', Input::old('thing_name'), array('autocomplete' => 'off')) }}

        @include('errors_handler')

        {{ Form::submit('add', array('class' => 'button')) }}
    </div>
    {{ Form::close() }}

    @include('tags.addModal')
@endsection