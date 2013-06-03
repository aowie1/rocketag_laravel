jQuery(document).ready(function ($) {
    function get_suggestions(data) {
        var suggestions = false;

        $.ajax({
            async: false,
            type: 'POST',
            url: '/'+suggest_field.data('rel')+'/suggestions',
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
        if (attached_container.find('.result-item').length >= 1) {
            $('.empty-msg').addClass('hidden');
        } else if (attached_container.find('.empty-msg').hasClass('hidden')) {
            $('.empty-msg').removeClass('hidden');
        }
    }

    $.fn.move_to_attached = function(el) {
        attached_container = $('#container-attached-'+el.data('type'));

        el.prepend('<input type="hidden" name="tags[]" value="'+el.data('rel')+'">')

        attached_container.prepend(el);

        empty_results();

        suggest_field.val('');

        check_contents(attached_container);
    }

    function empty_results() {
        results_container.find('.item-attached').remove();
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

    suggest_field.on('keydown', function(e) {

        var data = {};
        field = $(this);
        data.str = field.val();
        type = field.data('type');

        var keycode = (event.keyCode ? event.keyCode : event.which);

        // Look for suggestions
        // If anything but the Enter key was pressed
        if(field.val().length > 1) {
            // If Enter key was pressed
            if (keycode == '13') {
                e.preventDefault();

                data.exact = true;

                results = get_suggestions(data);

                add_modal = $('#add-modal-'+type);
                add_field = add_modal.find('.js-field-add');

                // Ask to create the entry if it doesnt already exist
                if (!results) {
                    add_field.val(data.str);
                    add_modal.foundation('reveal', 'open');

                    //suggest_field.val(add_field.val());
                } else {
                    $.fn.move_to_attached(results, type);
                    add_modal.foundation('reveal', 'close');
                }
            }
            else { // If any key other than Enter key was pressed
                data.exclude = [];

                $.each($('.container-attached-'+type).find('input'), function(i, el) {
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
        $.fn.move_to_attached($(this));
    });

    $('.container-attached').on('click', '.attached-remove', function() {
        $(this).parent().remove();

        check_contents($(this).data('type'));
    });

});
/* end suggest functionality */
