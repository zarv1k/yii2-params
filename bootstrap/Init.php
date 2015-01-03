<?php

namespace zarv1k\params\bootstrap;

use yii\base\BootstrapInterface;
use yii\base\Application;

class Init implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->on(Application::EVENT_BEFORE_REQUEST, function () {
            // TODO: review this code
            \Yii::$app->params = \Yii::createObject(\Yii::$app->params);
        });
    }
}