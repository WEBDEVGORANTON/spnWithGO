<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string type
 * @property int id
 */
class Certification extends Model
{
    const ANDROID_FCM_TYPE = 0;
    const IOS_APN_TYPE = 1;

    public static function getAllowTypes()
    {
        return [
            self::ANDROID_FCM_TYPE,
            self::IOS_APN_TYPE,
        ];
    }
}
