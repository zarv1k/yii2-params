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
            \Yii::$container->setSingleton('zarv1k\params\components\Params', \Yii::$app->params);
            \Yii::$container->setSingleton('yii2Params', 'zarv1k\params\components\Params');
            \Yii::$app->params = \Yii::$container->get('yii2Params');
        });
    }
}