<div class="suggest">
    <div class=" ten columns">
        <div id="tag-name-field-container">
            {{ Form::label('tag-name', 'Add a tag:', array('id' => 'tag-name', 'class' => 'form-label left')) }} <!--<a href="#" class="helper right" rel="helper-attacher-tag">What's this?</a>
            <ol id="helper-attacher-tag" class="hidden"><li data-id"tag-name-field-container" data-options="tipLocation:top;tipAnimation:fade">You can create brand new tags here, or just attach existing ones. Try it now!</li></ol>-->
        </div>
        <!-- <div class="attached">
            @if (!empty($tags))
                @foreach ($tags as $tag)
                    @include('tags.result')
                @endforeach
            @endif
        </div> -->

        {{ Form::text('tag_name', null, array('id' => 'tag-name', 'data-rel' => 'tag', 'autocomplete' => 'off', 'class' => 'suggest-field', 'data-type' => 'tag')) }}

        <div class="results-panel hidden">
            <label class="form-label">Suggestions:</label>
            <div class="results-container">
                <div class="clear"></div>
            </div>
        </div>
    </div>

    <div class="button two columns switch-back">Okay, I'm Done.</div>
</div>

@section('modal')
    @include('tags.addModal')
@endsection