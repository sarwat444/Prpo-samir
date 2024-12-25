<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMessageRequest extends FormRequest
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
            'to'            =>  ['required_if:room_type,Private', Rule::exists('users', 'id')],
            'room_id'       =>  ['required_if:room_type,Gruppe', Rule::exists('chat_rooms', 'chat_room_id')],
            'client'        =>  'nullable',
            'message'       =>  'sometimes',
            'is_link'       =>  ['sometimes' , Rule::in(0,1)],
            'chat_reply_id' =>  ['sometimes', Rule::exists('chat', 'chat_id')],
         ];
    }
}
