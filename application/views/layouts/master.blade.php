<!doctype html>
<html lang="en">
    <head>
        <title>Rocketag</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="/js/common.js"></script>
    </head>
    <body>
        @yield('content')
        <script>
            $(document).ready(function() {
                @if (!empty($errors))
                    display_messages('{{ json_encode($errors) }}', 'error');
                @endif
                @if (!empty($success))
                    display_messages('{{ json_encode($success) }}', 'success');
                @endif
            });
        </script>
    </body>
</html>
