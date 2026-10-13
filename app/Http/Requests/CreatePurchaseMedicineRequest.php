<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePurchaseMedicineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'lot_no' => ['required', 'array'],
            'lot_no.*' => ['required', 'regex:/^[A-Za-z0-9_#\-]+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'lot_no.*.regex' => 'Lot number may only contain letters, numbers, _, #, and -',
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
}
