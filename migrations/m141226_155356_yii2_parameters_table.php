<?php

use yii\db\Migration;

class m141226_155356_yii2_parameters_table extends Migration
{
    public function up()
    {
        $tableName = \zarv1k\params\models\Params::tableName();
        $this->execute("
            CREATE TABLE `$tableName` (
                `parameter_id` int(11) NOT NULL AUTO_INCREMENT,
                `scope` varchar(255) NULL DEFAULT NULL,
                `code` varchar(255) NOT NULL,
                `name` varchar(255) NOT NULL,
                `value` varchar(255) NOT NULL,
                `validation` text,
                `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`parameter_id`),
                UNIQUE KEY `code_UNIQUE` (`code`)
            ) ENGINE=InnoDB
        ");
    }

    public function down()
    {
        $tableName = \zarv1k\params\models\Params::tableName();
        $this->dropTable($tableName);
    }
}
