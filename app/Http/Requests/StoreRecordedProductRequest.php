<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecordedProductRequest extends FormRequest
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
            'recorded_product_code' => 'required|unique:recorded_products,code|max:32',
            'is_created_recorded_inspections' => 'nullable',
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
            'code' => $this->recorded_product_code,
            'is_created_recorded_inspections' => isset($this->is_created_recorded_inspections),
        ]);
    }
}
