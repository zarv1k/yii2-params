<?php

namespace zarv1k\params\bootstrap;

use yii\base\BootstrapInterface;
use yii\base\Application;

class MyBootstrapClass implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_REQUEST, function () {
            \Yii::$app->params = \Yii::$app->dbParams;
        });
    }
}