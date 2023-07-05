<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => 'required',
            'customer_id' => 'required',
            'durasi' => 'required',
            'jml_product' => 'required',
            'hari_toleransi' => 'required',
            'keterangan' => 'required',
        ];
    }
}
