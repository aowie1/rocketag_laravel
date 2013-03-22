<!-- Reveal Modal -->
<div id="add-tag-modal" class="reveal-modal expand">
    <h2>This tag doesn't exist yet. Let's create it!</h2>

    @include('tags.addForm')
</div>

@section('js')
    @parent
    <script>
    jQuery(document).ready(function ($) {
        $('.add-tag-form').submit(function(e){
            // Post and save the tag
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(ret) {
                    move_to_attached(ret);
                    add_modal.trigger('reveal:close');
                }
            });

            return false;
        });
    });
    </script>
@endsection