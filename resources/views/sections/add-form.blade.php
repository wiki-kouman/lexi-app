<form action="/wiki/add" method="post">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="language">Langue</label>
            <select id="language" class="custom-select mr-sm-2">
                <option selected>Choisir la langue...</option>
                <option>...</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="category">Catégorie grammaticale</label>
            <select id="category" class="custom-select mr-sm-2">
                <option selected>Choisir la catégorie...</option>
                <option>Verbe</option>
                <option>Nom</option>
            </select>
        </div>
    </div>
    <div class="repeater definition">
        <label>Definition</label>
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
                    <span class="input-group-text" id="originalExample">Source</span>
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

    <button type="submit" class="btn btn-primary align-right">Enregistrer</button>
</form>
