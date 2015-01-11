<?php

namespace zarv1k\params\modules\widget\controllers;

use yii\base\DynamicModel;
use yii\web\Controller;
use zarv1k\params\models\Params;

class UpdateController extends Controller
{
    public function actionIndex()
    {
        // TODO: implement ajax validation

        // TODO: modify this to automatic get class of dynamic model
        if (\Yii::$app->request->post('DynamicParam')) {
            $models = Params::getDynamicModels();
            DynamicModel::loadMultiple($models, $_POST);
            if (DynamicModel::validateMultiple($models)) {
                foreach ($models as $id => $model) {
                    $owner = $model->owner;
                    $owner->value = $model->{$owner->code};
                    if ($owner->isAttributeChanged('value') && !$owner->update(true, ['value'])) {
                        // TODO: implement update fail
                    }
                }
            }
        }
        \Yii::$app->response->redirect(\Yii::$app->request->getReferrer());
    }
}
