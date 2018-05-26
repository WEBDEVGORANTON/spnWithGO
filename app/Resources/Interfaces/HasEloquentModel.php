<?php

namespace App\Resources\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface HasEloquentModel {
    /**
     * Get eloquent model method
     *
     * @return Model
     */
    public function getModel();

    /**
     * Set eloquent model method
     *
     * @param Model $model
     * @param callable|null $beforeInit(Model $model)
     * @return self
     */
    public function setModel(Model $model, callable $beforeInit = null);

    /**
     * Know what model has been initialize
     *
     * @return boolean
     */
    public function isModelInitialize();
}