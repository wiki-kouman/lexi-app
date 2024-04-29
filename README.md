
# Lexi

Interactive web application for adding terms to Wiktionary.

## Requirements

* [PHP 7.3+](https://www.php.net/downloads.php)
* [Composer (PHP dependency manager)](https://getcomposer.org/download/)

## Installing dependencies
Let composer find and install latest versions of dependencies
```bash 
composer update
```

## Configuration
Copy `.env.example` to `.env` and change the parameters according to your OAuth consumer app. Checkout [MediaWiki  documentation ](https://www.mediawiki.org/wiki/OAuth/For_Developers) for more details on creating your Oauth credentials.

## Quickstart the app
```bash
composer start
```

## Unit testing
Do some testing by running the following command
```bash
composer test
```
