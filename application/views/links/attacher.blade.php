    <div>
    <div class="ten columns">
        <div id="link-name-field-container">
            {{ Form::label('link-name', 'Add a link:', array('id' => 'link-name', 'class' => 'form-label left')) }} <a href="#" class="helper right" rel="link-attacher-helper">What's this?</a>
            <ol id="link-attacher-helper" class="hidden"><li data-id"link-name-field-container" data-options="tipLocation:top;tipAnimation:fade">You can create brand new links here. Try it now!</li></ol>
        </div>

        {{ Form::text('link', null, array('id' => 'link', 'rel' => 'link', 'autocomplete' => 'off', 'class' => 'js-link-field')) }}
    </div>

    <div class="button two columns switch-back">Okay, I'm Done.</div>
</div>