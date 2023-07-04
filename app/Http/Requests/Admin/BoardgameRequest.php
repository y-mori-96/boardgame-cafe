<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BoardgameRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:50'],
            'barcode' => ['max:20'],
            // 'image' => [
            //   'file', // ファイルがアップロードされている
            //   'image', // 画像ファイルである
            //   'mimes:jpeg,jpg,png', // 形式はjpegかpng
            //   'dimensions:min_width=50,min_height=50,max_width=1000,max_height=1000', // 50*50 ~ 1000*1000 まで
            // ],
            'outline' => ['max:500'],
            'description' => ['max:2000'],
        ];
    }
}
