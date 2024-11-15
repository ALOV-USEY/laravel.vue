<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\DTO\MessageDTO;

class MessageFormRequest extends FormRequest
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
            'message' => 'required|string|min:3|max:255',
        ];
    }    

    /**
     * Get the validation data that you want to pass to the validator.
     *
     * @return array
     */
    public function validationData()
    {
        return (new MessageDTO($this->message))->toArray();
    }
}
