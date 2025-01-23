<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:1', 'max:255', Rule::unique('posts','title')->ignore($this->post->id)],
            'summary' => ['required', 'string', 'min:1', 'max:255'],
            'body' => ['required', 'string', 'min:1'],
            'image' => ['nullable', 'image', 'max:10240', 'mimes:jpg,bmp,png,jpeg,webp'],
            'category_id' => ['required', 'string', 'exists:categories,id']
        ];
    }
}
