<?php

namespace zarv1k\params\modules\params\controllers;

use yii\web\Controller;
use zarv1k\params\models\DynamicParam;
use zarv1k\params\models\Params;

class ManageController extends Controller
{
    public function actionIndex()
    {
        // TODO: implement ajax validation

        // TODO: modify this to automatic get class of dynamic model
        if (\Yii::$app->request->post('DynamicParam')) {
            $isUpdated = $isChanged = false;
            $models = Params::getDynamicModels();
            DynamicParam::loadMultiple($models, $_POST);
            if (DynamicParam::validateMultiple($models)) {
                foreach ($models as $id => $model) {
                    $owner = $model->owner;
                    $owner->value = $model->{$owner->code};
                    $isChanged = $owner->isAttributeChanged('value');
                    $isUpdated = $isUpdated || $isChanged;
                    if ($isChanged && !$owner->update(true, ['value'])) {
                        // TODO: implement update fail
                    }
                }
            }
            \Yii::$app->session->setFlash('yii2-params-updated', $isUpdated); // TODO: change flash key
            if (\Yii::$app->request->isAjax) {
                \Yii::$app->end();
            }
            else {
                \Yii::$app->response->redirect(\Yii::$app->request->getReferrer());
            }

        } else {
            \Yii::$app->response->redirect(\Yii::$app->request->getReferrer());
        }
    }

    public function actionPreview()
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
