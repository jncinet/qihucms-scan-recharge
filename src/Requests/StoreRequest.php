<?php

namespace Qihucms\ScanRecharge\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'payment_channel' => ['required', 'exists:scan_recharge_channels,id'],
            'custom_amount' => ['required', 'numeric'],
            'desc' => ['required'],
        ];
    }

    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    public function attributes()
    {
        return trans('scan-recharge::order');
    }
}