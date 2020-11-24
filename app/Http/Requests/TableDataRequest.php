<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableDataRequest extends FormRequest
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
            'draw'           => 'nullable|integer',
            'order.0.column' => 'nullable|integer',
            'order.0.dir'    => 'nullable|in:asc,desc',
            'start'          => 'nullable|integer',
            'length'         => 'nullable|integer',
            'search.value'   => 'nullable|string',
            'search.regex'   => 'nullable|in:true,false',
        ];
    }
}
