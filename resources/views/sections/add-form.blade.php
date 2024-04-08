<form action="/wiki/preview" method="post">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="language">{{__('Language')}}</label>
            <select id="language" class="custom-select mr-sm-2">
                <option selected>{{__('Choose language')}}...</option>
                <option value="adj">Adioukrou</option>
                <option value="any">Agni</option>
                <option value="bci">Baoulé</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="category">{{__('Grammar category')}}</label>
            <select id="category" class="custom-select mr-sm-2">
                <option selected>{{__('Choose category')}}...</option>
                <option value="noun">{{__('Noun')}}</option>
                <option value="verb">{{__('Verbe')}}</option>
                <option value="adverb">{{__('Adverb')}}</option>
                <option value="adjective">{{__('Adjective')}}</option>
            </select>
        </div>
    </div>
    <div class="repeater definition">
        <label>Definition</label>

        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="targetExample">Mot</span>
            </div>
            <input type="text" class="form-control" value="{{$term}}">
        </div>
        <div class="input-group form-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="targetDefinition">Français</span>
            </div>
            <input type="text" class="form-control" aria-describedby="targetDefinition">
        </div>
    </div>
    <div class="example">
        <div class="repeater repeater-container">
            <label>Example</label>

            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text source-label" id="originalExample">Source</span>
                </div>
                <input type="text" class="form-control" aria-describedby="originalExample">
            </div>
            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="targetExample">Français</span>
                </div>
                <input type="text" class="form-control" aria-describedby="targetExample">
            </div>
        </div>

    </div>
    <div class="actions form-group">
        <a href="#" class="btn btn-warning btn-sm btn-add"><i class="fa fa-plus"></i> Ajouter</a>
        <a href="#" class="btn btn-danger btn-sm btn-delete hidden"><i class="fa fa-trash"></i> Supprimer</a>
    </div>

    <button type="submit" class="btn btn-primary align-right">{{__('Preview')}}</button>
</form>
