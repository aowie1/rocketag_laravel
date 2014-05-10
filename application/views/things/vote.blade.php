<div class="vote-block">
     <div id="votes">
        <h3>Vote:</h3>
        <a class="btn-vote js-btn-vote @if(isset($user_data->vote) && $user_data->vote==1) active @endif" data-value="up">Up</a> 
        | <a class="btn-vote js-btn-vote @if(isset($user_data->vote) && $user_data->vote==0) active @endif" data-value="down" data-reveal-id="modal-register">Down</a>
    </div>
</div>

@section('dom-ready')
	@parent
		$('.js-btn-vote').on('click', function(e){
			@if(!empty($user))
				// Display the register modal if an anonymous user attempts a vote
				$('.js-modal-register').foundation('reveal', 'open');
			@else
	            e.preventDefault();

	            value = $(this).data('value');

	            // Post and save the vote
	            $.ajax({
	                type: 'POST',
	                url: '/thing/'+{{ $thing->id }}+'/vote/'+value,
	                success: function(ret) {
	                    // $.fn.deactivateVoting(value);
	                }
	            });
			@endif
		});
@endsection