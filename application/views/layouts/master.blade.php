<!doctype html>
<html lang="en">
    @include('layouts.header')

    <div class="lt col-1">
        <ul>
    <li><a href="#">Muse</a></li>
    <li><a href="#">Mars Volta</a></li>
    <li><a href="#">30 Seconds to Stars</a></li>
    <li><a href="#">Tool</a></li>
        </ul>
    </div>

    <div class="lt col-2">
        @yield('content')
    </div>

    <div class="rt col-3">

    </div>

    @include('layouts.footer')
</html>