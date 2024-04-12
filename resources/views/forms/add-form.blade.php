<form action="/wiki/preview" method="post">
    @csrf <!-- {{ csrf_field() }} -->
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="language">{{__('Language')}}</label>
            <select id="language" class="custom-select mr-sm-2" name="language">
                <option selected value="adj">{{__('Choose language')}}...</option>
                <option value="adj">Adioukrou</option>
                <option value="any">Agni</option>
                <option value="bci">Baoulé</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="category">{{__('Grammar category')}}</label>
            <select id="category" class="custom-select mr-sm-2"  name="category">
                <option selected value="noun">{{__('Choose category')}}...</option>
                <option value="noun">{{__('Noun')}}</option>
                <option value="verb">{{__('Verbe')}}</option>
                <option value="adverb">{{__('Adverb')}}</option>
                <option value="adj">{{__('Adjective')}}</option>
            </select>
        </div>
    </div>
    <div class="lexeme-attribute definition">
        <label>Definition</label>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text">Mot</span>

            </div>
            <input type="text" class="form-control keyboard-input" value="{{$term}}" name="definitionLabel">
            <button type="button" class="btn btn-dark keyboard-button"><i class="fa fa-keyboard-o"></i></button>
        </div>
        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text">Français</span>
            </div>
            <input type="text" class="form-control" name="definitionTranslation">
        </div>
    </div>
    <div class="example">
        <div class="lexeme-attribute repeater-container">
            <label>Example <span class="repeater-count hidden"></span></label>

            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text source-label" id="exampleLabel">Source</span>
                </div>
                <input type="text" class="form-control keyboard-input" name="exampleLabel[]">
                <button type="button" class="btn btn-dark keyboard-button"><i class="fa fa-keyboard-o"></i></button>
            </div>
            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="exampleTranslation">Français</span>
                </div>
                <input type="text" class="form-control" name="exampleTranslation[]">
            </div>
        </div>

    </div>
    <div class="actions form-group">
        <button type="button" class="btn btn-warning btn-sm btn-add"><i class="fa fa-plus"></i> Ajouter</button>
        <button type="button" class="btn btn-danger btn-sm btn-delete hidden"><i class="fa fa-trash"></i> Supprimer</button>
        <button type="submit" class="btn btn-sm btn-primary align-right"><i class="fa fa-eye"></i>  {{__('Preview')}}</button>
    </div>


</form>

@include('../keyboard')
