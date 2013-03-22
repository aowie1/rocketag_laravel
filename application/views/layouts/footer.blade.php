    <div class="clear"></div>

    <div id="footer" class="width">

        <div id="footer_left">
            <p>Copyright 2012</p>
        </div>

        <div id="footer_right">
            <p>Rocket blasting you to the <a href="#" alt="Moon!">moon!</a></p>
        </div>

    </div>

</div><!--end wrapper -->

@yield('modal')

<script>
    @if (!empty($errors))
        //display_messages('{{ json_encode($errors) }}', 'error');
    @endif

    @if (!empty($success))
        //display_messages('{{ json_encode($success) }}', 'success');
    @endif
jQuery(document).ready(function ($) {
    $('a.helper').on('click', function(e){
        // $('#' + $(this).attr('rel')).joyride({
        //   'tipLocation': 'bottom',         // 'top' or 'bottom' in relation to parent
        //   'nubPosition': 'auto',
        // });
    });

    $('#tag-attacher-button').on('click', function(){
        //$(this).parent().hide();

        original = $(this).parent();
        switch_to = $(this).attr('data-switch-id');
        switch_to_el = $('#' + switch_to);


        switch_to_el.show('fast', function(){
            $('.switch-back').on('click', function(){
                switch_to_el.hide();
                original.show();
            });
        });

        return true;
    });
});
</script>

@yield('js')

</body>