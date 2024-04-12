<form class="form-inline" action="/wiki/search">
    <div class="form-group mb-2 mr-2">
        <input class="form-control keyboard-input" name="term" type="text" class="form-control" id="term" placeholder="{{ __('Type your new word') }}">
        <button type="button" class="btn btn-dark keyboard-button"><i class="fa fa-keyboard-o"></i></button>
    </div>
    <button type="submit" class="btn btn-primary mb-2">{{ __('Check') }}</button>
    <link rel="stylesheet" href="/css/keyboard.css">
    <script src="/js/keyboard.js"></script>
    @include('../keyboard')
</form>
