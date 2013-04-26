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

        <div id="rocket"></div>
    </div>

    <div class="rt col-3">
        <h2>Images</h2>
        <div class="content">

        </div>

    </div>

    @include('layouts.footer')
</html>