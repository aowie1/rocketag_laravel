@if (Session::has('success'))
    <div data-alert class="alert-box success">{{ Session::get('success') }}</div>
@endif