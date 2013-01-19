@layout('layouts.master')

@section('content')
<div class="form">
    <h1>Add a tag</h1>

    {{ Form::open('tag', 'POST') }}

    <div class="msg"></div>

    {{ Form::label('name', 'Name') }}<br />
    {{ Form::text('name', Input::old('name')) }}

    {{ Form::hidden('spectrum', 0, array('id' => 'spectrum')) }}<br />
    {{ Form::label('spectrum-slider', 'Spectrum') }}
    <div id="spectrum-slider"></div>

    {{ Form::submit('add') }}
</div>
<script>
  $(function() {
    spectrum_field = $('#spectrum');
    $( "#spectrum-slider" ).slider({
      value: spectrum_field.val(),
      min: -10,
      max: 10,
      step: 1,
      slide: function( event, ui ) {
        spectrum_field.val( ui.value );
      }
    });
  });
</script>
@endsection