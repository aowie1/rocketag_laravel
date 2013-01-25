<!doctype html>
<html lang="en">
    @include('layouts.header')
    
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
        @include('layouts.footer')
    
