@layout('layouts.master')

@section('content')
    <h1>{{ $thing->name }}</h1>

    <h2>Tags</h2>
    <div class="panel">
    @forelse ($thing->tags as $tag)
        @include('tags.result')
    @empty
        No tags exist currently for this thing.
    @endforelse
    </div>

    <a href="#" class="button" id="tag-attacher-button" data-reveal-id="tag-attacher-modal">Attach tags</a>

    <div id="tag-attacher-modal" class="reveal-modal">
        {{ Form::open('tag', 'POST', array('class' => 'add-tag-form')) }}
            @include('tags.attacher')

            {{ Form::submit('Attach', array('class' => 'button')) }}
        {{ Form::close() }}
    </div>
@endsection

@section('js')
<script>
    $(function(){
        $('#tag-attacher-button').click(function(){
            $('#tag-attacher-modal').reveal();
        });
    });
</script>
@endsection