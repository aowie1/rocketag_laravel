@layout('layouts.master')

@section('content')

    This is tag: {{ $tag->name }}

    {{ $top_things_widget }}
@endsection
