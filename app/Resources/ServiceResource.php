<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 26.05.18
 * Time: 11:48
 */

namespace App\Resources;

use App\Models\Service;
use App\Resources\Behaviors\EloquentModel;
use App\Resources\Interfaces\HasEloquentModel;

class ServiceResource implements HasEloquentModel
{
    use EloquentModel;

    protected $allowCertsTypes = [
        'apns',
        'fcm'
    ];

    public function __construct()
    {
        // init model by default
        $this->setModel(new Service());
    }


    public function storeCert($type, $body)
    {

    }

    public function getCert($hash)
    {

    }
}