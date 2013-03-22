<div class="suggest">
    <div class=" ten columns">
        <div id="tag-name-field-container">
            {{ Form::label('tag-name', 'Add a tag:', array('id' => 'tag-name', 'class' => 'form-label left')) }} <a href="#" class="helper right" rel="tag-attacher-helper">What's this?</a>
            <ol id="tag-attacher-helper" class="hidden"><li data-id"tag-name-field-container" data-options="tipLocation:top;tipAnimation:fade">You can create brand new tags here, or just attach existing ones. Try it now!</li></ol>
        </div>
        <!-- <div class="attached">
            @if (!empty($tags))
                @foreach ($tags as $tag)
                    @include('tags.result')
                @endforeach
            @endif
        </div> -->

        {{ Form::text('tag_name', null, array('id' => 'tag-name', 'rel' => 'tag', 'autocomplete' => 'off', 'class' => 'tag-name-field suggest-field')) }}

        <div class="results-panel hidden">
            <label class="form-label">Suggestions:</label>
            <div class="results-container">
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <div class="button two columns switch-back">Okay, I'm Done.</div>
</div>

@section('modal')
    @include('tags.addModal')
@endsection

@section('js')
    @parent
    <script>
    jQuery(document).ready(function ($) {
        function get_suggestions(data) {
            var suggestions = false;

            $.ajax({
                async: false,
                type: 'POST',
                url: '/'+suggest_field.attr('rel')+'/suggestions',
                data: data,
                success: function(ret) {
                    if (ret !== '') {
                        suggestions = ret;
                    }
                }
            });

            return suggestions;
        }

        function check_contents() {
            if (attached_container.find('.tag').length >= 1) {
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
            results_container.find('.tag').remove();
            results_panel.hide();
        }

        /**
         * Attach suggestive functionality to textbox
         * id => use the table name, rel => root path to set of methods, "/suggestions" will automatically be appended where needed
         * Example of usage:
         * <input id="tags" class="suggest" rel="/admin/tags" type="text" name="tag" />
        */

        suggest_container = $('.suggest');
        suggest_field = suggest_container.find('input.suggest-field');
        results_panel = suggest_container.find('.results-panel');
        results_container = results_panel.find('.results-container');
        attached_container = $('.attached-container');

        suggest_field.on('keypress', function(e) {

            var data = {};
            data.str = $(this).val();

            var keycode = (event.keyCode ? event.keyCode : event.which);

            // Look for suggestions
            // If anything but the Enter key was pressed
            if($(this).val().length > 1) {
                // If Enter key was pressed
                if (keycode == '13') {
                    e.preventDefault();

                    data.exact = true;

                    results = get_suggestions(data);

                    add_modal = $('#add-tag-modal');

                    // Ask to create the entry if it doesnt already exist
                    if (!results) {
                        $('.add-tag-name-field').val(data.str);
                        add_modal.reveal();

                        suggest_field.val($('.tag-name-field').val());
                    } else {
                        move_to_attached(results);
                        add_modal.trigger('reveal:close');
                    }
                }
                else { // If any key other than Enter key was pressed
                    data.exclude = [];

                    $.each(attached_container.find('input'), function(i, el) {
                        data.exclude[i] = $(el).val();
                    });

                    empty_results();

                    suggestions = get_suggestions(data);

                    if (suggestions) {
                        results_container.prepend(suggestions);
                        results_panel.slideDown();
                    }
                }
            }
        });

        suggest_container.on('click', '.result-item', function() {
            move_to_attached($(this));
        });

        attached_container.on('click', '.attached-remove', function() {
            $(this).parent().remove();

            check_contents();
        });
        /* end suggest functionality */
    });
    </script>
@endsection