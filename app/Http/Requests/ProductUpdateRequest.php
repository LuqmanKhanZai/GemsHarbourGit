<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'dimension' => 'required',
            'dimension_x' => 'required',
            'dimension_y' => 'required',
            'weight' => 'required',
            'duration' => 'required',
            'shipping_details' => 'required',
            'shipping_price' => 'required',
            'shipping_cost' => 'required',
            'listing_type' => 'required',
            // 'images' => 'required|array',
            // 'cover' => 'required',
            'starting_price' => 'required',
            'reserve_price' => 'required',
        ];

    }
}
