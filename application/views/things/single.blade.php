@layout('layouts.master')

@section('content')
    {{ Form::open(Request::uri(), 'PUT', array('class' => 'save-thing-form')) }}
    <h1>{{ $thing->name }}</h1>

    <h3>Tags</h3>
    @include('success_handler')

    <div id="container-attached-tag" class="panel container-attached" data-type="tag">
    @forelse ($thing->tags as $tag)
        @include('tags.result')
    @empty
        <div class="empty-msg">No tags exist currently for this thing.</div>
    @endforelse
        <div class="clear"></div>
    </div>

    <div id="tag-attacher" class="hidden">
        @include('tags.attacher')
    </div>

    <div class="right">
        <a href="#tag-name" class="button js-attacher-button" data-switch-id="tag-attacher">Attach tags</a>
    </div>

    <hr />


    <h3>Links</h3>
    @if (!empty($success))
        <div class="alert-box success">{{ $success }}</div>
    @endif
    @if (!empty($error))
        <div class="alert-box error">{{ $error }}</div>
    @endif

    <div id="container-attached-link" class="panel attached-container">
    @forelse ($thing->links as $link)
        @include('links.result')
    @empty
        <div class="empty-msg">No links exist currently for this thing.</div>
    @endforelse
        <div class="clear"></div>
    </div>

    <div id="link-attacher" class="hidden">
        @include('links.attacher')
    </div>

    <div class="right">
        <a href="#link-attacher" class="button js-attacher-button" data-switch-id="link-attacher">Attach link</a>
    </div>

    <hr />

    @include('errors_handler')

    {{ Form::submit('Save', array('class' => 'button')) }}

    {{ Form::close() }}
@endsection

@section('js')
    <script>
        jQuery(document).ready(function ($) {
            $('.js-attacher-button').on('click', function(){
                $(this).parent().hide();

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

            $('#form-save-thing').submit(function(){
                $('.results-container input').each(function() {
                   this.disabled = 'disabled';
                });
            });
        });
    </script>
@endsection