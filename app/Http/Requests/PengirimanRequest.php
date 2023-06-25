<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PengirimanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tgl_pengiriman' => 'required',
            'customer_id' => 'required',
            'driver_id' => 'required',
            'project_id' => 'required',
            'jml_product' => 'required',
            'jam' => 'required',
        ];
    }
}
