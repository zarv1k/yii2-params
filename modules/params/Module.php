<?php

namespace zarv1k\params\modules\params;

class Module extends \yii\base\Module
{
    public $defaultRoute = 'manage';
    public $controllerNamespace = 'zarv1k\params\modules\params\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
