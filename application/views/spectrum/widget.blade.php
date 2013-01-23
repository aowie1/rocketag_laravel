{{ Form::hidden('spectrum', 0, array('id' => 'spectrum')) }}<br />
{{ Form::label('spectrum-slider', 'Spectrum') }}
<div id="spectrum-slider"></div>

<script>
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
</script>