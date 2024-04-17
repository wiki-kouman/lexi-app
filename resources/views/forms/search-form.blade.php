<form class="form-inline search-form-inline" action="/wiki/search">
    <input class="form-control keyboard-input" name="term" type="text" id="term" placeholder="{{ __('Type your new word') }}">
    <button type="button" class="btn btn-dark keyboard-button"><i class="fa fa-keyboard-o"></i></button>
    <button type="submit" class="btn btn-primary">{{ __('Check') }}</button>
    <link rel="stylesheet" href="/css/keyboard.css">
    <script src="/js/keyboard.js"></script>
    @include('../keyboard')
</form>
