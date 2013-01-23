<!-- Reveal Modal -->
<div id="add-tag-modal" class="reveal-modal expand">
    Looks like you're trying to add a new tag.

    @include('tags.addForm')
</div>

<script>
    $('.add-tag-form').submit(function(e){
        // Post and save the tag
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(ret) {
                attach(ret);
            }
        });

        return false;
    });
</script>