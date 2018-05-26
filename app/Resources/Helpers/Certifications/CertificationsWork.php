<?php
/**
 * Created by PhpStorm.
 * User: anton
 * Date: 26.05.18
 * Time: 13:18
 */

namespace App\Resources\Helpers\Certifications;

use App\Models\Certification;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @method Certification getModel()
 * @property \Illuminate\Filesystem\FilesystemManager $storage
 * */
trait CertificationsWork
{
    private $storage;
    private static $storageKey = 'certs';

    public function __construct()
    {
        $this->storage = Storage::disk(self::$storageKey);
    }

    public function hasCert($key)
    {
        $model = $this->getModel();

        return !is_null($model->{$key}) && $this->storage->exists($model->{$key});
    }

    public function storeCert(UploadedFile $cert, $key)
    {
        if (!$this->isModelInitialize()) return $this;

        // if model has been initialize save cert

        $model = $this->getModel();
        $certPath = null;

        switch ($this->getModel()->type) {
            case Certification::ANDROID_FCM_TYPE:
                $certPath = $this->storeAndroidFcmCertificate($cert);
                break;
            case Certification::IOS_APN_TYPE:
                $certPath = $this->storeIosApnCertificate($cert);
                break;
        }

        if (is_null($certPath)) return $this;

        // save cert path in database
        $model->{$key} = $certPath;

        // update model
        $this->setModel($model);

        return $this;
    }

    protected function generateRandomCertPathWithName($ext, $type)
    {
        $filename = Carbon::now()->micro . '.' . $ext;

        switch ($type) {
            case Certification::ANDROID_FCM_TYPE:
                $dir = 'android';
                break;
            case Certification::IOS_APN_TYPE:
                $dir = 'ios';
                break;
            default:
                $dir = 'custom';
        }

        $path = $dir . DIRECTORY_SEPARATOR . $filename;

        return compact('filename', 'path');
    }

    protected function storeAndroidFcmCertificate(UploadedFile $cert)
    {
        $fileInfo = $this->generateRandomCertPathWithName($cert->getClientOriginalExtension(), Certification::ANDROID_FCM_TYPE);
        $cert->store($fileInfo['path'], self::$storageKey);

        return $fileInfo['path'];
    }

    protected function storeIosApnCertificate(UploadedFile $cert)
    {
        $fileInfo = $this->generateRandomCertPathWithName($cert->getClientOriginalExtension(), Certification::IOS_APN_TYPE);
        $cert->store($fileInfo['path'], self::$storageKey);

        return $fileInfo['path'];
    }

    public function removeCertificate($key)
    {
        if (!$this->isModelInitialize()) return $this;
        return $this->storage->delete($this->{$key});
    }

    public function syncCertificate(UploadedFile $cert, $key)
    {
        if (!$this->isModelInitialize()) return $this;

        // remove old cert
        if ($this->hasCert($key)) {
            $this->storage->delete($this->{$key});
        }

        $model = $this->getModel();
        $model->{$key} = $this->storeCert($cert, $key);

        $this->setModel($model);

        return $this;
    }
}