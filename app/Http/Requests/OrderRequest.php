<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'orderKey' => 'required',
            'cust_fullname' => 'required',
            'cust_email' => 'required',
            'pass_type' => 'required|array',
            'pass_type.*' => 'required|string|in:adult,child,baby',
            'pass_title' => 'required|array',
            'pass_title.*' => 'required|string|in:mr,mrs,ms',
            'pass_fullname' => 'required|array',
            'pass_fullname.*' => 'required|string',
            'pass_state' => 'required|array',
        ];
    }
}
