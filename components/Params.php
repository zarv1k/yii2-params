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
    protected $_params = null;
    protected $_overwrite = true;
    protected $_filePath = '@app/config/params.php';
    protected $_tableName = '{{%params}}';

    /**
     * TODO: review this method access
     * @return array
     */
    protected function getDbParams()
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
     * Load params
     * @throws InvalidConfigException
     */
    protected function loadParams()
    {
        $this->loadParamsFromFile($this->getFilePath());
        $this->mergeParams();
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        if (is_null($this->_params)) {
            $this->loadParams();
        }
        return array_key_exists($offset, $this->_params);
    }

    /**
     * @inheritdoc
     */
    public function offsetGet($offset)
    {
        if (is_null($this->_params)) {
            $this->loadParams();
        }
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
        if (is_null($this->_params)) {
            $this->loadParams();
        }
        $this->_params[$offset] = $value;
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        if (is_null($this->_params)) {
            $this->loadParams();
        }
        unset($this->_params[$offset]);
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        if (is_null($this->_params)) {
            $this->loadParams();
        }
        return current($this->_params);
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        if (is_null($this->_params)) {
            $this->loadParams();
        }
        next($this->_params);
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        if (is_null($this->_params)) {
            $this->loadParams();
        }
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
        if (is_null($this->_params)) {
            $this->loadParams();
        }
        reset($this->_params);
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        if (is_null($this->_params)) {
            $this->loadParams();
        }
        return count($this->_params);
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->_params = $params;
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

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->_tableName;
    }

    /**
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $this->_tableName = $tableName;
    }
}
