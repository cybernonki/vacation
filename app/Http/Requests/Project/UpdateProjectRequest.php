<?php

namespace App\Http\Requests\Project;

use App\Rules\NotContainRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'orderer_id' => ['required'],
            'name' => ['required','max:200'],
            'sort' => ['required','numeric'],
        ];
    }

    public function attributes($params = [])
    {
        return [
            'orderer_id' => '発注元',
            'name' => '名前',
            'sort' => 'ソート',
        ];
    }

}
