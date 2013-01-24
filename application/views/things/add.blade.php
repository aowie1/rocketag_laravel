@layout('layouts.master')

@section('content')
    {{ Form::open('thing', 'POST', array('class' => 'add-thing-form')) }}
    <div class="form">
        <h1>Add a thing</h1>

        {{ Form::label('thing', 'Thing') }}
        {{ Form::open('thing', 'POST') }}
        <div class="msg"></div>

        {{ Form::text('name', Input::old('name')) }}
        <br />
        @include('tags.attacher')

        {{ Form::submit('add') }}
    </div>
    {{ Form::close() }}

    @include('tags.addModal')
@endsection