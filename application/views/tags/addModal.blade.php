<!-- Reveal Modal -->
<div id="add-modal-tag" class="reveal-modal expand">
    <h2>This tag doesn't exist yet. Let's create it!</h2>

    @include('tags.addForm')
</div>

@section('js')
    @parent
    <script>
    jQuery(document).ready(function ($) {
        $('#add-modal-tag form').submit(function(e){
            form = $(this);

            // Post and save the tag
            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: form.serialize(),
                success: function(ret) {
                    $.fn.move_to_attached($(ret), form.attr('data-type'));
                    add_modal.foundation('reveal', 'close');
                }
            });

            return false;
        });
    });
    </script>
@endsection