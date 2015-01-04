<?php

namespace zarv1k\params\modules\params\controllers;

use yii\web\Controller;

class ManageController extends Controller
{
    public function actionIndex()
    {
        // prepare file params data provider
        $filaPath = \Yii::$app->params->getFilePath();
        $fileParams = !empty($filaPath) ?
            require(\Yii::getAlias($filaPath)) :
            [];

        $fileParamKeys   = array_keys($fileParams);
        $fileParamsArray = array_map(
            function ($key) use ($fileParams) {
                $scopeSeparatorPos = strpos($key, '.');
                return [
                    'scope' => $scopeSeparatorPos === false ? 'NULL' : substr($key, 0, $scopeSeparatorPos),
                    'code' => $scopeSeparatorPos === false ? $key : substr($key, $scopeSeparatorPos + 1, strlen($key)),
                    'value' => $fileParams[$key]
                ];
            },
            $fileParamKeys

        );

        $fileParams = new \yii\data\ArrayDataProvider([
            'allModels' => $fileParamsArray,
            // TODO: add pagination and sort
        ]);

        // prepare db params data provider
        $modelClass = \Yii::$app->params->getModelClass();
        $dbParams   = new \yii\data\ActiveDataProvider([
            'query' => $modelClass::find(),
        ]);

        return $this->render('index', ['fileParams' => $fileParams, 'dbParams' => $dbParams]);
    }

    public function actionView()
    {
        return $this->render('view');
    }
}
