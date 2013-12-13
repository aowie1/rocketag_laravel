/**
 * Display error messages
 *
 * @param string[] errors - JSON encoded array of errors
 * @return void
 */
function display_messages(msg, type) 
{
    if (type == 'success')
    {
        $('#js-msg-success').text(msg);
    }
    else
    {

        var msg_json = $.parseJSON(msg);
        var el;

        msg_container = $('.msg');

        // if is_array
        if (msg_json) {
            $.each(msg_json, function(id, messages){

                if ($('#' + id).length > 0) {
                    el = $('#' + id);
                } else {
                    el = $('[name="' + id + '"]');
                }

                if (el.length > 0) {
                    el.addClass(type);
                }

                $.each(messages, function(i, message){

                    msg_container.append('<div class="'+type+'">' + message + '</div>');
                });
            });
        } else {
            msg_container.append('<div class="'+type+'">' + msg_json + '</div>');
        }
    }
}