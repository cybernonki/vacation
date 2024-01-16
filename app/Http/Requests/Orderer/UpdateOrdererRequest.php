<?php

namespace App\Http\Requests\Orderer;

use App\Rules\NotContainRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrdererRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required','max:200'],
            'sort' => ['required','numeric'],
        ];
    }

    public function attributes($params = [])
    {
        return [
            'name' => '名前',
            'sort' => 'ソート',
        ];
    }

}
