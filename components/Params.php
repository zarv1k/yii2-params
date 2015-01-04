<?php

namespace zarv1k\params\components;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\db\Connection;
use yii\db\Query;
use yii\di\Instance;
use yii\helpers\ArrayHelper;

class Params extends Component implements \ArrayAccess, \Iterator, \Countable
{
    protected $_db = 'db';
    protected $_params = [];
    protected $_overwrite = true;
    protected $_filePath = '@app/config/params.php';

    protected $_modelClass = '\zarv1k\params\models\Params';

    public function getTableName()
    {
        $modelClass = $this->getModelClass();
        return $modelClass::tableName();
    }

    public function getDbParams()
    {
        $params = [];
        // TODO: cache this method
        $table = $this->getTableName();

        $query = (new Query())
            ->select('scope, code, value')
            ->from($table)
            ->indexBy(function ($row) {
                $key = $row['code'];
                if (!is_null($row['scope'])) {
                    $key = "{$row['scope']}.$key";
                }
                return $key;
            });

        foreach ($query->each() as $k => $v) {
            $params[$k] = $v['value'];
        }
        return $params;
    }

    /**
     * Init component
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->_db = Instance::ensure($this->_db, Connection::className());

        $this->loadParamsFromFile($this->getFilePath());
        $this->mergeParams();
    }

    /**
     * Load params from php file
     * @param $_filePath
     * @throws InvalidConfigException
     */
    protected function loadParamsFromFile($_filePath)
    {
        if (is_string($_filePath) && !empty($_filePath)) {
            $path          = \Yii::getAlias($_filePath);
            $this->_params = require($path);
        } else {
            // TODO: review this code
            throw new InvalidConfigException('filePath property must be a string alias to params file');
        }
    }

    /**
     * Merge params
     */
    protected function mergeParams()
    {
        $this->_params = $this->getOverwrite() ?
            ArrayHelper::merge($this->_params, $this->getDbParams()) :
            ArrayHelper::merge($this->getDbParams(), $this->_params);

        ksort($this->_params);
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->_params);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->_params[$offset];
        } else {
            return null;
        }
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        $this->_params[$offset] = $value;
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        unset($this->_params[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return current($this->_params);
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        next($this->_params);
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return key($this->_params);
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return !is_null($this->key());
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        reset($this->_params);
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->_params);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->_params = $params;
    }

    /**
     * @return string
     */
    public function getModelClass()
    {
        return $this->_modelClass;
    }

    /**
     * @param string $modelClass
     */
    public function setModelClass($modelClass)
    {
        $this->_modelClass = $modelClass;
    }

    /**
     * Is DB parameter override
     *
     * @return boolean
     */
    public function getOverwrite()
    {
        return $this->_overwrite;
    }

    /**
     * @param boolean $overwrite
     */
    public function setOverwrite($overwrite)
    {
        $this->_overwrite = $overwrite;
    }

    /**
     * @return Connection
     */
    public function getDb()
    {
        return $this->_db;
    }

    /**
     * @param string|Connection $db
     */
    public function setDb($db)
    {
        $this->_db = $db;
    }

    /**
     * @return array
     */
    public function getFilePath()
    {
        return $this->_filePath;
    }

    /**
     * @param string $filePath
     */
    public function setFilePath($filePath)
    {
        $this->_filePath = $filePath;
    }
}
