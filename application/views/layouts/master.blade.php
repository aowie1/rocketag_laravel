<!doctype html>
<html lang="en">
<head>
    <title>Rocketag</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js"></script>
    <script src="/vendors/foundation-4.0.4/js/foundation.min.js"></script>
    <script src="/vendors/foundation-4.0.4/js/foundation/foundation.reveal.js"></script>
    <script src="/js/common.js"></script>

    <link rel="stylesheet" type="text/css" href="/css/ui-lightness/jquery-ui-1.10.0.custom.min.css" />
    <link rel="stylesheet" type="text/css" href="/vendors/foundation-4.0.4/css/foundation.css" />
    <link rel="stylesheet" type="text/css" href="/vendors/foundation-4.0.4/css/layout.css" />
    <link rel="icon" type="image/ico" href="/vendors/foundation-4.0.4/img/favicon.ico"/>
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,700,600' rel='stylesheet' type='text/css'>
</head>
<body>
    @include('layouts.header')

    <div id="content">
        <div  class="lt col-1">    
            <div id="thing_choices">
                <ul>
                    <li><a href="#">Muse</a></li>
                    <li><a href="#">Mars Volta</a></li>
                    <li><a href="#">30 Seconds to Stars</a></li>
                    <li><a href="#">Tool</a></li>
                    <li><a href="#">The Dirty Heads</a></li>
                    <li><a href="#">Modest Mouse</a></li>
                </ul>
            </div>
        </div>

        <div class="lt col-2">
            <div id="present_thing">
                @include('message_handler')

                @yield('content')

                <div class="clear"></div>
            </div>

            <div id="rocket"></div>
        </div>

        <div class="rt col-3">
            <div id="thing_images">
                <h2>Images</h2>
                <div id="thing_images_inside"></div>
            </div>

            <div id="sidebar" class="rt col-3">
                <h2 class="title">Other Stuff</h2>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">User Agreement</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Mobile App</a></li>
                    <li><a href="#">Api</a></li>
                </ul>
            </div>
        </div>
        <div class="clear"></div>

        <div>
            <div id="comments" class="lt col-2">
                <h2>Comments</h2>
                <ul>
                    <li><a href="#" class="id">Name!</a> <span class="date">- 12/3/2012 10:45am</span> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam egestas, massa sed lacinia volutpat, tellus magna suscipit sapien, vel mattis nisl metus ultrices dolor.</p></li>
                    <li><a href="#" class="id">Gerald</a> <span class="date"> - 12/3/2012 10:45am</span> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam egestas, massa sed lacinia volutpat, tellus magna suscipit sapien, vel mattis nisl metus ultrices dolor.</p></li>
                    <li><a href="#" class="id">ME</a> <span class="date"> - 12/3/2012 10:45am</span> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam egestas, massa sed lacinia volutpat, tellus magna suscipit sapien, vel mattis nisl metus ultrices dolor.</p></li>
                    <li><a href="#" class="id">Randen</a> <span class="date"> - 12/3/2012 10:58am</span> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam egestas, massa sed lacinia volutpat, tellus magna suscipit sapien, vel mattis nisl metus ultrices dolor.</p></li>
                </ul>
            </div>
        </div>
    </div><!--end content -->

    <div class="clear"></div>

    <!--footer-->
    <div class="clear"></div>

    <div id="footer" class="width">

        <div id="footer_left">
            <p>&copy; Copyright 2013</p>
        </div>

        <div id="footer_right">
            <p>Rocket blasting you to the <a href="#" alt="Moon!">moon!</a></p>
        </div>

    </div>

    @yield('modal')

    <script>
        @if (!empty($errors->messages))
            display_messages('{{ json_encode($errors->messages) }}', 'error');
        @endif

        @if (!empty($success))
            display_messages('{{ $success }}', 'success');
        @endif
    </script>

    @yield('js')
    
    <script>
    jQuery(document).ready(function ($) {
        $('a.helper').on('click', function(e){
            $('#' + $(this).attr('rel')).joyride({
              'tipLocation': 'bottom',         // 'top' or 'bottom' in relation to parent
              'nubPosition': 'auto',
            });
        });

        @yield('dom-ready')
    });
    </script>

</body>
</html>