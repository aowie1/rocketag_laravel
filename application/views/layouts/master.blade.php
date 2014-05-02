<!doctype html>
<html lang="en">
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

                @include('tags.top_tags')
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

    @include('layouts.footer')
</html>