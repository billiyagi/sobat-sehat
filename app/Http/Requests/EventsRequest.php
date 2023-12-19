<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventsRequest extends FormRequest
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
            'name'          =>  'required|string',
            'description'   =>  'required',
            'location_at'   =>  'required',
            'link_location' =>  'required',
            'start_at'      =>  'required',
            'end_at'        =>  'required',
            'thumbnail'     =>  'image:jpeg,png,jpg|max:2048',
        ];
    }
}
