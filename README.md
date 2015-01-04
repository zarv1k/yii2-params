### Installation instructions ###

Run migration to create params table in DB:
./yii migrate --migrationPath=@zarv1k/params/migrations

replace

'params' => require(__DIR__.'/params.php')

to

'params' => '@zarv1k/params/config/default.php'

or create your custom config like this:

'params' => [
        'class' => 'zarv1k\params\components\Params',
        'filePath' => '@app/config/params.php'
],