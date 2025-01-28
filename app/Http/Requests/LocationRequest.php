<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'parent_id' => 'nullable|exists:locations,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:provinsi,kabupaten,kecamatan,desa,dusun',
            'coordinates' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Handle JSON input
                    if (is_string($value)) {
                        $decoded = json_decode($value, true);
                        if (json_last_error() !== JSON_ERROR_NONE || ! $this->isValidCoordinatesArray($decoded)) {
                            $fail("$attribute is not a valid JSON coordinate array.");
                        }
                    }
                    // Handle array input
                    elseif (is_array($value)) {
                        if (! $this->isValidCoordinatesArray($value)) {
                            $fail("$attribute is not a valid coordinate array.");
                        }
                    } else {
                        $fail("$attribute must be a valid coordinate array or JSON string.");
                    }
                },
            ],
        ];
    }

    private function isValidCoordinatesArray($coordinates)
    {
        if (! is_array($coordinates)) {
            return false;
        }

        foreach ($coordinates as $coordinate) {
            if (
                ! is_array($coordinate) ||
                count($coordinate) !== 2 ||
                ! is_numeric($coordinate[0]) || // Longitude
                ! is_numeric($coordinate[1])    // Latitude
            ) {
                return false;
            }
        }

        return true;
    }
}
