<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'=>'required|string',
            'price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'reference'=>'required|string|unique:products,reference',
            'description'=>'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'qte'=>'required|integer|min:0',
            'id_sub_catg'=>'required|integer|exists:sub_categories,id',
            'in_stock'=>'required',
        ];
    }
}
