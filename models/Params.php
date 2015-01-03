<?php

namespace zarv1k\params\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%params}}".
 *
 * @property integer $id
 * @property string $scope
 * @property string $code
 * @property string $description
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
        return '{{%params}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'description', 'value'], 'required'],
            [['validation'], 'string'],
            [['created', 'updated'], 'safe'],
            [['scope', 'code'], 'string', 'max' => 255],
            [['description', 'value'], 'string', 'max' => 65500],
            [['code'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Parameter ID',
            'scope' => 'Scope',
            'code' => 'Code',
            'description' => 'Description',
            'value' => 'Value',
            'validation' => 'Validation',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
