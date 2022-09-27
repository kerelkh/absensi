<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOpdRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'opd_name' => ['required', 'unique:opds,opd_name'],
            'opd_address' => ['required'],
            'opd_longitude' => ['required', 'Regex:/^[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/'],
            'opd_latitude' => ['required', 'Regex:/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?)$/'],
            'opd_distance' => ['required', 'numeric']
        ];
    }
}
