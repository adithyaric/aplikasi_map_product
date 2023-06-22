<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BahanBakuRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'harga' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
            'satuan_id' => 'required',
        ];
    }
}
