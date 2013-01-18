@layout('layouts.master')

@section('content')
<div class="form">
    <h1>Add a tag</h1>

    {{ Form::open('tag', 'POST') }}
    <div class="msg"></div>
    {{ Form::text('name', Input::old('name', '')) }}
    {{ Form::submit('add') }}
</div>
@endsection