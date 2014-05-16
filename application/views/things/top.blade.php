@if (!empty($things))
    <div class="top-things">
        <h3>Top things:</h3>
        @foreach ($things as $thing)
            <a href="/thing/{{ $thing->id }}">{{ $thing->name }}</a>
        @endforeach
    </div>
@endif