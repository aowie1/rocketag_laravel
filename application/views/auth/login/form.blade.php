<div class="form-auth login">
    {{ Form::open() }}
        {{ Form::token() }}

        @if (!empty($errors->messages))
            @if (is_array($errors->messages))
                @foreach ($errors->messages as $error)
                    <p class="error">{{ $error }}</p>
                @endforeach
            @else
                <p class="error">{{ $errors->messages }}</p>
            @endif
        @endif
        
        {{ Form::label('username', 'Username or Email') }}
        {{ Form::text('username', Input::old('username')) }} <div class="icon-validate-username invalid"></div>
        <div class="msg-errors-username hidden"></div>

        {{ Form::label('password', 'Password') }}
        {{ Form::password('password') }}

        {{ Form::submit('Login', array('class' => 'btn-submit')) }}
    {{ Form::close() }}
</div>

@section('js')
    <script>
    jQuery(document).ready(function ($) {

        function notify_validation_username(valid)
        {

        }

        $('.form-auth #username').on('keyup', function(e){
            el = $(this);

            if (el.val().length > {{ Config::get('auth.min_username_length') }})
            {
                $.post('/auth/validate/username', {username: el.val()}, function(data) {

                    icon_validate = $('.icon-validate-username');

                    // Errors exist, notify the user
                    if (data.validation.errors.length > 0)
                    {
                        if (icon_validate.hasClass('valid'))
                        {
                            icon_validate.toggleClass('invalid').toggleClass('valid');
                        }

                        $.each(data.validation.errors, function(i, val){
                            $('msg-errors-username').append('<div class="error">'+val+'</div>');
                        });

                        btn_submit.disabled = 'disabled';
                    }
                    else // Everything is kosher, let the user continue
                    {
                        if (icon_validate.hasClass('invalid'))
                        {
                            icon_validate.toggleClass('invalid').toggleClass('valid');
                        } 

                        btn_submit.disabled = FALSE;
                    }
                });
            }
        }); 
    });
    </script>
@endsection