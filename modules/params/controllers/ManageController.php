<?php

namespace zarv1k\params\modules\params\controllers;

use yii\web\Controller;
use zarv1k\params\models\Params;

class ManageController extends Controller
{
    public function actionIndex()
    {
        // prepare file params data provider
        $fileParams = \Yii::$app->params->getFileParams();

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
        $dbParams   = new \yii\data\ActiveDataProvider([
            'query' => Params::find(),
        ]);

        return $this->render('index', ['fileParams' => $fileParams, 'dbParams' => $dbParams]);
    }

    public function actionView()
    {
        return $this->render('view');
    }
}
