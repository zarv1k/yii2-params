<?php

namespace zarv1k\params\modules\params\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {

        return $this->render('index');
    }
}
