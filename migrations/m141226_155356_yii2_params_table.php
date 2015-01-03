<?php

use yii\db\Migration;
use yii\db\Schema;

class m141226_155356_yii2_params_table extends Migration
{
    public function up()
    {
        $this->createTable(
            \zarv1k\params\models\Params::tableName(),
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
        $tableName = \zarv1k\params\models\Params::tableName();
        $this->dropTable($tableName);
    }
}
