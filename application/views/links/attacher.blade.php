<div>
    <div class="ten columns">
        <div id="link-name-field-container">
            {{ Form::label('link-name', 'Add a link:', array('id' => 'link-name', 'class' => 'form-label left')) }} <a href="#" class="helper right" rel="link-attacher-helper">What's this?</a>
            <ol id="link-attacher-helper" class="hidden"><li data-id"link-name-field-container" data-options="tipLocation:top;tipAnimation:fade">You can create brand new links here. Try it now!</li></ol>
        </div>

        {{ Form::text('link', null, array('id' => 'link', 'rel' => 'link', 'autocomplete' => 'off', 'class' => 'js-link-field')) }}
    </div>

    <div class="button two columns switch-back">Okay, I'm Done.</div>
</div>

@section('js')
    @parent
    <script>
    jQuery(document).ready(function ($) {

        function check_contents() {
            if (attached_container.find('.link').length >= 1) {
                $('.empty-msg').addClass('hidden');
            } else if (attached_container.find('.empty-msg').hasClass('hidden')) {
                $('.empty-msg').removeClass('hidden');
            }
        }

        function move_to_attached(el) {
            attached_container.prepend(el);

            empty_results();

            suggest_field.val('');

            check_contents();
        }

        function empty_results() {
            results_container.find('.link').remove();
            results_panel.hide();
        }

        attached_container.on('click', '.attached-remove', function() {
            $(this).parent().remove();

            check_contents();
        });

        $('input#link').on('click', function(el) {
            $.ajax({
                url: "/link",
                type: "POST",
                data: {link : $(this).val()},
                dataType: "html"
            }).done(function( msg ) {
                alert( "Data Saved: " + msg );
            });
        });
    });
    </script>
@endsection