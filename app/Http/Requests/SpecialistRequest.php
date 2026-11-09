<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SpecialistRequest extends FormRequest
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
        $id = $this->route('specialist');

        return [
            'name' => ['required', 'string', Rule::unique('specialists', 'name')->ignore($id)],
            'photo' => [$this->isMethod('post') ? 'required' : 'sometimes', 'image', 'max:2048'],
            'about' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
