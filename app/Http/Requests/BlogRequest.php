<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
            'title'    => 'required',
            'content' => 'required',
            'blog_category_id' => 'required',
            'blog_avatar' => 'mimes:jpeg,bmp,jpg,png|required'
        ];
    }
    public function messages()
    {
        return [
            'content.required' => 'The description field is required',
            'blog_avatar.required' => 'The image field is required',
        ];
    }
}
