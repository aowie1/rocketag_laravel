@layout('layouts.master')

@section('content')
<div class="form">
    This tag is not yet in our system, but feel free to add it!

    {{ Form::open('tag', 'POST') }}
    {{ Form::text('name', @$tag) }}
    {{ Form::submit('add') }}
</div>
@endsection

