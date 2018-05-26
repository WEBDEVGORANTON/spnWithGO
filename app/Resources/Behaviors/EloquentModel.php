<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 26.05.18
 * Time: 11:49
 */

namespace App\Resources\Behaviors;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Model $_model
 * */
trait EloquentModel
{
    protected $_model;

    public function setModel(Model $model, callable $callback = null)
    {
        $this->_model = $model;

        // prepare before save
        if (is_callable($callback)) $this->_model = call_user_func($callback, $this->_model);

        return $this;
    }

    public function getModel()
    {
        return $this->_model;
    }
}