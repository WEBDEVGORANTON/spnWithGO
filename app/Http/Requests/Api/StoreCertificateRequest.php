<?php

namespace App\Http\Requests\Api;

use App\Models\Certification;
use Illuminate\Foundation\Http\FormRequest;

class StoreCertificateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'service_id' => 'required|exists:id,services',
            'type' => 'required|in:' . implode(',', Certification::getAllowTypes()),
            'cert' => 'required|file',
        ];
    }
}
