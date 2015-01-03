<?php

namespace zarv1k\params\modules\params\controllers;

use yii\web\Controller;

class ManageController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView()
    {
        return $this->render('view');
    }
}
