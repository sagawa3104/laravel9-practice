<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
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
            'item_name' => 'required|max:255',
        ];
    }

    /**
     * バリーデーションのためにデータを準備
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // codeは除外する
        $sanitized = $this->except('code');
        $this->replace($sanitized);
    }

    /**
     * バリーデーションのためにデータを準備
     *
     * @return void
     */
    protected function passedValidation()
    {
        $this->merge([
            'name' => $this->item_name,
        ]);
    }
}
