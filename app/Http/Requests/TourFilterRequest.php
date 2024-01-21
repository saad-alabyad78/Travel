<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TourFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->mergeIfMissing([
            'dateFrom' => '1000-01-01' ,
            'dateTo' =>  '9999-12-31',
            'priceFrom' => 0 ,
            'priceTo' => 2000000000 ,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dateFrom' => ['date' ] ,
            'dateTo' => ['date'  , 'after_or_equal:dateFrom'] ,
            'priceFrom' => ['numeric'] ,
            'priceTo' => ['numeric' , 'gte:priceFrom'] ,
            'sortOrder' => ['required_with:sortBy' ,Rule::in(['asc' , 'desc' , 'Asc' , 'Desc'])] ,
            'sortBy' => ['required_with:sortOrder',Rule::in(['price' , 'ending_date' , 'name'])] ,
        ];
    }

    public function messages()
    {
        return [
            'sortOrder.in' => "the sortOrder parameter accepts only 'asc' or 'desc' values !" ,
            'sortOrder.required_with' => 'the sortBy field requird with sortOrder field' ,

            'sortBy.in' => "the sortBy parameter accepts only 'price' or 'ending_date' or 'name' values !" ,
            'sortBy.required_with' => 'the sortOrder field requird with sortBy field' ,
        ];
    }
}
