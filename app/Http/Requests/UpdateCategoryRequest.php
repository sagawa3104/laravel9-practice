<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'category_name' => 'required|max:255',
            'form' => 'required|in:MAPPING,CHECKLIST',
            'is_by_recorded_product' => 'nullable'
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
     * バリーデーション後にデータを補間
     *
     * @return void
     */
    protected function passedValidation()
    {
        $this->merge([
            'name' => $this->category_name,
            'is_by_recorded_product' => isset($this->is_by_recorded_product),
        ]);
    }
}
