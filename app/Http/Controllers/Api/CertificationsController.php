<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\StoreCertificateRequest;
use App\Http\Controllers\Controller;
use App\Models\Certification;
use App\Resources\CertificationsResource;
use Illuminate\Http\Request;

class CertificationsController extends Controller
{

    protected $certsResource;

    public function __construct(CertificationsResource $certResource)
    {
        $this->certsResource = $certResource;
    }

    public function store(StoreCertificateRequest $request)
    {
        $this->certsResource
            ->setModel(new Certification())
            ->fillModel($request->except('cert'))
            ->saveModel()
            ->storeCert($request->file('cert'), 'cert_location')
            ->saveModel();

        return $this->certsResource->getModel();
    }

    public function update(Request $request, Certification $certification)
    {
        $this->certsResource
            ->setModel($certification)
            ->fillModel($request->except('cert'))
            ->saveModel();

        if ($request->exists('cert') || $request->hasFile('cert')) {
            // update cert
            $this->certsResource
                ->syncCertificate($request->file('cert'), 'cert_location')
                ->saveModel();
        }

        return $this->certsResource->getModel();
    }

    public function delete(Certification $certification)
    {
        try {
            $this->certsResource
                ->removeCertificate('cert_location')
                ->getModel()
                ->delete();
        } catch (\Exception $e) {
            logger()->error('Certificate #' . $certification->id . ' error when deleting');
        }

        return true;
    }
}
