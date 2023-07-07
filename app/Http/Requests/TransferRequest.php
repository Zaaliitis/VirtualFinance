<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'sender_account_number' => 'required|exists:accounts,account_number',
            'receiver_account_number' => 'required|exists:accounts,account_number',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'name' => 'required|string|exists:users,name',
            'security_code' => 'required|string',
        ];
    }
}
