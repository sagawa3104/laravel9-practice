<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
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
            'unit_code' => 'required|unique:units,code|max:32',
            'unit_name' => 'required|max:255',
            'x_length' => 'required|integer|between:1,20',
            'y_length' => 'required|integer|between:1,20',
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
            'code' => $this->unit_code,
            'name' => $this->unit_name,
        ]);
    }
}
