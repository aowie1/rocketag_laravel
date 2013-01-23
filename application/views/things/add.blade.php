@layout('layouts.master')

@section('content')
    <div class="form">
        <h1>Add a thing</h1>

        {{ Form::label('thing', 'Thing') }}
        {{ Form::open('thing', 'POST') }}
        <div class="msg"></div>

        {{ Form::text('name', Input::old('name')) }}
        <br />
        <div class="suggest">
            {{ Form::label('tag', 'Tag') }}
            <div class="attached">

                @if (!empty($old_tags))
                    {{ dd($old_tags) }}
                    @foreach ($old_tags as $tag_id => $tag_name)
                        @include('tags.result')
                    @endforeach
                @endif
            </div>
            {{ Form::text('tag', null, array('id' => 'tags', 'rel' => 'tags', 'autocomplete' => 'off', 'class' => 'tag-name-field suggest-field')) }}
            <div class="results"></div>
        </div>

        {{ Form::submit('add') }}
    </div>
    {{ Form::close() }}

    @include('tags.addModal')
@endsection

@section('js')
    <script>
    function get_suggestions(data) {
        var suggestions = false;

        $.ajax({
            async: false,
            type: 'POST',
            url: suggest_field.attr('rel')+'/suggestions',
            data: data,
            success: function(ret) {
                if (ret !== '') {
                    suggestions = ret;
                }
            }
        });

        return suggestions;
    }

    function attach(ret) {
        suggest_container = $('.suggest');
        suggest_field = suggest_container.find('input.suggest-field');

        suggest_field.val('');
        if (ret !== '') {
            suggest_container.find('.attached').append(ret);
            $('#add-tag-modal').trigger('reveal:close');
        }
    }

    function move_to_attached(el) {
        suggest_container.find('.attached').append(el);

        results_container.empty();

        suggest_field.val('');
    }

    $(function(){
        /**
         * Attach suggestive functionality to textbox
         * id => use the table name, rel => root path to set of methods, "/suggestions" will automatically be appended where needed
         * Example of usage:
         * <input id="tags" class="suggest" rel="/admin/tags" type="text" name="tag" />
        */

        suggest_container = $('.suggest');
        suggest_field = suggest_container.find('input.suggest-field');
        results_container = suggest_container.find('.results');

        suggest_field.on('keypress', function(e) {

            var data = {};
            data.str = $(this).val();

            var keycode = (event.keyCode ? event.keyCode : event.which);

            // Look for suggestions
            // If anything but the Enter key was pushed
            if ($(this).val().length > 1 && keycode != '13') {
                data.exclude = [];

                $.each(suggest_container.find('.attached input'), function(i, el) {
                    data.exclude[i] = $(el).val();
                });

                results_container.empty();

                suggestions = get_suggestions(data);

                results_container.html(suggestions).show();
            }

            // Create the entry if it doesnt already exist

            // If Enter key was pushed
            else if(keycode == '13') {
                e.preventDefault();

                data.exact = true;

                results = get_suggestions(data);

                if (!results) {
                    $("#add-tag-modal").reveal();

                    $('.add-tag-name-field').val($('.tag-name-field').val());
                } else {
                    move_to_attached(results);
                }
            }
        });

        suggest_container.on('click', '.suggestion-result-row', function() {
            move_to_attached($(this));
        });

        suggest_container.on('click', '.attached-remove', function() {
            $(this).parent().remove();
        });
        /* end suggest functionality */

    });
    </script>
@endsection