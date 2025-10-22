<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerVerificationRequest extends FormRequest
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
            'partner' => 'required|exists:rekanans,id',
            'distribution_code_id' => 'required|exists:kode_distribusis,id',
            'fee' => 'required|numeric'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'partner' => 'Rekanan',
            'distribution_code_id' => 'Kategori',
            'fee' => 'Biaya'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'partner.required' => 'Rekanan harus dipilih',
            'partner.exists' => 'Rekanan tidak valid',
            'distribution_code_id.required' => 'Kategori harus dipilih',
            'distribution_code_id.exists' => 'Kategori tidak valid',
            'fee.required' => 'Biaya harus diisi',
            'fee.numeric' => 'Biaya harus berupa angka'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    public function prepareForValidation()
    {
        if ($this->has('fee')) {
            $this->merge([
                'fee' => str_replace(',', '', $this->fee)
            ]);
        }
    }
}
