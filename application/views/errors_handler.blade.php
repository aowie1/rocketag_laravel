@if (!empty($errors->messages))
    @foreach ($errors->messages as $field_messages)
        @foreach ($field_messages as $msg)
            <div data-alert class="alert-box alert">{{ $msg }}</div>
        @endforeach
    @endforeach
@endif