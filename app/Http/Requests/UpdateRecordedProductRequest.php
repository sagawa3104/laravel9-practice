<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecordedProductRequest extends FormRequest
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
            'product' => 'required|exists:products,id',
            'is_create_recorded_inspections' => 'nullable',
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
            'is_created_recorded_inspections' => isset($this->is_created_recorded_inspections),
        ]);
    }
}
