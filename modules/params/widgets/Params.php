<?php

namespace zarv1k\params\modules\params\widgets;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveField;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

class Params extends Widget
{
    // TODO: add getter/setter for moduleId + set it in config + move the all options in configuration
    protected $_moduleId = 'params';

    protected $_submitContent = 'Update';
    protected $_submitOptions = [
        'class' => 'btn btn-success btn-sm'
    ];
    protected $_formId = 'yii2-params-update-form';

    public function run()
    {
        Pjax::begin([
            'enablePushState' => false,
            'formSelector' => $this->getFormId()
        ]);
        if (\Yii::$app->session->getFlash('yii2-params-updated')) {
            // TODO: review this custom alert code
            $closeButton = Html::button('&times;', [
                'data-dismiss' => 'alert',
                'aria-hidden' => 'true',
                'class' => 'close',
            ]);

            echo Html::tag('div', $closeButton."Params updated successfully!", [
                'class' => 'alert-info alert fade in'
            ]);
        }

        /** @var \zarv1k\params\models\DynamicParam[] $models */
        $models = \zarv1k\params\models\Params::getDynamicModels();

        $form = ActiveForm::begin([
            'id' => $this->getFormId(),
            'action' => \Yii::$app->getUrlManager()->createUrl("$this->_moduleId/manage"),
        ]);
        /** @var ActiveField $activeField */
        $activeField = \Yii::$container->get('yii\widgets\ActiveField'); // TODO: review get from di

        foreach ($models as $model) {
            echo $form->field($model, "[{$model->owner->id}]{$model->owner->code}", [
                'labelOptions' => ArrayHelper::merge($activeField->labelOptions,[
                    'label' => $model->owner->description,
                    'title' => $model->owner->name,
                ]),
                'inputOptions' => ArrayHelper::merge($activeField->inputOptions,[
                    'placeholder' => $model->owner->description,
                    'title' => $model->owner->name,
                ]),
            ]);
        }
        echo Html::submitButton($this->getSubmitContent(), $this->getSubmitOptions());

        ActiveForm::end();
        Pjax::end();
    }

    /**
     * @return array
     */
    public function getSubmitOptions()
    {
        return $this->_submitOptions;
    }

    /**
     * @param array $submitOptions
     */
    public function setSubmitOptions($submitOptions)
    {
        $this->_submitOptions = $submitOptions;
    }

    /**
     * @return string
     */
    public function getSubmitContent()
    {
        return $this->_submitContent;
    }

    /**
     * @param string $submitContent
     */
    public function setSubmitContent($submitContent)
    {
        $this->_submitContent = $submitContent;
    }

    /**
     * @return string
     */
    public function getFormId()
    {
        return $this->_formId;
    }

    /**
     * @param string $formId
     */
    public function setFormId($formId)
    {
        $this->_formId = $formId;
    }
}