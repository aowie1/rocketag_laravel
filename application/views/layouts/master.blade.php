<!doctype html>
<html lang="en">
    <head>
        <title>Rocketag</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="/js/jquery-ui-1.10.0.custom.min.js"></script>
        <script src="/foundation/javascripts/foundation.min.js"></script>
        <script src="/js/common.js"></script>

        <link rel="stylesheet" type="text/css" href="/css/ui-lightness/jquery-ui-1.10.0.custom.min.css" />
        <link rel="stylesheet" type="text/css" href="/foundation/stylesheets/foundation.css" />
    </head>
    <body>
        @yield('content')
        <script>
            $(function() {
                @if (!empty($errors))
                    display_messages('{{ json_encode($errors) }}', 'error');
                @endif
                @if (!empty($success))
                    display_messages('{{ json_encode($success) }}', 'success');
                @endif
            });
        </script>
        @yield('js')
    </body>
</html>
