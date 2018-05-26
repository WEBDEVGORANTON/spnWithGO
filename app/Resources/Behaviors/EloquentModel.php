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
    protected $_model_save_status = false;

    public function setModel(Model $model, callable $callback = null)
    {
        $this->_model = $model;

        // prepare before save
        if (is_callable($callback)) $this->_model = call_user_func($callback, $this->_model);

        return $this;
    }

    public function getModel()
    {
        $this->_model_save_status = false;
        return $this->_model;
    }

    public function isModelInitialize()
    {
        return (bool) $this->_model;
    }

    public function saveModel()
    {
        $this->getModel()->save();
        $this->_model_save_status = true;
        return $this;
    }

    public function getSaveStatusModel()
    {
        return $this->_model_save_status = false;
    }

    public function fillModel(array $data)
    {
        $model = $this->getModel();
        $model->fill($data);

        $this->setModel($model);

        return $this;
    }
}