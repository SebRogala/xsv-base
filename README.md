# XsvBase
Module with some utils on which other modules can base in Zend Expressive 3.

To install simply use composer:
```
composer require sebrogala/xsv-base:^3.0
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

### Common Dependency Injection
If constructor is used only for assigning local variables (Dependency Injection) and it's in common pattern like Handlers,
Actions, InputFilter or anything that follows naming convention with type name on the end of class name,
there can be used Abstract Factory:

Copy `xsv-base-config.global.php.dist` to `config/autoload` folder and configure your common types there.

### Handy copy commands
```bash
cp vendor/sebrogala/xsv-base/data/xsv-base-config.global.php.dist config/autoload/xsv-base-config.global.php
cp vendor/sebrogala/xsv-base/data/App/Entity.php.dist src/App/src/Entity.php
cp vendor/sebrogala/xsv-base/data/App/Repository.php.dist src/App/src/Repository.php
cp vendor/sebrogala/xsv-base/data/App/RepositoryInterface.php.dist src/App/src/RepositoryInterface.php
cp vendor/sebrogala/xsv-base/data/App/UuidGen.php.dist src/App/src/UuidGen.php
```

[1]: http://zend-expressive.readthedocs.io/en/stable/features/helpers/body-parse/