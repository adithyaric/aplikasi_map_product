<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TruckRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'no_plat' => 'required',
        ];
    }
}
