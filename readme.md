# Simple DOM Analyser

Very simple command line app writen on top of [Lumen framework](http://lumen.laravel.com/docs), 
using [DiDom](https://github.com/Imangazaliev/DiDOM) HTML parser, to collect information about the markup of a 
given URL.

Information provided:

- Number of ocurrences per HTML tag
- Number of attributes per HTML tag
- Number of `id` attributes
- Number of `class` attributes
- Number of children elements per HTML tag

Results are exported as a `.json` file.

## Instalation

- Copy `.env.example` to `.env` to set the configuration file
- Run ```composer install```

To run the tests execute: ```vendor/phpunit/phpunit/phpunit```

## Usage:

```php artisan analyse <url_to_analyse>```
