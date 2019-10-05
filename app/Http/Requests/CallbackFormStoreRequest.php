<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CallbackFormStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'terms' => 'accepted|bail',
            'name' => 'required|string|max:255',
            'gender' => 'required|numeric|max:1',
            'phone' => 'required|phone:AUTO',
            'order_number' => 'nullable|numeric|max:50',
            'email' => 'nullable|email|max:255',
            'issue' => 'required|string|max:255',
            'callback_date' => 'required',
            'callback_time' => 'required',
        ];
    }
}
