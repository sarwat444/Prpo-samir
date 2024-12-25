<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class DeleteRequest extends FormRequest
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
            'room_type'     =>  ['required', Rule::in(['Private', 'Gruppe'])],
            'chat_id'       =>  ['required', Rule::exists('chat', 'chat_id')],
            'delete_type'   =>  ['required_if:room_type,Private', Rule::in(['me', 'every_one'])],
            'chat_room_id'  =>  ['required_if:room_type,Gruppe', Rule::exists('chat_rooms', 'chat_room_id')],
        ];
    }
}
