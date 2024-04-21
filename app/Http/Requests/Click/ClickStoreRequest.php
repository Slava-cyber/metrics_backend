<?php

namespace App\Http\Requests\Click;

use Illuminate\Foundation\Http\FormRequest;

class ClickStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'domain' => ['required', 'exists:domains,name'],
            'page_url' => ['required'],
            'position_x' => ['required', 'numeric', 'min:0'],
            'position_y' => ['required', 'numeric', 'min:0'],
            'screen_size_x' => ['required', 'numeric', 'min:0'],
            'screen_size_y' => ['required', 'numeric', 'min:0'],
            'datetime' => ['required', 'date'],
            'time_zone' => ['required']
        ];
    }
}
