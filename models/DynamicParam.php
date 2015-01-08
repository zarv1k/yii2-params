<?php
/**
 * Created by PhpStorm.
 * User: zarv1k
 * Date: 08/01/15
 * Time: 18:19
 */

namespace zarv1k\params\models;

use yii\base\DynamicModel;
use yii\di\Instance;

/**
 * Class DynamicParam
 * @property Params owner
 * @package zarv1k\params\models
 */
class DynamicParam extends DynamicModel
{
    protected $_owner = '\zarv1k\params\models\Params';

    public function init()
    {
        parent::init();

        $this->_owner = Instance::ensure($this->_owner, Params::className());
    }

    /**
     * @return Params
     */
    public function getOwner()
    {
        return $this->_owner;
    }

    /**
     * @param Params $owner
     */
    public function setOwner($owner)
    {
        $this->_owner = $owner;
    }
}