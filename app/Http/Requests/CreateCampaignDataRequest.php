<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCampaignDataRequest extends FormRequest
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
            'user_data' => 'required|array',
            'user_data.*.user_id' => 'required|exists:users,id',
            'user_data.*.video_url' => 'required|string',
            'user_date.*.custom_fields' => 'json'
        ];
    }
}
