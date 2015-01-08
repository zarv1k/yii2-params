<?php

use yii\db\Migration;
use yii\db\Schema;

class m141226_155356_yii2_params_table extends Migration
{
    public function up()
    {
        /** @var \zarv1k\params\components\Params $params */
        $params = Yii::$container->get('yii2Params');
        $tableName = $params->getTableName();
        $this->createTable(
            $tableName,
            [
                'id' => Schema::TYPE_PK,
                'scope' => 'VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin',
                'code' => 'VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL',
                'description' => 'string not null',
                'value' => Schema::TYPE_TEXT,
                'validation' => Schema::TYPE_TEXT,
                'created' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
                'updated' => 'timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP',
                'UNIQUE KEY `code_UNIQUE` (`code`)'
            ],
            'ENGINE=InnoDB'
        );
    }

    public function down()
    {
        /** @var \zarv1k\params\components\Params $params */
        $params = Yii::$container->get('yii2Params');
        $tableName = $params->getTableName();
        $this->dropTable($tableName);
    }
}
