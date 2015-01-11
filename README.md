Advanced application params for Yii 2
========================

This extension provides the advanced params for Yii 2 applications.
(Warning: this extension is under development, unstable and not for production use)


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist zarv1k/yii2-params "*"
```

or add

```
"zarv1k/yii2-params": "*"
```

to the require section of your `composer.json` file.


Run migrations to create params table in DB:
```
yii migrate --migrationPath=@zarv1k/params/migrations
```

Once the extension is installed, simply modify your application configuration as follows:

```php
return [
    // ...
    'params' => '@zarv1k/params/config/default.php',
    // ...
];
```

Or use your custom params component configuration as follows:
 
```php
return [
    // ...
    'params' => [
        'class' => 'zarv1k\params\components\Params',
        'filePath' => '@app/config/params.php'
    ],
    // ...
];
```

To manage application params on your web site you can turn on the params module:
  
```php
return [
    // ...
    'modules' => [
        // ...
        'params' => [
            'class' => 'zarv1k\params\modules\params\Module'
        ],
        // ...
    ],
];
```
Then you can then access params module through the following URL:

```
http://localhost/path/to/index.php?r=params
```

or if you have enabled pretty URLs, you may use the following URL:

```
http://localhost/path/to/index.php/params
```

Usage
-----

```
\Yii::$app->params['param_scope.param_code']
```