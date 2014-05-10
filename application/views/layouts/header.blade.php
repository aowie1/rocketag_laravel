<div id="top">
    <div class="width">
        <ul class="lt top_nav">
            <li><a href="#">Whats Up</a></li>
            <li><a href="#">How It Works</a></li>
            <li><a href="#">Test Form</a></li>
        </ul>
        <ul class="rt top_nav">
            <li><a href="#">Random!</a></li>
            <li><a href="#">My Tagmosphere</a></li>
            @if (User::is_logged_in())
                <li>Hi there, {{ $user->metadata->first_name }}! | <a href="/logout">Logout</a></li>
            @else
                <li><a href="/login">Login</a></li>
            @endif
        </ul>
    </div>

    <div class="clear"></div>
    </div><!--end top -->

    <div id="wrapper">

    <div id ="header">
        <div id ="logo" class="lt">
            <a href="index.html"><img src='/foundation/images/foundation/orbit/logo.png' alt="Rocketshag's Awesome Logo" /></a>
        </div>
        
        @include('search.form')

        <div class="clear"></div>
    </div><!--end header -->
</div>