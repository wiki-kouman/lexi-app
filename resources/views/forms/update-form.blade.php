<form action="/wiki/preview?operation=update" method="post">
    @csrf <!-- {{ csrf_field() }} -->
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="language">{{__('Language')}}</label>
            <select id="language" class="custom-select mr-sm-2" name="language">
                <option selected value="">{{__('Choose language')}}...</option>
                <option value="adj">Adioukrou</option>
                <option value="any">Agni</option>
                <option value="bci">Baoulé</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="category">{{__('Grammar category')}}</label>
            <select id="category" class="custom-select mr-sm-2"  name="category">
                <option selected value="">{{__('Choose category')}}...</option>
                <option value="noun">{{__('Noun')}}</option>
                <option value="verb">{{__('Verbe')}}</option>
                <option value="adv">{{__('Adverb')}}</option>
                <option value="adj">{{__('Adjective')}}</option>
                <option value="adj-int">{{__('Interogative Adjective')}}</option>
                <option value="interj">{{__('Interjection')}}</option>
            </select>
        </div>
    </div>
    <div class="lexeme-attribute definition">
        <label>{{__('Word')}}</label>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text">{{__('Word')}}</span>

            </div>
            <input type="text" class="form-control keyboard-input" value="{{$term}}" name="definitionLabel">
            <button type="button" class="btn btn-dark keyboard-button"><i class="fa fa-keyboard-o"></i></button>
        </div>
        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text">{{__('French')}}</span>
            </div>
            <input type="text" class="form-control" name="definitionTranslation">
        </div>
    </div>
    <div class="example">
        <div class="lexeme-attribute repeater-container">
            <label>{{__('Example')}} <span class="repeater-count hidden"></span></label>

            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text source-label" id="exampleLabel">{{__('Example text')}}</span>
                </div>
                <input type="text" class="form-control keyboard-input" name="exampleLabel[]">
                <button type="button" class="btn btn-dark keyboard-button"><i class="fa fa-keyboard-o"></i></button>
            </div>
            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="exampleTranslation">{{__('French')}}</span>
                </div>
                <input type="text" class="form-control" name="exampleTranslation[]">
            </div>
        </div>
        <input type="hidden" name="action" value="/wiki/update"/>
    </div>
    <div class="actions form-group">
        <button type="button" class="btn btn-warning btn-sm btn-add"><i class="fa fa-plus"></i> {{__('Add')}}</button>
        <button type="button" class="btn btn-danger btn-sm btn-delete hidden"><i class="fa fa-trash"></i> {{__('Delete')}}</button>
        <button type="submit" class="btn btn-sm btn-primary align-right"><i class="fa fa-eye"></i>  {{__('Preview')}}</button>
    </div>


</form>

@include('../keyboard')
