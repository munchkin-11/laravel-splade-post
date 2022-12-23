<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title' => 'required|string|max:100|unique:posts,title,' . $this->post->id,
            'body' => 'required',
            'thumbnail' => 'nullable|mimes:png,jpg,jpeg',
            'category_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'category_id' => 'category'
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->title),
            'user_id' => auth()->id()
        ]);
    }
}
