<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 26.05.18
 * Time: 12:16
 */

namespace App\Resources;

use App\Resources\Behaviors\EloquentModel;
use App\Resources\Helpers\Certifications\CertificationsWork;
use App\Resources\Interfaces\HasEloquentModel;

class CertificationsResource implements HasEloquentModel
{
    use EloquentModel, CertificationsWork;
}