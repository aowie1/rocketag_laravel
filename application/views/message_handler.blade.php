@if (Session::has('success'))
    <div data-alert class="alert-box success">{{ Session::get('success') }}</div>
@endif

@if (!empty($errors->messages))
    @foreach ($errors->messages as $field_messages)
        @foreach ($field_messages as $msg)
            <div data-alert class="alert-box alert">{{ $msg }}</div>
        @endforeach
    @endforeach
@endif