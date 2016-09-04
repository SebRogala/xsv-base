# XsvBase
Module with some utils on which other modules can base in Zend Expressive.

To install simply use composer:
```
composer require sebrogala/xsv-base:^0.1
```

### Body Params Middleware
Enchanted version which allows to use $request->getParsedBody() on PUT request.
For more details [see original Middleware][1].
To use new version you have to remove (if already used) invokable from config:

```php
'dependencies' => [
        'invokables' => [
            Helper\BodyParams\BodyParamsMiddleware::class => Helper\BodyParams\BodyParamsMiddleware::class,
            /* ... */
        ],
        'factories' => [
            /* ... */
        ],
    ],
```

and put new key to 'factories' key, so final should look like:

```php
'dependencies' => [
        'invokables' => [
            /* ... */
        ],
        'factories' => [
            Helper\BodyParams\BodyParamsMiddleware::class => Xsv\Base\Factory\BodyParams\BodyParamsFactory::class,
            /* ... */
        ],
    ],
```

Or if you didn't have one yet, you can simply copy 'body-params-factory.local.php.dist'
file from 'data' folder to config/autoload and remove .dist extension.

[1]: http://zend-expressive.readthedocs.io/en/stable/features/helpers/body-parse/