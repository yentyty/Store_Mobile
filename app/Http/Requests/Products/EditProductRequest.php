<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
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
            'name' => 'required|max:100|unique:products,name',
            'price' => 'required|numeric',
            'factory_id' => 'required',
            'body' => 'required',
            'color' => 'required',
            'image' => 'required',
            'in_stock' => 'required|numeric',
            'storage' => 'required|max:255',
            'screen' => 'required',
            'OS' => 'required',
            'camera' => 'required',
            'cpu' => 'required',
            'ram' => 'required',
            'sim' => 'required',
            'pin' => 'required',
            'fingerprint' => 'required',
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }
}
