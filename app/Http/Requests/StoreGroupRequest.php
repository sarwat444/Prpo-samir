<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
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
            'group_name'         => 'required|min:2|max:30',
            'group_image'        => 'sometimes|image|mimes:png,jpg,jpeg',
            'chat_room_details'  => 'sometimes|min:2|max:1000|regex:/^[A-Za-z0-9]+(?:[-_][A-Za-z0-9]+)*$/',
        ];
    }
}
