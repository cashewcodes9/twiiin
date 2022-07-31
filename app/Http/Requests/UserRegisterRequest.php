<?php

namespace App\Http\Requests;

use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class UserRegisterRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'voucher' => [
                'required',
                'min:8',
                'max:8',
                'string',
                Rule::exists('vouchers', 'voucher')->where(function (Builder $query) {
                    return $query->where([
                        ['voucher', '=', strtoupper($this->get('voucher'))],
                        ['expires_at', '>', Carbon::now()],
                    ]);
                })
            ],
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:8',
        ];
    }

    /**
     * Custom error messages
     * @return array
     * @throws Exception
     */
    public function messages(): array
    {
        return Arr::dot([
            'voucher' => [
                'exists' => 'You can only used your voucher once. Please make sure you are using valid voucher!',
            ]
        ]);
    }
}
