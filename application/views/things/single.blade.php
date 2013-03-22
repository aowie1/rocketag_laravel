@layout('layouts.master')

@section('content')
    <h1>{{ $thing->name }}</h1>

    <h3>Tags</h3>
    {{ Form::open(Request::uri(), 'PUT', array('class' => 'save-thing-form')) }}
    @if (!empty($success))
        <div class="alert-box success">{{ $success }}</div>
    @endif
    @if (!empty($error))
        <div class="alert-box error">{{ $error }}</div>
    @endif
    <div class="panel attached-container">
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

    <div>
        {{ Form::submit('Save', array('class' => 'button')) }}
        <a href="#" class="button" id="tag-attacher-button" data-switch-id="tag-attacher">Attach tags</a>
    </div>

    {{ Form::close() }}
@endsection

@section('js')
    <script>
        // $('#tag-attacher-button').on('click', function(){
        //     console.log($(this));
        // });
    </script>
@endsection