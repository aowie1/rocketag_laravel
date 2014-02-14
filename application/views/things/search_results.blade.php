@foreach ($things_results as $thing)
    <a href="{{ $thing->build_link() }}">{{ $thing->name }}</a>
@endforeach