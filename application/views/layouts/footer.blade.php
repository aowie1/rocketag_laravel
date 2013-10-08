    <div class="clear"></div>

    <div id="footer" class="width">

        <div id="footer_left">
            <p>&copy; Copyright 2013</p>
        </div>

        <div id="footer_right">
            <p>Rocket blasting you to the <a href="#" alt="Moon!">moon!</a></p>
        </div>

    </div>

</div><!--end wrapper -->

@yield('modal')

<script>
    @if (!empty($errors))
        display_messages('{{ json_encode($errors) }}', 'error');
    @endif

    @if (!empty($success))
        display_messages('{{ json_encode($success) }}', 'success');
    @endif

    jQuery(document).ready(function ($) {
        $('a.helper').on('click', function(e){
            $('#' + $(this).attr('rel')).joyride({
              'tipLocation': 'bottom',         // 'top' or 'bottom' in relation to parent
              'nubPosition': 'auto',
            });
        });
    });
</script>

<script src="/js/suggestive.js"></script>

@yield('js')

@if(!empty($user))
    @include('auth.register.modal')
@endif

</body>