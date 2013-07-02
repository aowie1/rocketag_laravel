<div>
    <div id="link-name-field-container">
        <div class="row">
            {{ Form::label('link-name', 'Add a link:', array('id' => 'link-name', 'class' => 'form-label left')) }}
            <a href="#" class="helper right" data-rel="link-attacher-helper">What's this?</a>

            <ol id="link-attacher-helper" class="hidden">
                <li data-id"link-name-field-container" data-options="tipLocation:top;tipAnimation:fade">
                    You can create brand new links here. Try it now!
                </li>
            </ol>
        </div>

        <div class="row">
            <div class="large-8 columns">
                {{ Form::text('link', null, array('id' => 'link', 'data-rel' => 'link', 'autocomplete' => 'off', 'class' => 'js-link-field')) }}
            </div>

            <div class="large-4 columns">
                <div class="button js-attach-button">Attach</div>
            </div>
        </div>
    </div>
    <div class="button two columns switch-back">Okay, I'm Done.</div>
</div>

@section('js')
    @parent
    <script>
    jQuery(document).ready(function ($) {
        $('.js-attach-button').on('click', function(e){
            e.preventDefault();

            //TODO: Run server side validation on submitted link

            // Post and save the link
            $.ajax({
                type: 'POST',
                url: '/thing/{{ $thing->name }}/link',
                data: 'link='+$('.js-link-field').val(),
                success: function(ret) {
                    if (ret.error != '')
                    {
                        $.fn.move_to_attached($(ret));
                    }
                }
            });

            // Temporarily attach it to the thing
            //

            return false;
        });
    });
    </script>
@endsection