<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
            'item_code' => 'required|unique:items,code|max:32',
            'item_name' => 'required|max:255',
            'is_checking_item' => 'nullable',
            'is_mapping_item' => 'nullable',
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
            'code' => $this->item_code,
            'name' => $this->item_name,
            'is_checking_item' => isset($this->is_checking_item),
            'is_mapping_item' => isset($this->is_mapping_item),
        ]);
    }
}
