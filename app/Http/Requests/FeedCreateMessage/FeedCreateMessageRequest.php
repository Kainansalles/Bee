<?php

namespace App\Http\Requests\FeedCreateMessage;

use Illuminate\Foundation\Http\FormRequest;

class FeedCreateMessageRequest extends FormRequest
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
            'consumer_id' => 'required|string',
            'anonymous' => 'required|boolean',
            'message' => 'required|string|max:300',
        ];
    }
}
