<div class="form-auth register">
    <h1>Register</h1>
    @if (!empty($user_count))
        <h2>Join our community of over {{ $user_count }} users!</h2>
    @endif

    {{ Form::open() }}
        {{ Form::label('username', 'Username') }}
        {{ Form::text('username') }}

        {{ Form::label('email', 'Email') }}
        {{ Form::text('email') }}

        {{ Form::label('password', 'Password') }}
        <em>Must contain at least 1 number, 1 capital letter, and 1 symbol.</em>
        {{ Form::password('password') }}

        {{ Form::password('password_confirmation') }}

        {{-- Captcha --}}

        {{ Form::submit() }}
    {{ Form::close() }}
</div>