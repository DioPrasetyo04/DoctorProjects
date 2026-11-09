<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class HospitalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('hospital');
        return [
            'name' => ['required', 'string', 'unique:hospitals,name' . $id],
            'photo' => [$this->isMethod('post') ? 'required' : 'sometimes', 'image', 'max:2048'],
            'city' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'about' => ['required', 'string'],
            'address' => ['required', 'string'],
            'post_code' => ['required', 'string'],
        ];
    }
}
