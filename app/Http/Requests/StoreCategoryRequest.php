<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'category_code' => 'required|unique:categories,code|max:32',
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
    protected function passedValidation()
    {
        $this->merge([
            'code' => $this->category_code,
            'name' => $this->category_name,
            'is_by_recorded_product' => isset($this->is_by_recorded_product),
        ]);
    }
}
