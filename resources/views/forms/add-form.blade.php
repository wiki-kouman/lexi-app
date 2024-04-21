@include('forms/error-modal')
<form action="/wiki/preview" method="post" class="needs-validation" novalidate>
    @csrf <!-- {{ csrf_field() }} -->
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="language">{{__('Language')}}</label>
            <select id="language" class="custom-select mr-sm-2" name="language" required>
                <option value="">{{__('Choose language')}}...</option>
                <option value="adj">Adioukrou</option>
                <option value="any">Agni</option>
                <option value="bci">Baoulé</option>
            </select>
			<div class="invalid-feedback">{{__('You need to choose a language from the list.')}}</div>
        </div>
        <div class="form-group col-md-6">
            <label for="category">{{__('Grammar category')}}</label>
            <select id="category" class="custom-select mr-sm-2"  name="category" required>
                <option value="">{{__('Choose category')}}...</option>
                <option value="noun">{{__('Noun')}}</option>
                <option value="pronoun">{{__('Pronoun')}}</option>
                <option value="adv">{{__('Adverb')}}</option>
                <option value="adj">{{__('Adjective')}}</option>
                <option value="verb">{{__('Verbe')}}</option>
                <option value="interj">{{__('Interjection')}}</option>
            </select>
			<div class="invalid-feedback">{{__('You need to choose a grammar category.')}}</div>
        </div>
    </div>
    <div class="lexeme-attribute definition">
        <label>{{__('Definition')}}</label>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text">{{__('Word')}}</span>
            </div>
            <input type="text" class="form-control keyboard-input" value="{{$term}}" name="definitionLabel" required>
            <button type="button" class="btn btn-dark keyboard-button"><i class="fa fa-keyboard-o"></i></button>
			<div class="invalid-feedback">{{__('This field is required, but it seems empty.')}}</div>
		</div>
        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text">{{__('French')}}</span>
            </div>
            <input type="text" class="form-control" name="definitionTranslation" required>
			<div class="invalid-feedback">{{__('Please make sure you have included a translation.')}}</div>
        </div>
    </div>
    <div class="example">
		<div class="lexeme-attribute repeater-container">
			<label>{{__('Example')}} <span class="repeater-count hidden"></span></label>

			<div class="input-group form-group">
				<div class="input-group-prepend">
					<span class="input-group-text source-label" id="exampleLabel">{{__('Example text')}}</span>
				</div>
				<input type="text" class="form-control keyboard-input" pattern=".*('''.*''').*" name="exampleLabel[]" required>
				<button type="button" class="btn btn-dark keyboard-button"><i class="fa fa-keyboard-o"></i></button>
				<div class="invalid-feedback">{{__('It seems that your example does not include a word in bold.')}}</div>
			</div>
			<div class="input-group form-group">
				<div class="input-group-prepend">
					<span class="input-group-text" id="exampleTranslation">{{__('French')}}</span>
				</div>
				<input type="text" class="form-control" name="exampleTranslation[]" required>
				<div class="invalid-feedback">{{__('Please make sure you have included a translation.')}}</div>
			</div>
		</div>
        <input type="hidden" name="operation" value="{{$operation}}"/>
    </div>
    <div class="actions form-group">
        <button type="button" class="btn btn-warning btn-sm btn-add"><i class="fa fa-plus"></i> {{__('Add')}}</button>
        <button type="button" class="btn btn-danger btn-sm btn-delete hidden"><i class="fa fa-trash"></i> {{__('Delete')}}</button>
        <button type="submit" class="btn btn-sm btn-primary align-right"><i class="fa fa-eye"></i>  {{__('Preview')}}</button>
    </div>
</form>
@include('keyboard')
