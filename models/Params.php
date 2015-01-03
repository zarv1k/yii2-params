<?php

namespace zarv1k\params\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%yii2_params}}".
 *
 * @property integer $parameter_id
 * @property string $scope
 * @property string $code
 * @property string $name
 * @property string $value
 * @property string $validation
 * @property string $created
 * @property string $updated
 */
class Params extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%yii2_params}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name', 'value'], 'required'],
            [['validation'], 'string'],
            [['created', 'updated'], 'safe'],
            [['scope', 'code', 'name', 'value'], 'string', 'max' => 255],
            [['code'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parameter_id' => 'Parameter ID',
            'scope' => 'Scope',
            'code' => 'Code',
            'name' => 'Name',
            'value' => 'Value',
            'validation' => 'Validation',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
